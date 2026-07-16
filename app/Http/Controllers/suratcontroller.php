<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\p3mModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class suratcontroller extends Controller
{

    // public function downloadSuratTugas($id)
    // {
    //     // Ambil data dari database
    //     $pengajuan = p3mModel::with('anggotap3m')->findOrFail($id);

    //     // Bikin instance FPDI
    //     $pdf = new Fpdi();
    //     $pdf->AddPage();

    //     // Ambil template dasar
    //     $templatePath = storage_path('app/public/STPeng.pdf');
    //     $pdf->setSourceFile($templatePath);
    //     $template = $pdf->importPage(1);
    //     $pdf->useTemplate($template, 0, 0, 210);

    //     $startY = 60;
    //     $pdf->SetY($startY);
    //     $pdf->SetFont('Times', '', 12);

    //     // Header info (judul, lama kegiatan)
    //     $pdf->SetFont('Times', '', 12);
    //     $pdf->SetXY(25, 75);
    //     $pdf->MultiCell(160, 8, "Ketua Pusat Penelitian dan Pengabdian kepada Masyarakat memberikan tugas kepada:", 0, 'L');

    //     // Header tabel
    //     $pdf->SetXY(25, 95);
    //     $pdf->SetFont('Times', '', 12);
    //     $pdf->Cell(60, 10, 'Nama', 1);
    //     $pdf->Cell(40, 10, 'NIDN/NIM', 1);
    //     $pdf->Cell(60, 10, 'Jabatan', 1);
    //     $pdf->Ln();

    //     // Isi tabel: ketua
    //     $start_x = 25; // Define the starting X position
    //     $pdf->SetXY($start_x, $pdf->GetY(0));
    //     $pdf->SetFont('Times', '', 12);
    //     $pdf->Cell(60, 10, $pengajuan->ketua, 1);
    //     $pdf->Cell(40, 10, $pengajuan->prodi, 1);
    //     $pdf->Cell(60, 10, 'Ketua', 1);
    //     $pdf->Ln();

    //     // Isi tabel: anggota
    //     foreach ($pengajuan->anggotap3m as $anggota) {
    //         $start_x = 25;
    //         $pdf->SetXY($start_x, $pdf->GetY(0));
    //         $pdf->Cell(60, 10, $anggota->nama, 1);
    //         $pdf->Cell(40, 10, $anggota->prodi, 1);
    //         $pdf->Cell(60, 10, 'Anggota', 1);
    //         $pdf->Ln();
    //     }

    //     // Tulis isi surat
    //     $start_x = 25;
    //     $pdf->SetXY($start_x, $pdf->GetY(0));
    //     $pdf->Ln(5);
    //     $pdf->SetFont('Times', '', 12);
    //     $pdf->MultiCell(0, 8, "Untuk melakukan Pengabdian dengan judul:", 0, 'L');
    //     $pdf->SetFont('Times', 'B', 12);
    //     $pdf->MultiCell(0, 8, $pengajuan->judul, 0, 'L');

    //     // tanggal
    //     $tglMulai = Carbon::parse($pengajuan->tanggal_mulai)->locale('id')->translatedFormat('j F Y');
    //     $tglSelesai = Carbon::parse($pengajuan->tanggal_selesai)->locale('id')->translatedFormat('j F Y');
    //     $start_x = 25;
    //     $pdf->SetXY($start_x, $pdf->GetY(0));
    //     $pdf->Ln(3);
    //     $pdf->SetFont('Times', '', 12);
    //     $pdf->MultiCell(0, 8, "Yang akan dilaksanakan pada tanggal " . $tglMulai . " - " . $tglSelesai, 0, 'L');

    //     // Tanda tangan
    //     $pdf->Ln(15);
    //     $pdf->Cell(0, 8, "Jepara, " . Carbon::now()->locale('id')->translatedFormat('d F Y'), 0, 1, 'R');
    //     $pdf->Ln(8);
    //     $pdf->Cell(0, 8, "Ketua P3M,", 0, 1, 'R);');
    //     $pdf->Ln(20);
    //     $pdf->MultiCell(0, 7, "Jepara, " . now()->format('d F Y') . "\nKetua P3M,\n\n\nSofia Ulfah, M.Kom,\n06289898989", 0, 'R');

    //     // $pdf->SetXY(25, 60);
    //     // $pdf->SetFont('Times', '', 12);
    //     // $pdf->MultiCell(160, 8, "Judul Kegiatan: " . $pengajuan->judul, 0, 'L');
    //     // $pdf->Ln(0);
    //     // $pdf->SetX(25);
    //     // $pdf->MultiCell(160, 8, "Lama Kegiatan: " . $pengajuan->lamapenelitian . " hari", 0, 'L');
    //     // $pdf->Ln(10);

    //     // // Isi tabel: ketua

    //     // $pdf->SetFont('Times', 'B', 12);
    //     // $pdf->Cell(60, 10, $pengajuan->ketua, 1);
    //     // $pdf->Cell(40, 10, $pengajuan->prodi, 1);
    //     // $pdf->Cell(60, 10, 'Ketua', 1);
    //     // $pdf->Ln();

    //     // $pdf->SetFont('Times', '', 12);
    //     // foreach ($pengajuan->anggotap3m as $anggota) {
    //     //     $pdf->Cell(60, 10, $anggota->nama, 1);
    //     //     $pdf->Cell(40, 10, $anggota->prodi, 1);
    //     //     $pdf->Cell(60, 10, 'Anggota', 1);
    //     //     $pdf->Ln();
    //     // }

    //     // Tanda tangan di kanan bawah
    //     // $pdf->Ln(20);
    //     // $pdf->SetXY(120, $pdf->GetY());
    //     // $pdf->MultiCell(0, 7, "Jepara, " . now()->format('d F Y') . "\nKetua P3M,\n\n\nSofia Ulfah, M.Kom,\nNIDN : 0619099004", 0, 'L');

    //     // Output ke browser

    //     // // Tanda tangan
    //     // $pdf->Ln(15);
    //     // $pdf->SetXY(120, $pdf->GetY());
    //     // $pdf->Cell(0, 10, 'Jepara, ' . now()->format('d F Y'), 0, 1, 'L');
    //     // $pdf->SetXY(120, $pdf->GetY());
    //     // $pdf->Cell(0, 10, 'Ketua P3M,', 0, 1, 'L');
    //     // $pdf->Ln(20);
    //     // $pdf->SetXY(120, $pdf->GetY());
    //     // $pdf->Cell(0, 10, 'Sofia Ulfah, M.Kom', 0, 1, 'L');
    //     // $pdf->SetXY(120, $pdf->GetY());
    //     // $pdf->Cell(0, 10, '0192876327', 0, 1, 'L');

    //     // Output PDF
    //     return response($pdf->Output('S', 'Surat_Tugas_' . $pengajuan->id . '.pdf'))
    //         ->header('Content-Type', 'application/pdf')
    //         ->header('Content-Disposition', 'attachment; filename="Surat_Tugas_' . $pengajuan->id . '.pdf"');
    // }
    public function downloadSuratTugas($id)
    {
        $penelitian = p3mModel::with('anggotap3m')->findOrFail($id);
        $anggota = json_decode($penelitian->anggota, true);

        $pdf = new Fpdi();
        $pdf->AddPage();
        $templatePath = storage_path('app/public/STPG1.pdf');
        $pdf->setSourceFile($templatePath);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 210);

        // $pdf->SetTitle('Surat Tugas Penelitian');
        // $pdf->SetAuthor('Politeknik Balekambang');
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(25, 70);
        $pdf->MultiCell(160, 8, "Ketua Pusat Penelitian dan Pengabdian kepada Masyarakat memberikan tugas kepada:", 0, 'L');

        // Tabel header
        $y = $pdf->GetY(); // kasih jarak kecil, misal 5 biar gak nempel banget
        $pdf->SetY($y);
        $pdf->SetX(25);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(10, 10, 'NO', 1, 0, 'C');
        $pdf->Cell(53, 10, 'NAMA', 1, 0, 'C');
        $pdf->Cell(40, 10, 'NIDN/NIM', 1, 0, 'C');
        $pdf->Cell(55, 10, 'PROGRAM STUDI', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Jabatan', 1, 1, 'C');

        // Ketua
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $pdf->GetY(0));
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(10, 10, '1', 1, 0, 'C');
        $pdf->Cell(53, 10, $penelitian->ketua, 1);
        $pdf->Cell(40, 10, '-', 1);
        $pdf->Cell(55, 10, '-', 1);
        $pdf->Cell(20, 10, 'Ketua', 1, 1, 'C');

        // Anggota

        $no = 2;
        foreach ($penelitian->anggotap3m as $row) {
            $start_x = 25; // Define the starting X position
            $pdf->SetXY($start_x, $pdf->GetY(0));
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(53, 10, $row['nama'], 1);
            $pdf->Cell(40, 10, $row['nim'], 1);
            $pdf->Cell(55, 10, $row['prodi'], 1);
            $pdf->Cell(20, 10, 'Anggota', 1, 1, 'C');
        }

        // Bagian bawah: judul penelitian

        $pdf->Ln(3);
        $pdf->SetFont('Times', '', 12);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $pdf->GetY(0));
        $pdf->MultiCell(0, 8, "Untuk melakukan Pengabdian dengan judul:", 0, 'L');

        $currentY = $pdf->GetY();

        $pdf->SetFont('Times', 'B', 12);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $currentY - 1);
        $pdf->MultiCell(0, 8, $penelitian->judul, 0, 'L');

        // Tanggal
        $tglMulai = Carbon::parse($penelitian->tanggal_mulai)->locale('id')->translatedFormat('j F Y');
        $tglSelesai = Carbon::parse($penelitian->tanggal_selesai)->locale('id')->translatedFormat('j F Y');


        $currentY = $pdf->GetY();
        $pdf->Ln(1);

        $pdf->SetFont('Times', '', 12);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $currentY - 1);
        $pdf->MultiCell(0, 8, "Yang akan dilaksanakan pada tanggal " . $tglMulai . " - " . $tglSelesai . ".", 0, 'L');

        $currentY = $pdf->GetY();

        $pdf->Ln(2);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $currentY - 1);
        $pdf->MultiCell(0, 7, "Surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggungjawab. Hal-hal yang terkait dengan prosedur pelaksanaan dapat dilihat pada SOP  Penelitian Politeknik Balekambang.", 0, 'L');


        // Tanda tangan
        $pdf->Ln(5);
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 8, "Jepara, " . Carbon::now()->locale('id')->translatedFormat('d F Y'), 0, 1, 'R');
        $pdf->Cell(0, 8, "Ketua P3M,", 0, 1, 'R');
        $pdf->Ln(20);

        $pdf->SetFont('Times', 'BU', 12);
        $pdf->Cell(0, 6, "Sofia Ulfah, M.Kom.", 0, 1, 'R');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 6, "NIDN : 0619099004", 0, 1, 'R');
        $pdf->Output('I', 'Surat_Tugas_Penelitian.pdf');
    }

    public function downsurtagpen($id)
    {
        $penelitian = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        $anggota = json_decode($penelitian->anggota, true);

        $pdf = new Fpdi();
        $pdf->AddPage();
        $templatePath = storage_path('app/public/STPN1.pdf');
        $pdf->setSourceFile($templatePath);
        $tplIdx = $pdf->importPage(1);
        $pdf->useTemplate($tplIdx, 0, 0, 210);

        // $pdf->SetTitle('Surat Tugas Penelitian');
        // $pdf->SetAuthor('Politeknik Balekambang');
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(25, 70);
        $pdf->MultiCell(160, 8, "Ketua Pusat Penelitian dan Pengabdian kepada Masyarakat memberikan tugas kepada:", 0, 'L');

        // Tabel header
        $y = $pdf->GetY(); // kasih jarak kecil, misal 5 biar gak nempel banget
        $pdf->SetY($y);
        $pdf->SetX(25);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(10, 10, 'NO', 1, 0, 'C');
        $pdf->Cell(53, 10, 'NAMA', 1, 0, 'C');
        $pdf->Cell(40, 10, 'NIDN/NIM', 1, 0, 'C');
        $pdf->Cell(55, 10, 'PROGRAM STUDI', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Jabatan', 1, 1, 'C');

        // Ketua
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $pdf->GetY(0));
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(10, 10, '1', 1, 0, 'C');
        $pdf->Cell(53, 10, $penelitian->ketua, 1);
        $pdf->Cell(40, 10, '-', 1);
        $pdf->Cell(55, 10, '-', 1);
        $pdf->Cell(20, 10, 'Ketua', 1, 1, 'C');

        // Anggota

        $no = 2;
        foreach ($penelitian->anggotap3m as $row) {
            $start_x = 25; // Define the starting X position
            $pdf->SetXY($start_x, $pdf->GetY(0));
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(53, 10, $row['nama'], 1);
            $pdf->Cell(40, 10, $row['nim'], 1);
            $pdf->Cell(55, 10, $row['prodi'], 1);
            $pdf->Cell(20, 10, 'Anggota', 1, 1, 'C');
        }

        // Bagian bawah: judul penelitian

        $pdf->Ln(3);
        $pdf->SetFont('Times', '', 12);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $pdf->GetY(0));
        $pdf->MultiCell(0, 8, "Untuk melakukan Pengabdian dengan judul:", 0, 'L');

        $currentY = $pdf->GetY();

        $pdf->SetFont('Times', 'B', 12);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $currentY - 1);
        $pdf->MultiCell(0, 8, $penelitian->judul, 0, 'L');

        // Tanggal
        $tglMulai = Carbon::parse($penelitian->tanggal_mulai)->locale('id')->translatedFormat('j F Y');
        $tglSelesai = Carbon::parse($penelitian->tanggal_selesai)->locale('id')->translatedFormat('j F Y');


        $currentY = $pdf->GetY();
        $pdf->Ln(1);

        $pdf->SetFont('Times', '', 12);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $currentY - 1);
        $pdf->MultiCell(0, 8, "Yang akan dilaksanakan pada tanggal " . $tglMulai . " - " . $tglSelesai . ".", 0, 'L');

        $currentY = $pdf->GetY();

        $pdf->Ln(2);
        $start_x = 25; // Define the starting X position
        $pdf->SetXY($start_x, $currentY - 1);
        $pdf->MultiCell(0, 7, "Surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggungjawab. Hal-hal yang terkait dengan prosedur pelaksanaan dapat dilihat pada SOP  Penelitian Politeknik Balekambang.", 0, 'L');


        // Tanda tangan
        $pdf->Ln(5);
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 8, "Jepara, " . Carbon::now()->locale('id')->translatedFormat('d F Y'), 0, 1, 'R');
        $pdf->Cell(0, 8, "Ketua P3M,", 0, 1, 'R');
        $pdf->Ln(20);

        $pdf->SetFont('Times', 'BU', 12);
        $pdf->Cell(0, 6, "Sofia Ulfah, M.Kom.", 0, 1, 'R');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 6, "NIDN : 0619099004", 0, 1, 'R');
        $pdf->Output('I', 'Surat_Tugas_Penelitian.pdf');
    }
}
