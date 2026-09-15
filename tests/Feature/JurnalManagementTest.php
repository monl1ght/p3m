<?php

namespace Tests\Feature;

use App\Models\JurnalModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class JurnalManagementTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_bisa_melihat_halaman_index_jurnal(): void
    {
        $admin = User::factory()->admin()->create();
        JurnalModel::create([
            'jurnalname' => 'Jurnal Penelitian Prototipe IoT',
            'link'       => 'https://scholar.google.com/citations?user=123',
        ]);

        $response = $this->actingAs($admin)->get(route('jurnal.index'));

        $response->assertStatus(200);
        $response->assertSee('Jurnal Penelitian Prototipe IoT');
        $response->assertSee('scholar.google.com');
    }

    #[Test]
    public function admin_bisa_menambah_jurnal_dengan_link_valid(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('jurnal.store'), [
            'jurnalname' => 'Sistem Informasi Presensi Mahasiswa',
            'link'       => 'https://journal.polibang.ac.id/index.php/jti/article/view/100',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('jurnal.index'));
        $response->assertSessionHas('success', 'Jurnal berhasil ditambahkan!');

        $this->assertDatabaseHas('jurnal_models', [
            'jurnalname' => 'Sistem Informasi Presensi Mahasiswa',
            'link'       => 'https://journal.polibang.ac.id/index.php/jti/article/view/100',
        ]);
    }

    #[Test]
    public function store_jurnal_otomatis_menambahkan_https_jika_belum_ada_protokol(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('jurnal.store'), [
            'jurnalname' => 'Kajian Machine Learning Terapan',
            'link'       => 'scholar.google.com/citations?id=abc',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('jurnal.index'));

        $this->assertDatabaseHas('jurnal_models', [
            'jurnalname' => 'Kajian Machine Learning Terapan',
            'link'       => 'https://scholar.google.com/citations?id=abc',
        ]);
    }

    #[Test]
    public function store_jurnal_menolak_judul_kosong_dan_link_tidak_valid(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('jurnal.store'), [
            'jurnalname' => '',
            'link'       => 'bukan-sebuah-url-valid',
        ]);

        $response->assertSessionHasErrors(['jurnalname', 'link']);
        $response->assertSessionHas('error');
        $this->assertEquals(0, JurnalModel::count());
    }

    #[Test]
    public function admin_bisa_mengupdate_jurnal(): void
    {
        $admin = User::factory()->admin()->create();
        $jurnal = JurnalModel::create([
            'jurnalname' => 'Judul Awal',
            'link'       => 'https://example.com/awal',
        ]);

        $response = $this->actingAs($admin)->put(route('jurnal.update', $jurnal->id), [
            'jurnalname' => 'Judul Revisi Publikasi 2026',
            'link'       => 'https://example.com/revisi',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('jurnal.index'));
        $response->assertSessionHas('success', 'Jurnal berhasil diperbarui!');

        $this->assertDatabaseHas('jurnal_models', [
            'id'         => $jurnal->id,
            'jurnalname' => 'Judul Revisi Publikasi 2026',
            'link'       => 'https://example.com/revisi',
        ]);
    }

    #[Test]
    public function admin_bisa_menghapus_jurnal(): void
    {
        $admin = User::factory()->admin()->create();
        $jurnal = JurnalModel::create([
            'jurnalname' => 'Jurnal Hendak Dihapus',
            'link'       => 'https://example.com/hapus',
        ]);

        $response = $this->actingAs($admin)->delete(route('jurnal.delete', $jurnal->id));

        $response->assertRedirect(route('jurnal.index'));
        $response->assertSessionHas('success', 'Jurnal berhasil dihapus!');

        $this->assertDatabaseMissing('jurnal_models', [
            'id' => $jurnal->id,
        ]);
    }
}
