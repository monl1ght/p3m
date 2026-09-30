<?php

namespace Tests\Feature;

use App\Models\M_categories;
use App\Models\M_news;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewsImageUploadValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    #[Test]
    public function kegiatan_tambah_menolak_file_format_tidak_valid(): void
    {
        $admin = User::factory()->admin()->create();
        $category = M_categories::create([
            'name' => 'Penelitian',
            'slug' => 'penelitian',
        ]);

        $invalidFile = UploadedFile::fake()->create('script.php', 100, 'application/x-php');

        $response = $this->actingAs($admin)->post(route('news.store'), [
            'title'       => 'Judul Kegiatan Test',
            'date'        => '2026-09-14',
            'category_id' => $category->id,
            'image'       => $invalidFile,
            'content'     => '<p>Konten kegiatan</p>',
        ]);

        $response->assertSessionHasErrors('image');
        $response->assertSessionHas('error', 'Format gambar harus berupa PNG, JPG, JPEG, WEBP, atau GIF.');
        $this->assertDatabaseMissing('m_news', [
            'title' => 'Judul Kegiatan Test',
        ]);
    }

    #[Test]
    public function kegiatan_tambah_menolak_file_melebihi_5_mb(): void
    {
        $admin = User::factory()->admin()->create();
        $category = M_categories::create([
            'name' => 'Pengabdian',
            'slug' => 'pengabdian',
        ]);

        // 6 MB image file
        $oversizedFile = UploadedFile::fake()->create('foto_besar.png', 6144, 'image/png');

        $response = $this->actingAs($admin)->post(route('news.store'), [
            'title'       => 'Kegiatan Foto Besar',
            'date'        => '2026-09-14',
            'category_id' => $category->id,
            'image'       => $oversizedFile,
            'content'     => '<p>Konten kegiatan</p>',
        ]);

        $response->assertSessionHasErrors('image');
        $response->assertSessionHas('error', 'Ukuran gambar maksimal adalah 5 MB.');
        $this->assertDatabaseMissing('m_news', [
            'title' => 'Kegiatan Foto Besar',
        ]);
    }

    #[Test]
    public function kegiatan_edit_menolak_file_format_tidak_valid(): void
    {
        $admin = User::factory()->admin()->create();
        $category = M_categories::create([
            'name' => 'Umum',
            'slug' => 'umum',
        ]);

        $news = M_news::create([
            'title'       => 'Kegiatan Lama',
            'date'        => '2026-09-01',
            'category_id' => $category->id,
            'image'       => 'lama.png',
            'content'     => '<p>Konten lama</p>',
            'user_id'     => $admin->id,
        ]);

        $invalidFile = UploadedFile::fake()->create('payload.php', 200, 'text/plain');

        $response = $this->actingAs($admin)->put(route('news.update', $news->id), [
            'title'       => 'Kegiatan Diperbarui',
            'date'        => '2026-09-14',
            'category_id' => $category->id,
            'image'       => $invalidFile,
            'content'     => '<p>Konten baru</p>',
        ]);

        $response->assertSessionHasErrors('image');
        $response->assertSessionHas('error', 'Format gambar harus berupa PNG, JPG, JPEG, WEBP, atau GIF.');
        $this->assertDatabaseHas('m_news', [
            'id'    => $news->id,
            'title' => 'Kegiatan Lama',
        ]);
    }

    #[Test]
    public function kegiatan_tambah_dan_tampilkan_membersihkan_payload_xss_dengan_aman(): void
    {
        $admin = User::factory()->admin()->create();
        $category = M_categories::create([
            'name' => 'Teknologi',
            'slug' => 'teknologi',
        ]);

        $imageFile = UploadedFile::fake()->image('cover.jpg', 600, 400);

        $maliciousContent = '<p>Kegiatan workshop <strong>Polibang</strong>.</p>'
            . '<script>alert("XSS_STORED")</script>'
            . '<img src="https://example.com/logo.png" onerror="alert(1)" alt="Logo">'
            . '<a href="javascript:alert(2)">Link Jahat</a>'
            . '<iframe src="https://attacker.com"></iframe>';

        $response = $this->actingAs($admin)->post(route('news.store'), [
            'title'       => 'Workshop Keamanan Sistem',
            'date'        => '2026-09-30',
            'category_id' => $category->id,
            'image'       => $imageFile,
            'content'     => $maliciousContent,
        ]);

        $response->assertRedirect(route('news.index'));
        $response->assertSessionHas('success');

        $news = M_news::where('title', 'Workshop Keamanan Sistem')->first();
        $this->assertNotNull($news);

        // Verifikasi database tidak menyimpan script atau payload berbahaya
        $this->assertStringNotContainsString('<script', $news->content);
        $this->assertStringNotContainsString('alert(', $news->content);
        $this->assertStringNotContainsString('onerror', $news->content);
        $this->assertStringNotContainsString('javascript:', $news->content);
        $this->assertStringNotContainsString('<iframe', $news->content);

        // Verifikasi format yang sah tetap ada
        $this->assertStringContainsString('Workshop Keamanan Sistem', $news->title);
        $this->assertStringContainsString('<strong>Polibang</strong>', $news->content);

        // Akses halaman detail publik
        $detailResponse = $this->get(route('tampilan.detail', $news->id));
        $detailResponse->assertOk();
        $detailResponse->assertSee('Workshop Keamanan Sistem');
        $detailResponse->assertSee('<strong>Polibang</strong>', false);
        $detailResponse->assertDontSee('<script>alert("XSS_STORED")</script>', false);
        $detailResponse->assertDontSee('onerror="alert(1)"', false);
    }
}
