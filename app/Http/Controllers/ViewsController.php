<?php

namespace App\Http\Controllers;

use App\Models\AgendaModel;
use App\Models\DokumenModel;
use App\Models\JurnalModel;
use App\Models\M_categories;
use App\Models\m_dashboard;
use App\Models\M_news;
use App\Models\m_panduan;
use App\Models\M_Pengelola;
use App\Models\M_tentang;
use App\Models\ajuan_penelitianModel;
use App\Models\p3mModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;

// use Illuminate\Database\Eloquent\Collection::sortBy() ;

class ViewsController extends Controller
{
    //home
    public function tampilan()
    {
        $pagetitle = 'Panduan P3M';
        $dash = m_dashboard::all();
        $berita = M_news::orderBy('created_at', 'desc')->get();
        $pengelola = M_Pengelola::all();
        $categories = M_categories::all();
        $tentang = M_tentang::all();
        $agenda = AgendaModel::all();
        return view('tampilan.index',  compact('pagetitle', 'dash', 'pengelola', 'categories', 'berita', 'tentang', 'agenda'));
    }

    //laman berita p3m
    public function berita()
    {
        $pagetitle = 'Kegiatan P3M';
        $berita = M_news::orderBy('created_at', 'desc')->paginate(6);
        // $newket = M_news::paginate(6);
        $categories = M_categories::all();
        session()->put('previous_page', url()->previous());
        if (session()->has('previous_page')) {
            return view('tampilan.berita', compact('pagetitle', 'berita', 'categories'));
        }
        return view('tampilan.berita', compact('pagetitle', 'berita', 'categories'));
    }

    //list berita
    public function show($id): ViewView
    {
        $pagetitle = 'Detail Kegiatan P3M';
        $berita = M_news::findOrFail($id);
        $categories = M_categories::all();
        $data = M_news::orderBy('created_at', 'desc')->take(5)->get();
        return view('tampilan.detail', compact('pagetitle', 'berita', 'categories', 'data'));
    }

    // Fungsi showPortfolioDetails dihapus — duplikat dan buggy ($recentNews undefined)
    // Gunakan show() di atas untuk detail berita

    //struktur P3M
    public function struktur()
    {
        // $dash = m_dashboard::all();
        // $berita = M_news::orderBy('created_at', 'desc')->get();
        $pagetitle = 'Struktur Organisasi P3M';
        $pengelola = M_Pengelola::all();
        // $categories = M_categories::all();
        return view('tampilan.struktur',  compact('pengelola', 'pagetitle'));
    }

    //panduan
    public function panduan(Request $request)
    {
        $user = Auth::user();
        $panduan = m_panduan::all();
        $pagetitle = 'Panduan P3M';
        return view('tampilan.panduan', compact('panduan', 'pagetitle', 'user'));
    }

    //unduh panduan
    public function unduh($id)
    {
        Log::info("Download attempt for panduan ID: " . $id);
        $panduan = m_panduan::findOrFail($id);

        // Cari file fisik berdasarkan original_name (atau fallback ke generated_name)
        $diskFileName = $panduan->original_name ?: $panduan->generated_name;

        if (!$diskFileName) {
            Log::warning("Data berkas panduan ID {$id} tidak memiliki nama file valid di database.");
            return redirect()->back()->with('error', 'Berkas panduan tidak valid atau belum diunggah.');
        }

        // Sanitasi nama file untuk mencegah directory traversal (CWE-22)
        $safeDiskFileName = basename($diskFileName);
        $storagePath = Storage::disk('public')->path('panduan/' . $safeDiskFileName);
        $legacyPath = public_path('uplouds' . DIRECTORY_SEPARATOR . $safeDiskFileName);

        if (Storage::disk('public')->exists('panduan/' . $safeDiskFileName) && is_file($storagePath)) {
            $filePath = $storagePath;
        } elseif (file_exists($legacyPath) && is_file($legacyPath)) {
            $filePath = $legacyPath;
        } else {
            // Fallback jika file tidak ditemukan di original_name, coba periksa generated_name
            $fallbackFile = basename($panduan->generated_name);
            $storageFallback = Storage::disk('public')->path('panduan/' . $fallbackFile);
            $legacyFallback = public_path('uplouds' . DIRECTORY_SEPARATOR . $fallbackFile);

            if ($fallbackFile && Storage::disk('public')->exists('panduan/' . $fallbackFile) && is_file($storageFallback)) {
                $filePath = $storageFallback;
            } elseif ($fallbackFile && file_exists($legacyFallback) && is_file($legacyFallback)) {
                $filePath = $legacyFallback;
            } else {
                Log::warning("File panduan ID {$id} tidak ditemukan di server: " . $safeDiskFileName);
                return redirect()->back()->with('error', 'Berkas panduan tidak ditemukan di server atau telah dipindahkan.');
            }
        }

        // Tentukan nama unduhan yang rapi dan aman bagi pengguna
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $rawTitle = trim(preg_replace('#[/\\\\?%*:|"<>]+#', '_', $panduan->namefile ?: 'Panduan_P3M'));
        
        if ($extension && !str_ends_with(strtolower($rawTitle), '.' . strtolower($extension))) {
            $downloadName = $rawTitle . '.' . $extension;
        } else {
            $downloadName = $rawTitle;
        }

        Log::info("File panduan ID {$id} siap diunduh: {$downloadName}");
        return response()->download($filePath, $downloadName);
    }


