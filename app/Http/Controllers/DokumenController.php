<?php

namespace App\Http\Controllers;

use App\Models\DokumenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            'originalname' => 'required|mimes:docx,pdf|max:2048',
            'namefile' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        $docs = $request->file('originalname');
        $nama_docs = date('Ymdhis') . '.' . $request->file('originalname')->getClientOriginalExtension();
        $docs->move(public_path('uploud'), $nama_docs);

        $data = new DokumenModel();
        $data->namefile = $request->namefile;
        $data->originalname = $nama_docs;
        // $data->generated_name = $nama_docs;
        $data->save();
        return redirect()->route('dokumen.index');
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
        // Temukan file berdasarkan  ID
        Log::info("Download attempt for ID: " . $id);
        $dokumen = DokumenModel::findOrFail($id);

        // Tentukan path file yang akan diunduh
        $filePath = public_path('uploud/' . $dokumen->originalname); // Sesuaikan dengan lokasi penyimpanan file Anda
        // dd($filePath);
        Log::info("File path: " . $filePath);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan: ' . $filePath);
        }
        Log::info("File found, preparing to download.");
        return response()->download($filePath, $dokumen->originalname);
    }

    public function view($id)
    {
        $user = Auth::user();
        $pagetitle = 'Panduan';
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
