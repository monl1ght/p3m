<?php

namespace Tests\Feature;

use App\Models\ajuan_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\kum_penelitianModel;
use App\Models\p3mModel;
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
}
