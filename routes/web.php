<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\suratcontroller;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\ViewlprnController;
use App\Http\Controllers\ViewsController;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view([ViewsController::class, 'tampilan'], 'tampilan.index');
// }); 

//views user halaman utama
Route::get('/', [ViewsController::class, 'tampilan'])->name('tampilan');
Route::get('/berita', [ViewsController::class, 'berita'])->name('tampilan.berita');
Route::get('/tampilan/deber/detail/{id}', [ViewsController::class, 'show'])->name('tampilan.detail');
Route::get('/struktur', [ViewsController::class, 'struktur'])->name('tampilan.struktur');
Route::get('/panduanp3m', [ViewsController::class, 'panduan'])->name('tampilan.panduan');
Route::get('/dokumen', [ViewsController::class, 'dokumen'])->name('tampilan.dokumen');
Route::get('/jurnal', [ViewsController::class, 'jurnal'])->name('tampilan.jurnal');
Route::get('/tentang', [ViewsController::class, 'tentangp3m'])->name('tampilan.tentangp3m');
Route::get('/agenda', [ViewsController::class, 'agenda'])->name('tampilan.agenda');
Route::get('/detailagenda/{id}', [ViewsController::class, 'listagenda'])->name('tampilan.detailagenda');

//proses login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/proses-login', [AuthController::class, 'proses_login'])->name('proses-login');

//proses register
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/proses-register', [AuthController::class, 'proses_register'])->name('proses-register');