    //dokumen p3m
    public function dokumen(Request $request)
    {
        $user = Auth::user();
        $dok = DokumenModel::all();
        $pagetitle = 'Dokumen P3M';
        return view('tampilan.dokum', compact('dok', 'pagetitle', 'user'));
    }


    //tentang
    public function tentangp3m(Request $request)
    {
        $tentang = M_tentang::all();
        $pagetitle = 'Informasi P3M';
        $berita =  M_news::orderBy('created_at', 'desc')->take(8)->get();
        return view('tampilan.tentangp3m', compact('tentang', 'pagetitle', 'berita'));
    }

    //agenda
    public function agenda(Request $request)
    {
        $user = Auth::user();
        $agenda = AgendaModel::all();
        $kegiatan = AgendaModel::orderBy('created_at', 'desc')->take(5)->get();
        $pagetitle = 'Agenda Kegiatan P3M';
        return view('tampilan.agenda', compact('agenda', 'pagetitle', 'user', 'kegiatan'));
    }
    //list agenda
    public function listagenda($id)
    {
        $pagetitle = 'Berita P3M';
        $agen = AgendaModel::find($id);
        $agenda = AgendaModel::orderBy('created_at', 'desc')->take(5)->get();
        return view('tampilan.detailagenda', compact('pagetitle', 'agen', 'agenda'));
    }

    //jurnal p3m
    public function jurnal(Request $request)
    {
        $user = Auth::user();
        $dok = JurnalModel::all();
        $pagetitle = 'Jurnal P3M';
        return view('tampilan.jurnal', compact('dok', 'pagetitle', 'user'));
    }

    // Penelitian yang di-approve
    public function penelitian(Request $request)
    {
        $pagetitle = 'Data Penelitian P3M';
        
        $penelitian = ajuan_penelitianModel::where('status', 'approve')
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        return view('tampilan.penelitian', compact('pagetitle', 'penelitian'));
    }

    // Pengabdian yang di-approve
    public function pengabdian(Request $request)
    {
        $pagetitle = 'Data Pengabdian P3M';
        
        $pengabdian = p3mModel::where('status', 'approve')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('tampilan.pengabdian', compact('pagetitle', 'pengabdian'));
    }

    // Unduh PDF Karya P3M yang di-approve untuk publik
    public function downloadKarya($type, $id)
    {
        $submission = match ($type) {
            'penelitian' => ajuan_penelitianModel::findOrFail($id),
            'pengabdian' => p3mModel::findOrFail($id),
            default => abort(404),
        };

        // Pastikan hanya yang berstatus approve yang bisa diunduh oleh publik
        abort_unless($submission->status === 'approve', 403, 'Dokumen ini belum disetujui untuk dipublikasikan.');

        $filename = $submission->uppdf;
        abort_unless(is_string($filename) && $filename !== '', 404, 'File dokumen tidak tersedia.');

        $privatePath = 'submissions/' . $filename;
        if (Storage::disk('private')->exists($privatePath)) {
            $label = $type === 'penelitian' ? 'Penelitian' : 'Pengabdian';
            return Storage::disk('private')->download($privatePath, $label . '-' . $submission->id . '.pdf');
        }

        abort(404, 'Dokumen tidak ditemukan di server.');
    }
}
