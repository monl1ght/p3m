<?php

namespace Tests\Feature;

use App\Models\ajuan_penelitianModel;
use App\Models\anggotap3mModel;
use App\Models\p3mModel;
use App\Models\SubmissionStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProposalRevisionWorkflowTest extends TestCase
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
    public function dosen_dapat_melihat_tombol_catatan_revisi_di_tabel_pengabdian_saat_ditolak(): void
    {
        $proposal = p3mModel::create([
            'judul'          => 'Pelatihan IoT UMKM Jepara',
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
            'biaya'          => 500000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'proposal-pengabdian',
            'submission_id'   => $proposal->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Perbaiki rincian anggaran biaya (RAB) dan lampirkan surat mitra.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.upp3m'));

        $response->assertOk();
        $response->assertSee('Ditolak');
        $response->assertSee('Catatan Revisi');
        $response->assertSee('Perbaiki rincian anggaran biaya (RAB) dan lampirkan surat mitra.');
        $response->assertSee('Admin Reviewer P3M');
    }

    #[Test]
    public function dosen_dapat_melihat_banner_catatan_revisi_di_halaman_edit_pengabdian(): void
    {
        $proposal = p3mModel::create([
            'judul'          => 'Pelatihan IoT UMKM Jepara',
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
            'biaya'          => 500000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        anggotap3mModel::create([
            'ajupengab_model_id' => $proposal->id,
            'nama'               => 'Ahmad Dani',
            'nim'                => '20230101',
            'prodi'              => 'R',
            'jabatan'            => 'MHS',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'proposal-pengabdian',
            'submission_id'   => $proposal->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Perbaiki rincian anggaran biaya (RAB) dan lampirkan surat mitra.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.edit_ajupengab', ['id' => $proposal->id]));

        $response->assertOk();
        $response->assertSee('Catatan Revisi dari Reviewer / Admin P3M');
        $response->assertSee('Perbaiki rincian anggaran biaya (RAB) dan lampirkan surat mitra.');
        $response->assertSee('Admin Reviewer P3M');
        $response->assertSee('Simpan & Ajukan Ulang Proposal', false);
    }

    #[Test]
    public function dosen_dapat_memperbaiki_dan_mengajukan_ulang_proposal_pengabdian(): void
    {
        $proposal = p3mModel::create([
            'judul'          => 'Pelatihan IoT UMKM Jepara',
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
            'biaya'          => 500000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        anggotap3mModel::create([
            'ajupengab_model_id' => $proposal->id,
            'nama'               => 'Ahmad Dani',
            'nim'                => '20230101',
            'prodi'              => 'R',
            'jabatan'            => 'MHS',
        ]);

        $updateData = [
            'judul'           => 'Pelatihan IoT UMKM Jepara Revisi Final',
            'bidang'          => 'Teknologi Informasi',
            'jeniskategori'   => 'PKM',
            'lokasi'          => 'Jepara Kota',
            'lamapenelitian'  => '6 bulan',
            'tanggal_mulai'   => '2026-04-01',
            'tanggal_selesai' => '2026-10-01',
            'biaya'           => 600000,
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

        $response = $this->actingAs($this->dosen)->post(route('dosen.updatep3m', ['id' => $proposal->id]), $updateData);

        $response->assertRedirect(route('dosen.upp3m'));
        $response->assertSessionHas('success');

        $proposal->refresh();
        $this->assertSame('proses', $proposal->status);
        $this->assertSame('Pelatihan IoT UMKM Jepara Revisi Final', $proposal->judul);
        $this->assertTrue($proposal->created_at->isToday());

        $latestHistory = SubmissionStatusHistory::where('submission_type', 'proposal-pengabdian')
            ->where('submission_id', $proposal->id)
            ->latest('id')
            ->first();

        $this->assertNotNull($latestHistory);
        $this->assertSame('proses', $latestHistory->status);
        $this->assertSame('non-approve', $latestHistory->previous_status);
        $this->assertSame($this->dosen->id, $latestHistory->decided_by);

        // Pastikan di halaman dosen & admin muncul label "Diajukan Ulang"
        $dosenPage = $this->actingAs($this->dosen)->get(route('dosen.upp3m'));
        $dosenPage->assertOk();
        $dosenPage->assertSee('Diajukan Ulang');

        $adminPage = $this->actingAs($this->admin)->get(route('plppm.lpengabdian'));
        $adminPage->assertOk();
        $adminPage->assertSee('Diajukan Ulang');
    }

    #[Test]
    public function dosen_dapat_melihat_tombol_catatan_revisi_di_tabel_penelitian_saat_ditolak(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'judul'          => 'Rancang Bangun Sistem AI Presisi',
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
            'biaya'          => 750000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'proposal-penelitian',
            'submission_id'   => $penelitian->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Perjelas roadmap penelitian dan instrumen pengujian.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.dash_ajuanpenelitian'));

        $response->assertOk();
        $response->assertSee('Ditolak');
        $response->assertSee('Catatan Revisi');
        $response->assertSee('Perjelas roadmap penelitian dan instrumen pengujian.');
        $response->assertSee('Admin Reviewer P3M');
    }

    #[Test]
    public function dosen_dapat_melihat_banner_catatan_revisi_di_halaman_edit_penelitian(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'judul'          => 'Rancang Bangun Sistem AI Presisi',
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
            'biaya'          => 750000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        anggotap3mModel::create([
            'ajupenel_model_id' => $penelitian->id,
            'nama'              => 'Siti Rahma',
            'nim'               => '20230202',
            'prodi'             => 'R',
            'jabatan'           => 'MHS',
        ]);

        SubmissionStatusHistory::create([
            'submission_type' => 'proposal-penelitian',
            'submission_id'   => $penelitian->id,
            'previous_status' => 'proses',
            'status'          => 'non-approve',
            'reason'          => 'Perjelas roadmap penelitian dan instrumen pengujian.',
            'decided_by'      => $this->admin->id,
            'decided_at'      => now(),
        ]);

        $response = $this->actingAs($this->dosen)->get(route('dosen.edit_ajuanpenelitian', ['id' => $penelitian->id]));

        $response->assertOk();
        $response->assertSee('Catatan Revisi dari Reviewer / Admin P3M');
        $response->assertSee('Perjelas roadmap penelitian dan instrumen pengujian.');
        $response->assertSee('Admin Reviewer P3M');
        $response->assertSee('Simpan & Ajukan Ulang Proposal', false);
    }

    #[Test]
    public function dosen_dapat_memperbaiki_dan_mengajukan_ulang_proposal_penelitian(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'judul'          => 'Rancang Bangun Sistem AI Presisi',
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
            'biaya'          => 750000,
            'user_id'        => $this->dosen->id,
            'status'         => 'non-approve',
        ]);

        anggotap3mModel::create([
            'ajupenel_model_id' => $penelitian->id,
            'nama'              => 'Siti Rahma',
            'nim'               => '20230202',
            'prodi'             => 'R',
            'jabatan'           => 'MHS',
        ]);

        $updateData = [
            'judul'           => 'Rancang Bangun Sistem AI Presisi Revisi Lengkap',
            'bidang'          => 'Kecerdasan Buatan',
            'jeniskategori'   => 'Penelitian Terapan',
            'lokasi'          => 'Semarang',
            'lamapenelitian'  => '8 bulan',
            'tanggal_mulai'   => '2026-05-01',
            'tanggal_selesai' => '2026-12-01',
            'biaya'           => 800000,
            'ketua'           => $this->dosen->name,
            'jabatan'         => 'DS',
            'nidn'            => '0612058801',
            'telp'            => '08123456789',
            'alamat'          => 'Jl. Balekambang No. 1',
            'jeniskelamin'    => 'L',
            'prodi'           => 'R',
            'anggota'         => [
                [
                    'nama'    => 'Siti Rahma',
                    'nim'     => '20230202',
                    'prodi'   => 'R',
                    'jabatan' => 'MHS',
                ],
            ],
        ];

        $response = $this->actingAs($this->dosen)->post(route('dosen.updatepenelitian', ['id' => $penelitian->id]), $updateData);

        $response->assertRedirect(route('dosen.dash_ajuanpenelitian'));
        $response->assertSessionHas('success');

        $penelitian->refresh();
        $this->assertSame('proses', $penelitian->status);
        $this->assertSame('Rancang Bangun Sistem AI Presisi Revisi Lengkap', $penelitian->judul);
        $this->assertTrue($penelitian->created_at->isToday());

        $latestHistory = SubmissionStatusHistory::where('submission_type', 'proposal-penelitian')
            ->where('submission_id', $penelitian->id)
            ->latest('id')
            ->first();

        $this->assertNotNull($latestHistory);
        $this->assertSame('proses', $latestHistory->status);
        $this->assertSame('non-approve', $latestHistory->previous_status);
        $this->assertSame($this->dosen->id, $latestHistory->decided_by);

        // Pastikan di halaman dosen & admin muncul label "Diajukan Ulang"
        $dosenPage = $this->actingAs($this->dosen)->get(route('dosen.dash_ajuanpenelitian'));
        $dosenPage->assertOk();
        $dosenPage->assertSee('Diajukan Ulang');

        $adminPage = $this->actingAs($this->admin)->get(route('plppm.lpeneleitian'));
        $adminPage->assertOk();
        $adminPage->assertSee('Diajukan Ulang');
    }
}
