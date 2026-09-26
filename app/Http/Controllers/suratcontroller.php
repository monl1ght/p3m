<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\p3mModel;
use App\Services\SuratTugasPdfService;
use Illuminate\Http\Request;

class suratcontroller extends Controller
{
    /**
     * Download Surat Tugas Pengabdian Masyarakat.
     */
    public function downloadSuratTugas(Request $request, $id, $filename = null)
    {
        $penelitian = p3mModel::with('anggotap3m')->findOrFail($id);
        $this->authorizeLetterDownload($request, $penelitian);

        $templatePath = storage_path('app/templates/SURAT TUGAS PENELITIAN FORMAT.pdf');
        $pdfService = new SuratTugasPdfService('Pengabdian Masyarakat', $templatePath);
        $pdfContent = $pdfService->generateDocument($penelitian, $penelitian->anggotap3m);

        $disposition = $request->query('disposition') === 'attachment' ? 'attachment' : 'inline';
        $downloadFilename = 'Surat_Tugas_Pengabdian.pdf';

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "{$disposition}; filename=\"{$downloadFilename}\"");
    }

    /**
     * Download Surat Tugas Penelitian.
     */
    public function downsurtagpen(Request $request, $id, $filename = null)
    {
        $penelitian = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        $this->authorizeLetterDownload($request, $penelitian);

        $templatePath = storage_path('app/templates/SURAT TUGAS PENELITIAN FORMAT.pdf');
        $pdfService = new SuratTugasPdfService('Penelitian', $templatePath);
        $pdfContent = $pdfService->generateDocument($penelitian, $penelitian->anggotap3m);

        $disposition = $request->query('disposition') === 'attachment' ? 'attachment' : 'inline';
        $downloadFilename = 'Surat_Tugas_Penelitian.pdf';

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "{$disposition}; filename=\"{$downloadFilename}\"");
    }

    /**
     * Authorize download access for owner and admin on approved submissions.
     */
    private function authorizeLetterDownload(Request $request, $submission): void
    {
        $user = $request->user();

        abort_unless($submission->status === 'approve', 403);
        abort_unless(
            $user->role === 'admin' || (int) $submission->user_id === (int) $user->id,
            403
        );
        abort_if(
            blank($submission->nomor_surat),
            403,
            'Surat tugas belum dapat diunduh karena nomor surat belum diterbitkan.'
        );
    }
}
