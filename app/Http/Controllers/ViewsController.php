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
use App\Models\kum_penelitianModel;
use App\Models\kum_pengabdianModel;
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
        $berita = M_news::with('user')->orderBy('created_at', 'desc')->get();
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
        $query = M_news::orderBy('created_at', 'desc');
        if (request()->filled('q')) {
            $keyword = trim(request('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }
        $berita = $query->paginate(6)->withQueryString();
        $categories = M_categories::all();
        session()->put('previous_page', url()->previous());
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
        $berita = M_news::with('user')->orderBy('created_at', 'desc')->take(8)->get();
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
        $agen = AgendaModel::findOrFail($id);
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

    // Laporan Penelitian yang di-approve
    public function penelitian(Request $request)
    {
        $pagetitle = 'Data Penelitian P3M';
        
        $penelitian = kum_penelitianModel::where('status', 'approve')
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        return view('tampilan.penelitian', compact('pagetitle', 'penelitian'));
    }

    // Laporan Pengabdian yang di-approve
    public function pengabdian(Request $request)
    {
        $pagetitle = 'Data Pengabdian P3M';
        
        $pengabdian = kum_pengabdianModel::where('status', 'approve')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('tampilan.pengabdian', compact('pagetitle', 'pengabdian'));
    }

    // Unduh PDF Karya P3M yang di-approve untuk publik via submission.public.download
    public function downloadKarya($type, $id)
    {
        $docType = match ($type) {
            'penelitian' => 'laporan-penelitian',
            'pengabdian' => 'laporan-pengabdian',
            default => abort(404),
        };

        return redirect()->route('submission.public.download', [
            'type' => $docType,
            'id' => $id,
        ]);
    }
}
