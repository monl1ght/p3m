<?php

namespace App\Http\Controllers;

use App\Models\M_categories;
use App\Models\M_news;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\HtmlSanitizer;
use DOMDocument;

class NewsController extends Controller
{
    // public function pagetitle()
    // {
    //     $pagetitle = 'Berita Terkini';
    //     return view('berita_terkini', compact('pagetitle'));
    // }

    public function index(Request $request)
    {
        $pagetitle = 'Seputar Kegiatan P3M Polibang';
        $user = Auth::user();

        $query = M_news::with(['category', 'user'])->where(function ($q) {
            $q->where('user_id', Auth::id())
                ->orWhereNull('user_id');
        });

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();
        $news = $data;

        return view('news.index', compact('pagetitle', 'data', 'news', 'user'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $pagetitle = 'Seputar Kegiatan P3M Polibang';
        $user = Auth::user();

        $query = M_news::with(['category', 'user']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($catQuery) use ($search) {
                        $catQuery->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $news = $query->orderBy('created_at', 'desc')->get();
        $data = $news;

        return view('news.index', compact('news', 'data', 'search', 'pagetitle', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $categories = M_categories::all();
        $pagetitle = 'Tambah Data Berita';
        return view('news.create', compact('categories', 'pagetitle', 'user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
            'category_id' => 'required',
        ], [
            'image.required' => 'Gambar kegiatan wajib diunggah.',
            'image.mimes' => 'Format gambar harus berupa PNG, JPG, JPEG, WEBP, atau GIF.',
            'image.max' => 'Ukuran gambar maksimal adalah 5 MB.',
            'title.required' => 'Judul kegiatan wajib diisi.',
            'content.required' => 'Isi kegiatan wajib diisi.',
            'date.required' => 'Tanggal kegiatan wajib diisi.',
            'category_id.required' => 'Kategori kegiatan wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', $validator->errors()->first());
        }

        // dd($request->all());

        $image = $request->file('image');
        $imageService = app(\App\Services\ImageService::class);
        $coverFilename = $imageService->processAndStore($image, 'photo-news');

        $htmlContent = $request->input('content');

        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            if ($img instanceof \DOMElement) {
                $src = $img->getAttribute('src'); // Mengambil atribut src

                // Cek jika src adalah base64
                if (strpos($src, 'data:image') === 0) {
                    $imageService = app(\App\Services\ImageService::class);
                    $filename = $imageService->storeBase64($src, 'photo-news');
                    $path = 'photo-news/' . $filename;
                    
                    // Ganti src dengan path yang baru
                    $img->setAttribute('src', Storage::url($path));
                }
            }
        }


        // $user = auth()->user();
        $data = [];
        $data['title']       = $request->title;
        $data['content']     = app(HtmlSanitizer::class)->sanitize($dom->saveHTML());
        $data['category_id'] = $request->category_id;
        $data['image']       = $coverFilename;
        $data['date']        = date('Y-m-d', strtotime($request->date));
        $data['user_id']     = Auth::user()->id;
        $user = Auth::user();

        M_news::create($data);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $news = M_news::findOrFail($id);
        $categories = M_categories::all();
        $pagetitle = 'Edit Data Berita';
        return view('news.edit', compact('news', 'categories', 'pagetitle', 'user'));
    }

    public function update(Request $request,  $id)
    {
        $find = M_news::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
            'category_id' => 'required',
        ], [
            'image.mimes' => 'Format gambar harus berupa PNG, JPG, JPEG, WEBP, atau GIF.',
            'image.max' => 'Ukuran gambar maksimal adalah 5 MB.',
            'title.required' => 'Judul kegiatan wajib diisi.',
            'content.required' => 'Isi kegiatan wajib diisi.',
            'date.required' => 'Tanggal kegiatan wajib diisi.',
            'category_id.required' => 'Kategori kegiatan wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', $validator->errors()->first());
        }

        $data['title'] = $request->title;
        $data['content'] = $request->input('content');
        $data['category_id'] = $request->category_id;
        $data['date']        = date('Y-m-d', strtotime($request->date));
        $data['user_id']     = Auth::user()->id;

        // Mengambil konten dari textarea
        $htmlContent = $request->input('content');

        // mengambil HTML untuk memproses gambar
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $images = $dom->getElementsByTagName('img');

        // Hapus gambar yang ada di dalam konten HTML sebelumnya
        $previousDom = new \DOMDocument();
        @$previousDom->loadHTML($find->content);
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

                    $imageService = app(\App\Services\ImageService::class);
                    $filename = $imageService->storeBase64($src, 'photo-news');
                    $path = 'photo-news/' . $filename;
                    
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
                    $path = 'photo-news/' . $filename;

                    // Hapus gambar dari storage jika ada
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }

        //menghapus gambar inputan
        $image = $request->file('image');
        if ($image) {
            $imageService = app(\App\Services\ImageService::class);
            $filename = $imageService->processAndStore($image, 'photo-news');
            
            if ($find->image) {
                Storage::disk('public')->delete('photo-news/' . $find->image);
            }
            $data['image'] = $filename;
        }

        $data['content'] = app(HtmlSanitizer::class)->sanitize($dom->saveHTML());
        $find->update($data);
        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function delete(Request $request, $id)
    {
        $news = M_news::find($id);

        if ($news) {
            $dom = new \DOMDocument();
            @$dom->loadHTML($news->content);

            foreach ($dom->getElementsByTagName('img') as $img) {
                $path = parse_url($img->getAttribute('src'), PHP_URL_PATH);

                if (is_string($path) && str_starts_with($path, '/storage/photo-news/')) {
                    Storage::disk('public')->delete('photo-news/' . basename($path));
                }
            }

            if ($news->image) {
                Storage::disk('public')->delete('photo-news/' . $news->image);
            }

            $news->delete();
        }

        return redirect()->route('news.index')->with('success', 'Data berhasil dihapus!');
    }
    public function read(Request $request, $id)
    {
        $user = Auth::user();
        $data = M_news::findOrFail($id);
        $categories = M_categories::all();
        $pagetitle = 'Detail Data Berita';
        return view('news.read', compact('data', 'categories', 'pagetitle', 'user'));
    }
}