//proses logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//jika ingin menggunakan route group di letakkan pada route group tapi jika per raoute letakkan pada route yang akan di gunakan role
Route::group(['middleware' => 'auth:sanctum', 'role:admin'], function () {
    //ini menggunaakan laravel gate
    // Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('can:view_dashboard');
    // ini menggunakan role/ langsung memanggil permission
    Route::prefix('dash')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/', [MainController::class, 'dashadmin'])->name('dash.dashadmin');
        Route::get('/dashboard', [MainController::class, 'index'])->name('dash.dashboard');
        Route::get('/create_dash', [MainController::class, 'create_dash'])->name('dash.create_dash');
        Route::post('/buat', [MainController::class, 'buat'])->name('dash.buat');

        Route::get('/edit_dash/{id}', [MainController::class, 'edit_dash'])->name('dash.edit_dash');
        Route::match(['get', 'PUT'], '/up_dash/{id}', [MainController::class, 'up_dash'])->name('dash.up_dash');
        // ;
    });
    Route::get('/user', [HomeController::class, 'index'])->name('index');

    Route::get('/create', [HomeController::class, 'create'])->name('create');
    Route::post('/store', [HomeController::class, 'store'])->name('store');


    Route::get('/update/{id}', [HomeController::class, 'update'])->name('update');
    Route::put('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
    Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
    Route::get('/delete/{id}', [HomeController::class, 'delete'])->name('delete')->withoutMiddleware('auth');

    // Route::get('/clientside', [DataTableController::class, 'clientside'])->name('clientside');
    // Route::get('/serverside', [DataTableController::class, 'serverside'])->name('serverside');
    //kategori
    Route::prefix('category')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [CategoryController::class, 'index'])->name('category.index');

        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');

        //route edit
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::match(['get', 'PUT'], '/ubah/{id}', [CategoryController::class, 'ubah'])->name('category.ubah');
        //route delete
        // Add more routes here...
    });
    //berita
    Route::prefix('news')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/pagetitle', 'NewsController@pagetitle')->name('news.pagetitle');

        Route::get('/index', [NewsController::class, 'index'])->name('news.index');
        Route::get('/search', [NewsController::class, 'search'])->name('news.search');
        //route create
        Route::get('/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
        //route edit
        Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/update/{id}', [NewsController::class, 'update'])->name('news.update');
        //route delete
        Route::get('/delete/{id}', [NewsController::class, 'delete'])->name('news.delete');
        //route detail data
        Route::get('/read/{id}', [NewsController::class, 'read'])->name('news.read');
    });
    Route::prefix('panduan')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [PanduanController::class, 'index'])->name('panduan.index');
        Route::get('/create', [PanduanController::class, 'create'])->name('panduan.create');
        Route::post('/store', [PanduanController::class, 'store'])->name('panduan.store');
        Route::get('/view/{id}', [PanduanController::class, 'view'])->name('panduan.view');
        Route::get('/download/{id}', [PanduanController::class, 'download'])->name('panduan.download');
        Route::get('/delete/{id}', [PanduanController::class, 'delete'])->name('panduan.delete')->withoutMiddleware('auth');
        // Route::get('/view/{id}', [PanduanController::class, 'view'])->name('panduan.view');

        // Route::get('/download/{generated_name}', function ($filename) {
        //     $path = public_path('uplouds/' . $filename);
        //     // dd($path);
        //     return response()->download($path);
        // })->name('panduan.download');

        // Route::get('/download/{id}', [PanduanController::class, 'download'])->name('panduan.download')->withoutMiddleware('auth');
        // Route::get('/download/{id}', [PanduanController::class, 'download'])->name('panduan.download');
        // Route::get('/index', [PanduanController::class, 'index'])->name('panduan.index');
        // Route::get('/index', [PanduanController::class, 'index'])->name('panduan.index');
    });
    //dokumen
    Route::prefix('dokumen')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [DokumenController::class, 'index'])->name('dokumen.index');
        Route::get('/create', [DokumenController::class, 'create'])->name('dokumen.create');
        Route::post('/store', [DokumenController::class, 'store'])->name('dokumen.store');
        Route::get('/view/{id}', [DokumenController::class, 'view'])->name('dokumen.view');
        Route::get('/download/{id}', [DokumenController::class, 'download'])->name('dokumen.download');
    });

    //Jurnal
    Route::prefix('jurnal')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [JurnalController::class, 'index'])->name('jurnal.index');
        Route::get('/create', [JurnalController::class, 'create'])->name('jurnal.create');
        Route::post('/store', [JurnalController::class, 'store'])->name('jurnal.store');
        Route::get('/edit/{id}', [JurnalController::class, 'edit'])->name('jurnal.edit');
        Route::put('/update/{id}', [JurnalController::class, 'update'])->name('jurnal.update');
        // Route::get('/shiw/{id}', [JurnalController::class, 'view'])->name('jurnal.view');
        Route::get('/delete/{id}', [JurnalController::class, 'delete'])->name('jurnal.delete')->withoutMiddleware('auth');
    });

    //pengelola p3m
    Route::prefix('pengelola')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [PengelolaController::class, 'index'])->name('pengelola.index');
        Route::get('/create', [PengelolaController::class, 'create'])->name('pengelola.create');
        Route::post('/store', [PengelolaController::class, 'store'])->name('pengelola.store');
        Route::get('/edit/{id}', [PengelolaController::class, 'edit'])->name('pengelola.edit');
        Route::put('/update/{id}', [PengelolaController::class, 'update'])->name('pengelola.update');
        Route::get('/delete/{id}', [PengelolaController::class, 'delete'])->name('pengelola.delete')->withoutMiddleware('auth');
        // //route edit
        // Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        // Route::match(['get', 'PUT'], '/ubah/{id}', [CategoryController::class, 'ubah'])->name('category.ubah');
        //route delete
        // Add more routes here...
    });

    //tentang p3m
    Route::prefix('tentang')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [TentangController::class, 'index'])->name('tentang.index');
        Route::get('/create', [TentangController::class, 'create'])->name('tentang.create');
        Route::post('/store', [TentangController::class, 'store'])->name('tentang.store');
        Route::get('/edit/{id}', [TentangController::class, 'edit'])->name('tentang.edit');
        Route::match(['get', 'PUT'], '/update/{id}', [TentangController::class, 'update'])->name('tentang.update');
    });

    //agenda p3m
    Route::prefix('agenda')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [AgendaController::class, 'index'])->name('agenda.index');
        Route::get('/create', [AgendaController::class, 'create'])->name('agenda.create');
        Route::post('/store', [AgendaController::class, 'store'])->name('agenda.store');
        Route::get('/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
        Route::match(['get', 'PUT'], '/update/{id}', [AgendaController::class, 'update'])->name('agenda.update');
        Route::get('/delete/{id}', [AgendaController::class, 'delete'])->name('agenda.delete');
        Route::get('/read/{id}', [AgendaController::class, 'read'])->name('agenda.read');
    });

    //data proposal dan laporan pengabdian dan penelitian kepada masyarakat
    Route::prefix('plppm')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/ppengabdian', [ViewlprnController::class, 'upp3m'])->name('plppm.lpengabdian');
        Route::patch('/ppengabdian/{id}/status', [ViewlprnController::class, 'updateStatus'])
            ->name('plppm.ppengabdian.status');
        Route::get('/lpengabdian', [ViewlprnController::class, 'kpengabdianp3m'])->name('plppm.kpengabdian');
        Route::get('/ppenelitian', [ViewlprnController::class, 'ajuanpeneliti'])->name('plppm.lpeneleitian');
        Route::patch('/ppnelitian/{id}/status', [ViewlprnController::class, 'updateStatusPen'])
            ->name('plppm.ppenelitian.status');
        Route::get('/lpenelitian', [ViewlprnController::class, 'kpeneliti'])->name('plppm.kpenelitian');

        Route::patch('/kumpul/{tipe}/{id}/status', [ViewlprnController::class, 'updateStatuskump'])
            ->name('plppm.kumpulan.status');
        //detail data

    });
});

