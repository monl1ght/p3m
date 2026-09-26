<?php

namespace Tests\Feature;

use App\Models\AgendaModel;
use App\Models\ajuan_penelitianModel;
use App\Models\Hki;
use App\Models\M_categories;
use App\Models\M_news;
use App\Models\p3mModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediumP2AuditTest extends TestCase
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

    /**
     * MEDIUM-01: View composer notifikasi hanya aktif untuk admin di layout.main
     */
    public function test_view_composer_notification_only_loads_for_admin(): void
    {
        // Buat data pengajuan yang belum dibaca
        p3mModel::create([
            'user_id'         => $this->dosen->id,
            'judul'           => 'Pengabdian Test Balekambang',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen Pengabdi',
            'jeniskelamin'    => 'L',
            'nidn'            => '0612345678',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '081234567890',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Balekambang',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'dummy.pdf',
            'jeniskategori'   => 'Pengabdian',
            'status'          => 'proses',
            'tanggal_mulai'   => now()->toDateString(),
            'tanggal_selesai' => now()->addMonth()->toDateString(),
            'read_at'         => null,
        ]);

        // Akses sebagai guest di halaman publik
        $responseGuest = $this->get(route('tampilan'));
        $responseGuest->assertStatus(200);
        $responseGuest->assertDontSee('1 Pengajuan Pengabdian');

        // Akses sebagai dosen ke halaman dosen
        $responseDosen = $this->actingAs($this->dosen)->get(route('dosen.hki.index'));
        $responseDosen->assertStatus(200);
        $responseDosen->assertDontSee('1 Pengajuan Pengabdian');

        // Akses sebagai admin ke halaman admin yang menggunakan layout.main (category.index)
        $responseAdmin = $this->actingAs($this->admin)->get(route('category.index'));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertSee('1 Pengajuan Pengabdian');
    }

    /**
     * Dosen pemilik dapat mengedit dan menghapus HKI miliknya
     */
    public function test_dosen_can_edit_and_delete_own_hki(): void
    {
        Storage::fake('private');

        $ownHki = Hki::create([
            'user_id'          => $this->dosen->id,
            'judul'            => 'Hak Cipta Modul Pembelajaran Web',
            'tanggal'          => '2026-05-10',
            'jenis_hki'        => 'Hak Cipta',
            'nomor_pencatatan' => 'EC00202612345',
            'file_path'        => 'hki-sertifikat/sample.pdf',
            'file_name'        => 'sample.pdf',
            'status'           => 'diterima',
        ]);

        // Akses form edit
        $responseEdit = $this->actingAs($this->dosen)
            ->get(route('dosen.hki.edit', $ownHki->id));
        $responseEdit->assertStatus(200);

        // Kirim update
        $responseUpdate = $this->actingAs($this->dosen)
            ->post(route('dosen.hki.update', $ownHki->id), [
                'judul'   => 'Judul Baru Yang Berhasil Diubah',
                'tanggal' => '2026-06-01',
                'anggota' => [
                    ['nama' => 'Dosen Penulis', 'peran' => 'Ketua'],
                ],
            ]);
        $responseUpdate->assertRedirect(route('dosen.hki.index'));
        $responseUpdate->assertSessionHas('success');

        // Pastikan judul berhasil berubah di DB
        $this->assertDatabaseHas('hkis', [
            'id'    => $ownHki->id,
            'judul' => 'Judul Baru Yang Berhasil Diubah',
        ]);

        // Hapus HKI
        $responseDelete = $this->actingAs($this->dosen)
            ->delete(route('dosen.hki.delete', $ownHki->id));
        $responseDelete->assertRedirect(route('dosen.hki.index'));
        $responseDelete->assertSessionHas('success');

        // Pastikan record terhapus
        $this->assertDatabaseMissing('hkis', [
            'id' => $ownHki->id,
        ]);
    }

    /**
     * MEDIUM-02: HKI yang masih 'diproses' atau 'revisi' tetap dapat diedit & dihapus
     */
    public function test_dosen_can_edit_and_delete_in_process_hki(): void
    {
        Storage::fake('private');

        $inProcessHki = Hki::create([
            'user_id'          => $this->dosen->id,
            'judul'            => 'Hak Cipta Game Edukasi',
            'tanggal'          => '2026-05-10',
            'jenis_hki'        => 'Hak Cipta',
            'nomor_pencatatan' => 'EC00202699999',
            'file_path'        => 'hki-sertifikat/sample2.pdf',
            'file_name'        => 'sample2.pdf',
            'status'           => 'diproses',
        ]);

        $responseEdit = $this->actingAs($this->dosen)
            ->get(route('dosen.hki.edit', $inProcessHki->id));
        $responseEdit->assertStatus(200);

        $responseDelete = $this->actingAs($this->dosen)
            ->delete(route('dosen.hki.delete', $inProcessHki->id));
        $responseDelete->assertRedirect(route('dosen.hki.index'));
        $responseDelete->assertSessionHas('success');

        $this->assertDatabaseMissing('hkis', [
            'id' => $inProcessHki->id,
        ]);
    }

    /**
     * MEDIUM-04: Parameter pencarian q pada header navbar terhubung ke M_news di berita
     */
    public function test_public_news_search_by_query_parameter(): void
    {
        $cat = M_categories::create([
            'name' => 'Umum',
            'slug' => 'umum',
        ]);

        $news1 = M_news::create([
            'title'        => 'Seminar Nasional Kecerdasan Buatan',
            'description'  => 'Kegiatan ilmiah yang dihadiri oleh seluruh dosen dan peneliti nasional.',
            'content'      => '<p>Kegiatan ilmiah yang dihadiri oleh seluruh dosen dan peneliti nasional.</p>',
            'image'        => 'dummy1.jpg',
            'date'         => now()->toDateString(),
            'time'         => '09:00',
            'category_id'  => $cat->id,
        ]);

        $news2 = M_news::create([
            'title'        => 'Pelatihan Pertanian Hidroponik',
            'description'  => 'Pelatihan bagi masyarakat desa sekitar kampus.',
            'content'      => '<p>Pelatihan bagi masyarakat desa sekitar kampus.</p>',
            'image'        => 'dummy2.jpg',
            'date'         => now()->toDateString(),
            'time'         => '13:00',
            'category_id'  => $cat->id,
        ]);

        $response = $this->get(route('tampilan.berita', ['q' => 'Kecerdasan Buatan']));
        $response->assertStatus(200);
        $response->assertSee('Seminar Nasional Kecerdasan Buatan');
        $response->assertDontSee('Pelatihan Pertanian Hidroponik');
    }

    /**
     * MEDIUM-06: CategoryController menerapkan validasi unique slug pada store dan ubah
     */
    public function test_category_slug_must_be_unique(): void
    {
        $cat1 = M_categories::create([
            'name' => 'Penelitian Dosen',
            'slug' => 'penelitian-dosen',
        ]);

        // Coba buat kategori baru dengan slug yang sama
        $responseStore = $this->actingAs($this->admin)
            ->post(route('category.store'), [
                'name' => 'Penelitian Dosen Baru',
                'slug' => 'penelitian-dosen',
            ]);
        $responseStore->assertSessionHasErrors(['slug']);

        // Coba buat kategori baru tanpa input slug manual tapi nama yang sama sehingga slug bentrok
        $responseStoreAuto = $this->actingAs($this->admin)
            ->post(route('category.store'), [
                'name' => 'Penelitian Dosen',
                'slug' => '',
            ]);
        $responseStoreAuto->assertSessionHasErrors(['slug']);

        // Buat kategori kedua yang valid
        $cat2 = M_categories::create([
            'name' => 'Pengabdian Warga',
            'slug' => 'pengabdian-warga',
        ]);

        // Coba ubah cat2 menjadi slug milik cat1 -> harus gagal
        $responseUpdateDuplicate = $this->actingAs($this->admin)
            ->put(route('category.ubah', $cat2->id), [
                'name' => 'Pengabdian Warga Revisi',
                'slug' => 'penelitian-dosen',
            ]);
        $responseUpdateDuplicate->assertSessionHasErrors(['slug']);

        // Ubah cat2 tetap dengan slug miliknya sendiri -> harus berhasil (ignore self)
        $responseUpdateSelf = $this->actingAs($this->admin)
            ->put(route('category.ubah', $cat2->id), [
                'name' => 'Pengabdian Warga Diperbarui',
                'slug' => 'pengabdian-warga',
            ]);
        $responseUpdateSelf->assertSessionHasNoErrors();
        $responseUpdateSelf->assertRedirect(route('category.index'));
        $this->assertDatabaseHas('m_categories', [
            'id'   => $cat2->id,
            'name' => 'Pengabdian Warga Diperbarui',
        ]);
    }

    /**
     * MEDIUM-03: Surat Tugas Penelitian dapat diunduh oleh pemilik/admin jika berstatus approve
     */
    public function test_surat_tugas_penelitian_download(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen->id,
            'judul'           => 'Analisis Sistem Sensor Pertanian',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dr. Dosen Peneliti',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098801',
            'jabatan'         => 'Lektor Kepala',
            'prodi'           => 'R',
            'telp'            => '08123456789',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Laboratorium IoT',
            'lamapenelitian'  => '60',
            'biaya'           => '10000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => '001/P3M-POLIBANG/ST-PN/2026',
            'tanggal_mulai'   => now()->toDateString(),
            'tanggal_selesai' => now()->addMonths(2)->toDateString(),
        ]);

        $response = $this->actingAs($this->dosen)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }

    /**
     * MEDIUM-05: AgendaController menghapus file gambar menggunakan Storage::disk('public')
     */
    public function test_agenda_delete_removes_image_from_public_storage(): void
    {
        Storage::fake('public');

        // Buat file gambar tiruan di disk public photo-agenda
        $imageName = 'test-agenda-image.jpg';
        $imagePath = 'photo-agenda/' . $imageName;
        Storage::disk('public')->put($imagePath, 'fake-image-content');
        $this->assertTrue(Storage::disk('public')->exists($imagePath));

        $imageUrl = Storage::url($imagePath);

        $agenda = AgendaModel::create([
            'title'      => 'Agenda Rapat Koordinasi P3M',
            'date'       => now()->toDateString(),
            'time'       => '09:00',
            'lokasi'     => 'Ruang Rapat Utama',
            'keterangan' => '<p>Pembahasan agenda tahunan.</p><img src="' . $imageUrl . '">',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('agenda.delete', $agenda->id));

        $response->assertRedirect(route('agenda.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('agenda_models', [
            'id' => $agenda->id,
        ]);

        // Verifikasi gambar terhapus dari disk public dan tidak menjadi orphaned
        $this->assertFalse(Storage::disk('public')->exists($imagePath));
    }
}
