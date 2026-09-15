<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\kum_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\p3mModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionDocumentController extends Controller
{
    public function download(Request $request, string $type, int $id)
    {
        [$submission, $label] = $this->submissionFor($type, $id);
        $user = $request->user();

        abort_unless(
            $user->role === 'admin' || (int) $submission->user_id === (int) $user->id,
            403
        );

        $filename = $submission->uppdf;
        abort_unless(is_string($filename) && $filename !== '', 404);

        $privatePath = 'submissions/'.$filename;
        if (Storage::disk('private')->exists($privatePath)) {
            return Storage::disk('private')->download($privatePath, $label.'-'.$submission->id.'.pdf');
        }

        // File tidak ditemukan di private storage.
        // File lama yang tersimpan di disk public tidak lagi dapat diakses via controller ini
        // untuk mencegah akses publik tanpa otorisasi ke /storage/uppdf/.
        abort(404, 'Dokumen tidak ditemukan. Silakan hubungi admin atau upload ulang dokumen Anda.');
    }

    /**
     * Public download for approved reports only.
     * Laporan penelitian dan pengabdian yang sudah di-approve dapat didownload publik.
     */
    public function publicDownload(string $type, int $id)
    {
        [$submission, $label] = $this->submissionFor($type, $id);

        // Only allow public download for approved reports
        abort_unless(
            in_array($type, ['laporan-penelitian', 'laporan-pengabdian'], true),
            404,
            'Tipe dokumen tidak dapat diakses secara publik.'
        );

        // Check if status is approved
        abort_unless(
            isset($submission->status) && $submission->status === 'approve',
            403,
            'Dokumen hanya dapat diakses setelah disetujui.'
        );

        $filename = $submission->uppdf;
        abort_unless(is_string($filename) && $filename !== '', 404, 'File tidak tersedia.');

        $privatePath = 'submissions/'.$filename;
        abort_unless(
            Storage::disk('private')->exists($privatePath),
            404,
            'Dokumen tidak ditemukan.'
        );

        return Storage::disk('private')->download($privatePath, $label.'-'.$submission->id.'.pdf');
    }

    /** @return array{0: Model, 1: string} */
    private function submissionFor(string $type, int $id): array
    {
        return match ($type) {
            'proposal-pengabdian' => [p3mModel::findOrFail($id), 'proposal-pengabdian'],
            'proposal-penelitian' => [ajuan_penelitianModel::findOrFail($id), 'proposal-penelitian'],
            'laporan-pengabdian' => [kum_pengabdianModel::findOrFail($id), 'laporan-pengabdian'],
            'laporan-penelitian' => [kum_penelitianModel::findOrFail($id), 'laporan-penelitian'],
            default => abort(404),
        };
    }
}
