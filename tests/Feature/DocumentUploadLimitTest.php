<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DocumentUploadLimitTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function panduan_upload_menerima_file_hingga_5_mb(): void
    {
        $admin = User::factory()->admin()->create();

        // 4 MB file (4096 KB) -> dulu gagal karena batas 2 MB (2048 KB), sekarang harus lolos
        $file = UploadedFile::fake()->create('panduan_riset.pdf', 4096, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('panduan.store'), [
            'namefile'      => 'Panduan Riset 2026',
            'original_name' => $file,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('panduan.index'));
        $this->assertDatabaseHas('m_panduans', [
            'namefile' => 'Panduan Riset 2026',
        ]);
    }

    #[Test]
    public function panduan_upload_menolak_file_melebihi_5_mb(): void
    {
        $admin = User::factory()->admin()->create();

        // 6 MB file (6144 KB) -> melebihi 5 MB (5120 KB)
        $file = UploadedFile::fake()->create('panduan_besar.pdf', 6144, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('panduan.store'), [
            'namefile'      => 'Panduan Terlalu Besar',
            'original_name' => $file,
        ]);

        $response->assertSessionHasErrors('original_name');
        $this->assertDatabaseMissing('m_panduans', [
            'namefile' => 'Panduan Terlalu Besar',
        ]);
    }

    #[Test]
    public function dokumen_upload_menerima_file_hingga_5_mb(): void
    {
        $admin = User::factory()->admin()->create();

        // 4.5 MB file (4608 KB)
        $file = UploadedFile::fake()->create('dokumen_sk.pdf', 4608, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('dokumen.store'), [
            'namefile'     => 'SK Pengangkatan',
            'originalname' => $file,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dokumen.index'));
        $this->assertDatabaseHas('dokumen_models', [
            'namefile' => 'SK Pengangkatan',
        ]);
    }

    #[Test]
    public function dokumen_upload_menolak_file_melebihi_5_mb(): void
    {
        $admin = User::factory()->admin()->create();

        // 6 MB file
        $file = UploadedFile::fake()->create('dokumen_besar.pdf', 6144, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('dokumen.store'), [
            'namefile'     => 'SK Terlalu Besar',
            'originalname' => $file,
        ]);

        $response->assertSessionHasErrors('originalname');
        $this->assertDatabaseMissing('dokumen_models', [
            'namefile' => 'SK Terlalu Besar',
        ]);
    }

    #[Test]
    public function panduan_bisa_diupdate_judul_dan_filenya(): void
    {
        $admin = User::factory()->admin()->create();

        $panduan = \App\Models\m_panduan::create([
            'namefile'       => 'Panduan Awal',
            'original_name'  => 'awal.pdf',
            'generated_name' => 'awal.pdf',
        ]);

        $newFile = UploadedFile::fake()->create('panduan_revisi.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        $response = $this->actingAs($admin)->put(route('panduan.update', $panduan->id), [
            'namefile'      => 'Panduan Revisi 2026',
            'original_name' => $newFile,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('panduan.index'));
        $this->assertDatabaseHas('m_panduans', [
            'id'       => $panduan->id,
            'namefile' => 'Panduan Revisi 2026',
        ]);
    }

    #[Test]
    public function dokumen_bisa_diupdate_judul_dan_filenya(): void
    {
        $admin = User::factory()->admin()->create();

        $dokumen = \App\Models\DokumenModel::create([
            'namefile'     => 'Dokumen Awal',
            'originalname' => 'awal.pdf',
        ]);

        $newFile = UploadedFile::fake()->create('dokumen_revisi.pdf', 2048, 'application/pdf');

        $response = $this->actingAs($admin)->put(route('dokumen.update', $dokumen->id), [
            'namefile'     => 'Dokumen SK Revisi',
            'originalname' => $newFile,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dokumen.index'));
        $this->assertDatabaseHas('dokumen_models', [
            'id'       => $dokumen->id,
            'namefile' => 'Dokumen SK Revisi',
        ]);
    }

    #[Test]
    public function dokumen_bisa_dihapus(): void
    {
        $admin = User::factory()->admin()->create();

        $dokumen = \App\Models\DokumenModel::create([
            'namefile'     => 'Dokumen Dihapus',
            'originalname' => 'hapus.pdf',
        ]);

        $response = $this->actingAs($admin)->delete(route('dokumen.delete', $dokumen->id));

        $response->assertRedirect(route('dokumen.index'));
        $this->assertDatabaseMissing('dokumen_models', [
            'id' => $dokumen->id,
        ]);
    }
}