// Route::post('/notif/opened', function () {
//     session(['notif_opened' => true]);
//     return response()->noContent();
// })->name('notif.opened');

//notif router
// Route::post('/notif/opened', function () {
//     session(['notif_last_seen' => now()]);
//     return response()->json(['ok' => true]);
// })->name('notif.opened');

// Route::post('notif/read_all', function () {
//     DB::table('ajupengabdian')->whereNull('read_at')->update(['read_at' => now()]);
//     DB::table('ajuan_penelitian_models')->whereNull('read_at')->update(['read_at' => now()]);
//     DB::table('kum_pengabdian_models')->whereNull('read_at')->update(['read_at' => now()]);
//     DB::table('kum_penelitian_models')->whereNull('read_at')->update(['read_at' => now()]);

//     return response()->json(['ok' => true]);
// })->name('notif.readAll');

Route::get('/notif/read-table/{tipe}', function ($tipe) {
    // dd('masuk udah', $tipe);
    $map = [
        'pengajuan_pengabdian' => [
            'table' => 'ajupengabdian',
            'redirect' => route('plppm.lpengabdian')
        ],
        'pengajuan_penelitian' => [
            'table' => 'ajuan_penelitian_models',
            'redirect' => route('plppm.lpeneleitian')
        ],
        'laporan_pengabdian' => [
            'table' => 'kum_pengabdian_models',
            'redirect' => route('plppm.kpengabdian')
        ],
        'laporan_penelitian' => [
            'table' => 'kum_penelitian_models',
            'redirect' => route('plppm.kpenelitian')
        ],
    ];
    if (!isset($map[$tipe])) {
        abort(404);
    }

    DB::table($map[$tipe]['table'])
        ->whereNull('read_at')
        ->update([
            'read_at' => now()
        ]);

    // dd('row update', $affected);
    return redirect($map[$tipe]['redirect']);
})->name('notif.open');

//수랏 투가스
Route::get('/p3m/surat-tugas/download/{id}', [suratcontroller::class, 'downloadSuratTugas'])
    ->name('p3m.surat-tugas.download');

Route::get('/p3m/surat-tugaspen/download/{id}', [suratcontroller::class, 'downsurtagpen'])
    ->name('p3m.surat-tugaspen.download');

Route::middleware(['auth'])->get('/Propengabdian/{tipe}/{id}', [ViewlprnController::class, 'dajupeneliti'])->name('detail.detail');
Route::middleware(['auth'])->get('/Lappengabdian/{tipe}/{id}', [ViewlprnController::class, 'kumpengneli'])->name('detail.detailk');
Route::middleware(['auth'])->get('/Propengabdian/{tipe}/{id}', [ViewlprnController::class, 'dajupeneliti'])->name('detail.detail');
Route::middleware(['auth'])->get('/Lappengabdian/{tipe}/{id}', [ViewlprnController::class, 'kumpengneli'])->name('detail.detailk');
//profil
Route::middleware(['auth'])->get('/profil/{id}', [DosenController::class, 'update'])->name('dosen.profil');

