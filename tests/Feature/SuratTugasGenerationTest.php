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
            'nomor_surat'     => '015/P3M-POLIBANG/ST-PM/IX/2026',
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
        $this->assertStringContainsString('015/P3M-POLIBANG/ST-PM/IX/2026', $response->getContent());

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
            'nomor_surat'     => '016/P3M-POLIBANG/ST-PN/X/2026',
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
        $this->assertStringContainsString('016/P3M-POLIBANG/ST-PN/X/2026', $response->getContent());
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
        $this->assertStringContainsString('Pusat Penelitian dan Pengabdian Kepada Masyarakat', $pdfShort);
        $this->assertStringContainsString('P3M', $pdfShort);
        $this->assertStringContainsString('POLITEKNIK BALEKAMBANG JEPARA', $pdfShort);
        $this->assertStringContainsString('Jl. Ponpes Balekambang Rt 02 Rw 07 Gemiring Lor', $pdfShort);
        $this->assertStringContainsString('Nalumsari Jepara Jawa Tengah Kode Pos 59466', $pdfShort);
        $this->assertStringContainsString('SURAT TUGAS PENGABDIAN', $pdfShort);
        $this->assertStringContainsString('Buku Panduan P3M Politeknik Balekambang Jepara', $pdfShort);
        $this->assertStringContainsString('Ketua P3M Polibang', $pdfShort);
        $this->assertStringContainsString('Sofia Ulfah, M. Kom', $pdfShort);
        $this->assertStringContainsString('NIDN : 0619099004', $pdfShort);

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
        $this->assertStringContainsString('SURAT TUGAS PENELITIAN', $pdfLong);
        $this->assertStringContainsString('Untuk melakukan penelitian dengan judul:', $pdfLong);

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
        $this->assertGreaterThan(1, $serviceMany->PageNo());
    }

    /**
     * Verifikasi struktur dan format template resmi SURAT TUGAS PENELITIAN FORMAT.pdf diikuti secara presisi.
     */
    public function test_official_template_format_structure_and_prodi_mapping(): void
    {
        $submission = (object)[
            'judul'           => 'RANCANG BANGUN APLIKASI PENCATATAN KEUANGAN UMKM BERBASIS WEBSITE',
            'ketua'           => 'A. Faiq Abror, M.Pd',
            'nidn'            => '0612029003',
            'prodi'           => 'R',
            'nomor_surat'     => 'A. 007/P3M-Polibang/V/PG/2026',
            'tanggal_mulai'   => '2026-05-15',
            'tanggal_selesai' => '2026-07-14',
        ];

        $members = [
            ['nama' => 'Nur Hikmah, M.E', 'nim' => '0610058202', 'prodi' => 'AB', 'jabatan' => 'DS'],
            ['nama' => 'Nila Ayu Kusuma Wardani, M.E', 'nim' => '0615039702', 'prodi' => 'AK', 'jabatan' => 'DS'],
            ['nama' => 'Sofia Ulfah, M.Kom', 'nim' => '0619099004', 'prodi' => 'A', 'jabatan' => 'MHS'],
            ['nama' => 'Muhammad Ali Subkhan, M.Pd', 'nim' => '0625109201', 'prodi' => 'AB', 'jabatan' => 'MHS'],
        ];

        $service = new SuratTugasPdfService('Penelitian');
        $pdf = $service->generateDocument($submission, $members);

        // Header Kop
        $this->assertStringContainsString('Pusat Penelitian dan Pengabdian Kepada Masyarakat', $pdf);
        $this->assertStringContainsString('P3M', $pdf);
        $this->assertStringContainsString('POLITEKNIK BALEKAMBANG JEPARA', $pdf);
        $this->assertStringContainsString('Jl. Ponpes Balekambang Rt 02 Rw 07 Gemiring Lor', $pdf);
        $this->assertStringContainsString('Nalumsari Jepara Jawa Tengah Kode Pos 59466', $pdf);
        $this->assertStringContainsString('e-mail : p3mpolibang@gmail.com', $pdf);

        // Judul Surat & Nomor
        $this->assertStringContainsString('SURAT TUGAS PENELITIAN', $pdf);
        $this->assertStringContainsString('Nomor: A. 007/P3M-Polibang/V/PG/2026', $pdf);

        // Intro
        $this->assertStringContainsString('Ketua Pusat Penelitian dan Pengabdian kepada Masyarakat memberikan tugas kepada:', $pdf);

        // Table headers
        $this->assertStringContainsString('NO', $pdf);
        $this->assertStringContainsString('NAMA', $pdf);
        $this->assertStringContainsString('NIDN/NUPTK/NIM', $pdf);
        $this->assertStringContainsString('PROGRAM STUDI', $pdf);
        $this->assertStringContainsString('Jabatan', $pdf);

        // Prodi full mapping
        $this->assertStringContainsString('Rekayasa Perangkat Lunak', $pdf);
        $this->assertStringContainsString('Bisnis Digital', $pdf);
        $this->assertStringContainsString('Administrasi Bisnis Internasional', $pdf);
        $this->assertStringContainsString('Akuntansi Keuangan Publik', $pdf);

        // Jabatan mapping: Ketua for ketua, Anggota for members, NO internal codes DS/MHS
        $this->assertStringContainsString('(Ketua)', $pdf);
        $this->assertStringContainsString('(Anggota)', $pdf);
        $this->assertStringNotContainsString('(DS)', $pdf);
        $this->assertStringNotContainsString('(MHS)', $pdf);

        // Detail
        $this->assertStringContainsString('Untuk melakukan penelitian dengan judul:', $pdf);
        $this->assertStringContainsString('RANCANG BANGUN APLIKASI PENCATATAN KEUANGAN UMKM BERBASIS WEBSITE', $pdf);
        $this->assertStringContainsString('15 Mei', $pdf);
        $this->assertStringContainsString('14 Juli 2026', $pdf);
        $this->assertStringContainsString('Buku Panduan P3M Politeknik Balekambang Jepara', $pdf);

        // Signature block
        $this->assertStringContainsString('Ketua P3M Polibang', $pdf);
        $this->assertStringContainsString('Sofia Ulfah, M. Kom', $pdf);
        $this->assertStringContainsString('NIDN : 0619099004', $pdf);
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
            'nomor_surat'     => '025/P3M/ST-PN/X/2026',
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

    /**
     * Admin Approve Workflow: Pengabdian -> Input Nomor Surat -> Simpan -> Dosen Download -> Nomor Surat tampil di PDF.
     */
    public function test_admin_approve_flow_pengabdian_saves_nomor_surat_and_dosen_downloads_pdf(): void
    {
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pelatihan E-Commerce untuk UMKM Jepara',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Drs. H. Pengabdi, M.M.',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098850',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456789',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Sentra Ukir Jepara',
            'lamapenelitian'  => '45',
            'biaya'           => '10000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'proses',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-11-15',
        ]);

        $nomorSurat = '033/P3M-POLIBANG/ST-PM/X/2026';

        // 1. Admin approve dengan input nomor surat
        $approveResponse = $this->actingAs($this->admin)
            ->patch(route('plppm.ppengabdian.status', $pengabdian->id), [
                'status'      => 'approve',
                'nomor_surat' => $nomorSurat,
            ]);

        $approveResponse->assertRedirect(route('plppm.lpengabdian'));
        $approveResponse->assertSessionHas('success');

        // 2. Periksa data tersimpan konsisten di database
        $this->assertDatabaseHas('ajupengabdian', [
            'id'          => $pengabdian->id,
            'status'      => 'approve',
            'nomor_surat' => $nomorSurat,
        ]);

        // 3. Dosen pemilik mengunduh PDF dan memastikan nomor surat tampil di dokumen
        $downloadResponse = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugas.download', $pengabdian->id));

        $downloadResponse->assertStatus(200);
        $downloadResponse->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString($nomorSurat, $downloadResponse->getContent());
        $this->assertStringContainsString('Nomor: ' . $nomorSurat, $downloadResponse->getContent());
    }

    /**
     * Admin Approve Workflow: Penelitian -> Input Nomor Surat -> Simpan -> Dosen Download -> Nomor Surat tampil di PDF.
     */
    public function test_admin_approve_flow_penelitian_saves_nomor_surat_and_dosen_downloads_pdf(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen2->id,
            'judul'           => 'Rancang Bangun Sistem Smart GreenHouse Berbasis ESP32',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Ir. Peneliti Hebat, M.T.',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098851',
            'jabatan'         => 'Lektor Kepala',
            'prodi'           => 'A',
            'telp'            => '08123456780',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Laboratorium Polibang',
            'lamapenelitian'  => '60',
            'biaya'           => '14000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'proses',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-11-30',
        ]);

        $nomorSurat = '034/P3M-POLIBANG/ST-PN/X/2026';

        // 1. Admin approve dengan input nomor surat
        $approveResponse = $this->actingAs($this->admin)
            ->patch(route('plppm.ppenelitian.status', $penelitian->id), [
                'status'      => 'approve',
                'nomor_surat' => $nomorSurat,
            ]);

        $approveResponse->assertRedirect(route('plppm.lpeneleitian'));
        $approveResponse->assertSessionHas('success');

        // 2. Periksa data tersimpan konsisten di database
        $this->assertDatabaseHas('ajuan_penelitian_models', [
            'id'          => $penelitian->id,
            'status'      => 'approve',
            'nomor_surat' => $nomorSurat,
        ]);

        // 3. Dosen pemilik mengunduh PDF dan memastikan nomor surat tampil di dokumen
        $downloadResponse = $this->actingAs($this->dosen2)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));

        $downloadResponse->assertStatus(200);
        $downloadResponse->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString($nomorSurat, $downloadResponse->getContent());
        $this->assertStringContainsString('Nomor: ' . $nomorSurat, $downloadResponse->getContent());
    }

    /**
     * Validasi: Approval gagal ketika nomor surat kosong atau hanya spasi (Pengabdian & Penelitian).
     */
    public function test_admin_approval_validation_fails_when_nomor_surat_is_empty_or_whitespace(): void
    {
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pengabdian Uji Validasi Nomor Kosong',
            'bidang'          => 'Sosial Humaniora',
            'ketua'           => 'Dosen Penguji',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098852',
            'jabatan'         => 'Asisten Ahli',
            'prodi'           => 'AB',
            'telp'            => '08123456781',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Balekambang',
            'lamapenelitian'  => '30',
            'biaya'           => '6000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'proses',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        // Kasus 1: nomor_surat null / empty string
        $responseEmpty = $this->actingAs($this->admin)
            ->patch(route('plppm.ppengabdian.status', $pengabdian->id), [
                'status'      => 'approve',
                'nomor_surat' => '',
            ]);

        $responseEmpty->assertSessionHasErrors('nomor_surat');
        $this->assertDatabaseHas('ajupengabdian', [
            'id'          => $pengabdian->id,
            'status'      => 'proses',
            'nomor_surat' => null,
        ]);

        // Kasus 2: nomor_surat hanya spasi
        $responseSpaces = $this->actingAs($this->admin)
            ->patch(route('plppm.ppengabdian.status', $pengabdian->id), [
                'status'      => 'approve',
                'nomor_surat' => '   ',
            ]);

        $responseSpaces->assertSessionHasErrors('nomor_surat');
        $this->assertDatabaseHas('ajupengabdian', [
            'id'          => $pengabdian->id,
            'status'      => 'proses',
            'nomor_surat' => null,
        ]);
    }

    /**
     * Validasi: Approval gagal ketika ID submission salah / tidak ada di database (404).
     */
    public function test_admin_approval_fails_with_invalid_id(): void
    {
        $nonExistentId = 999999;

        // Pengabdian dengan ID salah
        $responsePeng = $this->actingAs($this->admin)
            ->patch(route('plppm.ppengabdian.status', $nonExistentId), [
                'status'      => 'approve',
                'nomor_surat' => '099/ST-PM/2026',
            ]);

        $responsePeng->assertStatus(404);

        // Penelitian dengan ID salah
        $responsePenel = $this->actingAs($this->admin)
            ->patch(route('plppm.ppenelitian.status', $nonExistentId), [
                'status'      => 'approve',
                'nomor_surat' => '099/ST-PN/2026',
            ]);

        $responsePenel->assertStatus(404);
    }

    /**
     * Validasi: Approval gagal ketika transisi status tidak valid (misal dari non-approve langsung ke approve).
     */
    public function test_admin_approval_fails_on_invalid_status_transition(): void
    {
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pengabdian Berstatus Non-Approve',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen Ditolak',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098853',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456782',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Jepara',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'non-approve',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch(route('plppm.ppengabdian.status', $pengabdian->id), [
                'status'      => 'approve',
                'nomor_surat' => '040/P3M/ST/2026',
            ]);

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseHas('ajupengabdian', [
            'id'          => $pengabdian->id,
            'status'      => 'non-approve',
            'nomor_surat' => null,
        ]);
    }

    /**
     * Validasi: Download surat sebelum nomor surat tersedia harus ditolak (403).
     */
    public function test_download_surat_tugas_forbidden_before_nomor_surat_is_available(): void
    {
        // 1. Pengabdian berstatus approve tapi nomor_surat masih null
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pengabdian Tanpa Nomor Surat',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen Pemilik',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098854',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456783',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Jepara',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => null,
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        $resPengabdian = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugas.download', $pengabdian->id));

        $resPengabdian->assertStatus(403);

        // 2. Penelitian berstatus approve tapi nomor_surat masih null
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Penelitian Tanpa Nomor Surat',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen Pemilik',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098855',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456784',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Jepara',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => null,
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        $resPenelitian = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));

        $resPenelitian->assertStatus(403);
    }

    /**
     * Keamanan: Dosen tidak dapat memanipulasi nomor_surat melalui endpoint edit/update.
     */
    public function test_dosen_cannot_modify_nomor_surat_via_update(): void
    {
        $originalNomor = '050/P3M-POLIBANG/ST-PM/2026';
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pengabdian Terkunci',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen Pemilik',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098856',
            'jabatan'         => 'LT',
            'prodi'           => 'R',
            'telp'            => '08123456785',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Jepara',
            'lamapenelitian'  => '30',
            'biaya'           => '5000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'non-approve', // editable only when non-approve
            'nomor_surat'     => $originalNomor,
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        $this->actingAs($this->dosen1)->post(route('dosen.updatep3m', $pengabdian->id), [
            'judul'           => 'Judul Diperbarui',
            'bidang'          => 'Teknologi Informasi',
            'jeniskategori'   => 'Pengabdian Dosen',
            'lokasi'          => 'Jepara Baru',
            'lamapenelitian'  => '30',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
            'biaya'           => '5000000',
            'ketua'           => 'Dosen Pemilik',
            'jabatan'         => 'LT',
            'nidn'            => '0619098856',
            'telp'            => '08123456785',
            'alamat'          => 'Jepara',
            'jeniskelamin'    => 'L',
            'prodi'           => 'R',
            'nomor_surat'     => 'PALSU/999/ST-HACKED',
            'anggota'         => [
                ['nama' => 'Anggota 1', 'nim' => '123', 'prodi' => 'R', 'jabatan' => 'MHS'],
            ],
        ]);

        $pengabdian->refresh();
        $this->assertSame($originalNomor, $pengabdian->nomor_surat);
        $this->assertNotSame('PALSU/999/ST-HACKED', $pengabdian->nomor_surat);
    }

    /**
     * Isolasi: Nomor surat tidak pernah tertukar atau bertabrakan antara Pengabdian dan Penelitian.
     */
    public function test_nomor_surat_isolation_between_pengabdian_and_penelitian(): void
    {
        $nomorPengabdian = '077/P3M/ST-PENGABDIAN/2026';
        $nomorPenelitian = '088/P3M/ST-PENELITIAN/2026';

        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Pengabdian Masyarakat Mandiri',
            'bidang'          => 'Sosial Humaniora',
            'ketua'           => 'Dosen A',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098857',
            'jabatan'         => 'Lektor',
            'prodi'           => 'AB',
            'telp'            => '08123456786',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Jepara',
            'lamapenelitian'  => '30',
            'biaya'           => '7000000',
            'uppdf'           => 'proposal_pengabdian.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => $nomorPengabdian,
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'Penelitian Terapan Mandiri',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dosen B',
            'jeniskelamin'    => 'P',
            'nidn'            => '0619098858',
            'jabatan'         => 'Lektor',
            'prodi'           => 'R',
            'telp'            => '08123456787',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Jepara',
            'lamapenelitian'  => '30',
            'biaya'           => '9000000',
            'uppdf'           => 'proposal_penelitian.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => $nomorPenelitian,
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-10-31',
        ]);

        $resPeng = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugas.download', $pengabdian->id));
        $resPeng->assertOk();
        $this->assertStringContainsString($nomorPengabdian, $resPeng->getContent());
        $this->assertStringNotContainsString($nomorPenelitian, $resPeng->getContent());

        $resPen = $this->actingAs($this->dosen1)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));
        $resPen->assertOk();
        $this->assertStringContainsString($nomorPenelitian, $resPen->getContent());
        $this->assertStringNotContainsString($nomorPengabdian, $resPen->getContent());
    }

    /**
     * Uji konsistensi penuh Pengabdian: Database -> Detail Admin -> Berkas PDF
     * Sesuai skenario submission nyata: Bisnis Digital (AB), internal code DS/MHS diubah menjadi Ketua & Anggota pada PDF.
     */
    public function test_surat_tugas_pengabdian_data_consistency_between_detail_database_and_pdf(): void
    {
        $pengabdian = p3mModel::create([
            'user_id'         => $this->dosen1->id,
            'judul'           => 'EDUKASI SAHAM DAN KRIPTO: DARI FOMO KE MELEK FINANSIAL SEBAGAI BENTUK LITERASI KEUANGAN DI SMK ROUDLOTUL MUBTADIIN BALEKAMBANG JEPARA',
            'bidang'          => 'Ekonomi dan Bisnis',
            'ketua'           => 'Fatikha Rizqya Nur, S.E., M.E',
            'jeniskelamin'    => 'P',
            'nidn'            => '7145777678230203',
            'jabatan'         => 'DS',
            'prodi'           => 'A',
            'telp'            => '08123456789',
            'alamat'          => 'Jepara',
            'lokasi'          => 'SMK Roudlotul Mubtadiin',
            'lamapenelitian'  => '5',
            'biaya'           => '5000000',
            'uppdf'           => 'proposal.pdf',
            'jeniskategori'   => 'Pengabdian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => 'A. 001/P3M-Polibang/IX/PG/2026',
            'tanggal_mulai'   => '2026-11-16',
            'tanggal_selesai' => '2026-11-20',
        ]);

        $m1 = anggotap3mModel::create([
            'ajupengab_model_id' => $pengabdian->id,
            'nama'               => 'Taufiqurrohman, S.E., M.E',
            'nim'                => '5042766667130443',
            'prodi'              => 'AB',
            'jabatan'            => 'DS',
        ]);

        $m2 = anggotap3mModel::create([
            'ajupengab_model_id' => $pengabdian->id,
            'nama'               => 'Muhammad Dliyauddin, M.Kom',
            'nim'                => '4438776677130242',
            'prodi'              => 'R',
            'jabatan'            => 'DS',
        ]);

        $m3 = anggotap3mModel::create([
            'ajupengab_model_id' => $pengabdian->id,
            'nama'               => 'Muhammad Faqih',
            'nim'                => '2024010027',
            'prodi'              => 'R',
            'jabatan'            => 'MHS',
        ]);

        $m4 = anggotap3mModel::create([
            'ajupengab_model_id' => $pengabdian->id,
            'nama'               => 'Nilna Syarifah',
            'nim'                => '2025050094',
            'prodi'              => 'AB',
            'jabatan'            => 'MHS',
        ]);

        $m5 = anggotap3mModel::create([
            'ajupengab_model_id' => $pengabdian->id,
            'nama'               => 'Sinta Zuliyana Alfat H',
            'nim'                => '2025050095',
            'prodi'              => 'AB',
            'jabatan'            => 'MHS',
        ]);

        // 1. Verifikasi Data Halaman Detail Admin
        $resDetail = $this->actingAs($this->admin)
            ->get(route('detail.detail', ['tipe' => 'ajupengab', 'id' => $pengabdian->id]));
        $resDetail->assertOk();
        $detailHtml = $resDetail->getContent();

        // Di halaman detail, prodi AB tampil sebagai Bisnis Digital, R tampil sebagai Rekayasa Perangkat Lunak
        $this->assertStringContainsString('Bisnis Digital', $detailHtml);
        $this->assertStringContainsString('Rekayasa Perangkat Lunak', $detailHtml);
        $this->assertStringContainsString('Taufiqurrohman, S.E., M.E', $detailHtml);
        $this->assertStringContainsString('Muhammad Dliyauddin, M.Kom', $detailHtml);
        $this->assertStringContainsString('Muhammad Faqih', $detailHtml);
        $this->assertStringContainsString('Nilna Syarifah', $detailHtml);
        $this->assertStringContainsString('Sinta Zuliyana Alfat H', $detailHtml);

        // 2. Verifikasi Data Berkas PDF Surat Tugas
        $resPdf = $this->actingAs($this->admin)
            ->get(route('p3m.surat-tugas.download', $pengabdian->id));
        $resPdf->assertOk();
        $this->assertEquals('application/pdf', $resPdf->headers->get('Content-Type'));
        $pdfContent = $resPdf->getContent();

        // Periksa nomor surat dan judul
        $this->assertStringContainsString('SURAT TUGAS PENGABDIAN', $pdfContent);
        $this->assertStringContainsString('A. 001/P3M-Polibang/IX/PG/2026', $pdfContent);

        // Periksa Ketua (Fatikha)
        $this->assertStringContainsString('Fatikha Rizqya Nur, S.E., M.E', $pdfContent);
        $this->assertStringContainsString('7145777678230203', $pdfContent);
        $this->assertStringContainsString('Administrasi Bisnis Internasional', $pdfContent);
        $this->assertStringContainsString('Ketua', $pdfContent);

        // Periksa Anggota: Program Studi Bisnis Digital wajib tampil (BUKAN Administrasi Bisnis Internasional)
        $this->assertStringContainsString('Bisnis Digital', $pdfContent);
        $this->assertStringContainsString('Taufiqurrohman, S.E., M.E', $pdfContent);
        $this->assertStringContainsString('5042766667130443', $pdfContent);

        $this->assertStringContainsString('Muhammad Dliyauddin, M.Kom', $pdfContent);
        $this->assertStringContainsString('4438776677130242', $pdfContent);
        $this->assertStringContainsString('Rekayasa Perangkat Lunak', $pdfContent);

        $this->assertStringContainsString('Muhammad Faqih', $pdfContent);
        $this->assertStringContainsString('2024010027', $pdfContent);

        $this->assertStringContainsString('Nilna Syarifah', $pdfContent);
        $this->assertStringContainsString('2025050094', $pdfContent);

        $this->assertStringContainsString('Sinta Zuliyana Alfat H', $pdfContent);
        $this->assertStringContainsString('2025050095', $pdfContent);

        // Periksa Jabatan pada PDF: hanya 'Ketua' dan 'Anggota', TIDAK ADA kode internal 'DS' atau 'MHS'
        $this->assertStringContainsString('(Ketua)', $pdfContent);
        $this->assertStringContainsString('(Anggota)', $pdfContent);
        $this->assertStringNotContainsString('(DS)', $pdfContent);
        $this->assertStringNotContainsString('(MHS)', $pdfContent);
    }

    /**
     * Uji konsistensi penuh Penelitian: Database -> Detail Admin -> Berkas PDF
     * Memastikan prodi AK (Akuntansi Keuangan Publik), AP (Agribisnis Peternakan), dan jabatan Anggota konsisten 100%.
     */
    public function test_surat_tugas_penelitian_data_consistency_between_detail_database_and_pdf(): void
    {
        $penelitian = ajuan_penelitianModel::create([
            'user_id'         => $this->dosen2->id,
            'judul'           => 'Rancang Bangun Model Prediksi Keuangan Publik Berbasis AI',
            'bidang'          => 'Teknologi Informasi',
            'ketua'           => 'Dr. H. Peneliti Utama, M.Kom.',
            'jeniskelamin'    => 'L',
            'nidn'            => '0619098899',
            'jabatan'         => 'KP',
            'prodi'           => 'AK',
            'telp'            => '08123456781',
            'alamat'          => 'Jepara',
            'lokasi'          => 'Kampus Polibang',
            'lamapenelitian'  => '90',
            'biaya'           => '15000000',
            'uppdf'           => 'proposal_penelitian.pdf',
            'jeniskategori'   => 'Penelitian Dosen',
            'status'          => 'approve',
            'nomor_surat'     => 'B. 088/P3M-Polibang/X/PN/2026',
            'tanggal_mulai'   => '2026-10-01',
            'tanggal_selesai' => '2026-12-31',
        ]);

        anggotap3mModel::create([
            'ajupenel_model_id' => $penelitian->id,
            'nama'              => 'Peneliti Anggota Satu, M.Ak.',
            'nim'               => '0610098811',
            'prodi'             => 'AK',
            'jabatan'           => 'DS',
        ]);

        anggotap3mModel::create([
            'ajupenel_model_id' => $penelitian->id,
            'nama'              => 'Mahasiswa Peneliti Satu',
            'nim'               => '2024010888',
            'prodi'             => 'AP',
            'jabatan'           => 'MHS',
        ]);

        anggotap3mModel::create([
            'ajupenel_model_id' => $penelitian->id,
            'nama'              => 'Peneliti Anggota Dua, M.M.',
            'nim'               => '0610098822',
            'prodi'             => 'AB',
            'jabatan'           => 'LT',
        ]);

        // 1. Verifikasi Detail Admin
        $resDetail = $this->actingAs($this->admin)
            ->get(route('detail.detail', ['tipe' => 'ajupenel', 'id' => $penelitian->id]));
        $resDetail->assertOk();
        $detailHtml = $resDetail->getContent();

        $this->assertStringContainsString('Akuntansi Keuangan Publik', $detailHtml);
        $this->assertStringContainsString('Agribisnis Peternakan', $detailHtml);
        $this->assertStringContainsString('Bisnis Digital', $detailHtml);

        // 2. Verifikasi PDF Surat Tugas
        $resPdf = $this->actingAs($this->admin)
            ->get(route('p3m.surat-tugaspen.download', $penelitian->id));
        $resPdf->assertOk();
        $pdfContent = $resPdf->getContent();

        $this->assertStringContainsString('SURAT TUGAS PENELITIAN', $pdfContent);
        $this->assertStringContainsString('B. 088/P3M-Polibang/X/PN/2026', $pdfContent);
        $this->assertStringContainsString('Dr. H. Peneliti Utama, M.Kom.', $pdfContent);
        $this->assertStringContainsString('0619098899', $pdfContent);
        $this->assertStringContainsString('Akuntansi Keuangan Publik', $pdfContent);
        $this->assertStringContainsString('Ketua', $pdfContent);

        $this->assertStringContainsString('Peneliti Anggota Satu, M.Ak.', $pdfContent);
        $this->assertStringContainsString('Mahasiswa Peneliti Satu', $pdfContent);
        $this->assertStringContainsString('Agribisnis Peternakan', $pdfContent);
        $this->assertStringContainsString('Peneliti Anggota Dua, M.M.', $pdfContent);
        $this->assertStringContainsString('Bisnis Digital', $pdfContent);

        // Pastikan Jabatan pada seluruh anggota adalah 'Anggota' dan tidak ada kode internal
        $this->assertStringContainsString('(Ketua)', $pdfContent);
        $this->assertStringContainsString('(Anggota)', $pdfContent);
        $this->assertStringNotContainsString('(DS)', $pdfContent);
        $this->assertStringNotContainsString('(MHS)', $pdfContent);
        $this->assertStringNotContainsString('(LT)', $pdfContent);
        $this->assertStringNotContainsString('(KP)', $pdfContent);
    }

    /**
     * Memastikan text-wrapping pada nama/gelar panjang (seperti Nila Ayu Kusuma Wardani, S.E., M.E)
     * sinkron 100% antara perhitungan calculateLines dan lebar MultiCell, sehingga tinggi cell membesar
     * otomatis dan garis border bawah tidak memotong teks (border collision bug).
     */
    public function test_surat_tugas_multiline_name_cell_height_agreement_and_no_border_overlap(): void
    {
        $service = new SuratTugasPdfService('Penelitian');
        $service->AddPage();
        $service->SetFont('Times', '', 9.5);

        // Lebar kolom NAMA adalah 54mm, dengan indent 2.0mm maka lebar cetak MultiCell adalah 50.5mm
        $colWidth = 54.0;
        $printWidth = $colWidth - 3.5; // 50.5mm

        $multilineName = 'Nila Ayu Kusuma Wardani, S.E., M.E';
        $calculatedLines = $service->calculateLines($printWidth, $multilineName);

        // Harus terhitung 2 baris (bukan 1 baris seperti sebelum perbaikan)
        $this->assertEquals(2, $calculatedLines, 'Nama dan gelar panjang harus dihitung 2 baris pada printable width');

        // Uji agreement langsung dengan FPDF MultiCell
        $yBefore = $service->GetY();
        $service->MultiCell($printWidth, 4.4, $multilineName, 0, 'L');
        $yAfter = $service->GetY();
        $actualLines = (int)round(($yAfter - $yBefore) / 4.4);

        $this->assertEquals($calculatedLines, $actualLines, 'Perhitungan calculateLines harus identik dengan aktual FPDF MultiCell');
    }

    /**
     * Memastikan sanitasi artefak mojibake encoding (seperti â€™ menjadi ') serta normalisasi
     * typographic smart quotes/apostrof (’, ‘, ʼ, `, “) dan dash (–, —) pada seluruh komponen surat.
     */
    public function test_surat_tugas_mojibake_and_typographic_punctuation_sanitization(): void
    {
        // 1. Uji langsung method sanitizeText
        $this->assertSame("M. A'zim Musyaddad", SuratTugasPdfService::sanitizeText("M. Aâ€™zim Musyaddad"));
        $this->assertSame("M. A'zim Musyaddad", SuratTugasPdfService::sanitizeText("M. A’zim Musyaddad"));
        $this->assertSame("M. A'zim Musyaddad", SuratTugasPdfService::sanitizeText("M. A‘zim Musyaddad"));
        $this->assertSame("M. A'zim Musyaddad", SuratTugasPdfService::sanitizeText("M. A`zim Musyaddad"));
        $this->assertSame("M. A'zim Musyaddad", SuratTugasPdfService::sanitizeText("M. Aʼzim Musyaddad"));
        $this->assertSame('"Inovasi Digital" - 2026', SuratTugasPdfService::sanitizeText('“Inovasi Digital” – 2026'));

        // 2. Uji hasil dokumen PDF lengkap dengan data riil Wanusobo
        $submission = (object)[
            'judul'           => 'CIRCULAR ECONOMY BERBASIS RUMAH TANGGA: ANALISIS PEMANFAATAN MINYAK JELANTAH MENJADI PRODUK KREATIF BERNILAI EKONOMI PADA KELOMPOK PKK DESA WANUSOBO',
            'ketua'           => 'Nur Hikmah, M.E',
            'nidn'            => '0610058202',
            'prodi'           => 'A',
            'nomor_surat'     => 'A. 010/P3M–Polibang/IX/PL/2026', // Menggunakan en-dash tipografis
            'tanggal_mulai'   => '2026-09-01',
            'tanggal_selesai' => '2026-09-30',
        ];

        $members = [
            ['nama' => 'Muhammad Ali Subkan, M.Pd', 'nim' => '0625109201', 'prodi' => 'AK', 'jabatan' => 'DS'],
            ['nama' => 'Nila Ayu Kusuma Wardani, S.E., M.E', 'nim' => '0615039702', 'prodi' => 'AK', 'jabatan' => 'DS'],
            ['nama' => 'Purwati, S.E., M.E', 'nim' => '0610029601', 'prodi' => 'AK', 'jabatan' => 'DS'],
            ['nama' => 'M. Hilal Abyan', 'nim' => '2023010037', 'prodi' => 'AK', 'jabatan' => 'MHS'],
            ['nama' => 'Adinda Pretty Giftsafiani', 'nim' => '2023030131', 'prodi' => 'AK', 'jabatan' => 'MHS'],
            ['nama' => 'M. Ariel Setyawan', 'nim' => '2023020106', 'prodi' => 'A', 'jabatan' => 'MHS'],
            ['nama' => 'M. Aâ€™zim Musyaddad', 'nim' => '2023020106', 'prodi' => 'A', 'jabatan' => 'MHS'],
        ];

        $service = new SuratTugasPdfService('Penelitian');
        $service->SetCompression(false);
        $pdf = $service->generateDocument($submission, $members);

        // Verifikasi tidak ada karakter mojibake â€™
        $this->assertStringNotContainsString('â€™', $pdf);
        $this->assertStringNotContainsString('â€˜', $pdf);

        // Verifikasi nama terkonversi menjadi apostrof standar yang bersih
        $this->assertStringContainsString("M. A'zim Musyaddad", $pdf);

        // Verifikasi nomor surat tanda strip bersih
        $this->assertStringContainsString('A. 010/P3M-Polibang/IX/PL/2026', $pdf);
    }
}
