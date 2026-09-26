<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\p3mModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSuratKeluarController extends Controller
{
    /**
     * Tampilkan riwayat surat keluar (Surat Tugas Pengabdian & Penelitian yang telah diterbitkan/bernomor).
     */
    public function index(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->role === 'admin', 403);

        $user = Auth::user();
        $pagetitle = 'Riwayat Surat Keluar';

        // 1. Data Surat Tugas Pengabdian (Approved & Memiliki Nomor Surat Sah)
        $pengabdianQuery = p3mModel::with(['user', 'anggotap3m', 'latestStatusHistory'])
            ->where('status', 'approve')
            ->whereNotNull('nomor_surat')
            ->whereRaw("TRIM(nomor_surat) != ''");

        // 2. Data Surat Tugas Penelitian (Approved & Memiliki Nomor Surat Sah)
        $penelitianQuery = ajuan_penelitianModel::with(['user', 'anggotap3m', 'latestStatusHistory'])
            ->where('status', 'approve')
            ->whereNotNull('nomor_surat')
            ->whereRaw("TRIM(nomor_surat) != ''");

        // Hitung total untuk stat chips
        $totalPengabdian = (clone $pengabdianQuery)->count();
        $totalPenelitian = (clone $penelitianQuery)->count();
        $totalSurat = $totalPengabdian + $totalPenelitian;

        // Ambil data Pengabdian
        $pengabdianList = $pengabdianQuery->get()->map(function ($item) {
            $letterDate = $item->latestStatusHistory?->decided_at ?? $item->updated_at ?? $item->created_at;
            return (object) [
                'id' => 'pengabdian-' . $item->id,
                'source_id' => $item->id,
                'type' => 'pengabdian',
                'jenis_surat' => 'Pengabdian',
                'nomor_surat' => trim((string)$item->nomor_surat),
                'judul' => $item->judul,
                'ketua' => $item->ketua,
                'nidn' => $item->nidn,
                'prodi' => $item->prodi,
                'tanggal_surat' => $letterDate ? Carbon::parse($letterDate) : null,
                'tanggal_mulai' => $item->tanggal_mulai,
                'tanggal_selesai' => $item->tanggal_selesai,
                'anggota_count' => $item->anggotap3m ? $item->anggotap3m->count() : 0,
                'user' => $item->user,
                'detail_url' => route('detail.detail', ['tipe' => 'ajupengab', 'id' => $item->id]),
                'view_url' => route('p3m.surat-tugas.download', ['id' => $item->id, 'disposition' => 'inline']),
                'download_url' => route('p3m.surat-tugas.download', ['id' => $item->id, 'disposition' => 'attachment']),
            ];
        });

        // Ambil data Penelitian
        $penelitianList = $penelitianQuery->get()->map(function ($item) {
            $letterDate = $item->latestStatusHistory?->decided_at ?? $item->updated_at ?? $item->created_at;
            return (object) [
                'id' => 'penelitian-' . $item->id,
                'source_id' => $item->id,
                'type' => 'penelitian',
                'jenis_surat' => 'Penelitian',
                'nomor_surat' => trim((string)$item->nomor_surat),
                'judul' => $item->judul,
                'ketua' => $item->ketua,
                'nidn' => $item->nidn,
                'prodi' => $item->prodi,
                'tanggal_surat' => $letterDate ? Carbon::parse($letterDate) : null,
                'tanggal_mulai' => $item->tanggal_mulai,
                'tanggal_selesai' => $item->tanggal_selesai,
                'anggota_count' => $item->anggotap3m ? $item->anggotap3m->count() : 0,
                'user' => $item->user,
                'detail_url' => route('detail.detail', ['tipe' => 'ajupenel', 'id' => $item->id]),
                'view_url' => route('p3m.surat-tugaspen.download', ['id' => $item->id, 'disposition' => 'inline']),
                'download_url' => route('p3m.surat-tugaspen.download', ['id' => $item->id, 'disposition' => 'attachment']),
            ];
        });

        // Gabungkan dan urutkan tanggal surat terbaru
        $allSurat = $pengabdianList->concat($penelitianList)->sortByDesc(function ($item) {
            return $item->tanggal_surat ? $item->tanggal_surat->timestamp : 0;
        })->values();

        // Filter jenis surat via request jika disediakan
        if ($request->filled('jenis_surat')) {
            $selectedJenis = strtolower($request->jenis_surat);
            if (in_array($selectedJenis, ['penelitian', 'pengabdian'], true)) {
                $allSurat = $allSurat->filter(function ($item) use ($selectedJenis) {
                    return strtolower($item->jenis_surat) === $selectedJenis;
                })->values();
            }
        }

        // Filter pencarian via request jika disediakan
        if ($request->filled('search')) {
            $keyword = strtolower(trim($request->search));
            $allSurat = $allSurat->filter(function ($item) use ($keyword) {
                return str_contains(strtolower($item->nomor_surat), $keyword)
                    || str_contains(strtolower($item->judul ?? ''), $keyword)
                    || str_contains(strtolower($item->ketua ?? ''), $keyword)
                    || str_contains(strtolower($item->prodi ?? ''), $keyword);
            })->values();
        }

        return view('plppm.surat_keluar', compact(
            'user',
            'pagetitle',
            'allSurat',
            'totalSurat',
            'totalPenelitian',
            'totalPengabdian'
        ));
    }
}
