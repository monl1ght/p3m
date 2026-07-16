<?php

namespace App\Http\Controllers;

use App\Models\AgendaModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
                    $path = 'photo-agenda/' . $filename;

                    // Simpan gambar ke storage
                    Storage::disk('public')->put($path, $data);

                    // Ganti src dengan path yang baru
                    $img->setAttribute('src', Storage::url($path));
                }
            }
        }
        $data['title']       = $request->title;
        $data['date']       = $request->date;
        $data['time']       = $request->time;
        $data['lokasi']       = $request->lokasi;
        $data['keterangan']       = $dom->saveHTML();

        AgendaModel::create($data);

        return redirect()->route('agenda.index', compact('pagetitle'));
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
        $find = AgendaModel::find($id);
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
        // $user = auth()->user();
        $data = [];
        $data['title']       = $request->title;
        $data['date']       = $request->date;
        $data['time']       = $request->time;
        $data['lokasi']       = $request->lokasi;
        $data['keterangan']       = $dom->saveHTML();

        $find->update($data);

        return redirect()->route('agenda.index');
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
                    $path = public_path('photo-agenda/' . $filename);

                    // Hapus gambar dari server jika ada
                    if (file_exists($path)) {
                        unlink($path);
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
        $data = AgendaModel::find($id);
        // $categories = M_categories::all();
        $pagetitle = 'Detail Data Kegiatan';
        return view('agenda.read', compact('data', 'pagetitle', 'user'));
    }
}
