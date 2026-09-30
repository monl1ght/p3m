<?php

namespace App\Http\Controllers;

use App\Models\m_panduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PanduanController extends Controller
{
    public function index(Request $request)
    {
        // $data = new M_news();
        $user = Auth::user();
        $pands = m_panduan::get();
        // if ($request->get('search')) {
        //     $data = M_news::where('title', 'like', '%' . $request->get('search') . '%');
        // }
        $pagetitle = 'Panduan';
        // $data = $data->get();
        return view('panduan.index', compact('pands', 'pagetitle', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        // $panduan = m_panduan::all();
        $pagetitle = 'Panduan Jurnal';
        return view('panduan.create', compact('pagetitle', 'user'));
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'original_name' => 'required|mimes:docx,pdf|max:2048'
    //     ]);

    //     if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

    //     // dd($request->all());
    //     $file = $request->file('file');
    //     $fileName = $file->hashName();
    //     $file->storeAs('uploads', $fileName);

    //     m_panduan::create([
    //         'original_name' => $file->getClientOriginalName(),
    //         'generated_name' => $fileName
    //     ]);

    //     // m_panduan::create($data);

    //     return redirect()->route('panduan.index');
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'original_name' => 'required|mimes:docx,pdf|max:5120',
            'namefile' => 'required',
        ], [
            'original_name.required' => 'File dokumen panduan wajib diunggah.',
            'original_name.mimes' => 'Format file harus berupa PDF atau DOCX.',
            'original_name.max' => 'Ukuran file dokumen panduan maksimal adalah 5 MB.',
            'namefile.required' => 'Nama file/judul panduan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'create_panduan');
        }

        $docs = $request->file('original_name');
        // SEC-FILE-01: Use server-detected extension instead of client-supplied
        $nama_docs = date('YmdHis') . '_' . uniqid() . '.' . ($docs->guessExtension() ?: 'bin');
        // Simpan ke storage disk publik pada subfolder panduan
        Storage::disk('public')->putFileAs('panduan', $docs, $nama_docs);

        $data = new m_panduan();
        $data->namefile = $request->namefile;
        $data->original_name = $nama_docs;
        $data->generated_name = $nama_docs;
        $data->save();
        return redirect()->route('panduan.index')->with('success', 'Panduan berhasil ditambahkan!');
    }

    // public function download(m_panduan $file)
    // {
    //     $filePath = storage_path("app/uploads/{$file->generated_name}");

    //     if (file_exists($filePath)) {
    //         return response()->download($filePath, $file->generated_name);
    //     } else {
    //         abort(404, 'File not found');
    //     }
    // }

    public function download($id)
    {
        Log::info("Download attempt for panduan ID: " . $id);
        $panduan = m_panduan::findOrFail($id);

        $diskFileName = $panduan->original_name ?: $panduan->generated_name;
        if (!$diskFileName) {
            Log::warning("Data panduan ID {$id} tidak memiliki file valid.");
            return redirect()->back()->with('error', 'Berkas panduan tidak valid atau belum diunggah.');
        }

        $safeFilename = basename($diskFileName);
        $storagePath = Storage::disk('public')->path('panduan/' . $safeFilename);
        $legacyPath = public_path('uplouds' . DIRECTORY_SEPARATOR . $safeFilename);

        if (Storage::disk('public')->exists('panduan/' . $safeFilename) && is_file($storagePath)) {
            $filePath = $storagePath;
        } elseif (file_exists($legacyPath) && is_file($legacyPath)) {
            $filePath = $legacyPath;
        } else {
            // Cek generated_name jika ada perbedaan nama
            $fallbackGen = basename($panduan->generated_name);
            $storageGen = Storage::disk('public')->path('panduan/' . $fallbackGen);
            $legacyGen = public_path('uplouds' . DIRECTORY_SEPARATOR . $fallbackGen);
            if ($fallbackGen && Storage::disk('public')->exists('panduan/' . $fallbackGen) && is_file($storageGen)) {
                $filePath = $storageGen;
            } elseif ($fallbackGen && file_exists($legacyGen) && is_file($legacyGen)) {
                $filePath = $legacyGen;
            } else {
                Log::warning("File panduan ID {$id} tidak ditemukan di server: " . $safeFilename);
                return redirect()->back()->with('error', 'Berkas panduan tidak ditemukan di server atau telah dipindahkan.');
            }
        }

        // Tentukan nama unduhan yang rapi dan aman bagi pengguna
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $rawTitle = trim(preg_replace('#[/\\\\?%*:|"<>]+#', '_', $panduan->namefile ?: 'Panduan_P3M'));
        if ($extension && !str_ends_with(strtolower($rawTitle), '.' . strtolower($extension))) {
            $downloadName = $rawTitle . '.' . $extension;
        } else {
            $downloadName = $rawTitle;
        }

        Log::info("File panduan ID {$id} siap diunduh: {$downloadName}");
        return response()->download($filePath, $downloadName);
    }

    public function view($id)
    {
        $user = Auth::user();
        $pagetitle = 'Panduan';
        $panduan = m_panduan::findOrFail($id);

        // Path ke file PDF
        // $filePath = storage_path('uplouds/' . $panduan->generated_name);

        // // Pastikan file ada
        // if (!file_exists($filePath)) {
        //     return redirect()->back()->with('error', 'File tidak ditemukan.');
        // }

        // Mengembalikan tampilan dengan data PDF
        return view('panduan.view', compact('panduan', 'user', 'pagetitle'));
    }

    //DELETE DATA (Dengan pembersihan berkas fisik untuk mencegah orphaned files)
    public function delete($id)
    {
        $panduan = m_panduan::findOrFail($id);
        $files = array_filter(array_unique([
            basename($panduan->original_name),
            basename($panduan->generated_name)
        ]));

        foreach ($files as $f) {
            if (Storage::disk('public')->exists('panduan/' . $f)) {
                Storage::disk('public')->delete('panduan/' . $f);
            }
            $legacyPath = public_path('uplouds/' . $f);
            if (file_exists($legacyPath) && is_file($legacyPath)) {
                @unlink($legacyPath);
            }
        }

        $panduan->delete();
        return redirect()->route('panduan.index')->with('success', 'Panduan berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $panduan = m_panduan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'namefile'      => 'required',
            'original_name' => 'nullable|mimes:docx,pdf|max:5120',
        ], [
            'namefile.required' => 'Nama file/judul panduan wajib diisi.',
            'original_name.mimes' => 'Format file harus berupa PDF atau DOCX.',
            'original_name.max' => 'Ukuran file dokumen panduan maksimal adalah 5 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'edit_panduan_' . $id);
        }

        $panduan->namefile = $request->namefile;

        if ($request->hasFile('original_name')) {
            $oldFiles = array_filter(array_unique([
                basename($panduan->original_name),
                basename($panduan->generated_name)
            ]));

            foreach ($oldFiles as $f) {
                if (Storage::disk('public')->exists('panduan/' . $f)) {
                    Storage::disk('public')->delete('panduan/' . $f);
                }
                $oldLegacy = public_path('uplouds/' . $f);
                if (file_exists($oldLegacy) && is_file($oldLegacy)) {
                    @unlink($oldLegacy);
                }
            }

            $docs = $request->file('original_name');
            // SEC-FILE-01: Use server-detected extension instead of client-supplied
            $nama_docs = date('YmdHis') . '_' . uniqid() . '.' . ($docs->guessExtension() ?: 'bin');
            Storage::disk('public')->putFileAs('panduan', $docs, $nama_docs);

            $panduan->original_name = $nama_docs;
            $panduan->generated_name = $nama_docs;
        }

        $panduan->save();

        return redirect()->route('panduan.index')->with('success', 'Panduan berhasil diperbarui!');
    }
}
