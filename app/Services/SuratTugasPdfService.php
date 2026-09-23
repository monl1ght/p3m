<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class SuratTugasPdfService extends Fpdi
{
    private string $letterType;
    private ?string $logoLeft;
    private ?string $logoRight;
    private ?string $templatePath;

    public function __construct(string $letterType = 'Pengabdian Masyarakat', ?string $templatePath = null)
    {
        parent::__construct('P', 'mm', 'A4');
        $this->letterType = $letterType;
        $this->templatePath = $templatePath;

        $leftPath = public_path('mte/assets/img/Logo_Politbang.png');
        $rightPath = public_path('mte/assets/img/clients/Pusat_Penelitian.png');

        $this->logoLeft = (file_exists($leftPath) && is_readable($leftPath)) ? $leftPath : null;
        $this->logoRight = (file_exists($rightPath) && is_readable($rightPath)) ? $rightPath : null;

        $this->SetMargins(20, 15, 20);
        $this->SetAutoPageBreak(false); // Controlled programmatically to ensure table and signature layout integrity

        $initialTitle = 'Surat Tugas ' . $this->letterType;
        $this->SetTitle($initialTitle, true);
        $this->SetAuthor('P3M Politeknik Balekambang', true);
        $this->SetCreator('P3M Politeknik Balekambang', true);
        $this->SetSubject($initialTitle, true);
    }

    /**
     * Render Kop Surat resmi Politeknik Balekambang dan P3M.
     */
    public function renderHeader(): void
    {
        // Jika terdapat file PDF template pre-printed valid, gunakan sebagai background layer
        if ($this->templatePath && file_exists($this->templatePath) && is_readable($this->templatePath)) {
            try {
                $this->setSourceFile($this->templatePath);
                $tplIdx = $this->importPage(1);
                $this->useTemplate($tplIdx, 0, 0, 210);
                $this->SetY(48);
                return;
            } catch (\Throwable $e) {
                Log::warning("Gagal import template surat ({$this->templatePath}): " . $e->getMessage());
            }
        }

        $startY = 12.5;

        // Logo Politeknik Balekambang (Kiri)
        if ($this->logoLeft) {
            // Target height 21mm, width 18.1mm
            $this->Image($this->logoLeft, 20, $startY, 18.1, 21);
        }

        // Logo P3M (Kanan)
        if ($this->logoRight) {
            // Target height 21mm, width 22.3mm
            $this->Image($this->logoRight, 167.7, $startY, 22.3, 21);
        }

        // Teks Kop Surat (Center di antara kedua logo)
        $this->SetY($startY + 0.5);
        $this->SetFont('Times', 'B', 13.5);
        $this->Cell(170, 5.5, 'POLITEKNIK BALEKAMBANG', 0, 1, 'C');

        $this->SetFont('Times', 'B', 10);
        $this->Cell(170, 5, 'PUSAT PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT (P3M)', 0, 1, 'C');

        $this->SetFont('Times', '', 8.5);
        $this->Cell(170, 4.2, 'Jl. Raya Jepara - Kudus Km. 10 Balekambang, Gemiring Lor, Nalumsari, Jepara, Jawa Tengah 59466', 0, 1, 'C');

        $this->SetFont('Times', '', 8);
        $this->Cell(170, 3.8, 'Website: https://p3m.polibang.ac.id | Email: p3m@polibang.ac.id', 0, 1, 'C');

        // Garis Pembatas Kop Ganda (Double Rule)
        $lineY = 38.5;
        $this->SetLineWidth(0.75);
        $this->Line(20, $lineY, 190, $lineY);
        $this->SetLineWidth(0.25);
        $this->Line(20, $lineY + 1.1, 190, $lineY + 1.1);

        $this->SetY($lineY + 5.5);
    }

    /**
     * Render Judul Surat Tugas formal dan bergaris bawah.
     */
    public function renderTitle(): void
    {
        $this->SetFont('Times', 'BU', 12);
        $title = 'SURAT TUGAS ' . strtoupper($this->letterType);
        $this->Cell(170, 6.5, $title, 0, 1, 'C');
        $this->Ln(3);
    }

    /**
     * Format kode Program Studi menjadi nama resmi atau singkatan standar.
     */
    public function formatProdi(?string $prodi): string
    {
        if (!$prodi) {
            return '-';
        }
        $clean = trim($prodi);
        return match (strtoupper($clean)) {
            'R'  => 'RPL',
            'A'  => 'Agribisnis',
            'AK' => 'Akuntansi',
            'AB' => 'Admin Bisnis',
            'AP' => 'Admin Perkantoran',
            default => $clean,
        };
    }

    /**
     * Hitung jumlah baris yang dihasilkan oleh teks pada lebar sel tertentu.
     * Menggunakan font dan cMargin FPDF secara sinkron untuk menghindari text overflow.
     */
    public function calculateLines(float $width, string $text): int
    {
        $cw = &$this->CurrentFont['cw'];
        if ($width <= 0) {
            $width = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($width - (2 * $this->cMargin)) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $text);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] === "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c === "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c === ' ') {
                $sep = $i;
            }
            $l += $cw[$c] ?? 500;
            if ($l > $wmax) {
                if ($sep === -1) {
                    if ($i === $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    /**
     * Render header tabel peserta.
     */
    public function renderTableHeader(float $startX, array $widths, array $headers): void
    {
        $this->SetFont('Times', 'B', 10);
        $this->SetFillColor(242, 244, 247);
        $this->SetDrawColor(30, 30, 30);
        $this->SetLineWidth(0.3);

        $this->SetX($startX);
        foreach ($headers as $i => $header) {
            $this->Cell($widths[$i], 8, $header, 1, 0, 'C', true);
        }
        $this->Ln();
    }

    /**
     * Render tabel anggota dinamis dengan text-wrapping dan vertical alignment presisi.
     */
    public function renderTable(array $rows): void
    {
        $startX = 20;
        $widths = [10, 58, 32, 45, 25]; // Total: 170mm (A4 printable width)
        $headers = ['NO', 'NAMA', 'NIDN/NIM', 'PROGRAM STUDI', 'JABATAN'];
        $aligns = ['C', 'L', 'C', 'L', 'C'];

        $this->renderTableHeader($startX, $widths, $headers);

        $this->SetFont('Times', '', 9.5);
        $lineHeight = 4.6;

        foreach ($rows as $row) {
            // Pastikan font data aktif saat menghitung baris
            $this->SetFont('Times', '', 9.5);
            $maxLines = 1;
            foreach ($row as $i => $text) {
                $lines = $this->calculateLines($widths[$i], (string)$text);
                if ($lines > $maxLines) {
                    $maxLines = $lines;
                }
            }

            $rowHeight = max(7.2, ($maxLines * $lineHeight) + 2.8);

            // Cek kebutuhan page break sebelum mencetak baris
            if ($this->GetY() + $rowHeight > 265) {
                $this->AddPage();
                $this->renderHeader();
                $this->Ln(2);
                $this->renderTableHeader($startX, $widths, $headers);
                $this->SetFont('Times', '', 9.5);
            }

            $currentY = $this->GetY();

            // Render masing-masing kolom dengan border utuh dan padding rapi
            foreach ($row as $i => $text) {
                $colX = $startX + array_sum(array_slice($widths, 0, $i));
                $colW = $widths[$i];

                // Gambar kotak batas sel
                $this->Rect($colX, $currentY, $colW, $rowHeight, 'D');

                // Hitung offset vertikal agar teks berada di tengah tinggi sel
                $cellLines = $this->calculateLines($colW, (string)$text);
                $textHeight = $cellLines * $lineHeight;
                $topPadding = max(1.4, ($rowHeight - $textHeight) / 2);

                $this->SetXY($colX, $currentY + $topPadding);
                $this->MultiCell($colW, $lineHeight, (string)$text, 0, $aligns[$i]);
            }

            $this->SetXY($startX, $currentY + $rowHeight);
        }
    }

    /**
     * Generate seluruh dokumen Surat Tugas dan kembalikan binary string PDF.
     */
    public function generateDocument(object $submission, iterable $anggotaList): string
    {
        $docTitle = 'Surat Tugas ' . $this->letterType;
        if (!empty($submission->judul)) {
            $cleanJudul = trim(strip_tags((string)$submission->judul));
            if ($cleanJudul !== '') {
                $docTitle .= ' - ' . $cleanJudul;
            }
        }
        $this->SetTitle($docTitle, true);
        $this->SetAuthor('P3M Politeknik Balekambang', true);
        $this->SetCreator('P3M Politeknik Balekambang', true);
        $this->SetSubject('Surat Tugas Resmi P3M Politeknik Balekambang', true);

        $this->AddPage();
        $this->renderHeader();
        $this->renderTitle();

        // Kalimat pengantar
        $this->SetFont('Times', '', 10.5);
        $this->Cell(170, 5.5, 'Ketua Pusat Penelitian dan Pengabdian kepada Masyarakat memberikan tugas kepada:', 0, 1, 'L');
        $this->Ln(2);

        // Siapkan baris data tabel
        $tableRows = [];

        // Ketua
        $ketuaProdi = $this->formatProdi($submission->prodi ?? null);
        $ketuaNidn = $submission->nidn ?: '-';
        $tableRows[] = [
            '1',
            $submission->ketua ?? '-',
            $ketuaNidn,
            $ketuaProdi,
            'Ketua',
        ];

        // Anggota
        $no = 2;
        foreach ($anggotaList as $item) {
            $nama = is_array($item) ? ($item['nama'] ?? '-') : ($item->nama ?? '-');
            $nim = is_array($item) ? ($item['nim'] ?? '-') : ($item->nim ?? '-');
            $prodi = is_array($item) ? ($item['prodi'] ?? null) : ($item->prodi ?? null);
            $rawJabatan = is_array($item) ? ($item['jabatan'] ?? 'Anggota') : ($item->jabatan ?? 'Anggota');
            $cleanJabatan = trim((string)$rawJabatan);
            if (empty($cleanJabatan) || strtoupper($cleanJabatan) === 'KP' || strtoupper($cleanJabatan) === 'ANGGOTA') {
                $jabatan = 'Anggota';
            } else {
                $jabatan = $cleanJabatan;
            }

            $tableRows[] = [
                (string)$no++,
                $nama ?: '-',
                $nim ?: '-',
                $this->formatProdi($prodi),
                $jabatan,
            ];
        }

        // Render tabel anggota
        $this->renderTable($tableRows);

        // Bagian Bawah Surat: Detail Kegiatan
        $this->Ln(3.5);

        // Cek sisa halaman sebelum mencetak detail kegiatan dan tanda tangan
        if ($this->GetY() + 60 > 275) {
            $this->AddPage();
            $this->renderHeader();
            $this->Ln(4);
        }

        $kegiatanType = ($this->letterType === 'Penelitian') ? 'Penelitian' : 'Pengabdian';

        $this->SetFont('Times', '', 10.5);
        $this->Cell(170, 5.5, "Untuk melakukan {$kegiatanType} dengan judul:", 0, 1, 'L');

        $this->SetFont('Times', 'B', 11);
        $this->MultiCell(170, 5.2, $submission->judul ?? '-', 0, 'L');
        $this->Ln(1.2);

        // Tanggal Pelaksanaan
        $tglMulai = !empty($submission->tanggal_mulai) ? Carbon::parse($submission->tanggal_mulai)->locale('id')->translatedFormat('j F Y') : '-';
        $tglSelesai = !empty($submission->tanggal_selesai) ? Carbon::parse($submission->tanggal_selesai)->locale('id')->translatedFormat('j F Y') : '-';

        $this->SetFont('Times', '', 10.5);
        $this->Cell(170, 5.5, "Yang akan dilaksanakan pada tanggal {$tglMulai} - {$tglSelesai}.", 0, 1, 'L');
        $this->Ln(1.2);

        // Kalimat Penutup
        $sopType = ($this->letterType === 'Penelitian') ? 'Penelitian' : 'Pengabdian';
        $this->MultiCell(170, 5.2, "Surat tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab. Hal-hal yang terkait dengan prosedur pelaksanaan dapat dilihat pada SOP {$sopType} Politeknik Balekambang.", 0, 'L');

        // Blok Tanda Tangan
        $sigHeight = 40;
        if ($this->GetY() + $sigHeight > 275) {
            $this->AddPage();
            $this->renderHeader();
            $this->Ln(4);
        }

        $this->Ln(4.5);
        $sigX = 125;
        $sigW = 65;

        $this->SetX($sigX);
        $this->SetFont('Times', '', 10.5);
        $today = Carbon::now()->locale('id')->translatedFormat('d F Y');
        $this->Cell($sigW, 5, "Jepara, {$today}", 0, 1, 'L');

        $this->SetX($sigX);
        $this->Cell($sigW, 5, 'Ketua P3M,', 0, 1, 'L');

        $this->Ln(18); // Ruang tanda tangan & cap

        $this->SetX($sigX);
        $this->SetFont('Times', 'BU', 10.5);
        $this->Cell($sigW, 5, 'Sofia Ulfah, M.Kom.', 0, 1, 'L');

        $this->SetX($sigX);
        $this->SetFont('Times', 'B', 10.5);
        $this->Cell($sigW, 5, 'NIDN : 0619099004', 0, 1, 'L');

        return $this->Output('S');
    }
}
