<?php

namespace Tests\Feature;

use App\Models\ajuan_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\p3mModel;
use App\Models\SubmissionStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Tier 1 — Status Transition Tests
 *
 * Memverifikasi bahwa mesin transisi status berjalan sesuai aturan:
 * - Hanya admin yang dapat mengubah status
 * - Transisi hanya boleh mengikuti aturan yang ditetapkan
 * - Status 'approve' dapat dikembalikan ke proses
 * - Penolakan wajib menyertakan alasan
 * - Semua perubahan tercatat di audit trail
 */
class StatusTransitionTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $dosen;
    private p3mModel $proposal;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->dosen = User::factory()->dosen()->create();

        $this->proposal = p3mModel::create([
            'judul'          => 'Proposal Test Status',
            'bidang'         => 'Teknologi',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'PKM',
            'jeniskelamin'   => 'L',
            'nidn'           => '0101010101',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Test',
            'lokasi'         => 'Bandung',
            'lamapenelitian' => '3 bulan',
            'biaya'          => 999999, // double(8,2) max = 999999.99
            'user_id'        => $this->dosen->id,
            'status'         => 'proses',
        ]);
    }

    private function patchStatus(string $status, ?string $reason = null, ?string $nomorSurat = null): \Illuminate\Testing\TestResponse
    {
        $payload = ['status' => $status];
        if ($reason !== null) {
            $payload['reason'] = $reason;
        }
        if ($status === 'approve') {
            $payload['nomor_surat'] = $nomorSurat ?? '001/P3M-POLIBANG/ST/2026';
        }

        return $this->actingAs($this->admin)
            ->patch(route('plppm.ppengabdian.status', ['id' => $this->proposal->id]), $payload);
    }

    // -------------------------------------------------------------------------
    // Akses kontrol
    // -------------------------------------------------------------------------

    #[Test]
    public function dosen_tidak_bisa_mengubah_status_submission(): void
    {
        $response = $this->actingAs($this->dosen)
            ->patch(route('plppm.ppengabdian.status', ['id' => $this->proposal->id]), [
                'status' => 'approve',
            ]);

        // RoleMiddleware redirect dosen ke dosen.dash, bukan abort(403)
        $response->assertRedirect(route('dosen.dash'));
        // Pastikan status tidak berubah
        $this->assertDatabaseMissing('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'approve']);
    }

    #[Test]
    public function guest_tidak_bisa_mengubah_status_submission(): void
    {
        $response = $this->patch(route('plppm.ppengabdian.status', ['id' => $this->proposal->id]), [
            'status' => 'approve',
        ]);

        $response->assertRedirect('/login');
    }

    // -------------------------------------------------------------------------
    // Transisi valid
    // -------------------------------------------------------------------------

    #[Test]
    public function admin_bisa_approve_proposal_berstatus_proses(): void
    {
        $response = $this->patchStatus('approve');

        $response->assertRedirect(route('plppm.lpengabdian'));
        $this->assertDatabaseHas('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'approve']);
    }

    #[Test]
    public function admin_bisa_non_approve_proposal_berstatus_proses_dengan_alasan(): void
    {
        $response = $this->patchStatus('non-approve', 'Proposal kurang lengkap.');

        $response->assertRedirect(route('plppm.lpengabdian'));
        $this->assertDatabaseHas('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'non-approve']);
    }

    #[Test]
    public function admin_bisa_kembalikan_ke_proses_dari_non_approve(): void
    {
        $this->proposal->update(['status' => 'non-approve']);

        $response = $this->patchStatus('proses');

        $response->assertRedirect(route('plppm.lpengabdian'));
        $this->assertDatabaseHas('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'proses']);
    }

    // -------------------------------------------------------------------------
    // Transisi tidak valid
    // -------------------------------------------------------------------------

    #[Test]
    public function admin_bisa_kembalikan_ke_proses_dari_approve(): void
    {
        $this->proposal->update(['status' => 'approve']);

        $response = $this->patchStatus('proses');

        $response->assertRedirect(route('plppm.lpengabdian'));
        $this->assertDatabaseHas('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'proses']);
    }

    #[Test]
    public function tidak_bisa_langsung_dari_non_approve_ke_approve(): void
    {
        $this->proposal->update(['status' => 'non-approve']);

        $response = $this->patchStatus('approve');

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseHas('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'non-approve']);
    }

    #[Test]
    public function status_nilai_tidak_valid_ditolak(): void
    {
        $response = $this->patchStatus('disetujui'); // nilai tidak ada di enum

        $response->assertSessionHasErrors('status');
    }

    // -------------------------------------------------------------------------
    // Validasi alasan
    // -------------------------------------------------------------------------

    #[Test]
    public function non_approve_tanpa_alasan_gagal_validasi(): void
    {
        $response = $this->patchStatus('non-approve'); // tidak ada reason

        $response->assertSessionHasErrors('reason');
        $this->assertDatabaseHas('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'proses']);
    }

    #[Test]
    public function non_approve_dengan_alasan_kosong_gagal_validasi(): void
    {
        $response = $this->patchStatus('non-approve', '   '); // whitespace saja

        $response->assertSessionHasErrors('reason');
    }

    #[Test]
    public function approve_tidak_memerlukan_alasan(): void
    {
        $response = $this->patchStatus('approve'); // tanpa reason — harus berhasil

        $response->assertRedirect(route('plppm.lpengabdian'));
        $this->assertDatabaseHas('ajupengabdian', ['id' => $this->proposal->id, 'status' => 'approve']);
    }

    // -------------------------------------------------------------------------
    // Audit trail
    // -------------------------------------------------------------------------

    #[Test]
    public function perubahan_status_tercatat_di_audit_trail(): void
    {
        $this->patchStatus('approve');

        $this->assertDatabaseHas('submission_status_histories', [
            'submission_type' => 'proposal-pengabdian',
            'submission_id'   => $this->proposal->id,
            'previous_status' => 'proses',
            'status'          => 'approve',
            'decided_by'      => $this->admin->id,
        ]);
    }

    #[Test]
    public function alasan_penolakan_tersimpan_di_audit_trail(): void
    {
        $alasan = 'Anggaran terlalu besar dan tidak sesuai proposal.';

        $this->patchStatus('non-approve', $alasan);

        $this->assertDatabaseHas('submission_status_histories', [
            'submission_type' => 'proposal-pengabdian',
            'submission_id'   => $this->proposal->id,
            'status'          => 'non-approve',
            'reason'          => $alasan,
            'decided_by'      => $this->admin->id,
        ]);
    }

    #[Test]
    public function audit_trail_approve_tidak_menyimpan_alasan(): void
    {
        $this->patchStatus('approve');

        $history = SubmissionStatusHistory::where('submission_id', $this->proposal->id)->first();

        $this->assertNull($history->reason, 'Kolom reason harus NULL untuk keputusan approve.');
    }

    #[Test]
    public function multiple_keputusan_semuanya_tercatat_di_audit_trail(): void
    {
        // Siklus lengkap: proses → non-approve → proses → approve
        $this->patchStatus('non-approve', 'Perlu revisi anggaran.');
        $this->patchStatus('proses');
        $this->patchStatus('approve');

        $totalHistory = SubmissionStatusHistory::where('submission_id', $this->proposal->id)->count();

        $this->assertEquals(3, $totalHistory, 'Harus ada 3 entri audit trail.');
    }

    // -------------------------------------------------------------------------
    // Laporan (kumpulan) — tipe berbeda
    // -------------------------------------------------------------------------

    #[Test]
    public function admin_bisa_approve_laporan_pengabdian(): void
    {
        $laporan = kum_pengabdianModel::create([
            'judul'          => 'Laporan Pengabdian Test',
            'bidang'         => 'Teknologi',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'PKM',
            'jeniskelamin'   => 'L',
            'nidn'           => '0101010101',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Test',
            'lokasi'         => 'Bandung',
            'lamapenelitian' => '3 bulan',
            'biaya'          => 999999, // double(8,2) max = 999999.99
            'user_id'        => $this->dosen->id,
            'status'         => 'proses',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('plppm.kumpulan.status', ['tipe' => 'kum_pengabdian', 'id' => $laporan->id]), [
                'status' => 'approve',
            ]);

        $response->assertRedirect(route('plppm.kpengabdian'));
        $this->assertDatabaseHas('kum_pengabdian_models', ['id' => $laporan->id, 'status' => 'approve']);
    }

    #[Test]
    public function admin_bisa_kembalikan_laporan_pengabdian_yang_sudah_disetujui_ke_proses(): void
    {
        $laporan = kum_pengabdianModel::create([
            'judul'          => 'Laporan Pengabdian Disetujui',
            'bidang'         => 'Teknologi',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'PKM',
            'jeniskelamin'   => 'L',
            'nidn'           => '0101010101',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Test',
            'lokasi'         => 'Bandung',
            'lamapenelitian' => '3 bulan',
            'biaya'          => 999999,
            'user_id'        => $this->dosen->id,
            'status'         => 'approve',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('plppm.kumpulan.status', ['tipe' => 'kum_pengabdian', 'id' => $laporan->id]), [
                'status' => 'proses',
            ]);

        $response->assertRedirect(route('plppm.kpengabdian'));
        $this->assertDatabaseHas('kum_pengabdian_models', ['id' => $laporan->id, 'status' => 'proses']);
    }
}
