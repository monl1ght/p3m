<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }



    /**
     * Bootstrap any application services.
     */
    // public function boot()
    // {
    //     View::composer('*', function ($view) {
    //         // dd('COMPOSER JALAN');
    //         $notifikasi = collect();

    //         // PENGAJUAN PENGABDIAN
    //         $pengajuanPengabdian = DB::table('ajupengabdian')
    //             ->whereNull('read_at')
    //             ->leftJoin('users', 'ajupengabdian.user_id', '=', 'users.id')
    //             ->select(
    //                 'ajupengabdian.id',
    //                 'users.name as nama_dosen',
    //                 'ajupengabdian.judul',
    //                 'ajupengabdian.created_at',
    //                 DB::raw("'pengajuan_pengabdian' as tipe")
    //             )
    //             ->latest()
    //             ->limit(5)
    //             ->get();

    //         // LAPORAN PENGABDIAN
    //         $laporanPengabdian = DB::table('kum_pengabdian_models')
    //             ->whereNull('read_at')
    //             ->leftJoin('users', 'kum_pengabdian_models.user_id', '=', 'users.id')
    //             ->select(
    //                 'kum_pengabdian_models.id',
    //                 'users.name as nama_dosen',
    //                 'kum_pengabdian_models.judul',
    //                 'kum_pengabdian_models.created_at',
    //                 DB::raw("'laporan_pengabdian' as tipe")
    //             )
    //             ->latest()
    //             ->limit(5)
    //             ->get();

    //         // PENGAJUAN PENELITIAN
    //         $pengajuanPenelitian = DB::table('ajuan_penelitian_models')
    //             ->whereNull('read_at')
    //             ->leftJoin('users', 'ajuan_penelitian_models.user_id', '=', 'users.id')
    //             // ->leftJoin('users', 'ajupengabdian.user_id', '=', 'users.id')
    //             ->select(
    //                 'ajuan_penelitian_models.id',
    //                 'users.name as nama_dosen',
    //                 'ajuan_penelitian_models.judul',
    //                 'ajuan_penelitian_models.created_at',
    //                 DB::raw("'pengajuan_penelitian' as tipe")
    //             )
    //             ->latest()
    //             ->limit(5)
    //             ->get();

    //         // LAPORAN PENELITIAN
    //         $laporanPenelitian = DB::table('kum_penelitian_models')
    //             ->whereNull('read_at')
    //             ->leftJoin('users', 'kum_penelitian_models.user_id', '=', 'users.id')
    //             ->select(
    //                 'kum_penelitian_models.id',
    //                 'users.name as nama_dosen',
    //                 'kum_penelitian_models.judul',
    //                 'kum_penelitian_models.created_at',
    //                 DB::raw("'laporan_penelitian' as tipe")
    //             )
    //             ->latest()
    //             ->limit(5)
    //             ->get();

    //         $notifikasi = $notifikasi
    //             ->merge($pengajuanPengabdian)
    //             ->merge($laporanPenelitian)
    //             ->merge($laporanPengabdian)
    //             ->merge($pengajuanPenelitian)
    //             ->sortByDesc('created_at')
    //             ->take(10)
    //             ->values();

    //         // 🔥 INI INTINYA
    //         $notifikasi = $notifikasi->map(function ($n) {


    //             switch ($n->tipe) {

    //                 case 'pengajuan_pengabdian':
    //                     $n->link = route('plppm.lpengabdian');
    //                     break;

    //                 case 'pengajuan_penelitian':
    //                     $n->link = route('plppm.lpeneleitian');
    //                     break;

    //                 case 'laporan_pengabdian':
    //                     $n->link = route('plppm.kpengabdian');
    //                     break;

    //                 case 'laporan_penelitian':
    //                     $n->link = route('plppm.kpenelitian');
    //                     break;
    //             }
    //             // $n->notif_key = $key;
    //             return $n;
    //         });
    //         // $lastSeen = session('notif_last_seen');
    //         // $latestNotifTime = optional($notifikasi->first())->created_at;

    //         // // $hasNewNotif = $latestNotifTime && (!$lastSeen || $latestNotifTime > $lastSeen);
    //         // $hasNewNotif = !$lastSeen || ($latestNotifTime && $latestNotifTime > $lastSeen);

    //         // simpan waktu refresh terakhir
    //         // session(['notif_last_seen' => now()]);

    //         // BADGE
    //         $hasNewNotif = $notifikasi->count() > 0;

    //         $view->with([
    //             'notifikasi'   => $notifikasi,
    //             'totalNotif'   => $notifikasi->count(),
    //             'hasNewNotif'  => $hasNewNotif
    //         ]);
    //         // $view->with([
    //         //     'notifikasi' => $notifikasi,
    //         //     'totalNotif' => $notifikasi->count()
    //         // ]);
    //         // dd('COMPOSER JALAN');
    //     });
    // }

    public function boot()
    {
        Carbon::setLocale('id');
        View::composer('*', function ($view) {
            $notifikasi = collect();

            $sources = [
                'pengajuan_pengabdian' => [
                    'table' => 'ajupengabdian',
                    'judul' => '%d Pengajuan Pengabdian',
                    'link' => route('plppm.lpengabdian')
                ],
                'pengajuan_penelitian' => [
                    'table' => 'ajuan_penelitian_models',
                    'judul' => '%d Pengajuan Penelitian',
                    'link' => route('plppm.lpeneleitian')
                ],
                'laporan_pengabdian' => [
                    'table' => 'kum_pengabdian_models',
                    'judul' => '%d Laporan Pengabdian',
                    'link' => route('plppm.kpengabdian')
                ],
                'laporan_penelitian' => [
                    'table' => 'kum_penelitian_models',
                    'judul' => '%d Pengajuan Pengabdian',
                    'link' => route('plppm.kpenelitian')
                ],
            ];
            foreach ($sources as $tipe => $cfg) {
                $jumlah = DB::table($cfg['table'])
                    ->whereNull('read_at')
                    ->count();

                if ($jumlah > 0) {
                    $notifikasi->push([
                        'tipe' => $tipe,
                        'judul' => sprintf($cfg['judul'], $jumlah),
                        'link' => $cfg['link']
                    ]);
                }
            }

            $view->with([
                'notifikasi' => $notifikasi,
                'totalNotif' => $notifikasi->count()
            ]);
        });
    }
}
