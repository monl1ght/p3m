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
        $validator = Validator::make($request->all(), [
            'jurnalname' => 'required',
            'link' => 'required',
        ]);
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data = new JurnalModel();
        $data['jurnalname']      = $request->jurnalname;
        $data['link']       = $request->link;
        // $data->generated_name = $nama_docs;
        $data->save();
        return redirect()->route('jurnal.index');
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
        $find = JurnalModel::find($id);
        $validator = Validator::make($request->all(), [
            'jurnalname' => 'required',
            'link' => 'required',
        ]);
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['jurnalname']      = $request->jurnalname;
        $data['link']       = $request->link;

        $find->update($data);
        return redirect()->route('jurnal.index');
    }

    //DELETE DATA
    public function delete($id)
    {
        $panduan = JurnalModel::findOrFail($id);
        $panduan->delete();
        return redirect()->route('jurnal.index');
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
