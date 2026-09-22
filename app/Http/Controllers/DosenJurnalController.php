<?php

namespace App\Http\Controllers;

use App\Models\DosenJurnalUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DosenJurnalController extends Controller
{
    /**
     * List jurnal milik dosen yang login.
     * Mendukung filter ?kategori= dan ?status=
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $kategori = $request->input('kategori', '');
        $status = $request->input('status', '');

        $uploads = DosenJurnalUpload::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dosen.jurnal_upload.index', compact('user', 'uploads', 'kategori', 'status'));
    }

    /**
     * Form tambah jurnal baru.
     * Kategori terisi otomatis dari parameter URL.
     */
    public function create($kategori = null)
    {
        $user = Auth::user();

        if ($kategori && !in_array($kategori, ['penelitian', 'pengabdian'])) {
            $kategori = 'penelitian';
        }
        $kategori = $kategori ?: 'penelitian';

        return view('dosen.jurnal_upload.create', compact('user', 'kategori'));
    }

    /**
     * Simpan jurnal baru ke database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|in:penelitian,pengabdian',
            'uppdf'    => 'required|file|mimes:pdf|max:5120',
        ], [
            'judul.required'    => 'Judul jurnal wajib diisi.',
            'judul.max'         => 'Judul jurnal maksimal 255 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in'       => 'Kategori tidak valid.',
            'uppdf.required'    => 'File PDF jurnal wajib diunggah.',
            'uppdf.mimes'       => 'File harus berformat PDF.',
            'uppdf.max'         => 'Ukuran file maksimal 5 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('uppdf');
        $originalName = $file->getClientOriginalName();
        $storedName = time() . '_' . Str::random(16) . '.pdf';

        Storage::disk('private')->putFileAs('jurnal-dosen', $file, $storedName);

        DosenJurnalUpload::create([
            'user_id'   => $user->id,
            'judul'     => $request->input('judul'),
            'kategori'  => $request->input('kategori'),
            'file_path' => 'jurnal-dosen/' . $storedName,
            'file_name' => $originalName,
            'status'    => 'diproses',
        ]);

        return redirect()
            ->route('dosen.jurnal_upload.index', ['kategori' => $request->input('kategori')])
            ->with('success', 'Jurnal berhasil diunggah dan sedang menunggu verifikasi admin.');
    }

    /**
     * Form edit jurnal. Hanya bisa jika status bukan 'diterima'.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $jurnal = DosenJurnalUpload::where('user_id', $user->id)->findOrFail($id);

        if ($jurnal->status === 'diterima') {
            return redirect()->route('dosen.jurnal_upload.index')
                ->with('error', 'Jurnal yang sudah disetujui tidak dapat diedit.');
        }

        return view('dosen.jurnal_upload.edit', compact('user', 'jurnal'));
    }

    /**
     * Update jurnal yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $jurnal = DosenJurnalUpload::where('user_id', $user->id)->findOrFail($id);

        if ($jurnal->status === 'diterima') {
            return redirect()->route('dosen.jurnal_upload.index')
                ->with('error', 'Jurnal yang sudah disetujui tidak dapat diedit.');
        }

        $validator = Validator::make($request->all(), [
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|in:penelitian,pengabdian',
            'uppdf'    => 'nullable|file|mimes:pdf|max:5120',
        ], [
            'judul.required'    => 'Judul jurnal wajib diisi.',
            'judul.max'         => 'Judul jurnal maksimal 255 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in'       => 'Kategori tidak valid.',
            'uppdf.mimes'       => 'File harus berformat PDF.',
            'uppdf.max'         => 'Ukuran file maksimal 5 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jurnal->judul = $request->input('judul');
        $jurnal->kategori = $request->input('kategori');

        // Jika ada file baru, simpan file baru terlebih dahulu sebelum menghapus file lama
        if ($request->hasFile('uppdf')) {
            $file = $request->file('uppdf');
            $originalName = $file->getClientOriginalName();
            $storedName = time() . '_' . Str::random(16) . '.pdf';

            // Simpan ke private storage
            Storage::disk('private')->putFileAs('jurnal-dosen', $file, $storedName);

            // Hapus file lama jika berkas baru berhasil disimpan
            $oldPath = $this->resolveJurnalFilePath($jurnal);
            if ($oldPath && file_exists($oldPath)) {
                @unlink($oldPath);
            }

            $jurnal->file_path = 'jurnal-dosen/' . $storedName;
            $jurnal->file_name = $originalName;
        }

        // Reset status ke diproses setelah edit dan buat notifikasi unread
        $jurnal->status = 'diproses';
        $jurnal->catatan_admin = null;
        $jurnal->read_at = null;
        $jurnal->save();

        return redirect()
            ->route('dosen.jurnal_upload.index', ['kategori' => $jurnal->kategori])
            ->with('success', 'Jurnal berhasil diperbarui dan dikirim ulang untuk verifikasi.');
    }

    /**
     * Hapus jurnal. Hanya bisa jika status bukan 'diterima'.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $jurnal = DosenJurnalUpload::where('user_id', $user->id)->findOrFail($id);

        if ($jurnal->status === 'diterima') {
            return redirect()->route('dosen.jurnal_upload.index')
                ->with('error', 'Jurnal yang sudah disetujui tidak dapat dihapus.');
        }

        // Hapus file fisik jika ada
        $filePath = $this->resolveJurnalFilePath($jurnal);
        if ($filePath && file_exists($filePath)) {
            @unlink($filePath);
        }

        $jurnal->delete();

        return redirect()->route('dosen.jurnal_upload.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }

    /**
     * Download file jurnal.
     */
    public function download($id)
    {
        $user = Auth::user();
        $jurnal = DosenJurnalUpload::where('user_id', $user->id)->findOrFail($id);

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
    public function resolveJurnalFilePath(DosenJurnalUpload $jurnal): ?string
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
