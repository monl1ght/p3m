<?php

namespace App\Http\Controllers;

use App\Models\AgendaModel;
use App\Models\User;
use App\Services\HtmlSanitizer;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $pagetitle = 'Berita Kegiatan Terbaru';
        $user = Auth::user();
        // $data = AgendaModel::all();
        // if ($request->get('search')) {
        //     $data = AgendaModel::where('title', 'like', '%' . $request->get('search') . '%');
        // }
        $query = AgendaModel::query();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('keterangan', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('agenda.index', compact('pagetitle', 'data', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $pagetitle = 'Agenda Terbaru';
        return view('agenda.create', compact('user', 'pagetitle'));
    }
    public function store(Request $request)
    {
        $pagetitle = 'Tambah Kegiatan P3M';
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'keterangan' => 'required',
            'lokasi' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $htmlContent = $request->input('keterangan');
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
                $filename = $imageService->processBase64InlineImage($src, 'photo-agenda');
                if ($filename) {
                    $img->setAttribute('src', Storage::url('photo-agenda/' . $filename));
                } else {
                    // Malicious/invalid payload — remove the image node
                    $img->parentNode->removeChild($img);
                }
            }
        }
        $data['title']       = $request->title;
        $data['date']       = $request->date;
        $data['time']       = $request->time;
        $data['lokasi']       = $request->lokasi;
        $data['keterangan']   = app(HtmlSanitizer::class)->sanitize($dom->saveHTML());

        AgendaModel::create($data);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $agenda = AgendaModel::findOrFail($id);
        $pagetitle = 'Sekilas P3M';
        return view('agenda.edit', compact('agenda', 'pagetitle', 'user'));
    }

    public function update(Request $request, $id)
    {
        $find = AgendaModel::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'keterangan' => 'required',
            'lokasi' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // Mengambil konten dari textarea
        $htmlContent = $request->input('keterangan');
        $imageService = app(ImageService::class);

        // Memuat HTML untuk memproses gambar
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $images = $dom->getElementsByTagName('img');

        // Hapus gambar yang ada di dalam konten HTML sebelumnya
        $previousDom = new \DOMDocument();
        @$previousDom->loadHTML($find->keterangan);
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

                $filename = $imageService->processBase64InlineImage($src, 'photo-agenda');
                if ($filename) {
                    $img->setAttribute('src', Storage::url('photo-agenda/' . $filename));
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
                    $path = 'photo-agenda/' . $filename;

                    // Hapus gambar dari storage jika ada
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }
        // $user = auth()->user();
        $data = [];
        $data['title']       = $request->title;
        $data['date']       = $request->date;
        $data['time']       = $request->time;
        $data['lokasi']       = $request->lokasi;
        $data['keterangan']   = app(HtmlSanitizer::class)->sanitize($dom->saveHTML());

        $find->update($data);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui!');
    }
    public function delete(Request $request, $id)
    {
        $agenda = AgendaModel::find($id);
        if ($agenda) {
            // Misalkan kolom 'keterangan' menyimpan HTML yang berisi gambar
            $htmlContent = $agenda->keterangan;

            // Memuat HTML untuk memproses gambar
            $dom = new \DOMDocument();
            @$dom->loadHTML($htmlContent);
            $images = $dom->getElementsByTagName('img');

            // Hapus gambar dari server
            foreach ($images as $img) {
                if ($img instanceof \DOMElement) {
                    $src = $img->getAttribute('src');

                    // Ambil nama file dari URL
                    $filename = basename($src);
                    $path = 'photo-agenda/' . $filename;

                    // Hapus gambar dari storage disk public jika ada
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }

                    // Fallback untuk legacy file di public_path
                    $legacyPath = public_path('photo-agenda/' . $filename);
                    if (file_exists($legacyPath)) {
                        @unlink($legacyPath);
                    }
                }
            }

            // Menghapus data dari database
            $agenda->delete();
        }
        return redirect()->route('agenda.index')->with('success', 'Data berhasil dihapus!');
    }

    public function read(Request $request, $id)
    {
        $user = Auth::user();
        $data = AgendaModel::findOrFail($id);
        // $categories = M_categories::all();
        $pagetitle = 'Detail Data Kegiatan';
        return view('agenda.read', compact('data', 'pagetitle', 'user'));
    }
}