Route::group(['middleware' => 'auth:sanctum', 'role:dosen'], function () {
    Route::prefix('dosdash')->middleware('auth:sanctum', 'role:dosen')->group(function () {
        Route::get('/dash', [DosenController::class, 'dash'])->name('dosen.dash');
        //profil

        Route::put('/edit/{id}', [DosenController::class, 'edit'])->name('edit');

        //ajuan pengabdian
        Route::get('/ajupengabdi', [DosenController::class, 'upp3m'])->name('dosen.upp3m');
        Route::get('/datapengabdian', [DosenController::class, 'addp3m'])->name('dosen.addp3m');
        Route::post('/storep3m', [DosenController::class, 'storep3m'])->name('dosen.storep3m');
        Route::get('/editproposal/{id}', [DosenController::class, 'editp3m'])->name('dosen.edit_ajupengab');
        Route::post('/updatep3m/{id}', [DosenController::class, 'updatep3m'])->name('dosen.updatep3m');
        // Route::get('/dajupengab/{tipe}/{id}', [DosenController::class, 'dajupeneliti'])->name('detail.detail');
        Route::get('/propengdelete/{id}', [DosenController::class, 'deletep3m'])->name('dosen.deletep3m')->withoutMiddleware('auth');
        // //route edit

        //pengumpulan laporan pengabdian
        Route::get('/kpengabdian', [DosenController::class, 'kpengabdianp3m'])->name('dosen.dash_kpengabdian');
        Route::get('/addkpengabdian', [DosenController::class, 'addkumpulanp3m'])->name('dosen.addkpengabdian');
        Route::post('/storepengabdian', [DosenController::class, 'storekumpulanp3m'])->name('dosen.storekumpulanp3m');
        Route::get('/editkpengabdian/{id}', [DosenController::class, 'editkumpulanp3m'])->name('dosen.edit_kpengabdian');
        Route::post('/updatekpengabdian/{id}', [DosenController::class, 'updatekumpulanp3m'])->name('dosen.updatekumpulanp3m');
        // Route::get('/kdpenelitian/{tipe}/{id}', [DosenController::class, 'kumpengneli'])->name('detail.detailk');
        Route::get('/deletekpeng/{id}', [DosenController::class, 'deletekpeng'])->name('dosen.deletekpeng')->withoutMiddleware('auth');

        //ajuan penelitian
        Route::get('/ajupeneliti', [DosenController::class, 'ajuanpeneliti'])->name('dosen.dash_ajuanpenelitian');
        Route::get('/tambahpenelitian', [DosenController::class, 'tambahpenelitian'])->name('dosen.add_ajuanpenelitian');
        Route::post('/storepenelitian', [DosenController::class, 'storepenelitian'])->name('dosen.storepenelitian');
        Route::get('/editpropenelitian/{id}', [DosenController::class, 'editpenelitian'])->name('dosen.edit_ajuanpenelitian');
        Route::post('/updatepropenelitian/{id}', [DosenController::class, 'updatepenelitian'])->name('dosen.updatepenelitian');
        // Route::get('/dpenelitian/{tipe}/{id}', [DosenController::class, 'dajupeneliti'])->name('detail.detail');
        Route::get('/deletepropen/{id}', [DosenController::class, 'deletepropen'])->name('dosen.deletepropen')->withoutMiddleware('auth');

        //pengumpulan laporan penelitian
        Route::get('/datakpenelitian', [DosenController::class, 'kpeneliti'])->name('dosen.dash_kpenelitian');
        Route::get('/kpenelitian', [DosenController::class, 'tambahkumpulanpenelitian'])->name('dosen.add_kumnpeneliti');
        Route::post('/storekpenelitian', [DosenController::class, 'storekumpulanpenelitian'])->name('dosen.storekumpulanpenelitian');
        Route::get('/editkpenelitian/{id}', [DosenController::class, 'editkumpulanpenelitian'])->name('dosen.edit_kpenliti');
        Route::post('/updatekpenelitian/{id}', [DosenController::class, 'updatekumpulanpenelitian'])->name('dosen.updatekumpulanpenelitian');
        // Route::get('/kddpenelitian/{tipe}/{id}', [DosenController::class, 'kumpengneli'])->name('detail.detailk');
        Route::get('/deletekpen/{id}', [DosenController::class, 'deletekpen'])->name('dosen.delete')->withoutMiddleware('auth');
    });
});
