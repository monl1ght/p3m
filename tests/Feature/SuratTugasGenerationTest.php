<?php

namespace Tests\Feature;

use App\Models\ajuan_penelitianModel;
use App\Models\anggotap3mModel;
use App\Models\p3mModel;
use App\Models\User;
use App\Services\SuratTugasPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SuratTugasGenerationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $dosen1;
    private User $dosen2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->dosen1 = User::factory()->create([
            'role' => 'dosen',
        ]);

        $this->dosen2 = User::factory()->create([
            'role' => 'dosen',
        ]);
    }

    /**
     * Dosen pemilik dapat mengunduh Surat Tugas Pengabdian Masyarakat yang berstatus approve.
     */
    public function test_surat_tugas_pengabdian_download_approved_by_owner(): void
    {
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pemberdayaan Masyarakat Nelayan Jepara Berbasis IoT',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dr. Dosen Pengabdi, M.Kom.',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098801',
            'jabatan'         => 'Lektor Kepala',
            'prodi'           => 'R',
            'telp'            => '08123456789',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Desa Kedung',
            'lamapenelitian'  => '90',
            'biaya'           => '15000000',
            'uppdf'           => 'proposal_pengabdian.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'approve',
            'tanggal_mulai'   => '2026-09-01',
            'tanggal_selesai' => '2026-11-30',
        ]);

        anggotap3mModel::create([
            'ajupengab_model_id' => $pengabdian->id,
            'nama'               => 'Muhammad Bahauddin, S.Kom.',
            'nim'                => '361603B',
            'prodi'              => 'R',
            'jabatan'            => 'Anggota',
        ]);

        $response = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugas.download', $pengabdian->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Surat_Tugas_Pengabdian.pdf', $response->headers->get('Content-Disposition'));
        $this->assertStringStartsWith('%PDF-', $response->getContent());
        $this->assertStringContainsString('/Title', $response->getContent());
        $this->assertStringContainsString('Surat Tugas Pengabdian Masyarakat', $response->getContent());

        // Test route with semantic filename parameter
        $resWithFilename = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugas.download', ['id' => $pengabdian->id, 'filename' => 'Surat_Tugas_Pengabdian.pdf']));
        $resWithFilename->assertStatus(200);
    }

    /**
     * Admin dapat mengunduh Surat Tugas Penelitian yang berstatus approve.
     */
    public function test_surat_tugas_penelitian_download_approved_by_admin(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Analisis Sistem Sensor Pertanian Presisi',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dr. Dosen Peneliti, M.T.',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098802',
            'jabatan'         => 'Lektor',
            'prodi'           => 'A',
            'telp'            => '08123456788',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Laboratorium Smart Agri',
            'lamapenelitian'  => '60',
            'biaya'           => '12000000',
            'uppdf'           => 'proposal_penelitian.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-12-31',
        ]);

        anggotap3mModel::create([
            'ajupenel_model_id' => $penelitian->id,
            'nama'              => 'Siti Fatimatuzzahra',
            'nim'               => '20240109923',
            'prodi'             => 'AK',
            'jabatan'           => 'Anggota Peneliti',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Surat_Tugas_Penelitian.pdf', $response->headers->get('Content-Disposition'));
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }

    /**
     * Pengajuan berstatus non-approve (misal proses/tolak) ditolak akses unduh (403).
     */
    public function test_surat_tugas_forbidden_if_not_approved(): void
    {
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pengajuan Belum Disetujui',
            'bidang'          => 'Sosial Humaniora',
            'ketua'           => 'Dosen Pengaju',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098803',
            'jabatan'         => 'Asisten Ahli',
            'prodi'           => 'AB',
            'telp'            => '08123456787',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Kecamatan Tahunan',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'proses',
            'tanggal_mulai'   => '2026-09-01',
            'tanggal_selesai' => '2026-09-30',
        ]);

        $response = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugas.download', $pengabdian->id));

        $response->assertStatus(403);
    }

    /**
     * Dosen lain tidak boleh mengunduh surat tugas milik dosen pengusul (403).
     */
    public function test_surat_tugas_forbidden_for_other_dosen(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Penelitian Milik Dosen 1',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen Pemilik',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098804',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456786',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Kampus Polibang',
            'lamapenelitian'  => '45',
            'biaya'           => '8000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-11-15',
        ]);

        $response = $this->actingAs($this->dosen2)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));

        $response->assertStatus(403);
    }

    /**
     * Uji langsung SuratTugasPdfService dengan data pendek, data panjang, dan banyak anggota.
     */
    public function test_surat_tugas_pdf_service_short_long_and_many_members(): void
    {
        // 1. Data Pendek
        $subShort = (object)[
            'judul'           => 'Pengabdian Desa Wanusobo',
            'ketua'           => 'Najib',
            'nidn'            => '0619098800',
            'prodi'           => 'R',
            'tanggal_mulai'   => '2026-09-16',
            'tanggal_selesai' => '2026-09-17',
        ];
        $membersShort = [
            ['nama' => 'Muhammad Bahauddin', 'nim' => '361603B', 'prodi' => 'R', 'jabatan' => 'Anggota']
        ];
        $serviceShort = new SuratTugasPdfService('Pengabdian Masyarakat');
        $pdfShort = $serviceShort->generateDocument($subShort, $membersShort);
        $this->assertStringStartsWith('%PDF-', $pdfShort);

        // 2. Data Panjang (Nama sangat panjang & judul multi-baris)
        $subLong = (object)[
            'judul'           => 'Rancang Bangun dan Implementasi Autonomous IoT Monitoring Multi-Sensor dengan Machine Learning Terdistribusi untuk Deteksi Dini Banjir Pasang Rob di Jepara',
            'ketua'           => 'Prof. Dr. Ir. H. Muhammad Bahauddin Al-Anshori, S.Kom., M.Cs., Ph.D., IPU., ASEAN Eng.',
            'nidn'            => '061909880199281',
            'prodi'           => 'Rekayasa Perangkat Lunak',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-12-31',
        ];
        $membersLong = [
            [
                'nama'    => 'Dr. Siti Fatimatuzzahra Nurul Hidayah binti Ahmad Mustofa Al-Habsyi, M.Pd., M.Ed.',
                'nim'     => '202401099238120',
                'prodi'   => 'Teknologi Rekayasa Multimedia',
                'jabatan' => 'Peneliti Ahli Madya',
            ]
        ];
        $serviceLong = new SuratTugasPdfService('Penelitian');
        $pdfLong = $serviceLong->generateDocument($subLong, $membersLong);
        $this->assertStringStartsWith('%PDF-', $pdfLong);

        // 3. Banyak Anggota (15+ anggota yang menguji mekanisme page break dan pengulangan header)
        $subMany = (object)[
            'judul'           => 'Penelitian Skala Besar Konsorsium Riset Nasional',
            'ketua'           => 'Dr. Fawaid, M.Kom.',
            'nidn'            => '0619098805',
            'prodi'           => 'R',
            'tanggal_mulai'   => '2026-09-01',
            'tanggal_selesai' => '2026-12-31',
        ];
        $membersMany = [];
        for ($i = 1; $i <= 18; $i++) {
            $membersMany[] = [
                'nama'    => "Peneliti Anggota {$i} dengan Gelar Sarjana Lengkap",
                'nim'     => '202600' . str_pad((string)$i, 4, '0', STR_PAD_LEFT),
                'prodi'   => ($i % 2 === 0) ? 'AK' : 'R',
                'jabatan' => "Anggota {$i}",
            ];
        }
        $serviceMany = new SuratTugasPdfService('Penelitian');
        $pdfMany = $serviceMany->generateDocument($subMany, $membersMany);
        $this->assertStringStartsWith('%PDF-', $pdfMany);
    }

    /**
     * Parameter disposition=attachment memicu Content-Disposition attachment untuk auto download.
     */
    public function test_surat_tugas_disposition_attachment_and_inline(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Uji Disposisi Attachment',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dr. Dosen Peneliti',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098809',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456789',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Kampus Polibang',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        // Default / inline
        $resInline = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));
        $resInline->assertOk();
        $this->assertStringContainsString('inline; filename="Surat_Tugas_Penelitian.pdf"', $resInline->headers->get('Content-Disposition'));

        // Attachment (otomatis terunduh)
        $resAttachment = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugaspen.download', ['id' => $penelitian->id, 'disposition' => 'attachment']));
        $resAttachment->assertOk();
        $this->assertStringContainsString('attachment; filename="Surat_Tugas_Penelitian.pdf"', $resAttachment->headers->get('Content-Disposition'));
    }
}
