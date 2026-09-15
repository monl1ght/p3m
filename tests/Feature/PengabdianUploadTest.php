<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\kum_pengabdianModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PengabdianUploadTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function dosen_bisa_mengakses_halaman_tambah_laporan_pengabdian_dengan_atribut_upload_lengkap(): void
    {
        $dosen = User::factory()->dosen()->create();

        $response = $this->actingAs($dosen)->get(route('dosen.addkpengabdian'));

        $response->assertStatus(200);
        $response->assertSee('id="uploadLaporan"', false);
        $response->assertSee('data-p3m-upload-name-id="uploadLaporanName"', false);
        $response->assertSee('data-p3m-upload-preserve-accept', false);
        $response->assertSee('accept=".pdf,application/pdf"', false);
        $response->assertSee('id="uploadLaporanName"', false);
        $response->assertSee('name="foto"', false);
        $response->assertSee('data-p3m-upload-max-bytes="2097152"', false);
    }

    #[Test]
    public function unggah_laporan_pengabdian_menolak_foto_melebihi_2mb(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan.pdf', 1024, 'application/pdf');
        // 3000 KB > 2048 KB limit
        $oversizedPhoto = UploadedFile::fake()->create('foto_besar.jpg', 3000, 'image/jpeg');

        $payload = [
            'judul' => 'Pengabdian Foto Besar',
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Kategori',
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

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanp3m'), $payload);

        $response->assertSessionHasErrors('foto');
        $this->assertDatabaseMissing('kum_pengabdian_models', [
            'judul' => 'Pengabdian Foto Besar',
        ]);
    }

    #[Test]
    public function dosen_berhasil_mengunggah_laporan_pengabdian(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan_pengabdian.pdf', 1024, 'application/pdf');
        $photo = UploadedFile::fake()->image('dokumentasi.jpg', 600, 600);

        $payload = [
            'judul' => 'Pengabdian Masyarakat Digital Desa',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Kategori Pengabdian',
            'lokasi' => 'Desa Sukamaju',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'uppdf' => $pdf,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Budi Santoso',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'foto' => $photo,
            'anggota' => [
                [
                    'nama' => 'Ahmad Anggota',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanp3m'), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dosen.dash_kpengabdian'));

        $this->assertDatabaseHas('kum_pengabdian_models', [
            'user_id' => $dosen->id,
            'judul' => 'Pengabdian Masyarakat Digital Desa',
            'prodi' => 'R',
        ]);

        $submission = kum_pengabdianModel::where('judul', 'Pengabdian Masyarakat Digital Desa')->first();
        $this->assertNotNull($submission);
        $this->assertNotNull($submission->uppdf);
        Storage::disk('private')->assertExists('submissions/' . $submission->uppdf);
    }

    #[Test]
    public function dosen_dengan_prodi_bisnis_digital_dan_agribisnis_bisa_unggah_laporan(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan_ab.pdf', 1024, 'application/pdf');
        $photo = UploadedFile::fake()->image('dokumentasi.png', 400, 400);

        $payload = [
            'judul' => 'Pengabdian Bisnis Digital',
            'bidang' => 'Bisnis',
            'jeniskategori' => 'Kategori Bisnis',
            'lokasi' => 'Semarang',
            'biaya' => '3000000',
            'uppdf' => $pdf,
            'tanggal_mulai' => '2026-02-01',
            'tanggal_selesai' => '2026-05-01',
            'ketua' => 'Siti Rahma',
            'jabatan' => 'KP',
            'nidn' => '0098765432',
            'telp' => '08987654321',
            'alamat' => 'Semarang Tengah',
            'jeniskelamin' => 'P',
            'prodi' => 'AB', // Bisnis Digital
            'foto' => $photo,
            'anggota' => [
                [
                    'nama' => 'Bambang',
                    'prodi' => 'AP', // Agribisnis Perternakan
                    'nim' => '2026002',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanp3m'), $payload);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dosen.dash_kpengabdian'));

        $this->assertDatabaseHas('kum_pengabdian_models', [
            'judul' => 'Pengabdian Bisnis Digital',
            'prodi' => 'AB',
        ]);
    }

    #[Test]
    public function unggah_laporan_pengabdian_menolak_file_non_pdf(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $docx = UploadedFile::fake()->create('laporan.docx', 1024, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $photo = UploadedFile::fake()->image('dokumentasi.jpg', 600, 600);

        $payload = [
            'judul' => 'Pengabdian Non PDF',
            'bidang' => 'Teknologi',
            'jeniskategori' => 'Kategori',
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

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanp3m'), $payload);

        $response->assertSessionHasErrors('uppdf');
        $this->assertDatabaseMissing('kum_pengabdian_models', [
            'judul' => 'Pengabdian Non PDF',
        ]);
    }

    #[Test]
    public function validasi_gagal_menyimpan_file_sementara_dan_bisa_disubmit_kembali_tanpa_unggah_ulang(): void
    {
        Storage::fake('private');
        Storage::fake('public');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('laporan_cached.pdf', 1024, 'application/pdf');
        $photo = UploadedFile::fake()->image('dokumentasi_cached.jpg', 500, 500);

        // First submit with missing judul (triggers validation error)
        $invalidPayload = [
            'judul' => '', // missing
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Kategori Pengabdian',
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
                    'nama' => 'Ahmad Anggota',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanp3m'), $invalidPayload);

        $response->assertSessionHasErrors('judul');
        $response->assertSessionHas('cached_uppdf');
        $response->assertSessionHas('cached_foto');

        $cachedUppdf = session('cached_uppdf');
        $cachedUppdfName = session('cached_uppdf_name');
        $cachedFoto = session('cached_foto');
        $cachedFotoName = session('cached_foto_name');

        $this->assertNotEmpty($cachedUppdf);
        $this->assertNotEmpty($cachedFoto);
        $this->assertSame('laporan_cached.pdf', $cachedUppdfName);

        // Follow redirect and ensure HTML renders cached inputs and indicators
        $formPage = $this->actingAs($dosen)->get(route('dosen.addkpengabdian'));
        $formPage->assertStatus(200);
        $formPage->assertSee('name="cached_uppdf"', false);
        $formPage->assertSee('name="cached_foto"', false);
        $formPage->assertSee('(Tersimpan)', false);
        $formPage->assertSee('Ganti File', false);

        // Second submit: now fill judul, WITHOUT re-uploading file objects, using cached tokens
        $validPayload = [
            'judul' => 'Pengabdian Berhasil Tersimpan',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Kategori Pengabdian',
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
                    'nama' => 'Ahmad Anggota',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $secondResponse = $this->actingAs($dosen)->post(route('dosen.storekumpulanp3m'), $validPayload);

        $secondResponse->assertSessionHasNoErrors();
        $secondResponse->assertRedirect(route('dosen.dash_kpengabdian'));

        $this->assertDatabaseHas('kum_pengabdian_models', [
            'user_id' => $dosen->id,
            'judul' => 'Pengabdian Berhasil Tersimpan',
        ]);

        $submission = kum_pengabdianModel::where('judul', 'Pengabdian Berhasil Tersimpan')->first();
        $this->assertNotNull($submission);
        $this->assertNotNull($submission->uppdf);
        Storage::disk('private')->assertExists('submissions/' . $submission->uppdf);
    }

    #[Test]
    public function validasi_gagal_mempertahankan_semua_anggota_yang_diinput(): void
    {
        $dosen = User::factory()->dosen()->create();

        $payload = [
            'judul' => '', // missing to trigger validation failure
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
                    'nama' => 'Anggota Pertama',
                    'prodi' => 'R',
                    'nim' => '111111',
                    'jabatan' => 'MHS',
                ],
                [
                    'nama' => 'Anggota Kedua Dosen',
                    'prodi' => 'AB',
                    'nim' => '222222',
                    'jabatan' => 'DS',
                ],
                [
                    'nama' => 'Anggota Ketiga Pejabat',
                    'prodi' => 'AK',
                    'nim' => '333333',
                    'jabatan' => 'KP',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storekumpulanp3m'), $payload);

        $response->assertSessionHasErrors('judul');

        // Check that following the redirect renders all 3 members in the HTML
        $formPage = $this->actingAs($dosen)->get(route('dosen.addkpengabdian'));
        $formPage->assertStatus(200);
        $formPage->assertSee('Anggota Pertama');
        $formPage->assertSee('Anggota Kedua Dosen');
        $formPage->assertSee('Anggota Ketiga Pejabat');
        $formPage->assertSee('name="anggota[0][nama]"', false);
        $formPage->assertSee('name="anggota[1][nama]"', false);
        $formPage->assertSee('name="anggota[2][nama]"', false);
    }

    #[Test]
    public function validasi_gagal_pengajuan_pengabdian_menyimpan_file_sementara_dan_bisa_disubmit_kembali_tanpa_unggah_ulang(): void
    {
        Storage::fake('private');

        $dosen = User::factory()->dosen()->create();

        $pdf = UploadedFile::fake()->create('proposal_pengabdian_cached.pdf', 1024, 'application/pdf');

        // First submit with missing judul
        $invalidPayload = [
            'judul' => '', // missing
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Kategori Proposal Pengabdian',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'uppdf' => $pdf,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Proposal Pengabdian',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Ahmad Anggota Pengabdian',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storep3m'), $invalidPayload);

        $response->assertSessionHasErrors('judul');
        $response->assertSessionHas('cached_uppdf');

        $cachedUppdf = session('cached_uppdf');
        $cachedUppdfName = session('cached_uppdf_name');

        $this->assertNotEmpty($cachedUppdf);
        $this->assertSame('proposal_pengabdian_cached.pdf', $cachedUppdfName);

        // Follow redirect to page and verify HTML
        $formPage = $this->actingAs($dosen)->get(route('dosen.addp3m'));
        $formPage->assertStatus(200);
        $formPage->assertSee('name="cached_uppdf"', false);
        $formPage->assertSee('(Tersimpan)', false);
        $formPage->assertSee('Ganti File', false);

        // Second submit with filled judul and cached tokens
        $validPayload = [
            'judul' => 'Proposal Pengabdian Berhasil Tersimpan',
            'bidang' => 'Teknologi Informasi',
            'jeniskategori' => 'Kategori Proposal Pengabdian',
            'lokasi' => 'Semarang',
            'lamapenelitian' => '6 Bulan',
            'biaya' => '5000000',
            'cached_uppdf' => $cachedUppdf,
            'cached_uppdf_name' => $cachedUppdfName,
            'tanggal_mulai' => '2026-01-01',
            'tanggal_selesai' => '2026-06-30',
            'ketua' => 'Dr. Proposal Pengabdian',
            'jabatan' => 'DS',
            'nidn' => '0012345678',
            'telp' => '08123456789',
            'alamat' => 'Jl. Kampus No. 1',
            'jeniskelamin' => 'L',
            'prodi' => 'R',
            'anggota' => [
                [
                    'nama' => 'Ahmad Anggota Pengabdian',
                    'prodi' => 'R',
                    'nim' => '2026001',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $secondResponse = $this->actingAs($dosen)->post(route('dosen.storep3m'), $validPayload);

        $secondResponse->assertSessionHasNoErrors();
        $secondResponse->assertRedirect(route('dosen.upp3m'));

        $this->assertDatabaseHas('ajupengabdian', [
            'user_id' => $dosen->id,
            'judul' => 'Proposal Pengabdian Berhasil Tersimpan',
        ]);

        $submission = \App\Models\p3mModel::where('judul', 'Proposal Pengabdian Berhasil Tersimpan')->first();
        $this->assertNotNull($submission);
        $this->assertNotNull($submission->uppdf);
        Storage::disk('private')->assertExists('submissions/' . $submission->uppdf);
    }

    #[Test]
    public function validasi_gagal_pengajuan_pengabdian_mempertahankan_semua_anggota_yang_diinput(): void
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
                    'nama' => 'Anggota Pengabdian Satu',
                    'prodi' => 'R',
                    'nim' => '111111',
                    'jabatan' => 'MHS',
                ],
                [
                    'nama' => 'Anggota Pengabdian Dua',
                    'prodi' => 'AB',
                    'nim' => '222222',
                    'jabatan' => 'DS',
                ],
                [
                    'nama' => 'Anggota Pengabdian Tiga',
                    'prodi' => 'AK',
                    'nim' => '333333',
                    'jabatan' => 'KP',
                ],
            ],
        ];

        $response = $this->actingAs($dosen)->post(route('dosen.storep3m'), $payload);

        $response->assertSessionHasErrors('judul');

        // Check HTML renders all 3 members
        $formPage = $this->actingAs($dosen)->get(route('dosen.addp3m'));
        $formPage->assertStatus(200);
        $formPage->assertSee('Anggota Pengabdian Satu');
        $formPage->assertSee('Anggota Pengabdian Dua');
        $formPage->assertSee('Anggota Pengabdian Tiga');
        $formPage->assertSee('name="anggota[0][nama]"', false);
        $formPage->assertSee('name="anggota[1][nama]"', false);
        $formPage->assertSee('name="anggota[2][nama]"', false);
    }
}


