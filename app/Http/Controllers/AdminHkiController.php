<?php

namespace App\Http\Controllers;

use App\Models\Hki;
use App\Models\SubmissionStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminHkiController extends Controller
{
    // ──────────────────────────────────────────────
    //  INDEX — List semua HKI dari seluruh dosen
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $user = Auth::user();
        $pagetitle = 'Data HKI Dosen';

        // Tandai HKI yang belum dibaca admin
        Hki::whereNull('read_at')->update(['read_at' => now()]);

        $query = Hki::with(['user', 'anggotas'])->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status') && in_array($request->status, ['diproses', 'diterima', 'direvisi', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis HKI
        if ($request->filled('jenis_hki') && !empty($request->jenis_hki)) {
            $query->where('jenis_hki', $request->jenis_hki);
        }

        // Pencarian
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                  ->orWhere('nomor_pencatatan', 'like', '%' . $keyword . '%')
                  ->orWhere('jenis_hki', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($uq) use ($keyword) {
                      $uq->where('name', 'like', '%' . $keyword . '%');
                  })
                  ->orWhereHas('anggotas', function ($aq) use ($keyword) {
                      $aq->where('nama', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $hkis = $query->get();

        return view('plppm.hki_dosen', compact('user', 'pagetitle', 'hkis'));
    }

    // ──────────────────────────────────────────────
    //  SHOW — Detail HKI (read-only untuk admin)
    // ──────────────────────────────────────────────
    public function show($id)
    {
        $user = Auth::user();
        $pagetitle = 'Detail HKI Dosen';

        $hki = Hki::with(['user', 'anggotas'])->findOrFail($id);

        return view('plppm.hki_dosen_detail', compact('user', 'pagetitle', 'hki'));
    }

    // ──────────────────────────────────────────────
    //  UPDATE CATATAN / STATUS — Catatan admin P3M
    //  Admin hanya boleh memberikan catatan,
    //  BUKAN mengubah data karya cipta dosen.
    // ──────────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $hki = Hki::findOrFail($id);

        $request->validate([
            'catatan' => 'nullable|string|max:2000',
            'reason'  => 'nullable|string|max:2000',
            'status'  => 'nullable|string|max:50',
        ], [
            'catatan.max' => 'Catatan maksimal 2000 karakter.',
            'reason.max'  => 'Catatan maksimal 2000 karakter.',
        ]);

        // Catat status sebelum perubahan untuk audit trail
        $previousStatus = $hki->status;

        $catatan = $request->input('catatan') ?? $request->input('reason');
        $hki->catatan_admin = !blank($catatan) ? trim($catatan) : null;

        if ($request->filled('status')) {
            $rawStatus = $request->input('status');
            $hki->status = match ($rawStatus) {
                'approve', 'diterima'     => 'diterima',
                'proses', 'diproses'      => 'diproses',
                'non-approve', 'ditolak'  => 'ditolak',
                'direvisi'                => 'direvisi',
                default                   => $hki->status ?? 'diproses',
            };
        }

        $hki->save();

        // SEC-AUTHZ-04: Catat audit trail hanya jika status benar-benar berubah.
        // Ini mencegah duplicate history jika admin hanya memperbarui catatan.
        if ($hki->status !== $previousStatus) {
            SubmissionStatusHistory::create([
                'submission_type' => 'hki',
                'submission_id'   => $hki->id,
                'previous_status' => $previousStatus,
                'status'          => $hki->status,
                'reason'          => !blank($catatan) ? trim($catatan) : null,
                'decided_by'      => Auth::id(),
                'decided_at'      => now(),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Catatan admin untuk HKI berhasil disimpan.');
    }

    // ──────────────────────────────────────────────
    //  DOWNLOAD — Unduh file sertifikat HKI (admin)
    // ──────────────────────────────────────────────
    public function download($id)
    {
        $hki = Hki::findOrFail($id);

        $path = $this->resolveHkiFilePath($hki);
        if (!$path || !file_exists($path)) {
            return redirect()->back()->with('error', 'File sertifikat HKI tidak ditemukan.');
        }

        $downloadName = $hki->file_name ?: basename($path);
        if (!str_ends_with(strtolower($downloadName), '.pdf')) {
            $downloadName .= '.pdf';
        }

        return response()->download($path, $downloadName, [
            'Content-Type'           => 'application/pdf',
            'Cache-Control'          => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'                 => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    // ══════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ══════════════════════════════════════════════

    /**
     * Resolusi path file fisik sertifikat HKI dari private disk.
     */
    private function resolveHkiFilePath(Hki $hki): ?string
    {
        $rawPath = $hki->file_path;
        if (empty($rawPath)) {
            return null;
        }

        // Primary: Storage disk private direct path
        if (Storage::disk('private')->exists($rawPath)) {
            return Storage::disk('private')->path($rawPath);
        }

        // Fallback: subfolder check
        $baseName = basename($rawPath);
        if (Storage::disk('private')->exists('hki-sertifikat/' . $baseName)) {
            return Storage::disk('private')->path('hki-sertifikat/' . $baseName);
        }

        return null;
    }
}
