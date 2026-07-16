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
        // dd('masuk gak?');
        // $data = new M_news();
        $pagetitle = 'Seputar Kegiatan P3M Polibang';
        $user = Auth::user();

        $query = M_news::where(function ($q) {
            $q->where('user_id', Auth::id())
                ->orWhereNull('user_id');
        });
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('news.index', compact('pagetitle', 'data', 'user'));
        // $data = M_news::where('user_id', Auth::id())
        //     ->orWhereNull('user_id')
        //     ->orderBy('created_at', 'desc')
        //     ->get();
        // if ($request->get('search')) {
        //     $data = M_news::where('title', 'like', '%' . $request->get('search') . '%');
        // }

        // // $data = new M_news();
        // $user = Auth::user();
        // $news = M_news::where('user_id', Auth::id())
        //     ->orWhereNull('user_id')
        //     ->orderBy('created_at', 'desc')
        //     ->get();
        // // if ($request->get('search')) {
        // //     $data = M_news::where('title', 'like', '%' . $request->get('search') . '%');
        // // }
        // $pagetitle = 'Berita Terkini';
        // // $data = $data->get();
        // return view('news.index', compact('news', 'pagetitle', 'user'));
    }

    public function search(Request $request)
    {
        dd('masuk');
        $search = $request->search;
        $pagetitle = 'Berita Terkini';
        $user = Auth::user();

        $news = M_news::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        })
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->get();
        return view('news.index', compact('news', 'search', 'pagetitle', 'user'));
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
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
            'category_id' => 'required', // add this
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // dd($request->all());

        $image = $request->file('image');
        $filename = date('d-m-Y') . $image->getClientOriginalName();
        $path = 'photo-news/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($image));

        $htmlContent = $request->input('content');

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
                    $path = 'photo-news/' . $filename;

                    // Simpan gambar ke storage
                    Storage::disk('public')->put($path, $data);

                    // Ganti src dengan path yang baru
                    $img->setAttribute('src', Storage::url($path));
                }
            }
        }


        // $user = auth()->user();
        $data = [];
        $data['title']       = $request->title;
        $data['content']     = $dom->saveHTML();
        $data['category_id'] = $request->category_id;
        $data['image']       = $filename;
        $data['date']        = date('Y-m-d', strtotime($request->date));
        $data['user_id']     = Auth::user()->id;
        $user = Auth::user();

        M_news::create($data);

        return redirect()->route('news.index');
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
        $find = M_news::find($id);
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'title' => 'required',
            'content' => 'required',
            'date' => 'required',
            'category_id' => 'required', // add this
        ]);
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

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

                    list($type, $data) = explode(';', $src);
                    list(, $data) = explode(',', $data);
                    $data = base64_decode($data);

                    // Dapatkan ekstensi gambar
                    $extension = explode('/', $type)[1];
                    $filename = date('d-m-Y-H-i-s') . '-' . uniqid() . '.' . $extension;
                    $path = 'photo-agenda/' . $filename;

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
                    $path = 'photo-agenda/' . $filename;

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
            $filename = date('d-m-Y') . $image->getClientOriginalName();
            $path = 'photo-news/' . $filename;
            if ($find->image) {
                Storage::disk('public')->delete('photo-news/' . $find->image);
            }
            Storage::disk('public')->put($path, file_get_contents($image));
            $data['image'] = $filename;
        }

        $find->update($data);
        return redirect()->route('news.index');
    }

    public function delete(Request $request, $id)
    {
        $agenda = M_news::find($id);
        if ($agenda) {
            // Misalkan kolom 'keterangan' menyimpan HTML yang berisi gambar
            $htmlContent = $agenda->content;

            // Memuat HTML untuk memproses gambar
            $dom = new \DOMDocument();
            @$dom->loadHTML($htmlContent);
            $images = $dom->getElementsByTagName('img');

            // Hapus gambar dari server
            // foreach ($images as $img) {
            //     if ($img instanceof \DOMElement) {
            //         $src = $img->getAttribute('src');

            //         // Ambil nama file dari URL
            //         $filename = basename($src);
            //         $path = public_path('photo-news/' . $filename);

            //         // Hapus gambar dari server jika ada
            //         if (file_exists($path)) {
            //             unlink($path);
            //         }
            //     }
            // }

            foreach ($images as $img) {
                if ($img instanceof \DOMElement) {
                    $src = $img->getAttribute('src');

                    // Ambil nama file dari URL
                    $filename = basename($src);
                    $path = public_path('photo-news/' . $filename);
                    dd($path);
                    // Debugging
                    echo "Trying to delete: " . $path . "<br>";

                    if (file_exists($path)) {
                        if (unlink($path)) {
                            echo "Successfully deleted: " . $filename . "<br>";
                        } else {
                            echo "Failed to delete: " . $filename . "<br>";
                        }
                    } else {
                        echo "File not found: " . $filename . "<br>";
                    }
                }
            }


            // Menghapus data dari database
            $agenda->delete();
        }
        return redirect()->route('news.index')->with('success', 'Data berhasil dihapus!');
    }
    public function read(Request $request, $id)
    {
        $user = Auth::user();
        $data = M_news::find($id);
        $categories = M_categories::all();
        $pagetitle = 'Detail Data Berita';
        return view('news.read', compact('data', 'categories', 'pagetitle', 'user'));
    }
}
