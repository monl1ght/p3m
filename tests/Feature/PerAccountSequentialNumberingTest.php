<?php

namespace Tests\Feature;

use App\Models\ajuan_penelitianModel;
use App\Models\DosenJurnalUpload;
use App\Models\Hki;
use App\Models\p3mModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PerAccountSequentialNumberingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pengabdian_proposal_badge_is_sequential_per_account_even_with_large_db_id(): void
    {
        $dosen = User::factory()->dosen()->create();

        // Create proposal with explicit DB ID 28
        p3mModel::create([
            'id' => 28,
            'user_id' => $dosen->id,
            'judul' => 'Pengabdian di Wanusobo',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Pengabdian Masyarakat',
            'lokasi' => 'Wanusobo',
            'lama' => '6 Bulan',
            'biaya' => '5000000',
            'status' => 'proses',
            'ketua' => $dosen->name,
            'nama_ketua' => $dosen->name,
            'nidn_ketua' => '0612345678',
            'prodi_ketua' => 'Teknik Informatika',
        ]);

        $response = $this->actingAs($dosen)->get(route('dosen.upp3m'));

        $response->assertOk();
        $response->assertSee('Pengabdian di Wanusobo');
        // Must show #001 for the dosen's first proposal, not #028
        $response->assertSee('#001');
        $htmlWithoutStyles = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $response->getContent());
        $this->assertStringNotContainsString('#028', $htmlWithoutStyles);
    }

    #[Test]
    public function multiple_proposals_render_sequential_numbers_001_and_002(): void
    {
        $dosen = User::factory()->dosen()->create();

        // Create two proposals with arbitrary high/discontinuous IDs
        p3mModel::create([
            'id' => 45,
            'user_id' => $dosen->id,
            'judul' => 'Proposal Pertama Aktif',
            'bidang' => 'Pertanian',
            'jeniskategori' => 'Pengabdian Masyarakat',
            'lokasi' => 'Desa A',
            'lama' => '3 Bulan',
            'biaya' => '3000000',
            'status' => 'proses',
            'ketua' => $dosen->name,
            'nama_ketua' => $dosen->name,
            'created_at' => now()->subDay(),
        ]);

        p3mModel::create([
            'id' => 88,
            'user_id' => $dosen->id,
            'judul' => 'Proposal Kedua Baru',
            'bidang' => 'Kesehatan',
            'jeniskategori' => 'Pengabdian Masyarakat',
            'lokasi' => 'Desa B',
            'lama' => '3 Bulan',
            'biaya' => '4000000',
            'status' => 'proses',
            'ketua' => $dosen->name,
            'nama_ketua' => $dosen->name,
            'created_at' => now(),
        ]);

        $response = $this->actingAs($dosen)->get(route('dosen.upp3m'));

        $response->assertOk();
        $response->assertSee('#001');
        $response->assertSee('#002');
        $htmlWithoutStyles = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $response->getContent());
        $this->assertStringNotContainsString('#045', $htmlWithoutStyles);
        $this->assertStringNotContainsString('#088', $htmlWithoutStyles);
    }

    #[Test]
    public function penelitian_proposal_badge_is_sequential_per_account(): void
    {
        $dosen = User::factory()->dosen()->create();

        ajuan_penelitianModel::create([
            'id' => 77,
            'user_id' => $dosen->id,
            'judul' => 'Penelitian Smart Agriculture',
            'bidang' => 'Pertanian Modern',
            'jeniskategori' => 'Penelitian Dasar',
            'lokasi' => 'Laboratorium',
            'lamapenelitian' => '12 Bulan',
            'biaya' => '15000000',
            'status' => 'proses',
            'ketua' => $dosen->name,
            'nama_ketua' => $dosen->name,
            'nidn_ketua' => '0612345678',
            'prodi_ketua' => 'Teknik Informatika',
        ]);

        $response = $this->actingAs($dosen)->get(route('dosen.dash_ajuanpenelitian'));

        $response->assertOk();
        $response->assertSee('Penelitian Smart Agriculture');
        $response->assertSee('#001');
        $response->assertDontSee('#077');
    }

    #[Test]
    public function jurnal_upload_badge_is_sequential_per_account(): void
    {
        $dosen = User::factory()->dosen()->create();

        DosenJurnalUpload::create([
            'id' => 64,
            'user_id' => $dosen->id,
            'judul' => 'Artikel Jurnal Terapan AI',
            'kategori' => 'penelitian',
            'file_path' => 'jurnal-dosen/test.pdf',
            'file_name' => 'test.pdf',
            'status' => 'diterima',
        ]);

        $response = $this->actingAs($dosen)->get(route('dosen.jurnal_upload.index'));

        $response->assertOk();
        $response->assertSee('Artikel Jurnal Terapan AI');
        $response->assertSee('#001');
        $response->assertDontSee('#064');
    }

    #[Test]
    public function hki_badge_is_sequential_per_account(): void
    {
        $dosen = User::factory()->dosen()->create();

        Hki::create([
            'id' => 53,
            'user_id' => $dosen->id,
            'judul' => 'Hak Cipta Aplikasi Monitoring',
            'tanggal' => now()->toDateString(),
            'jenis_hki' => 'Hak Cipta',
            'file_name' => 'test.pdf',
            'file_path' => 'hki-sertifikat/test.pdf',
            'file_sertifikat' => 'hki-sertifikat/test.pdf',
        ]);

        $response = $this->actingAs($dosen)->get(route('dosen.hki.index'));

        $response->assertOk();
        $response->assertSee('Hak Cipta Aplikasi Monitoring');
        $response->assertSee('#HKI-001');
        $response->assertDontSee('#HKI-053');
    }
}
