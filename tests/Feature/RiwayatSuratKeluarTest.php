<?php

namespace Tests\Feature;

use App\Models\ajuan_penelitianModel;
use App\Models\p3mModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RiwayatSuratKeluarTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $dosen;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->dosen = User::factory()->create([
            'role' => 'dosen',
        ]);
    }

    private function createPengabdian(array $attributes = []): p3mModel
    {
        return p3mModel::create(array_merge([
            'user_id'         => $this->dosen->id,
            'judul'           => 'Judul Pengabdian Default',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dr. Dosen Pengabdi',
            'jeniskategori'   => 'Pengabdian Dosen',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098801',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456789',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Nalumsari',
            'lamapenelitian'  => '3 Bulan',
            'biaya'           => '10000000',
            'uppdf'           => 'proposal.pdf',
            'status'          => 'approve',
            'nomor_surat'     => '001/P3M/ST-PG/2026',
        ], $attributes));
    }

    private function createPenelitian(array $attributes = []): ajuan_penelitianModel
    {
        return ajuan_penelitianModel::create(array_merge([
            'user_id'         => $this->dosen->id,
            'judul'           => 'Judul Penelitian Default',
            'bidang'          => 'Rekayasa Perangkat Lunak',
            'ketua'           => 'Dr. Dosen Peneliti',
            'jeniskategori'   => 'Penelitian Dosen Pemula',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098802',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456780',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Kampus Polibang',
            'lamapenelitian'  => '6 Bulan',
            'biaya'           => '15000000',
            'uppdf'           => 'proposal.pdf',
            'status'          => 'approve',
            'nomor_surat'     => '002/P3M/ST-PN/2026',
        ], $attributes));
    }

    /**
     * Guest tidak dapat mengakses menu Riwayat Surat Keluar (redirect ke login).
     */
    public function test_guest_cannot_access_riwayat_surat_keluar(): void
    {
        $response = $this->get(route('plppm.surat_keluar'));
        $response->assertRedirect('/login');
    }

    /**
     * Dosen dialihkan (302) ke dashboard dosen atau 403 saat mengakses via AJAX.
     */
    public function test_dosen_forbidden_from_riwayat_surat_keluar(): void
    {
        $response = $this->actingAs($this->dosen)->get(route('plppm.surat_keluar'));
        $response->assertRedirect(route('dosen.dash'));

        $ajaxResponse = $this->actingAs($this->dosen)->getJson(route('plppm.surat_keluar'));
        $ajaxResponse->assertStatus(403);
    }

    /**
     * Admin dapat mengakses halaman Riwayat Surat Keluar dengan sukses.
     */
    public function test_admin_can_access_riwayat_surat_keluar(): void
    {
        $response = $this->actingAs($this->admin)->get(route('plppm.surat_keluar'));

        $response->assertStatus(200);
        $response->assertSee('Riwayat Surat Keluar');
        $response->assertSee('Total Surat Keluar');
        $response->assertSee('Penelitian');
        $response->assertSee('Pengabdian');
    }

    /**
     * Hanya surat yang berstatus approve DAN memiliki nomor surat yang tampil di riwayat surat keluar.
     */
    public function test_only_approved_with_nomor_surat_appear_in_riwayat(): void
    {
        // 1. Pengabdian Approved dengan nomor surat -> HARUS MUNCUL
        $this->createPengabdian([
            'judul'       => 'Pengabdian Terbit Sah',
            'status'      => 'approve',
            'nomor_surat' => '001/P3M/ST-PG/2026',
        ]);

        // 2. Pengabdian Approved TANPA nomor surat -> TIDAK BOLEH MUNCUL
        $this->createPengabdian([
            'judul'       => 'Pengabdian Tanpa Nomor',
            'status'      => 'approve',
            'nomor_surat' => null,
        ]);

        // 3. Pengabdian Status Proses (meski ada nomor / kosong) -> TIDAK BOLEH MUNCUL
        $this->createPengabdian([
            'judul'       => 'Pengabdian Masih Proses',
            'status'      => 'proses',
            'nomor_surat' => '002/P3M/ST-PG/2026',
        ]);

        // 4. Penelitian Approved dengan nomor surat -> HARUS MUNCUL
        $this->createPenelitian([
            'judul'       => 'Penelitian Terbit Sah',
            'status'      => 'approve',
            'nomor_surat' => '003/P3M/ST-PN/2026',
        ]);

        // 5. Penelitian Non-Approve (Ditolak) -> TIDAK BOLEH MUNCUL
        $this->createPenelitian([
            'judul'       => 'Penelitian Ditolak Revisi',
            'status'      => 'non-approve',
            'nomor_surat' => '004/P3M/ST-PN/2026',
        ]);

        $response = $this->actingAs($this->admin)->get(route('plppm.surat_keluar'));

        $response->assertStatus(200);

        // Yang sah harus muncul
        $response->assertSee('001/P3M/ST-PG/2026');
        $response->assertSee('Pengabdian Terbit Sah');
        $response->assertSee('003/P3M/ST-PN/2026');
        $response->assertSee('Penelitian Terbit Sah');

        // Yang belum sah tidak boleh muncul
        $response->assertDontSee('Pengabdian Tanpa Nomor');
        $response->assertDontSee('Pengabdian Masih Proses');
        $response->assertDontSee('Penelitian Ditolak Revisi');
    }

    /**
     * Filter jenis surat via query parameter (Penelitian / Pengabdian).
     */
    public function test_filter_by_jenis_surat(): void
    {
        $this->createPengabdian([
            'judul'       => 'Usulan Pengabdian Khusus',
            'nomor_surat' => 'PG-999',
        ]);

        $this->createPenelitian([
            'judul'       => 'Usulan Penelitian Khusus',
            'nomor_surat' => 'PN-888',
        ]);

        // Filter Penelitian
        $resPenelitian = $this->actingAs($this->admin)->get(route('plppm.surat_keluar', ['jenis_surat' => 'Penelitian']));
        $resPenelitian->assertStatus(200);
        $resPenelitian->assertSee('PN-888');
        $resPenelitian->assertSee('Usulan Penelitian Khusus');
        $resPenelitian->assertDontSee('PG-999');

        // Filter Pengabdian
        $resPengabdian = $this->actingAs($this->admin)->get(route('plppm.surat_keluar', ['jenis_surat' => 'Pengabdian']));
        $resPengabdian->assertStatus(200);
        $resPengabdian->assertSee('PG-999');
        $resPengabdian->assertSee('Usulan Pengabdian Khusus');
        $resPengabdian->assertDontSee('PN-888');
    }

    /**
     * Filter pencarian keyword pada Riwayat Surat Keluar.
     */
    public function test_search_keyword_filter(): void
    {
        $this->createPengabdian([
            'judul'       => 'Pemberdayaan Nelayan Jepara',
            'ketua'       => 'Muhammad Najib',
            'nomor_surat' => 'SURAT-NELAYAN-01',
        ]);

        $this->createPengabdian([
            'judul'       => 'Pelatihan UMKM Kerajinan',
            'ketua'       => 'Siti Fatimah',
            'nomor_surat' => 'SURAT-UMKM-02',
        ]);

        $res = $this->actingAs($this->admin)->get(route('plppm.surat_keluar', ['search' => 'Nelayan']));
        $res->assertStatus(200);
        $res->assertSee('SURAT-NELAYAN-01');
        $res->assertDontSee('SURAT-UMKM-02');
    }

    /**
     * Admin dapat melihat (inline) dan mengunduh (attachment) dokumen PDF surat tugas dari link riwayat.
     */
    public function test_admin_can_view_and_download_pdf_from_riwayat_link(): void
    {
        $pengabdian = $this->createPengabdian([
            'judul'       => 'Uji Download PDF Surat Tugas Pengabdian',
            'nomor_surat' => '077/P3M/ST-PG/IX/2026',
        ]);

        $penelitian = $this->createPenelitian([
            'judul'       => 'Uji Download PDF Surat Tugas Penelitian',
            'nomor_surat' => '088/P3M/ST-PN/IX/2026',
        ]);

        // 1. Preview inline pengabdian
        $viewResPengabdian = $this->actingAs($this->admin)
            ->get(route('p3m.surat-tugas.download', ['id' => $pengabdian->id, 'disposition' => 'inline']));
        $viewResPengabdian->assertStatus(200);
        $viewResPengabdian->assertHeader('content-type', 'application/pdf');

        // 2. Download attachment penelitian
        $dlResPenelitian = $this->actingAs($this->admin)
            ->get(route('p3m.surat-tugaspen.download', ['id' => $penelitian->id, 'disposition' => 'attachment']));
        $dlResPenelitian->assertStatus(200);
        $dlResPenelitian->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('attachment', $dlResPenelitian->headers->get('content-disposition'));
    }

    /**
     * Sidebar admin memuat link menu mandiri Riwayat Surat Keluar.
     */
    public function test_sidebar_admin_displays_riwayat_surat_keluar_menu(): void
    {
        $response = $this->actingAs($this->admin)->get(route('dash.dashboard'));

        $response->assertStatus(200);
        $response->assertSee(route('plppm.surat_keluar'));
        $response->assertSee('Riwayat Surat Keluar');
    }
}
