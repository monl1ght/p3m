<?php

namespace App\Http\Controllers;

use App\Models\M_tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TentangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bout = M_tentang::all();
        $pagetitle = 'Tentang P3M';
        return view('tentang.index', compact('bout', 'pagetitle', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $ten = M_tentang::all();
        $pagetitle = 'Sekilas P3M';
        return view('tentang.create', compact('ten', 'pagetitle', 'user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visi' => 'required',
            'misi' => 'required',
            'ourbout' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $htmlContent = $request->input('ourbout');

        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            if ($img instanceof \DOMElement) {
                $src = $img->getAttribute('src'); // Mengambil atribut src

                // Cek jika src adalah base64
                if (strpos($src, 'data:image') === 0) {
                    list($type, $data) = explode(';', $src);
                    list(, $data) = explode(',', $data);
                    $data = base64_decode($data);

                    // Dapatkan ekstensi gambar
                    $extension = explode('/', $type)[1];
                    $filename = date('d-m-Y-H-i-s') . '-' . uniqid() . '.' . $extension;
                    $path = 'photo-tentang/' . $filename;

                    // Simpan gambar ke storage
                    Storage::disk('public')->put($path, $data);

                    // Ganti src dengan path yang baru
                    $img->setAttribute('src', Storage::url($path));
                }
            }
        }
        // $user = auth()->user();
        // $data = [];
        $data['visi']       = $request->visi;
        $data['misi']       = $request->misi;
        $data['ourbout']       = $dom->saveHTML();
        // $user = Auth::user();

        M_tentang::create($data);

        return redirect()->route('tentang.index');
    }
    public function edit($id)
    {
        $user = Auth::user();
        $ten = M_tentang::findOrFail($id);
        $pagetitle = 'Sekilas P3M';
        return view('tentang.edit', compact('ten', 'pagetitle', 'user'));
    }

    public function update(Request $request, $id)
    {
        $find = M_tentang::find($id);
        $validator = Validator::make($request->all(), [
            'visi' => 'required',
            'misi' => 'required',
            'ourbout' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // Mengambil konten dari textarea
        $htmlContent = $request->input('ourbout');

        // Memuat HTML untuk memproses gambar
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $images = $dom->getElementsByTagName('img');

        // Hapus gambar yang ada di dalam konten HTML sebelumnya
        $previousDom = new \DOMDocument();
        @$previousDom->loadHTML($find->ourbout);
        $previousImages = $previousDom->getElementsByTagName('img');

        // Cek apakah ada gambar baru
        $hasNewImages = false;

        // Proses gambar baru dari textarea
        foreach ($images as $img) {
            if ($img instanceof \DOMElement) {
                $src = $img->getAttribute('src');

                // Cek jika src adalah base64
                if (strpos($src, 'data:image') === 0) {
                    $hasNewImages = true; // Menandai bahwa ada gambar baru

                    list($type, $data) = explode(';', $src);
                    list(, $data) = explode(',', $data);
                    $data = base64_decode($data);

                    // Dapatkan ekstensi gambar
                    $extension = explode('/', $type)[1];
                    $filename = date('d-m-Y-H-i-s') . '-' . uniqid() . '.' . $extension;
                    $path = 'photo-tentang/' . $filename;

                    // Simpan gambar ke storage
                    Storage::disk('public')->put($path, $data);

                    // Ganti src dengan path yang baru
                    $img->setAttribute('src', Storage::url($path));
                }
            }
        }

        // Hapus gambar yang ada di storage jika ada gambar baru
        if ($hasNewImages) {
            foreach ($previousImages as $img) {
                if ($img instanceof \DOMElement) {
                    $src = $img->getAttribute('src');

                    // Ambil nama file dari URL
                    $filename = basename($src);
                    $path = 'photo-tentang/' . $filename;

                    // Hapus gambar dari storage jika ada
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }
        // $user = auth()->user();
        $data = [];
        $data['visi']       = $request->visi;
        $data['misi']       = $request->misi;
        $data['ourbout']       = $dom->saveHTML();
        // $user = Auth::user();

        $find->update($data);

        return redirect()->route('tentang.index');
    }
}
