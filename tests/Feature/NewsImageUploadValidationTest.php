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
}
