<?php

namespace Tests\Feature;

use App\Models\DosenJurnalUpload;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DosenJurnalUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('private');
    }

    #[Test]
    public function dosen_bisa_mengunggah_jurnal_ke_private_storage(): void
    {
        $dosen = User::factory()->dosen()->create();
        $file = UploadedFile::fake()->create('naskah_penelitian.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($dosen)->post(route('dosen.jurnal_upload.store'), [
            'judul'    => 'Rancang Bangun Sistem Monitoring IoT',
            'kategori' => 'penelitian',
            'uppdf'    => $file,
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dosen.jurnal_upload.index', ['kategori' => 'penelitian']));

        $this->assertDatabaseHas('dosen_jurnal_uploads', [
            'user_id'   => $dosen->id,
            'judul'     => 'Rancang Bangun Sistem Monitoring IoT',
            'kategori'  => 'penelitian',
            'status'    => 'diproses',
            'read_at'   => null,
        ]);

        $jurnal = DosenJurnalUpload::where('user_id', $dosen->id)->first();
        $this->assertNotNull($jurnal);
        $this->assertStringStartsWith('jurnal-dosen/', $jurnal->file_path);
        Storage::disk('private')->assertExists($jurnal->file_path);
    }

    #[Test]
    public function dosen_bisa_memperbarui_judul_dan_kategori_jurnal(): void
    {
        $dosen = User::factory()->dosen()->create();
        Storage::disk('private')->put('jurnal-dosen/test_file.pdf', 'dummy content');

        $jurnal = DosenJurnalUpload::create([
            'user_id'   => $dosen->id,
            'judul'     => 'Judul Awal',
            'kategori'  => 'penelitian',
            'file_path' => 'jurnal-dosen/test_file.pdf',
            'file_name' => 'test_file.pdf',
            'status'    => 'diproses',
            'read_at'   => now(), // sebelumnya sudah terbaca
        ]);

        // Update mengubah kategori menjadi 'pengabdian' dan judul baru
        $response = $this->actingAs($dosen)->post(route('dosen.jurnal_upload.update', $jurnal->id), [
            'judul'    => 'Judul Baru yang Diperbarui',
            'kategori' => 'pengabdian',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dosen.jurnal_upload.index', ['kategori' => 'pengabdian']));

        $jurnal->refresh();
        $this->assertEquals('Judul Baru yang Diperbarui', $jurnal->judul);
        $this->assertEquals('pengabdian', $jurnal->kategori);
        $this->assertNull($jurnal->read_at); // Harus reset agar admin dapat notifikasi
    }

    #[Test]
    public function dosen_bisa_mengganti_berkas_jurnal_lama_secara_aman(): void
    {
        $dosen = User::factory()->dosen()->create();
        Storage::disk('private')->put('jurnal-dosen/old_file.pdf', 'old content');

        $jurnal = DosenJurnalUpload::create([
            'user_id'   => $dosen->id,
            'judul'     => 'Judul Awal',
            'kategori'  => 'penelitian',
            'file_path' => 'jurnal-dosen/old_file.pdf',
            'file_name' => 'old_file.pdf',
            'status'    => 'diproses',
        ]);

        $newFile = UploadedFile::fake()->create('naskah_revisi.pdf', 2048, 'application/pdf');

        $response = $this->actingAs($dosen)->post(route('dosen.jurnal_upload.update', $jurnal->id), [
            'judul'    => 'Judul Revisi',
            'kategori' => 'penelitian',
            'uppdf'    => $newFile,
        ]);

        $response->assertSessionHasNoErrors();

        $jurnal->refresh();
        $this->assertEquals('naskah_revisi.pdf', $jurnal->file_name);
        Storage::disk('private')->assertExists($jurnal->file_path);
        Storage::disk('private')->assertMissing('jurnal-dosen/old_file.pdf');
    }

    #[Test]
    public function dosen_lain_tidak_bisa_mengubah_atau_mengunduh_jurnal_bukan_miliknya(): void
    {
        $dosenA = User::factory()->dosen()->create();
        $dosenB = User::factory()->dosen()->create();

        Storage::disk('private')->put('jurnal-dosen/file_a.pdf', 'content A');
        $jurnalA = DosenJurnalUpload::create([
            'user_id'   => $dosenA->id,
            'judul'     => 'Jurnal Dosen A',
            'kategori'  => 'penelitian',
            'file_path' => 'jurnal-dosen/file_a.pdf',
            'file_name' => 'file_a.pdf',
            'status'    => 'diproses',
        ]);

        // Dosen B mencoba akses download
        $responseDownload = $this->actingAs($dosenB)->get(route('dosen.jurnal_upload.download', $jurnalA->id));
        $responseDownload->assertStatus(404);

        // Dosen B mencoba update
        $responseUpdate = $this->actingAs($dosenB)->post(route('dosen.jurnal_upload.update', $jurnalA->id), [
            'judul'    => 'Hacked Title',
            'kategori' => 'penelitian',
        ]);
        $responseUpdate->assertStatus(404);
    }

    #[Test]
    public function admin_bisa_melihat_dan_mengunduh_berkas_jurnal_dosen(): void
    {
        $admin = User::factory()->admin()->create();
        $dosen = User::factory()->dosen()->create();

        Storage::disk('private')->put('jurnal-dosen/admin_test.pdf', 'dummy pdf content');
        $jurnal = DosenJurnalUpload::create([
            'user_id'   => $dosen->id,
            'judul'     => 'Jurnal untuk Admin',
            'kategori'  => 'penelitian',
            'file_path' => 'jurnal-dosen/admin_test.pdf',
            'file_name' => 'admin_test.pdf',
            'status'    => 'diproses',
            'read_at'   => null,
        ]);

        // Admin membuka list jurnal dosen -> otomatis menandai read_at
        $responseIndex = $this->actingAs($admin)->get(route('plppm.jurnal_dosen'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Jurnal untuk Admin');

        $jurnal->refresh();
        $this->assertNotNull($jurnal->read_at);

        // Admin mengunduh berkas
        $responseDownload = $this->actingAs($admin)->get(route('plppm.jurnal_dosen.download', $jurnal->id));
        $responseDownload->assertStatus(200);
        $responseDownload->assertHeader('content-type', 'application/pdf');
    }

    #[Test]
    public function notifikasi_jurnal_dosen_terintegrasi_di_app_service_provider(): void
    {
        $admin = User::factory()->admin()->create();
        $dosen = User::factory()->dosen()->create();

        DosenJurnalUpload::create([
            'user_id'   => $dosen->id,
            'judul'     => 'Jurnal Baru Unread',
            'kategori'  => 'penelitian',
            'file_path' => 'jurnal-dosen/dummy.pdf',
            'file_name' => 'dummy.pdf',
            'status'    => 'diproses',
            'read_at'   => null,
        ]);

        $response = $this->actingAs($admin)->get(route('dash.dashboard'));
        $response->assertStatus(200);

        // Notifikasi harus terdaftar dan berisikan jumlah jurnal dosen
        $notifikasi = $response->viewData('notifikasi');
        $this->assertNotNull($notifikasi);
        $jurnalNotif = $notifikasi->firstWhere('tipe', 'jurnal_dosen');
        $this->assertNotNull($jurnalNotif);
        $this->assertStringContainsString('Jurnal Dosen', $jurnalNotif['judul']);
    }
}
