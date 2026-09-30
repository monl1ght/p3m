<?php

namespace App\Http\Controllers;

use App\Models\Hki;
use App\Models\HkiAnggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DosenHkiController extends Controller
{
    // ──────────────────────────────────────────────
    //  INDEX — Daftar HKI milik dosen yang login
    // ──────────────────────────────────────────────
    public function index(Request $request)
    {
        $user = Auth::user();

        $uploads = Hki::where('user_id', $user->id)
            ->with('anggotas')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.hki.index', compact('user', 'uploads'));
    }

    // ──────────────────────────────────────────────
    //  CREATE — Form tambah HKI baru
    // ──────────────────────────────────────────────
    public function create()
    {
        $user = Auth::user();

        return view('dosen.hki.create', compact('user'));
    }

    // ──────────────────────────────────────────────
    //  STORE — Simpan HKI baru + anggota + file
    // ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'judul'             => 'required|string|max:255',
            'tanggal'           => 'required|date',
            'jenis_hki'         => 'nullable|string|max:100',
            'nomor_pencatatan'  => 'nullable|string|max:100',
            'file_sertifikat'   => 'required|file|mimes:pdf|max:5120',
            'anggota'           => 'required|array|min:1',
            'anggota.*.nama'    => 'required|string|max:150',
            'anggota.*.nim_nidn' => 'nullable|string|max:50',
            'anggota.*.peran'   => 'nullable|string|max:50',
        ], [
            'judul.required'          => 'Judul HKI wajib diisi.',
            'judul.max'               => 'Judul HKI maksimal 255 karakter.',
            'tanggal.required'        => 'Tanggal HKI wajib diisi.',
            'tanggal.date'            => 'Format tanggal tidak valid.',
            'file_sertifikat.required' => 'File sertifikat/HKI wajib diunggah.',
            'file_sertifikat.mimes'   => 'File sertifikat harus berformat PDF.',
            'file_sertifikat.max'     => 'Ukuran file sertifikat maksimal 5 MB.',
            'anggota.required'        => 'Minimal satu anggota/pencipta harus diisi.',
            'anggota.min'             => 'Minimal satu anggota/pencipta harus diisi.',
            'anggota.*.nama.required' => 'Nama anggota/pencipta wajib diisi.',
            'anggota.*.nama.max'      => 'Nama anggota maksimal 150 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Upload file ke private disk terlebih dahulu
        $file = $request->file('file_sertifikat');
        $originalName = $file->getClientOriginalName();
        $storedName = time() . '_' . Str::random(20) . '.pdf';
        $storedPath = 'hki-sertifikat/' . $storedName;

        try {
            Storage::disk('private')->putFileAs('hki-sertifikat', $file, $storedName);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengunggah file sertifikat. Silakan coba lagi.');
        }

        // Simpan data HKI + anggota dalam transaksi database
        try {
            DB::transaction(function () use ($user, $request, $storedPath, $originalName) {
                $hki = Hki::create([
                    'user_id'          => $user->id,
                    'judul'            => $request->input('judul'),
                    'tanggal'          => $request->input('tanggal'),
                    'jenis_hki'        => $request->input('jenis_hki'),
                    'nomor_pencatatan' => $request->input('nomor_pencatatan'),
                    'file_path'        => $storedPath,
                    'file_name'        => $originalName,
                    'status'           => 'diproses',
                ]);

                $this->syncAnggotas($hki, $request->input('anggota', []));
            });
        } catch (\Throwable $e) {
            // Rollback: hapus file yang sudah diupload jika DB gagal
            Storage::disk('private')->delete($storedPath);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data HKI. Silakan coba lagi.');
        }

        return redirect()
            ->route('dosen.hki.index')
            ->with('success', 'Data HKI berhasil disimpan dan tersimpan di repositori P3M.');
    }

    // ──────────────────────────────────────────────
    //  SHOW — Halaman Detail HKI
    // ──────────────────────────────────────────────
    public function show($id)
    {
        $user = Auth::user();
        $hki = Hki::where('user_id', $user->id)
            ->with('anggotas')
            ->findOrFail($id);

        return view('dosen.hki.show', compact('user', 'hki'));
    }

    // ──────────────────────────────────────────────
    //  EDIT — Form edit HKI (hanya jika belum diterima)
    // ──────────────────────────────────────────────
    public function edit($id)
    {
        $user = Auth::user();
        $hki = Hki::where('user_id', $user->id)->with('anggotas')->findOrFail($id);

        if ($hki->status === 'diterima') {
            return redirect()->route('dosen.hki.index')
                ->with('error', 'Data HKI yang sudah disetujui tidak dapat diubah.');
        }

        return view('dosen.hki.edit', compact('user', 'hki'));
    }

    // ──────────────────────────────────────────────
    //  UPDATE — Simpan perubahan HKI
    // ──────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $hki = Hki::where('user_id', $user->id)->findOrFail($id);

        if ($hki->status === 'diterima') {
            return redirect()->route('dosen.hki.index')
                ->with('error', 'Data HKI yang sudah disetujui tidak dapat diubah.');
        }

        $validator = Validator::make($request->all(), [
            'judul'             => 'required|string|max:255',
            'tanggal'           => 'required|date',
            'jenis_hki'         => 'nullable|string|max:100',
            'nomor_pencatatan'  => 'nullable|string|max:100',
            'file_sertifikat'   => 'nullable|file|mimes:pdf|max:5120',
            'anggota'           => 'required|array|min:1',
            'anggota.*.nama'    => 'required|string|max:150',
            'anggota.*.nim_nidn' => 'nullable|string|max:50',
            'anggota.*.peran'   => 'nullable|string|max:50',
        ], [
            'judul.required'          => 'Judul HKI wajib diisi.',
            'judul.max'               => 'Judul HKI maksimal 255 karakter.',
            'tanggal.required'        => 'Tanggal HKI wajib diisi.',
            'tanggal.date'            => 'Format tanggal tidak valid.',
            'file_sertifikat.mimes'   => 'File sertifikat harus berformat PDF.',
            'file_sertifikat.max'     => 'Ukuran file sertifikat maksimal 5 MB.',
            'anggota.required'        => 'Minimal satu anggota/pencipta harus diisi.',
            'anggota.min'             => 'Minimal satu anggota/pencipta harus diisi.',
            'anggota.*.nama.required' => 'Nama anggota/pencipta wajib diisi.',
            'anggota.*.nama.max'      => 'Nama anggota maksimal 150 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newStoredPath = null;
        $oldFilePath = $hki->file_path;
        $originalName = null;

        // Jika ada file baru, upload terlebih dahulu
        if ($request->hasFile('file_sertifikat')) {
            $file = $request->file('file_sertifikat');
            $originalName = $file->getClientOriginalName();
            $storedName = time() . '_' . Str::random(20) . '.pdf';
            $newStoredPath = 'hki-sertifikat/' . $storedName;

            try {
                Storage::disk('private')->putFileAs('hki-sertifikat', $file, $storedName);
            } catch (\Throwable $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah file sertifikat baru. Silakan coba lagi.');
            }
        }

        try {
            DB::transaction(function () use ($hki, $request, $newStoredPath, $originalName) {
                $previousStatus = $hki->status;
                $wasRejected = in_array($previousStatus, ['direvisi', 'ditolak', 'non-approve'], true);

                $hki->judul            = $request->input('judul');
                $hki->tanggal          = $request->input('tanggal');
                $hki->jenis_hki        = $request->input('jenis_hki');
                $hki->nomor_pencatatan = $request->input('nomor_pencatatan');

                if ($newStoredPath) {
                    $hki->file_path = $newStoredPath;
                    $hki->file_name = $originalName;
                }

                if ($wasRejected) {
                    $hki->status = 'diproses';
                    $hki->catatan_admin = null;
                }

                $hki->read_at = null;
                $hki->save();

                // Sinkronisasi anggota
                $this->syncAnggotas($hki, $request->input('anggota', []));
            });
        } catch (\Throwable $e) {
            // Rollback: hapus file baru jika DB gagal
            if ($newStoredPath) {
                Storage::disk('private')->delete($newStoredPath);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data HKI. Silakan coba lagi.');
        }

        // Hapus file lama hanya setelah DB sukses dan file baru tersimpan
        if ($newStoredPath && $oldFilePath) {
            $this->deleteFileFromPrivateDisk($oldFilePath);
        }

        return redirect()
            ->route('dosen.hki.index')
            ->with('success', 'Data HKI berhasil diperbarui.');
    }

    // ──────────────────────────────────────────────
    //  DESTROY — Hapus HKI (hanya jika belum diterima)
    // ──────────────────────────────────────────────
    public function destroy($id)
    {
        $user = Auth::user();
        $hki = Hki::where('user_id', $user->id)->findOrFail($id);

        if ($hki->status === 'diterima') {
            return redirect()->route('dosen.hki.index')
                ->with('error', 'Data HKI yang sudah disetujui tidak dapat dihapus.');
        }

        $filePath = $hki->file_path;

        // Hapus record DB (cascade ke anggotas via FK)
        $hki->delete();

        // Hapus file fisik setelah DB sukses
        if ($filePath) {
            $this->deleteFileFromPrivateDisk($filePath);
        }

        return redirect()->route('dosen.hki.index')
            ->with('success', 'Data HKI berhasil dihapus.');
    }

    // ──────────────────────────────────────────────
    //  DOWNLOAD — Unduh file sertifikat HKI
    // ──────────────────────────────────────────────
    public function download($id)
    {
        $user = Auth::user();
        $hki = Hki::where('user_id', $user->id)->findOrFail($id);

        $path = $this->resolveHkiFilePath($hki);
        if (!$path || !file_exists($path)) {
            return redirect()->back()->with('error', 'File sertifikat HKI tidak ditemukan.');
        }

        $downloadName = $hki->file_name ?: basename($path);
        if (!str_ends_with(strtolower($downloadName), '.pdf')) {
            $downloadName .= '.pdf';
        }

        return response()->download($path, $downloadName, [
            'Content-Type'        => 'application/pdf',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma'              => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    // ══════════════════════════════════════════════
    //  PRIVATE HELPERS
    // ══════════════════════════════════════════════

    /**
     * Sinkronisasi anggota/pencipta HKI (delete-then-create).
     */
    private function syncAnggotas(Hki $hki, array $members): void
    {
        HkiAnggota::where('hki_id', $hki->id)->delete();

        foreach ($members as $index => $member) {
            if (empty($member['nama'])) {
                continue;
            }
            HkiAnggota::create([
                'hki_id'   => $hki->id,
                'nama'     => $member['nama'],
                'nim_nidn' => $member['nim_nidn'] ?? null,
                'peran'    => $member['peran'] ?? 'Anggota',
                'urutan'   => $index + 1,
            ]);
        }
    }

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

    /**
     * Hapus file dari private disk secara aman.
     */
    private function deleteFileFromPrivateDisk(string $filePath): void
    {
        try {
            if (Storage::disk('private')->exists($filePath)) {
                Storage::disk('private')->delete($filePath);
            } else {
                // Coba juga basename saja di subfolder
                $baseName = basename($filePath);
                if (Storage::disk('private')->exists('hki-sertifikat/' . $baseName)) {
                    Storage::disk('private')->delete('hki-sertifikat/' . $baseName);
                }
            }
        } catch (\Throwable $e) {
            // Log error tapi jangan gagalkan operasi
            \Illuminate\Support\Facades\Log::warning('Gagal menghapus file HKI: ' . $filePath, [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
