<?php

namespace App\Http\Controllers;

use App\Models\M_tentang;
use App\Services\ImageService;
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
        $imageService = app(ImageService::class);

        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $images = $dom->getElementsByTagName('img');

        // Collect nodes to process (DOMNodeList is live, cannot modify during iteration)
        $toProcess = [];
        foreach ($images as $img) {
            if ($img instanceof \DOMElement) {
                $toProcess[] = $img;
            }
        }

        foreach ($toProcess as $img) {
            $src = $img->getAttribute('src');

            // SEC-XSS-02: Validate and re-encode base64 images through ImageService
            if (strpos($src, 'data:image') === 0) {
                $filename = $imageService->processBase64InlineImage($src, 'photo-tentang');
                if ($filename) {
                    $img->setAttribute('src', Storage::url('photo-tentang/' . $filename));
                } else {
                    // Malicious/invalid payload — remove the image node
                    $img->parentNode->removeChild($img);
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

        return redirect()->route('tentang.index')->with('success', 'Data Tentang P3M berhasil ditambahkan!');
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
        $find = M_tentang::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'visi' => 'required',
            'misi' => 'required',
            'ourbout' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // Mengambil konten dari textarea
        $htmlContent = $request->input('ourbout');
        $imageService = app(ImageService::class);

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

        // Collect nodes to process (DOMNodeList is live)
        $toProcess = [];
        foreach ($images as $img) {
            if ($img instanceof \DOMElement) {
                $toProcess[] = $img;
            }
        }

        // SEC-XSS-02: Validate and re-encode base64 images through ImageService
        foreach ($toProcess as $img) {
            $src = $img->getAttribute('src');

            if (strpos($src, 'data:image') === 0) {
                $hasNewImages = true;

                $filename = $imageService->processBase64InlineImage($src, 'photo-tentang');
                if ($filename) {
                    $img->setAttribute('src', Storage::url('photo-tentang/' . $filename));
                } else {
                    // Malicious/invalid payload — remove the image node
                    $img->parentNode->removeChild($img);
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

        return redirect()->route('tentang.index')->with('success', 'Data Tentang P3M berhasil diperbarui!');
    }
}
