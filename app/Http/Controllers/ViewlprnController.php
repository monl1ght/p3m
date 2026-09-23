<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\DosenJurnalUpload;
use App\Models\kum_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\p3mModel;
use App\Models\SubmissionStatusHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ViewlprnController extends Controller
{

    public function upp3m(Request $request)
    {
        // $data = new M_news();
        $pagetitle = 'Proposal Pengabdian Masyarakat';
        $user = Auth::user();
        // $data = User::find($id
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = p3mModel::with(['anggotap3m', 'latestStatusHistory']);
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = p3mModel::where('user_id', $user->id)
                ->with(['anggotap3m', 'latestStatusHistory']);
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();


        // $penelitians = p3mModel::where('user_id', $user->id)
        //     // ->orWhereNull('user_id')
        //     ->orderBy('created_at', 'desc')
        //     ->with('anggotap3m')
        //     ->get();
        // dd($penelitians);
        return view('plppm.lpengabdian', compact('user', 'penelitians', 'pagetitle'));
    }

    public function ajuanpeneliti(Request $request)
    {
        // $data = new M_news();
        $pagetitle = 'Proposal Penelitian Masyarakat';
        $user = Auth::user();
        // $data = User::find($id);
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = ajuan_penelitianModel::with(['anggotap3m', 'latestStatusHistory']);
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = ajuan_penelitianModel::where('user_id', $user->id)
                ->with(['anggotap3m', 'latestStatusHistory']);
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();
        // dd($penelitians);
        return view('plppm.lpeneleitian', compact('user', 'penelitians', 'pagetitle'));
    }

    public function kpengabdianp3m(Request $request)
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Pengabdian Masyarakat';
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = kum_pengabdianModel::with(['anggotap3m', 'latestStatusHistory']);
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = kum_pengabdianModel::where('user_id', $user->id)
                ->with(['anggotap3m', 'latestStatusHistory']);
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();
        return view('plppm.kpengabdian', compact('user', 'pagetitle', 'penelitians'));
    }

    public function kpeneliti(Request $request)
    {
        // $data = new M_news();
        $pagetitle = 'Laporan Penelitian Masyarakat';
        $user = Auth::user();
        // $data = User::find($id);
        if ($user->role == 'admin') {
            // Kalau admin, ambil semua data
            $query = kum_penelitianModel::with(['anggotap3m', 'latestStatusHistory']);
        } else {
            // Kalau bukan admin, ambil yang sesuai user_id
            $query = kum_penelitianModel::where('user_id', $user->id)
                ->with(['anggotap3m', 'latestStatusHistory']);
        }
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $penelitians = $query->orderBy('created_at', 'desc')->get();
        // dd($penelitians);
        return view('plppm.kpenelitian', compact('user', 'penelitians', 'pagetitle'));
    }


    //UPDATE STATUS P3M 
    //PEGABDIAN
    public function updateStatus(Request $request, $id)
    {
        $this->changeSubmissionStatus($request, p3mModel::class, 'proposal-pengabdian', $id);

        return redirect()->route('plppm.lpengabdian')->with('success', 'Status pengajuan berhasil diperbarui.');
    }


    //PENELITIAN
    public function updateStatusPen(Request $request, $id)
    {
        $this->changeSubmissionStatus($request, ajuan_penelitianModel::class, 'proposal-penelitian', $id);

        return redirect()->route('plppm.lpeneleitian')->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    //둘다
    public function updateStatuskump(Request $request, $tipe, $id)
    {
        switch ($tipe) {
            case 'kum_penelitian':
                $modelClass = kum_penelitianModel::class;
                $submissionType = 'laporan-penelitian';
                $redirect = 'plppm.kpenelitian';
                break;

            case 'kum_pengabdian':
                $modelClass = kum_pengabdianModel::class;
                $submissionType = 'laporan-pengabdian';
                $redirect = 'plppm.kpengabdian';
                break;

            default:
                return redirect()->back()->with('error', 'Tipe tidak valid');
        }

        $this->changeSubmissionStatus($request, $modelClass, $submissionType, $id);

        return redirect()->route($redirect)->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    /**
     * Apply one valid administrative decision and retain an immutable audit record.
     *
     * @param class-string<Model> $modelClass
     */
    private function changeSubmissionStatus(Request $request, string $modelClass, string $submissionType, int $id): void
    {
        $validated = $request->validate([
            'status' => 'required|in:approve,proses,non-approve',
            'reason' => 'nullable|string|max:2000',
        ]);

        if ($validated['status'] === 'non-approve' && blank($validated['reason'] ?? null)) {
            throw ValidationException::withMessages([
                'reason' => 'Alasan penolakan atau revisi wajib diisi.',
            ]);
        }

        DB::transaction(function () use ($request, $modelClass, $submissionType, $id, $validated) {
            $submission = $modelClass::query()->lockForUpdate()->findOrFail($id);
            $currentStatus = $submission->status ?? 'proses';
            
            // If the requested status is the same as current, just return
            if ($currentStatus === $validated['status']) {
                return;
            }

            $allowedTransitions = [
                'proses' => ['approve', 'non-approve'],
                'non-approve' => ['proses'],
                'approve' => ['proses'],
            ];

            if (! in_array($validated['status'], $allowedTransitions[$currentStatus] ?? [], true)) {
                throw ValidationException::withMessages([
                    'status' => 'Perubahan status tidak valid untuk status saat ini.',
                ]);
            }

            $submission->status = $validated['status'];
            $submission->save();

            SubmissionStatusHistory::create([
                'submission_type' => $submissionType,
                'submission_id' => $submission->id,
                'previous_status' => $currentStatus,
                'status' => $validated['status'],
                'reason' => $validated['status'] === 'non-approve' ? trim($validated['reason']) : null,
                'decided_by' => $request->user()->id,
                'decided_at' => now(),
            ]);
        });
    }


    public function dajupeneliti($tipe, $id, Request $request)
    {
        $user = Auth::user();
        $pagetitle = 'Detail Data Proposal';
        // $tipe = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        switch ($tipe) {
            case 'ajupengab':
                $data = p3mModel::with('anggotap3m')->findOrFail($id);
                $documentType = 'proposal-pengabdian';
                break;
            case 'ajupenel':
                $data = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
                $documentType = 'proposal-penelitian';
                break;
            // case 'kpenel':
            //     $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            // case 'kpengab':
            //     $data = kum_pengabdianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            default:
                abort(404);
        }
        if ($user->role != 'admin' && $data->user_id != $user->id) {
            abort(403, 'Kamu tidak boleh mengakses data ini.');
        }

        // Load decision history
        $statusHistories = SubmissionStatusHistory::where('submission_type', $documentType)
            ->where('submission_id', $id)
            ->with('decisionMaker')
            ->orderBy('decided_at', 'desc')
            ->get();

        // searching data
        if ($request->filled('search')) {
            $keyword = $request->get('search');

            if ($tipe === 'ajupengab') {
                $data = p3mModel::with('anggotap3m')
                    ->where('id', $id)
                    ->where('judul', 'like', '%' . $keyword . '%')
                    ->firstOrFail();
            } elseif ($tipe === 'ajupenel') {
                $data = ajuan_penelitianModel::with('anggotap3m')
                    ->where('id', $id)
                    ->where('judul', 'like', '%' . $keyword . '%')
                    ->firstOrFail();
            }
        }

        return view('detail.detail', [
            'penelitians'    => $data,
            'pagetitle'      => $pagetitle,
            'tipe'           => $tipe,
            'documentType'   => $documentType,
            'user'           => $user,
            'statusHistories' => $statusHistories,
            'layout'         => ($user->role === 'admin') ? 'layout.main' : 'layout.doslayout'
        ]);
    }

    public function kumpengneli($tipe, $id)
    {
        $user = Auth::user();
        $pagetitle = 'Detail Data Laporan';
        // $tipe = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        switch ($tipe) {
            case 'kpengeabdian':
                $data = kum_pengabdianModel::with('anggotap3m')->findOrFail($id);
                $documentType = 'laporan-pengabdian';
                break;
            case 'kpeneliti':
                $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
                $documentType = 'laporan-penelitian';
                break;
            // case 'kpenel':
            //     $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            // case 'kpengab':
            //     $data = kum_pengabdianModel::with('anggotap3m')->findOrFail($id);
            //     break;
            default:
                abort(404);
        }

        if ($user->role !== 'admin' && (int) $data->user_id !== (int) $user->id) {
            abort(403, 'Kamu tidak boleh mengakses data ini.');
        }

        // Load decision history
        $statusHistories = SubmissionStatusHistory::where('submission_type', $documentType)
            ->where('submission_id', $id)
            ->with('decisionMaker')
            ->orderBy('decided_at', 'desc')
            ->get();

        return view('detail.detailk', [
            'penelitians'    => $data,
            'type'           => 'penelitian',
            'documentType'   => $documentType,
            'user'           => $user,
            'pagetitle'      => $pagetitle,
            'statusHistories' => $statusHistories,
            'layout'         => ($user->role === 'admin') ? 'layout.main' : 'layout.doslayout'
        ]);
    }

    /**
     * List semua jurnal dosen untuk verifikasi admin.
     */
    public function jurnalDosen(Request $request)
    {
        $user = Auth::user();
        $pagetitle = 'List Jurnal P3M';

        // Tandai berkas jurnal yang belum dibaca admin
        DosenJurnalUpload::whereNull('read_at')->update(['read_at' => now()]);

        $query = DosenJurnalUpload::with(['user', 'latestStatusHistory'])->orderBy('created_at', 'desc');

        if ($request->filled('kategori') && in_array($request->kategori, ['penelitian', 'pengabdian'])) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status') && in_array($request->status, ['diproses', 'diterima', 'direvisi', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        $jurnals = $query->get();

        return view('plppm.jurnal_dosen', compact('user', 'pagetitle', 'jurnals'));
    }

    /**
     * Admin: update status jurnal dosen (diterima / diproses / ditolak / direvisi).
     */
    public function updateStatusJurnal(Request $request, $id)
    {
        $jurnal = DosenJurnalUpload::findOrFail($id);

        $request->validate([
            'status'  => 'required|in:diterima,direvisi,ditolak,diproses,approve,proses,non-approve',
            'catatan' => 'nullable|string|max:2000',
            'reason'  => 'nullable|string|max:2000',
            'alasan'  => 'nullable|string|max:2000',
        ], [
            'status.required' => 'Status verifikasi wajib dipilih.',
            'status.in'       => 'Status verifikasi tidak valid.',
            'catatan.max'     => 'Catatan maksimal 2000 karakter.',
            'reason.max'      => 'Catatan maksimal 2000 karakter.',
            'alasan.max'      => 'Catatan maksimal 2000 karakter.',
        ]);

        $rawStatus = $request->input('status');
        $normalizedStatus = match ($rawStatus) {
            'approve', 'diterima' => 'diterima',
            'proses', 'diproses'  => 'diproses',
            'non-approve', 'ditolak' => 'ditolak',
            'direvisi' => 'direvisi',
            default => 'diproses',
        };

        $catatan = $request->input('reason') ?? $request->input('catatan') ?? $request->input('alasan');

        if (in_array($normalizedStatus, ['ditolak', 'direvisi']) && blank($catatan)) {
            return redirect()->back()->with('error', 'Alasan penolakan atau revisi wajib diisi.');
        }

        $previousStatus = $jurnal->getOriginal('status') ?? 'diproses';
        $jurnal->status = $normalizedStatus;
        if ($normalizedStatus === 'diterima' || $normalizedStatus === 'diproses') {
            if ($catatan) {
                $jurnal->catatan_admin = $catatan;
            } else if ($normalizedStatus === 'diterima') {
                $jurnal->catatan_admin = null;
            }
        } else {
            $jurnal->catatan_admin = $catatan;
        }

        $jurnal->save();

        SubmissionStatusHistory::create([
            'submission_type' => 'jurnal-upload',
            'submission_id'   => $jurnal->id,
            'previous_status' => $previousStatus,
            'status'          => $normalizedStatus,
            'reason'          => in_array($normalizedStatus, ['ditolak', 'direvisi']) ? $catatan : null,
            'decided_by'      => $request->user()->id,
            'decided_at'      => now(),
        ]);

        $labels = [
            'diterima' => 'disetujui',
            'diproses' => 'diset ke status diproses',
            'direvisi' => 'diminta revisi',
            'ditolak'  => 'ditolak / diminta revisi',
        ];

        return redirect()->route('plppm.jurnal_dosen')
            ->with('success', 'Status jurnal berhasil ' . ($labels[$normalizedStatus] ?? 'diperbarui') . '.');
    }


    /**
     * Admin: download berkas PDF jurnal dosen.
     */
    public function downloadJurnal($id)
    {
        $jurnal = DosenJurnalUpload::findOrFail($id);
        $path = $this->resolveJurnalFilePath($jurnal);

        if (!$path || !file_exists($path)) {
            return redirect()->back()->with('error', 'File jurnal tidak ditemukan.');
        }

        $downloadName = $jurnal->file_name ?: basename($path);
        if (!str_ends_with(strtolower($downloadName), '.pdf')) {
            $downloadName .= '.pdf';
        }

        return response()->download($path, $downloadName, [
            'Content-Type'  => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'        => 'no-cache',
        ]);
    }

    /**
     * Resolusi path file fisik jurnal dari berbagai lokasi storage (backward compatible).
     */
    protected function resolveJurnalFilePath(DosenJurnalUpload $jurnal): ?string
    {
        $rawPath = $jurnal->file_path;
        if (empty($rawPath)) {
            return null;
        }

        $baseName = basename($rawPath);

        // 1. Storage disk private direct path
        if (Storage::disk('private')->exists($rawPath)) {
            return Storage::disk('private')->path($rawPath);
        }

        // 2. Storage disk private subfolder 'jurnal-dosen'
        if (Storage::disk('private')->exists('jurnal-dosen/' . $baseName)) {
            return Storage::disk('private')->path('jurnal-dosen/' . $baseName);
        }

        // 3. Storage disk private subfolder 'jurnal_dosen'
        if (Storage::disk('private')->exists('jurnal_dosen/' . $baseName)) {
            return Storage::disk('private')->path('jurnal_dosen/' . $baseName);
        }

        // 4. Storage disk local (storage/app)
        if (Storage::disk('local')->exists($rawPath)) {
            return Storage::disk('local')->path($rawPath);
        }
        if (Storage::disk('local')->exists('private/jurnal-dosen/' . $baseName)) {
            return Storage::disk('local')->path('private/jurnal-dosen/' . $baseName);
        }

        // 5. Fallback public path
        if (file_exists(public_path($rawPath))) {
            return public_path($rawPath);
        }
        if (file_exists(public_path('uploads/jurnal_dosen/' . $baseName))) {
            return public_path('uploads/jurnal_dosen/' . $baseName);
        }

        return null;
    }
}
