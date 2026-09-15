<?php

namespace App\Http\Controllers;

use App\Models\JurnalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class JurnalController extends Controller
{
    //
    public function index(Request $request)
    {
        // $data = new M_news();
        $user = Auth::user();
        $jurnal = JurnalModel::get();
        // if ($request->get('search')) {
        //     $data = M_news::where('title', 'like', '%' . $request->get('search') . '%');
        // }
        $pagetitle = 'Jurnal P3M';
        // $data = $data->get();
        return view('jurnal.index', compact('jurnal', 'pagetitle', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        // $panduan = m_panduan::all();
        $pagetitle = 'Jurnal P3M';
        return view('jurnal.create', compact('pagetitle', 'user'));
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
        $link = trim($request->input('link', ''));
        if ($link !== '' && !preg_match("~^(?:f|ht)tps?://~i", $link)) {
            if (preg_match("~^([a-z0-9-]+\.)+[a-z]{2,}~i", $link) || str_starts_with(strtolower($link), 'localhost')) {
                $link = 'https://' . $link;
                $request->merge(['link' => $link]);
            }
        }

        $validator = Validator::make($request->all(), [
            'jurnalname' => 'required|string|max:255',
            'link'       => 'required|url|max:500',
        ], [
            'jurnalname.required' => 'Judul jurnal wajib diisi.',
            'jurnalname.string'   => 'Judul jurnal harus berupa teks.',
            'jurnalname.max'      => 'Judul jurnal maksimal 255 karakter.',
            'link.required'       => 'Tautan jurnal wajib diisi.',
            'link.url'            => 'Format tautan jurnal harus berupa URL yang valid (contoh: https://...).',
            'link.max'            => 'Tautan jurnal maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'create_jurnal')
                ->with('error', $validator->errors()->first());
        }

        JurnalModel::create([
            'jurnalname' => $request->jurnalname,
            'link'       => $link,
        ]);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $jurnal = JurnalModel::findOrFail($id);
        $pagetitle = 'Edit Jurnal P3M';
        return view('jurnal.edit', compact('jurnal', 'pagetitle', 'user'));
    }

    public function update(Request $request,  $id)
    {
        $find = JurnalModel::findOrFail($id);

        $link = trim($request->input('link', ''));
        if ($link !== '' && !preg_match("~^(?:f|ht)tps?://~i", $link)) {
            if (preg_match("~^([a-z0-9-]+\.)+[a-z]{2,}~i", $link) || str_starts_with(strtolower($link), 'localhost')) {
                $link = 'https://' . $link;
                $request->merge(['link' => $link]);
            }
        }

        $validator = Validator::make($request->all(), [
            'jurnalname' => 'required|string|max:255',
            'link'       => 'required|url|max:500',
        ], [
            'jurnalname.required' => 'Judul jurnal wajib diisi.',
            'jurnalname.string'   => 'Judul jurnal harus berupa teks.',
            'jurnalname.max'      => 'Judul jurnal maksimal 255 karakter.',
            'link.required'       => 'Tautan jurnal wajib diisi.',
            'link.url'            => 'Format tautan jurnal harus berupa URL yang valid (contoh: https://...).',
            'link.max'            => 'Tautan jurnal maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'edit_jurnal_' . $id)
                ->with('error', $validator->errors()->first());
        }

        $find->update([
            'jurnalname' => $request->jurnalname,
            'link'       => $link,
        ]);

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui!');
    }

    //DELETE DATA
    public function delete($id)
    {
        $jurnal = JurnalModel::findOrFail($id);
        $jurnal->delete();
        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil dihapus!');
    }


    // public function show($id)
    // {
    //     $user = Auth::user();
    //     $pagetitle = 'Panduan';
    //     $dokum = DokumenModel::findOrFail($id);

    //     // Path ke file PDF
    //     // $filePath = storage_path('uplouds/' . $panduan->generated_name);

    //     // // Pastikan file ada
    //     // if (!file_exists($filePath)) {
    //     //     return redirect()->back()->with('error', 'File tidak ditemukan.');
    //     // }

    //     // Mengembalikan tampilan dengan data PDF
    //     return view('dokumen.view', compact('dokum', 'user', 'pagetitle'));
    // }
}
