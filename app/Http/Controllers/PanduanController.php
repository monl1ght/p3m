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
            'original_name' => 'required|mimes:docx,pdf|max:2048',
            'namefile' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        $docs = $request->file('original_name');
        $nama_docs = date('Ymdhis') . '.' . $request->file('original_name')->getClientOriginalExtension();
        $docs->move(public_path('uplouds'), $nama_docs);

        $data = new m_panduan();
        $data->namefile = $request->namefile;
        $data->original_name = $nama_docs;
        $data->generated_name = $nama_docs;
        $data->save();
        return redirect()->route('panduan.index');
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
        // Temukan file berdasarkan ID
        Log::info("Download attempt for ID: " . $id);
        $panduan = m_panduan::findOrFail($id);

        // Tentukan path file yang akan diunduh
        $filePath = public_path('uplouds/' . $panduan->generated_name); // Sesuaikan dengan lokasi penyimpanan file Anda
        // dd($filePath);
        Log::info("File path: " . $filePath);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan: ' . $filePath);
        }
        Log::info("File found, preparing to download.");
        return response()->download($filePath, $panduan->original_name);
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

    //DELETE DATA
    public function delete($id)
    {
        $panduan = m_panduan::findOrFail($id);
        $panduan->delete();
        return redirect()->route('panduan.index');
    }
}
