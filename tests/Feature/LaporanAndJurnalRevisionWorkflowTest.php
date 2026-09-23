<?php

namespace Tests\Feature;

use App\Models\anggotap3mModel;
use App\Models\DosenJurnalUpload;
use App\Models\kum_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\SubmissionStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LaporanAndJurnalRevisionWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $dosen;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create(['name' => 'Admin Reviewer P3M']);
        $this->dosen = User::factory()->dosen()->create(['name' => 'Dr. Budi Santoso']);
    }

    #[Test]
    public function dosen_dapat_melihat_tombol_catatan_revisi_di_tabel_laporan_pengabdian_saat_ditolak(): void
    {
        $laporan = kum_pengabdianModel::create([
            'judul'          => 'Laporan Pengabdian Pelatihan IoT Desa Karangaji',
            'bidang'         => 'Teknologi Informasi',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'PKM',
            'jeniskelamin'   => 'L',
            'nidn'           => '0612058801',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Balekambang No. 1',
            'lokasi'         => 'Jepara',
            'lamapenelitian' => '6 bulan',
            'biaya'          => 5000000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'laporan-pengabdian',
            'submission_id'   => $laporan->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Lengkapi dokumentasi foto kegiatan dan daftar hadir peserta pengabdian.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.dash_kpengabdian'));

        $response->assertOk();
        $response->assertSee('Ditolak');
        $response->assertSee('Catatan Revisi');
        $response->assertSee('Lengkapi dokumentasi foto kegiatan dan daftar hadir peserta pengabdian.');
        $response->assertSee('Admin Reviewer P3M');
    }

    #[Test]
    public function dosen_dapat_melihat_banner_catatan_revisi_di_halaman_edit_laporan_pengabdian(): void
    {
        $laporan = kum_pengabdianModel::create([
            'judul'          => 'Laporan Pengabdian Pelatihan IoT Desa Karangaji',
            'bidang'         => 'Teknologi Informasi',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'PKM',
            'jeniskelamin'   => 'L',
            'nidn'           => '0612058801',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Balekambang No. 1',
            'lokasi'         => 'Jepara',
            'lamapenelitian' => '6 bulan',
            'biaya'          => 5000000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        anggotap3mModel::create([
            'kpengab_model_id' => $laporan->id,
            'nama'             => 'Ahmad Dani',
            'nim'              => '20230101',
            'prodi'            => 'R',
            'jabatan'          => 'MHS',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'laporan-pengabdian',
            'submission_id'   => $laporan->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Lengkapi dokumentasi foto kegiatan dan daftar hadir peserta pengabdian.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.edit_kpengabdian', ['id' => $laporan->id]));

        $response->assertOk();
        $response->assertSee('Catatan Revisi dari Reviewer / Admin P3M');
        $response->assertSee('Lengkapi dokumentasi foto kegiatan dan daftar hadir peserta pengabdian.');
        $response->assertSee('Admin Reviewer P3M');
        $response->assertSee('Simpan & Ajukan Ulang Laporan', false);
    }

    #[Test]
    public function dosen_dapat_memperbaiki_dan_mengajukan_ulang_laporan_pengabdian(): void
    {
        $pastDate = now()->subDays(10);
        $laporan = kum_pengabdianModel::create([
            'judul'          => 'Laporan Pengabdian Pelatihan IoT Desa Karangaji',
            'bidang'         => 'Teknologi Informasi',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'PKM',
            'jeniskelamin'   => 'L',
            'nidn'           => '0612058801',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Balekambang No. 1',
            'lokasi'         => 'Jepara',
            'lamapenelitian' => '6 bulan',
            'biaya'          => 5000000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
            'created_at'     => $pastDate,
        ]);

        anggotap3mModel::create([
            'kpengab_model_id' => $laporan->id,
            'nama'             => 'Ahmad Dani',
            'nim'              => '20230101',
            'prodi'            => 'R',
            'jabatan'          => 'MHS',
        ]);

        $updateData = [
            'judul'           => 'Laporan Pengabdian Pelatihan IoT Desa Karangaji Revisi Lengkap',
            'bidang'          => 'Teknologi Informasi',
            'jeniskategori'   => 'PKM',
            'lokasi'          => 'Jepara Kota',
            'lamapenelitian'  => '6 bulan',
            'tanggal_mulai'   => '2026-04-01',
            'tanggal_selesai' => '2026-10-01',
            'biaya'           => 5500000,
            'ketua'           => $this->dosen->name,
            'jabatan'         => 'DS',
            'nidn'            => '0612058801',
            'telp'            => '08123456789',
            'alamat'          => 'Jl. Balekambang No. 1',
            'jeniskelamin'    => 'L',
            'prodi'           => 'R',
            'anggota'         => [
                [
                    'nama'    => 'Ahmad Dani',
                    'nim'     => '20230101',
                    'prodi'   => 'R',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($this->dosen)->post(route('dosen.updatekumpulanp3m', ['id' => $laporan->id]), $updateData);

        $response->assertRedirect(route('dosen.dash_kpengabdian'));
        $response->assertSessionHas('success');

        $laporan->refresh();
        $this->assertSame('proses', $laporan->status);
        $this->assertSame('Laporan Pengabdian Pelatihan IoT Desa Karangaji Revisi Lengkap', $laporan->judul);
        $this->assertTrue($laporan->created_at->isToday());

        $latestHistory = SubmissionStatusHistory::where('submission_type', 'laporan-pengabdian')
            ->where('submission_id', $laporan->id)
            ->latest('id')
            ->first();

        $this->assertNotNull($latestHistory);
        $this->assertSame('proses', $latestHistory->status);
        $this->assertSame('non-approve', $latestHistory->previous_status);
        $this->assertSame($this->dosen->id, $latestHistory->decided_by);

        // Pastikan di dashboard dosen & admin muncul badge "Diajukan Ulang"
        $dosenPage = $this->actingAs($this->dosen)->get(route('dosen.dash_kpengabdian'));
        $dosenPage->assertOk();
        $dosenPage->assertSee('Diajukan Ulang');

        $adminPage = $this->actingAs($this->admin)->get(route('plppm.kpengabdian'));
        $adminPage->assertOk();
        $adminPage->assertSee('Diajukan Ulang');
    }

    #[Test]
    public function dosen_dapat_melihat_tombol_catatan_revisi_di_tabel_laporan_penelitian_saat_ditolak(): void
    {
        $penelitian = kum_penelitianModel::create([
            'judul'          => 'Laporan Akhir Sistem AI Presisi Balekambang',
            'bidang'         => 'Kecerdasan Buatan',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'Penelitian Terapan',
            'jeniskelamin'   => 'L',
            'nidn'           => '0612058801',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Balekambang No. 1',
            'lokasi'         => 'Semarang',
            'lamapenelitian' => '8 bulan',
            'biaya'          => 7500000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'laporan-penelitian',
            'submission_id'   => $penelitian->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Mohon lengkapi data luaran wajib publikasi jurnal dan HKI.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.dash_kpenelitian'));

        $response->assertOk();
        $response->assertSee('Ditolak');
        $response->assertSee('Catatan Revisi');
        $response->assertSee('Mohon lengkapi data luaran wajib publikasi jurnal dan HKI.');
        $response->assertSee('Admin Reviewer P3M');
    }

    #[Test]
    public function dosen_dapat_melihat_banner_catatan_revisi_di_halaman_edit_laporan_penelitian(): void
    {
        $penelitian = kum_penelitianModel::create([
            'judul'          => 'Laporan Akhir Sistem AI Presisi Balekambang',
            'bidang'         => 'Kecerdasan Buatan',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'Penelitian Terapan',
            'jeniskelamin'   => 'L',
            'nidn'           => '0612058801',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Balekambang No. 1',
            'lokasi'         => 'Semarang',
            'lamapenelitian' => '8 bulan',
            'biaya'          => 7500000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        anggotap3mModel::create([
            'kpenelitian_model_id' => $penelitian->id,
            'nama'                 => 'Ahmad Dani',
            'nim'                  => '20230101',
            'prodi'                => 'R',
            'jabatan'              => 'MHS',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'laporan-penelitian',
            'submission_id'   => $penelitian->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Mohon lengkapi data luaran wajib publikasi jurnal dan HKI.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.edit_kpenliti', ['id' => $penelitian->id]));

        $response->assertOk();
        $response->assertSee('Catatan Revisi dari Reviewer / Admin P3M');
        $response->assertSee('Mohon lengkapi data luaran wajib publikasi jurnal dan HKI.');
        $response->assertSee('Admin Reviewer P3M');
        $response->assertSee('Simpan & Ajukan Ulang Laporan', false);
    }

    #[Test]
    public function dosen_dapat_memperbaiki_dan_mengajukan_ulang_laporan_penelitian(): void
    {
        $pastDate = now()->subDays(15);
        $penelitian = kum_penelitianModel::create([
            'judul'          => 'Laporan Akhir Sistem AI Presisi Balekambang',
            'bidang'         => 'Kecerdasan Buatan',
            'ketua'          => $this->dosen->name,
            'jeniskategori'  => 'Penelitian Terapan',
            'jeniskelamin'   => 'L',
            'nidn'           => '0612058801',
            'jabatan'        => 'DS',
            'prodi'          => 'R',
            'telp'           => '08123456789',
            'alamat'         => 'Jl. Balekambang No. 1',
            'lokasi'         => 'Semarang',
            'lamapenelitian' => '8 bulan',
            'biaya'          => 7500000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
            'created_at'     => $pastDate,
        ]);

        anggotap3mModel::create([
            'kpenelitian_model_id' => $penelitian->id,
            'nama'                 => 'Ahmad Dani',
            'nim'                  => '20230101',
            'prodi'                => 'R',
            'jabatan'              => 'MHS',
        ]);

        $updateData = [
            'judul'           => 'Laporan Akhir Sistem AI Presisi Balekambang Revisi Final',
            'bidang'          => 'Kecerdasan Buatan',
            'jeniskategori'   => 'Penelitian Terapan',
            'lokasi'          => 'Semarang',
            'lamapenelitian'  => '8 bulan',
            'tanggal_mulai'   => '2026-03-01',
            'tanggal_selesai' => '2026-11-01',
            'biaya'           => 8000000,
            'ketua'           => $this->dosen->name,
            'jabatan'         => 'DS',
            'nidn'            => '0612058801',
            'telp'            => '08123456789',
            'alamat'          => 'Jl. Balekambang No. 1',
            'jeniskelamin'    => 'L',
            'prodi'           => 'R',
            'anggota'         => [
                [
                    'nama'    => 'Ahmad Dani',
                    'nim'     => '20230101',
                    'prodi'   => 'R',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($this->dosen)->post(route('dosen.updatekumpulanpenelitian', ['id' => $penelitian->id]), $updateData);

        $response->assertRedirect(route('dosen.dash_kpenelitian'));
        $response->assertSessionHas('success');

        $penelitian->refresh();
        $this->assertSame('proses', $penelitian->status);
        $this->assertSame('Laporan Akhir Sistem AI Presisi Balekambang Revisi Final', $penelitian->judul);
        $this->assertTrue($penelitian->created_at->isToday());

        $latestHistory = SubmissionStatusHistory::where('submission_type', 'laporan-penelitian')
            ->where('submission_id', $penelitian->id)
            ->latest('id')
            ->first();

        $this->assertNotNull($latestHistory);
        $this->assertSame('proses', $latestHistory->status);
        $this->assertSame('non-approve', $latestHistory->previous_status);
        $this->assertSame($this->dosen->id, $latestHistory->decided_by);

        // Pastikan di dashboard dosen & admin muncul badge "Diajukan Ulang"
        $dosenPage = $this->actingAs($this->dosen)->get(route('dosen.dash_kpenelitian'));
        $dosenPage->assertOk();
        $dosenPage->assertSee('Diajukan Ulang');

        $adminPage = $this->actingAs($this->admin)->get(route('plppm.kpenelitian'));
        $adminPage->assertOk();
        $adminPage->assertSee('Diajukan Ulang');
    }

    #[Test]
    public function admin_dapat_menolak_jurnal_dengan_catatan_dan_dosen_melihat_catatan_revisi(): void
    {
        $jurnal = DosenJurnalUpload::create([
            'user_id'       => $this->dosen->id,
            'judul'         => 'Rancang Bangun Sistem Monitoring IoT LoRa',
            'kategori'      => 'penelitian',
            'file_path'     => 'dosen_jurnal/test.pdf',
            'file_name'     => 'test.pdf',
            'file_size'     => 1024,
            'status'        => 'diproses',
        ]);

        // Admin tolak dengan catatan revisi
        $response = $this->actingAs($this->admin)->patch(route('plppm.jurnal_dosen.status', $jurnal->id), [
            'status' => 'ditolak',
            'alasan' => 'Format sitasi naskah harus menggunakan standar IEEE dan perjelas abstrak.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $jurnal->refresh();
        $this->assertSame('ditolak', $jurnal->status);
        $this->assertSame('Format sitasi naskah harus menggunakan standar IEEE dan perjelas abstrak.', $jurnal->catatan_admin);

        // Check history logged
        $history = SubmissionStatusHistory::where('submission_type', 'jurnal-upload')
            ->where('submission_id', $jurnal->id)
            ->first();

        $this->assertNotNull($history);
        $this->assertSame('ditolak', $history->status);
        $this->assertSame('Format sitasi naskah harus menggunakan standar IEEE dan perjelas abstrak.', $history->reason);
        $this->assertSame($this->admin->id, $history->decided_by);

        // Dosen melihat catatan revisi di tabel jurnal
        $dosenIndex = $this->actingAs($this->dosen)->get(route('dosen.jurnal_upload.index'));
        $dosenIndex->assertOk();
        $dosenIndex->assertSee('Ditolak');
        $dosenIndex->assertSee('Format sitasi naskah harus menggunakan standar IEEE dan perjelas abstrak.');

        // Dosen melihat banner catatan revisi di halaman edit jurnal
        $dosenEdit = $this->actingAs($this->dosen)->get(route('dosen.jurnal_upload.edit', $jurnal->id));
        $dosenEdit->assertOk();
        $dosenEdit->assertSee('Catatan Revisi dari Reviewer / Admin P3M');
        $dosenEdit->assertSee('Format sitasi naskah harus menggunakan standar IEEE dan perjelas abstrak.');
        $dosenEdit->assertSee('Simpan & Ajukan Ulang Jurnal', false);
    }

    #[Test]
    public function dosen_dapat_memperbaiki_dan_mengajukan_ulang_jurnal(): void
    {
        $pastDate = now()->subDays(20);
        $jurnal = DosenJurnalUpload::create([
            'user_id'       => $this->dosen->id,
            'judul'         => 'Rancang Bangun Sistem Monitoring IoT LoRa',
            'kategori'      => 'penelitian',
            'file_path'     => 'dosen_jurnal/test.pdf',
            'file_name'     => 'test.pdf',
            'file_size'     => 1024,
            'status'        => 'ditolak',
            'catatan_admin' => 'Perbaiki abstrak dan tambahkan keyword.',
            'created_at'    => $pastDate,
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'jurnal-upload',
            'submission_id'   => $jurnal->id,
            'previous_status' => 'diproses',
            'status'          => 'ditolak',
            'reason'          => 'Perbaiki abstrak dan tambahkan keyword.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => $pastDate,
        ]);

        $updateData = [
            'judul'    => 'Rancang Bangun Sistem Monitoring IoT LoRa Berbasis Edge Computing',
            'kategori' => 'penelitian',
        ];

        $response = $this->actingAs($this->dosen)->post(route('dosen.jurnal_upload.update', $jurnal->id), $updateData);

        $response->assertRedirect(route('dosen.jurnal_upload.index', ['kategori' => 'penelitian']));
        $response->assertSessionHas('success');

        $jurnal->refresh();
        $this->assertSame('diproses', $jurnal->status);
        $this->assertSame('Rancang Bangun Sistem Monitoring IoT LoRa Berbasis Edge Computing', $jurnal->judul);
        $this->assertTrue($jurnal->created_at->isToday());

        $latestHistory = SubmissionStatusHistory::where('submission_type', 'jurnal-upload')
            ->where('submission_id', $jurnal->id)
            ->latest('id')
            ->first();

        $this->assertNotNull($latestHistory);
        $this->assertSame('diproses', $latestHistory->status);
        $this->assertSame('ditolak', $latestHistory->previous_status);
        $this->assertSame($this->dosen->id, $latestHistory->decided_by);

        // Pastikan di dashboard dosen & admin muncul badge "Diajukan Ulang"
        $dosenIndex = $this->actingAs($this->dosen)->get(route('dosen.jurnal_upload.index'));
        $dosenIndex->assertOk();
        $dosenIndex->assertSee('Diajukan Ulang');

        $adminPage = $this->actingAs($this->admin)->get(route('plppm.jurnal_dosen'));
        $adminPage->assertOk();
        $adminPage->assertSee('Diajukan Ulang');
    }
}
