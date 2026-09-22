<?php

namespace Tests\Feature;

use App\Models\ajuan_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\kum_penelitianModel;
use App\Models\p3mModel;
use App\Models\SubmissionStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Tier 1 — Authorization / IDOR Tests
 *
 * Memverifikasi bahwa setiap dosen hanya bisa mengakses,
 * mengedit, dan menghapus resource miliknya sendiri.
 */
class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Helper: buat submission dengan owner tertentu
    // -------------------------------------------------------------------------

    private function buatProposalPengabdian(User $owner, string $status = 'proses'): p3mModel
    {
        return p3mModel::create([
            'judul'         => 'Proposal Pengabdian ' . $owner->name,
            'bidang'        => 'Teknologi',
            'ketua'         => $owner->name,
            'jeniskategori' => 'PKM',
            'jeniskelamin'  => 'L',
            'nidn'          => '0101010101',
            'jabatan'       => 'DS',
            'prodi'         => 'R',
            'telp'          => '08123456789',
            'alamat'        => 'Jl. Test No. 1',
            'lokasi'        => 'Bandung',
            'lamapenelitian'=> '3 bulan',
            'biaya'         => 999999,
            'user_id'       => $owner->id,
            'status'        => $status,
        ]);
    }

    private function buatProposalPenelitian(User $owner, string $status = 'proses'): ajuan_penelitianModel
    {
        return ajuan_penelitianModel::create([
            'judul'         => 'Proposal Penelitian ' . $owner->name,
            'bidang'        => 'Sains',
            'ketua'         => $owner->name,
            'jeniskategori' => 'Penelitian Dasar',
            'jeniskelamin'  => 'P',
            'nidn'          => '0202020202',
            'jabatan'       => 'DS',
            'prodi'         => 'A',
            'telp'          => '08198765432',
            'alamat'        => 'Jl. Riset No. 2',
            'lokasi'        => 'Jakarta',
            'lamapenelitian'=> '6 bulan',
            'biaya'         => 999999,
            'user_id'       => $owner->id,
            'status'        => $status,
        ]);
    }

    private function buatLaporanPengabdian(User $owner, string $status = 'approve', ?string $judul = null): kum_pengabdianModel
    {
        return kum_pengabdianModel::create([
            'judul'          => $judul ?? ('Laporan Pengabdian ' . $status . ' ' . $owner->name),
            'bidang'         => 'Teknologi',
            'ketua'          => $owner->name,
            'jeniskategori'  => 'PKM',
            'jeniskelamin'   => 'L',
            'nidn'           => '0101010101',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Test No. 1',
            'lokasi'         => 'Jepara',
            'lamapenelitian' => '3 bulan',
            'biaya'          => 5000000,
            'user_id'        => $owner->id,
            'status'         => $status,
            'tanggal_mulai'  => '2026-01-01',
            'tanggal_selesai'=> '2026-04-01',
        ]);
    }

    private function buatLaporanPenelitian(User $owner, string $status = 'approve', ?string $judul = null): kum_penelitianModel
    {
        return kum_penelitianModel::create([
            'judul'          => $judul ?? ('Laporan Penelitian ' . $status . ' ' . $owner->name),
            'bidang'         => 'Sains',
            'ketua'          => $owner->name,
            'jeniskategori'  => 'Penelitian Terapan',
            'jeniskelamin'   => 'P',
            'nidn'           => '0202020202',
            'jabatan'        => 'DS',
            'prodi'          => 'A',
            'telp'           => '08198765432',
            'alamat'         => 'Jl. Riset No. 2',
            'lokasi'         => 'Semarang',
            'lamapenelitian' => '6 bulan',
            'biaya'          => 7500000,
            'user_id'        => $owner->id,
            'status'         => $status,
            'tanggal_mulai'  => '2026-01-01',
            'tanggal_selesai'=> '2026-07-01',
        ]);
    }

    // -------------------------------------------------------------------------
    // IDOR — Profil
    // -------------------------------------------------------------------------

    #[Test]
    public function dosen_tidak_bisa_edit_profil_dosen_lain(): void
    {
        $dosen1 = User::factory()->dosen()->create();
        $dosen2 = User::factory()->dosen()->create();

        $response = $this->actingAs($dosen1)->put("/profil/{$dosen2->id}", [
            'name'  => $dosen1->name,
            'email' => 'baru@example.com',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('users', ['id' => $dosen2->id, 'email' => 'baru@example.com']);
    }

    #[Test]
    public function dosen_bisa_edit_profilnya_sendiri(): void
    {
        $dosen = User::factory()->dosen()->create(['email' => 'lama@example.com']);

        $response = $this->actingAs($dosen)->put("/profil/{$dosen->id}", [
            'name'  => $dosen->name,
            'email' => 'baru@example.com',
        ]);

        $response->assertRedirect(route('dosen.profil', ['id' => $dosen->id]));
        $this->assertDatabaseHas('users', ['id' => $dosen->id, 'email' => 'baru@example.com']);
    }

    // -------------------------------------------------------------------------
    // IDOR — Proposal Pengabdian
    // -------------------------------------------------------------------------

    #[Test]
    public function dosen_tidak_bisa_edit_proposal_pengabdian_milik_dosen_lain(): void
    {
        $dosen1   = User::factory()->dosen()->create();
        $dosen2   = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen2);

        // Controller mengquery HANYA milik dosen yang login,
        // jadi proposal milik dosen2 tidak ditemukan → redirect/404
        // Assertion terpenting: data tidak berubah
        $this->actingAs($dosen1)
            ->post("/dosdash/updatep3m/{$proposal->id}", [
                'judul' => 'Judul Curian',
            ]);

        $this->assertDatabaseMissing('ajupengabdian', ['id' => $proposal->id, 'judul' => 'Judul Curian']);
    }

    #[Test]
    public function dosen_tidak_bisa_hapus_proposal_pengabdian_milik_dosen_lain(): void
    {
        $dosen1   = User::factory()->dosen()->create();
        $dosen2   = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen2);

        // Controller query ownership → record tidak ditemukan
        $this->actingAs($dosen1)
            ->delete("/dosdash/propengdelete/{$proposal->id}");

        // Assertion terpenting: record masih ada (tidak terhapus)
        $this->assertDatabaseHas('ajupengabdian', ['id' => $proposal->id]);
    }

    // -------------------------------------------------------------------------
    // IDOR — Proposal Penelitian
    // -------------------------------------------------------------------------

    #[Test]
    public function dosen_tidak_bisa_hapus_proposal_penelitian_milik_dosen_lain(): void
    {
        $dosen1   = User::factory()->dosen()->create();
        $dosen2   = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPenelitian($dosen2);

        // Controller query ownership → record tidak ditemukan
        $this->actingAs($dosen1)
            ->delete("/dosdash/deletepropen/{$proposal->id}");

        // Assertion terpenting: record masih ada (tidak terhapus)
        $this->assertDatabaseHas('ajuan_penelitian_models', ['id' => $proposal->id]);
    }

    // -------------------------------------------------------------------------
    // IDOR — Detail View
    // -------------------------------------------------------------------------

    #[Test]
    public function dosen_tidak_bisa_lihat_detail_proposal_pengabdian_milik_dosen_lain(): void
    {
        $dosen1   = User::factory()->dosen()->create();
        $dosen2   = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen2);

        $response = $this->actingAs($dosen1)
            ->get("/Propengabdian/ajupengab/{$proposal->id}");

        // Controller menggunakan abort_unless() yang return 403
        $response->assertForbidden();
    }

    #[Test]
    public function admin_bisa_lihat_detail_proposal_pengabdian_milik_siapapun(): void
    {
        $admin    = User::factory()->admin()->create();
        $dosen    = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen);

        $response = $this->actingAs($admin)
            ->get("/Propengabdian/ajupengab/{$proposal->id}");

        $response->assertOk();
    }

    #[Test]
    public function pencarian_detail_proposal_dengan_query_search_tidak_crash(): void
    {
        $admin    = User::factory()->admin()->create();
        $dosen    = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen);

        // Parameter search mencocokkan kolom 'judul' tanpa QueryException kolom 'title'
        $response = $this->actingAs($admin)
            ->get("/Propengabdian/ajupengab/{$proposal->id}?search=Proposal");

        $response->assertOk();
    }

    // -------------------------------------------------------------------------
    // Download Dokumen
    // -------------------------------------------------------------------------

    #[Test]
    public function guest_tidak_bisa_download_dokumen_submission(): void
    {
        $dosen    = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen);

        $response = $this->get("/dokumen-pengajuan/proposal-pengabdian/{$proposal->id}/download");

        $response->assertRedirect('/login');
    }

    #[Test]
    public function dosen_tidak_bisa_download_dokumen_milik_dosen_lain(): void
    {
        $dosen1   = User::factory()->dosen()->create();
        $dosen2   = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen2, 'approve');
        // uppdf sengaja kosong → 404 karena file tidak ada, bukan 403
        // Tapi ownership check harus return 403 sebelum sampai ke file check
        p3mModel::where('id', $proposal->id)->update(['uppdf' => 'somefile.pdf']);

        $response = $this->actingAs($dosen1)
            ->get("/dokumen-pengajuan/proposal-pengabdian/{$proposal->id}/download");

        $response->assertForbidden();
    }

    // -------------------------------------------------------------------------
    // HIGH-04: Penghapusan Submission Membersihkan Riwayat Status
    // -------------------------------------------------------------------------

    #[Test]
    public function hapus_proposal_pengabdian_membersihkan_riwayat_status(): void
    {
        $dosen = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen, 'proses');

        SubmissionStatusHistory::create([
            'submission_type' => 'proposal-pengabdian',
            'submission_id'   => $proposal->id,
            'previous_status' => 'draft',
            'status'          => 'proses',
            'decided_by'      => $dosen->id,
            'decided_at'      => now(),
        ]);

        $this->assertDatabaseHas('submission_status_histories', [
            'submission_type' => 'proposal-pengabdian',
            'submission_id'   => $proposal->id,
        ]);

        $response = $this->actingAs($dosen)->delete(route('dosen.deletep3m', $proposal->id));
        $response->assertRedirect(route('dosen.upp3m'));

        $this->assertDatabaseMissing('ajupengabdian', ['id' => $proposal->id]);
        $this->assertDatabaseMissing('submission_status_histories', [
            'submission_type' => 'proposal-pengabdian',
            'submission_id'   => $proposal->id,
        ]);
    }

    #[Test]
    public function hapus_proposal_penelitian_membersihkan_riwayat_status(): void
    {
        $dosen = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPenelitian($dosen, 'proses');

        SubmissionStatusHistory::create([
            'submission_type' => 'proposal-penelitian',
            'submission_id'   => $proposal->id,
            'previous_status' => 'draft',
            'status'          => 'proses',
            'decided_by'      => $dosen->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($dosen)->delete(route('dosen.deletepropen', $proposal->id));
        $response->assertRedirect(route('dosen.dash_ajuanpenelitian'));

        $this->assertDatabaseMissing('ajuan_penelitian_models', ['id' => $proposal->id]);
        $this->assertDatabaseMissing('submission_status_histories', [
            'submission_type' => 'proposal-penelitian',
            'submission_id'   => $proposal->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // HIGH-03: Halaman Publik Hanya Menampilkan Laporan Hasil Approve
    // -------------------------------------------------------------------------

    #[Test]
    public function halaman_publik_penelitian_hanya_menampilkan_laporan_hasil_approved(): void
    {
        $dosen = User::factory()->dosen()->create();
        $laporanApproved = $this->buatLaporanPenelitian($dosen, 'approve');
        $laporanProses   = $this->buatLaporanPenelitian($dosen, 'proses');

        $response = $this->get(route('tampilan.penelitian'));
        $response->assertOk();
        $response->assertSee($laporanApproved->judul);
        $response->assertDontSee($laporanProses->judul);
    }

    #[Test]
    public function halaman_publik_pengabdian_hanya_menampilkan_laporan_hasil_approved(): void
    {
        $dosen = User::factory()->dosen()->create();
        $laporanApproved = $this->buatLaporanPengabdian($dosen, 'approve');
        $laporanProses   = $this->buatLaporanPengabdian($dosen, 'proses');

        $response = $this->get(route('tampilan.pengabdian'));
        $response->assertOk();
        $response->assertSee($laporanApproved->judul);
        $response->assertDontSee($laporanProses->judul);
    }

    // -------------------------------------------------------------------------
    // HIGH-01: Model Relasi Bersih Tanpa Kolom Kategori ID Mati
    // -------------------------------------------------------------------------

    #[Test]
    public function model_relasi_p3m_dan_kategori_berjalan_tanpa_error(): void
    {
        $dosen = User::factory()->dosen()->create();
        $proposal = $this->buatProposalPengabdian($dosen);

        $loaded = p3mModel::with(['anggotap3m', 'user'])->find($proposal->id);
        $this->assertNotNull($loaded);
        $this->assertEquals($dosen->id, $loaded->user->id);

        $cat = \App\Models\M_categories::create([
            'name' => 'Kategori Uji',
            'slug' => 'kategori-uji',
        ]);
        $loadedCat = \App\Models\M_categories::with('news')->find($cat->id);
        $this->assertNotNull($loadedCat);
    }
}
