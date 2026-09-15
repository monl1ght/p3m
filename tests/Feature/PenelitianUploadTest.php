<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\kum_penelitianModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PenelitianUploadTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function dosen_bisa_mengakses_halaman_tambah_laporan_penelitian(): void
    {
        $dosen = User::factory()->dosen()->create();

        $response = $this->actingAs($dosen)->get(route('dosen.add_kumnpeneliti'));

        $response->assertStatus(200);
        $response->assertSee('id="uploadLaporanPenelitian"', false);
        $response->assertSee('data-p3m-upload-name-id="uploadLaporanPenelitianName"', false);
        $response->assertSee('data-p3m-upload-preserve-accept', false);
        $response->assertSee('accept=".pdf,application/pdf"', false);
        $response->assertSee('id="uploadLaporanPenelitianName"', false);
        $response->assertSee('name="foto"', false);
        $response->assertSee('data-p3m-upload-max-bytes="2097152"', false);
    }

    #[Test]
    public function unggah_laporan_penelitian_menolak_foto_melebihi_2mb(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan.pdf', 1024, 'application/pdf');
        // 3000 KB > 2048 KB limit
        $oversizedPhoto = UploadedFile::fake()->create('foto_besar.jpg', 3000, 'image/jpeg');

        $payload = [
            'judul' => 'Penelitian Foto Besar',
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '3 Bulan',
            'biaya' => '1000000',
            'uppdf' => $pdf,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-03-31',
            'ketua' => 'Ketua Test',
            'jabatan' => 'DS',
            'nidn' => '123456',
            'telp' => '08123456',
            'alamat' => 'Alamat Test',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'foto' => $oversizedPhoto,
            'anggota' => [
                [
                    'nama' => 'Anggota Test',
                    'prodi' => 'R',
                    'nim' => '111',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanpenelitian'), $payload);

        $response->assertSessionHasErrors('foto');
        $this->assertDatabaseMissing('kum_penelitian_models', [
            'judul' => 'Penelitian Foto Besar',
        ]);
    }

    #[Test]
    public function dosen_berhasil_mengunggah_laporan_penelitian_dengan_jabatan_wakil_direktur_lt(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan_penelitian.pdf', 1024, 'application/pdf');
        $photo = UploadedFile::fake()->image('dokumentasi.jpg', 600, 600);

        $payload = [
            'judul' => 'Penelitian Sistem AI Polibang',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '7500000',
            'uppdf' => $pdf,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Muhammad Fajar',
            'jabatan' => 'LT', // Wakil Direktur (previously caused MySQL 1265 truncation error)
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Pendidikan No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'foto' => $photo,
            'anggota' => [
                [
                    'nama' => 'Anggota Riset 1',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanpenelitian'), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dosen.dash_kpenelitian'));

        $this->assertDatabaseHas('kum_penelitian_models', [
            'user_id' => $dosen->id,
            'judul' => 'Penelitian Sistem AI Polibang',
            'jabatan' => 'LT',
            'prodi' => 'R',
        ]);

        $submission = kum_penelitianModel::where('judul', 'Penelitian Sistem AI Polibang')->first();
        $this->assertNotNull($submission);
        $this->assertNotNull($submission->uppdf);
        Storage::disk('private')->assertExists('submissions/' . $submission->uppdf);
    }

    #[Test]
    public function halaman_dosen_dan_admin_menampilkan_status_proses_dari_data_laporan_yang_sama(): void
    {
        $dosen = User::factory()->dosen()->create();
        $admin = User::factory()->admin()->create();

        $submission = kum_penelitianModel::create([
            'user_id' => $dosen->id,
            'judul' => 'Laporan Status Konsisten',
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => 5000000,
            'uppdf' => 'status-konsisten.pdf',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Status',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
        ]);

        $submission->refresh();
        $this->assertSame('proses', $submission->status);

        $this->actingAs($dosen)
            ->get(route('dosen.dash_kpenelitian'))
            ->assertOk()
            ->assertSee('Laporan Status Konsisten')
            ->assertSee('Diproses')
            ->assertDontSee('Ditolak');

        $this->actingAs($admin)
            ->get(route('plppm.kpenelitian'))
            ->assertOk()
            ->assertSee('Laporan Status Konsisten')
            ->assertSee('Diproses');
    }

    #[Test]
    public function unggah_laporan_penelitian_menolak_file_non_pdf(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $docx = UploadedFile::fake()->create('laporan.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $photo = UploadedFile::fake()->image('dokumentasi.jpg', 600, 600);

        $payload = [
            'judul' => 'Penelitian Non PDF',
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Jepara',
            'biaya' => '1000000',
            'uppdf' => $docx,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Ketua Test',
            'jabatan' => 'DS',
            'nidn' => '123456',
            'telp' => '08123456',
            'alamat' => 'Alamat Test',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'foto' => $photo,
            'anggota' => [
                [
                    'nama' => 'Anggota Test',
                    'prodi' => 'R',
                    'nim' => '111',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanpenelitian'), $payload);

        $response->assertSessionHasErrors('uppdf');
        $this->assertDatabaseMissing('kum_penelitian_models', [
            'judul' => 'Penelitian Non PDF',
        ]);
    }

    #[Test]
    public function dosen_bisa_memperbarui_laporan_penelitian_tanpa_unggah_ulang_file(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan_lama.pdf', 1024, 'application/pdf');
        $photo = UploadedFile::fake()->image('foto_lama.jpg', 600, 600);

        $penelitian = kum_penelitianModel::create([
            'user_id' => $dosen->id,
            'judul' => 'Judul Sebelum Update',
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => 5000000,
            'uppdf' => 'submissions/existing.pdf',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Budi',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'foto' => 'submissions/existing.jpg',
            'status' => 'pending',
        ]);

        $payload = [
            'judul' => 'Judul Setelah Update',
            'bidang' => 'Sistem Cerdas',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Kudus',
            'lamapenelitian' => '8 Bulan',
            'biaya' => '6000000',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-08-31',
            'ketua' => 'Dr. Budi Santoso, M.Kom',
            'jabatan' => 'LT', // update to Wakil Direktur
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus Baru',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Anggota Tim 1',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.updatekumpulanpenelitian', $penelitian->id), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dosen.dash_kpenelitian'));

        $this->assertDatabaseHas('kum_penelitian_models', [
            'id' => $penelitian->id,
            'judul' => 'Judul Setelah Update',
            'jabatan' => 'LT',
            'uppdf' => 'submissions/existing.pdf',
        ]);
    }

    #[Test]
    public function dosen_bisa_menghapus_laporan_penelitian_dan_menerima_flash_sukses(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $penelitian = kum_penelitianModel::create([
            'user_id' => $dosen->id,
            'judul' => 'Laporan Siap Hapus',
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Kudus',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'uppdf' => 'submissions/delete_me.pdf',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Budi',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
        ]);

        $response = $this->actingAs($dosen)->delete(route('dosen.deletekpen', $penelitian->id));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dosen.dash_kpenelitian'));
        $response->assertSessionHas('success', 'Data dan file terkait berhasil dihapus!');

        $this->assertDatabaseMissing('kum_penelitian_models', [
            'id' => $penelitian->id,
        ]);

        // Follow redirect and check global alert flash element
        $followResponse = $this->actingAs($dosen)->get(route('dosen.dash_kpenelitian'));
        $followResponse->assertStatus(200);
        $followResponse->assertSee('global-delete-form', false);
    }

    #[Test]
    public function dosen_bisa_mengakses_halaman_edit_laporan_penelitian_dengan_anggota(): void
    {
        $dosen = User::factory()->dosen()->create();

        $penelitian = kum_penelitianModel::create([
            'user_id' => $dosen->id,
            'judul' => 'Penelitian untuk Di-edit',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'uppdf' => 'submissions/existing.pdf',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Budi Santoso',
            'jabatan' => 'KP',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'status' => 'pending',
        ]);

        \App\Models\anggotap3mModel::create([
            'kpenel_model_id' => $penelitian->id,
            'nama' => 'Anggota 1 Budi',
            'prodi' => 'R',
            'nim' => '2026001',
            'jabatan' => 'MHS',
        ]);

        $response = $this->actingAs($dosen)->get(route('dosen.edit_kpenliti', $penelitian->id));

        $response->assertStatus(200);
        $response->assertSee('Penelitian untuk Di-edit');
        $response->assertSee('Dr. Budi Santoso');
        $response->assertSee('Anggota 1 Budi');
        $response->assertSee('Laporan Penelitian Masyarakat');
    }

    #[Test]
    public function validasi_gagal_penelitian_menyimpan_file_sementara_dan_bisa_disubmit_kembali_tanpa_unggah_ulang(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan_penelitian_cached.pdf', 1024, 'application/pdf');
        $photo = UploadedFile::fake()->image('dokumentasi_penelitian_cached.jpg', 500, 500);

        // First submit with missing judul (triggers validation error)
        $invalidPayload = [
            'judul' => '', // missing
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'uppdf' => $pdf,
            'foto' => $photo,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Budi Santoso',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Ahmad Peneliti',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanpenelitian'), $invalidPayload);

        $response->assertSessionHasErrors('judul');
        $response->assertSessionHas('cached_uppdf');
        $response->assertSessionHas('cached_foto');

        $cachedUppdf = session('cached_uppdf');
        $cachedUppdfName = session('cached_uppdf_name');
        $cachedFoto = session('cached_foto');
        $cachedFotoName = session('cached_foto_name');

        $this->assertNotEmpty($cachedUppdf);
        $this->assertNotEmpty($cachedFoto);
        $this->assertSame('laporan_penelitian_cached.pdf', $cachedUppdfName);

        // Follow redirect and ensure HTML renders cached inputs and indicators
        $formPage = $this->actingAs($dosen)->get(route('dosen.add_kumnpeneliti'));
        $formPage->assertStatus(200);
        $formPage->assertSee('name="cached_uppdf"', false);
        $formPage->assertSee('name="cached_foto"', false);
        $formPage->assertSee('(Tersimpan)', false);
        $formPage->assertSee('Ganti File', false);

        // Second submit: now fill judul, WITHOUT re-uploading file objects, using cached tokens
        $validPayload = [
            'judul' => 'Penelitian Berhasil Tersimpan',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'cached_uppdf' => $cachedUppdf,
            'cached_uppdf_name' => $cachedUppdfName,
            'cached_foto' => $cachedFoto,
            'cached_foto_name' => $cachedFotoName,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Budi Santoso',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Ahmad Peneliti',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $secondResponse = $this->actingAs($dosen)->post(route('dosen.storekumpulanpenelitian'), $validPayload);

        $secondResponse->assertSessionHasNoErrors();
        $secondResponse->assertRedirect(route('dosen.dash_kpenelitian'));

        $this->assertDatabaseHas('kum_penelitian_models', [
            'user_id' => $dosen->id,
            'judul' => 'Penelitian Berhasil Tersimpan',
        ]);

        $submission = kum_penelitianModel::where('judul', 'Penelitian Berhasil Tersimpan')->first();
        $this->assertNotNull($submission);
        $this->assertNotNull($submission->uppdf);
        Storage::disk('private')->assertExists('submissions/' . $submission->uppdf);
    }

    #[Test]
    public function validasi_gagal_penelitian_mempertahankan_semua_anggota_yang_diinput(): void
    {
        $dosen = User::factory()->dosen()->create();

        $payload = [
            'judul' => '', // missing to trigger validation failure
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Laporan Penelitian Masyarakat',
            'lokasi' => 'Semarang',
            'biaya' => '1000000',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Ketua Test',
            'jabatan' => 'DS',
            'nidn' => '123456',
            'telp' => '08123456',
            'alamat' => 'Alamat Test',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Peneliti Pertama',
                    'prodi' => 'R',
                    'nim' => '111111',
                    'jabatan' => 'MHS',
                ],
                [
                    'nama' => 'Peneliti Kedua Dosen',
                    'prodi' => 'AB',
                    'nim' => '222222',
                    'jabatan' => 'DS',
                ],
                [
                    'nama' => 'Peneliti Ketiga Pejabat',
                    'prodi' => 'AK',
                    'nim' => '333333',
                    'jabatan' => 'KP',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanpenelitian'), $payload);

        $response->assertSessionHasErrors('judul');

        // Check that following the redirect renders all 3 members in the HTML
        $formPage = $this->actingAs($dosen)->get(route('dosen.add_kumnpeneliti'));
        $formPage->assertStatus(200);
        $formPage->assertSee('Peneliti Pertama');
        $formPage->assertSee('Peneliti Kedua Dosen');
        $formPage->assertSee('Peneliti Ketiga Pejabat');
        $formPage->assertSee('name="anggota[0][nama]"', false);
        $formPage->assertSee('name="anggota[1][nama]"', false);
        $formPage->assertSee('name="anggota[2][nama]"', false);
    }

    #[Test]
    public function validasi_gagal_pengajuan_penelitian_menyimpan_file_sementara_dan_bisa_disubmit_kembali_tanpa_unggah_ulang(): void
    {
        Storage::fake('private');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('proposal_penelitian_cached.pdf', 1024, 'application/pdf');

        // First submit with missing judul
        $invalidPayload = [
            'judul' => '', // missing
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Kategori Proposal',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'uppdf' => $pdf,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Proposal Santoso',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Ahmad Anggota Proposal',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storepenelitian'), $invalidPayload);

        $response->assertSessionHasErrors('judul');
        $response->assertSessionHas('cached_uppdf');

        $cachedUppdf = session('cached_uppdf');
        $cachedUppdfName = session('cached_uppdf_name');

        $this->assertNotEmpty($cachedUppdf);
        $this->assertSame('proposal_penelitian_cached.pdf', $cachedUppdfName);

        // Follow redirect to page and verify HTML
        $formPage = $this->actingAs($dosen)->get(route('dosen.add_ajuanpenelitian'));
        $formPage->assertStatus(200);
        $formPage->assertSee('name="cached_uppdf"', false);
        $formPage->assertSee('(Tersimpan)', false);
        $formPage->assertSee('Ganti File', false);

        // Second submit with filled judul and cached tokens
        $validPayload = [
            'judul' => 'Proposal Penelitian Berhasil Tersimpan',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Kategori Proposal',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'cached_uppdf' => $cachedUppdf,
            'cached_uppdf_name' => $cachedUppdfName,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Proposal Santoso',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Ahmad Anggota Proposal',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $secondResponse = $this->actingAs($dosen)->post(route('dosen.storepenelitian'), $validPayload);

        $secondResponse->assertSessionHasNoErrors();
        $secondResponse->assertRedirect(route('dosen.dash_ajuanpenelitian'));

        $this->assertDatabaseHas('ajuan_penelitian_models', [
            'user_id' => $dosen->id,
            'judul' => 'Proposal Penelitian Berhasil Tersimpan',
        ]);

        $submission = \App\Models\ajuan_penelitianModel::where('judul', 'Proposal Penelitian Berhasil Tersimpan')->first();
        $this->assertNotNull($submission);
        $this->assertNotNull($submission->uppdf);
        Storage::disk('private')->assertExists('submissions/' . $submission->uppdf);
    }

    #[Test]
    public function validasi_gagal_pengajuan_penelitian_mempertahankan_semua_anggota_yang_diinput(): void
    {
        $dosen = User::factory()->dosen()->create();

        $payload = [
            'judul' => '', // missing
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Kategori',
            'lokasi' => 'Semarang',
            'biaya' => '1000000',
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Ketua Test',
            'jabatan' => 'DS',
            'nidn' => '123456',
            'telp' => '08123456',
            'alamat' => 'Alamat Test',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Anggota Proposal Satu',
                    'prodi' => 'R',
                    'nim' => '111111',
                    'jabatan' => 'MHS',
                ],
                [
                    'nama' => 'Anggota Proposal Dua',
                    'prodi' => 'AB',
                    'nim' => '222222',
                    'jabatan' => 'DS',
                ],
                [
                    'nama' => 'Anggota Proposal Tiga',
                    'prodi' => 'AK',
                    'nim' => '333333',
                    'jabatan' => 'KP',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storepenelitian'), $payload);

        $response->assertSessionHasErrors('judul');

        // Check HTML renders all 3 members
        $formPage = $this->actingAs($dosen)->get(route('dosen.add_ajuanpenelitian'));
        $formPage->assertStatus(200);
        $formPage->assertSee('Anggota Proposal Satu');
        $formPage->assertSee('Anggota Proposal Dua');
        $formPage->assertSee('Anggota Proposal Tiga');
        $formPage->assertSee('name="anggota[0][nama]"', false);
        $formPage->assertSee('name="anggota[1][nama]"', false);
        $formPage->assertSee('name="anggota[2][nama]"', false);
    }
}


