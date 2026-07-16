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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $berita = M_news::find($id);
        $categories = M_categories::all();
        $data = M_news::orderBy('created_at', 'desc')->take(5)->get();
        return view('tampilan.detail', compact('pagetitle', 'berita', 'categories', 'data'));
    }

    //detail berita
    public function showPortfolioDetails($id)
    {
        $pagetitle = 'Detail Kegiatan P3M';
        $dat = M_news::find($id);
        $dat = M_news::orderBy('created_at', 'desc')->take(5)->get(); // Mengambil 3 berita terbaru
        return view('tampilan.detail', compact('pagetitle', 'dat', 'recentNews'));
    }

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
        // Temukan file berdasarkan ID
        Log::info("Download attempt for ID: " . $id);
        $panduan = m_panduan::findOrFail($id);

        // Tentukan path file yang akan diunduh
        $filePath = public_path('uplouds/' . $panduan->namefile); // Sesuaikan dengan lokasi penyimpanan file Anda
        // dd($filePath);
        Log::info("File path: " . $filePath);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan: ' . $filePath);
        }
        Log::info("File found, preparing to download.");
        return response()->download($filePath, $panduan->namefile);
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
}
