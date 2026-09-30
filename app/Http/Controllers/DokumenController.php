<?php

namespace App\Http\Controllers;

use App\Models\DokumenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        // $data = new M_news();
        $user = Auth::user();
        $doks = DokumenModel::get();
        // if ($request->get('search')) {
        //     $data = M_news::where('title', 'like', '%' . $request->get('search') . '%');
        // }
        $pagetitle = 'Dokumen P3M';
        // $data = $data->get();
        return view('dokumen.index', compact('doks', 'pagetitle', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        // $panduan = m_panduan::all();
        $pagetitle = 'Dokumen P3M';
        return view('dokumen.create', compact('pagetitle', 'user'));
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
            'originalname' => 'required|mimes:docx,pdf|max:5120',
            'namefile' => 'required',
        ], [
            'originalname.required' => 'File dokumen wajib diunggah.',
            'originalname.mimes' => 'Format file harus berupa PDF atau DOCX.',
            'originalname.max' => 'Ukuran file dokumen maksimal adalah 5 MB.',
            'namefile.required' => 'Nama file dokumen wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'create_dokumen');
        }

        $docs = $request->file('originalname');
        // SEC-FILE-01: Use server-detected extension instead of client-supplied
        $nama_docs = date('YmdHis') . '_' . uniqid() . '.' . ($docs->guessExtension() ?: 'bin');
        // Simpan berkas ke storage disk publik pada subdirektori dokumen
        Storage::disk('public')->putFileAs('dokumen', $docs, $nama_docs);

        $data = new DokumenModel();
        $data->namefile = $request->namefile;
        $data->originalname = $nama_docs;
        $data->save();

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $dokumen = DokumenModel::findOrFail($id);
        $pagetitle = 'Edit Dokumen';
        return view('dokumen.edit', compact('dokumen', 'pagetitle', 'user'));
    }

    public function update(Request $request, $id)
    {
        $dokumen = DokumenModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'namefile' => 'required',
            'originalname' => 'nullable|mimes:docx,pdf|max:5120',
        ], [
            'namefile.required' => 'Nama file dokumen wajib diisi.',
            'originalname.mimes' => 'Format file harus berupa PDF atau DOCX.',
            'originalname.max' => 'Ukuran file dokumen maksimal adalah 5 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'edit_dokumen_' . $id);
        }

        $dokumen->namefile = $request->namefile;

        if ($request->hasFile('originalname')) {
            // Bersihkan file lama dari storage disk dan legacy public path
            $oldFile = basename($dokumen->originalname);
            if ($oldFile) {
                if (Storage::disk('public')->exists('dokumen/' . $oldFile)) {
                    Storage::disk('public')->delete('dokumen/' . $oldFile);
                }
                $legacyOld = public_path('uploud' . DIRECTORY_SEPARATOR . $oldFile);
                if (file_exists($legacyOld) && is_file($legacyOld)) {
                    @unlink($legacyOld);
                }
            }

            $docs = $request->file('originalname');
            // SEC-FILE-01: Use server-detected extension instead of client-supplied
            $nama_docs = date('YmdHis') . '_' . uniqid() . '.' . ($docs->guessExtension() ?: 'bin');
            Storage::disk('public')->putFileAs('dokumen', $docs, $nama_docs);
            $dokumen->originalname = $nama_docs;
        }

        $dokumen->save();

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    public function delete($id)
    {
        $dokumen = DokumenModel::findOrFail($id);
        $file = basename($dokumen->originalname);
        if ($file) {
            // Hapus dari storage disk publik
            if (Storage::disk('public')->exists('dokumen/' . $file)) {
                Storage::disk('public')->delete('dokumen/' . $file);
            }
            // Bersihkan juga jika masih tertinggal di folder legacy
            $legacyPath = public_path('uploud' . DIRECTORY_SEPARATOR . $file);
            if (file_exists($legacyPath) && is_file($legacyPath)) {
                @unlink($legacyPath);
            }
        }

        $dokumen->delete();
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus!');
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
        Log::info("Download attempt for dokumen ID: " . $id);
        $dokumen = DokumenModel::findOrFail($id);

        $safeFilename = basename($dokumen->originalname);
        if (!$safeFilename) {
            Log::warning("Data dokumen ID {$id} tidak memiliki file valid.");
            return redirect()->back()->with('error', 'Berkas dokumen tidak valid atau belum diunggah.');
        }

        // Resolusi bertingkat: prioritas storage disk public/dokumen, fallback ke legacy public/uploud
        $storagePath = Storage::disk('public')->path('dokumen/' . $safeFilename);
        $legacyPath = public_path('uploud' . DIRECTORY_SEPARATOR . $safeFilename);

        if (Storage::disk('public')->exists('dokumen/' . $safeFilename) && is_file($storagePath)) {
            $filePath = $storagePath;
        } elseif (file_exists($legacyPath) && is_file($legacyPath)) {
            $filePath = $legacyPath;
        } else {
            Log::warning("File dokumen ID {$id} tidak ditemukan di server: " . $safeFilename);
            return redirect()->back()->with('error', 'Berkas dokumen tidak ditemukan di server atau telah dipindahkan.');
        }

        // Format nama download yang ramah dan aman bagi pengguna
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $rawTitle = trim(preg_replace('#[/\\\\?%*:|"<>]+#', '_', $dokumen->namefile ?: 'Dokumen_P3M'));
        if ($extension && !str_ends_with(strtolower($rawTitle), '.' . strtolower($extension))) {
            $downloadName = $rawTitle . '.' . $extension;
        } else {
            $downloadName = $rawTitle;
        }

        Log::info("File dokumen ID {$id} siap diunduh: {$downloadName}");
        return response()->download($filePath, $downloadName);
    }

    public function view($id)
    {
        $user = Auth::user();
        $pagetitle = 'Dokumen P3M';
        $dokum = DokumenModel::findOrFail($id);

        // Path ke file PDF
        // $filePath = storage_path('uplouds/' . $panduan->generated_name);

        // // Pastikan file ada
        // if (!file_exists($filePath)) {
        //     return redirect()->back()->with('error', 'File tidak ditemukan.');
        // }

        // Mengembalikan tampilan dengan data PDF
        return view('dokumen.view', compact('dokum', 'user', 'pagetitle'));
    }
}
