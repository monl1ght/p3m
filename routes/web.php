<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\DosenJurnalController;
use App\Http\Controllers\DosenHkiController;
use App\Http\Controllers\AdminHkiController;
use App\Http\Controllers\AdminSuratKeluarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\PengelolaController;
use App\Http\Controllers\SubmissionDocumentController;
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
Route::get('/panduanp3m/unduh/{id}', [ViewsController::class, 'unduh'])->name('tampilan.unduh');
Route::get('/panduan/unduh/{id}', [ViewsController::class, 'unduh'])->name('tampilan.panduan.unduh');
Route::get('/dokumen', [ViewsController::class, 'dokumen'])->name('tampilan.dokumen');
Route::get('/jurnal', [ViewsController::class, 'jurnal'])->name('tampilan.jurnal');
Route::get('/tentang', [ViewsController::class, 'tentangp3m'])->name('tampilan.tentangp3m');
Route::get('/agenda', [ViewsController::class, 'agenda'])->name('tampilan.agenda');
Route::get('/detailagenda/{id}', [ViewsController::class, 'listagenda'])->name('tampilan.detailagenda');
Route::get('/penelitian-p3m', [ViewsController::class, 'penelitian'])->name('tampilan.penelitian');
Route::get('/pengabdian-p3m', [ViewsController::class, 'pengabdian'])->name('tampilan.pengabdian');
Route::get('/karya-p3m/{type}/{id}/download', [ViewsController::class, 'downloadKarya'])->name('tampilan.download_karya');


//proses login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/proses-login', [AuthController::class, 'proses_login'])->middleware('throttle:login')->name('proses-login');

//proses register
Route::post('/register/verify-gate', [AuthController::class, 'verify_gate'])
    ->middleware('throttle:5,1')
    ->name('register.verify-gate');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/proses-register', [AuthController::class, 'proses_register'])
    ->middleware('throttle:5,1')
    ->name('proses-register');

//proses logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

//jika ingin menggunakan route group di letakkan pada route group tapi jika per raoute letakkan pada route yang akan di gunakan role
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    //ini menggunaakan laravel gate
    // Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('can:view_dashboard');
    // ini menggunakan role/ langsung memanggil permission
    Route::prefix('dash')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/', [MainController::class, 'dashadmin'])->name('dash.dashadmin');
        Route::get('/dashboard', [MainController::class, 'index'])->name('dash.dashboard');
        Route::get('/create_dash', [MainController::class, 'create_dash'])->name('dash.create_dash');
        Route::post('/buat', [MainController::class, 'buat'])->name('dash.buat');

        Route::get('/edit_dash/{id}', [MainController::class, 'edit_dash'])->name('dash.edit_dash');
        Route::put('/up_dash/{id}', [MainController::class, 'up_dash'])->name('dash.up_dash');
        // ;
    });
    Route::get('/user', [HomeController::class, 'index'])->name('index');

    Route::get('/create', [HomeController::class, 'create'])->name('create');
    Route::post('/store', [HomeController::class, 'store'])->name('store');


    Route::get('/update/{id}', [HomeController::class, 'update'])->name('update');
    Route::put('/edit/{id}', [HomeController::class, 'edit'])->name('edit');
    Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
    Route::delete('/delete/{id}', [HomeController::class, 'delete'])->name('delete');

    // Route::get('/clientside', [DataTableController::class, 'clientside'])->name('clientside');
    // Route::get('/serverside', [DataTableController::class, 'serverside'])->name('serverside');
    //kategori
    Route::prefix('category')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [CategoryController::class, 'index'])->name('category.index');

        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');

        //route edit
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::put('/ubah/{id}', [CategoryController::class, 'ubah'])->name('category.ubah');
        //route delete
        Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
    });
    //berita
    Route::prefix('news')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [NewsController::class, 'index'])->name('news.index');
        Route::get('/search', [NewsController::class, 'search'])->name('news.search');
        //route create
        Route::get('/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
        //route edit
        Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/update/{id}', [NewsController::class, 'update'])->name('news.update');
        //route delete
        Route::delete('/delete/{id}', [NewsController::class, 'delete'])->name('news.delete');
        //route detail data
        Route::get('/read/{id}', [NewsController::class, 'read'])->name('news.read');
    });
    Route::prefix('panduan')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [PanduanController::class, 'index'])->name('panduan.index');
        Route::get('/create', [PanduanController::class, 'create'])->name('panduan.create');
        Route::post('/store', [PanduanController::class, 'store'])->name('panduan.store');
        Route::get('/view/{id}', [PanduanController::class, 'view'])->name('panduan.view');
        Route::get('/download/{id}', [PanduanController::class, 'download'])->name('panduan.download');
        Route::delete('/delete/{id}', [PanduanController::class, 'delete'])->name('panduan.delete');
        Route::put('/update/{id}', [PanduanController::class, 'update'])->name('panduan.update');

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
        Route::get('/edit/{id}', [DokumenController::class, 'edit'])->name('dokumen.edit');
        Route::put('/update/{id}', [DokumenController::class, 'update'])->name('dokumen.update');
        Route::delete('/delete/{id}', [DokumenController::class, 'delete'])->name('dokumen.delete');
    });

    //Jurnal
    Route::prefix('jurnal')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [JurnalController::class, 'index'])->name('jurnal.index');
        Route::get('/create', [JurnalController::class, 'create'])->name('jurnal.create');
        Route::post('/store', [JurnalController::class, 'store'])->name('jurnal.store');
        Route::get('/edit/{id}', [JurnalController::class, 'edit'])->name('jurnal.edit');
        Route::put('/update/{id}', [JurnalController::class, 'update'])->name('jurnal.update');
        // Route::get('/shiw/{id}', [JurnalController::class, 'view'])->name('jurnal.view');
        Route::delete('/delete/{id}', [JurnalController::class, 'delete'])->name('jurnal.delete');
    });

    //pengelola p3m
    Route::prefix('pengelola')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [PengelolaController::class, 'index'])->name('pengelola.index');
        Route::get('/create', [PengelolaController::class, 'create'])->name('pengelola.create');
        Route::post('/store', [PengelolaController::class, 'store'])->name('pengelola.store');
        Route::get('/edit/{id}', [PengelolaController::class, 'edit'])->name('pengelola.edit');
        Route::put('/update/{id}', [PengelolaController::class, 'update'])->name('pengelola.update');
        Route::delete('/delete/{id}', [PengelolaController::class, 'delete'])->name('pengelola.delete');
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
        Route::put('/update/{id}', [TentangController::class, 'update'])->name('tentang.update');
    });

    //agenda p3m
    Route::prefix('agenda')->middleware('auth:sanctum', 'role:admin')->group(function () {
        Route::get('/index', [AgendaController::class, 'index'])->name('agenda.index');
        Route::get('/create', [AgendaController::class, 'create'])->name('agenda.create');
        Route::post('/store', [AgendaController::class, 'store'])->name('agenda.store');
        Route::get('/edit/{id}', [AgendaController::class, 'edit'])->name('agenda.edit');
        Route::put('/update/{id}', [AgendaController::class, 'update'])->name('agenda.update');
        Route::delete('/delete/{id}', [AgendaController::class, 'delete'])->name('agenda.delete');
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

        // Jurnal Dosen — Verifikasi Admin
        Route::get('/jurnal-dosen', [ViewlprnController::class, 'jurnalDosen'])->name('plppm.jurnal_dosen');
        Route::patch('/jurnal-dosen/{id}/status', [ViewlprnController::class, 'updateStatusJurnal'])
            ->name('plppm.jurnal_dosen.status');
        Route::get('/jurnal-dosen/{id}/download', [ViewlprnController::class, 'downloadJurnal'])
            ->name('plppm.jurnal_dosen.download');

        // HKI Dosen — Verifikasi Admin
        Route::get('/hki-dosen', [AdminHkiController::class, 'index'])->name('plppm.hki_dosen');
        Route::get('/hki-dosen/{id}', [AdminHkiController::class, 'show'])->name('plppm.hki_dosen.show');
        Route::patch('/hki-dosen/{id}/status', [AdminHkiController::class, 'updateStatus'])
            ->name('plppm.hki_dosen.status');
        Route::get('/hki-dosen/{id}/download', [AdminHkiController::class, 'download'])
            ->name('plppm.hki_dosen.download');

        // Riwayat Surat Keluar — Arsip & Pangkalan Data Surat Tugas Resmi
        Route::get('/surat-keluar', [AdminSuratKeluarController::class, 'index'])
            ->name('plppm.surat_keluar');
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

Route::post('/notif/read-table/{tipe}', function ($tipe) {
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
        'jurnal_dosen' => [
            'table' => 'dosen_jurnal_uploads',
            'redirect' => route('plppm.jurnal_dosen')
        ],
        'hki_dosen' => [
            'table' => 'hkis',
            'redirect' => route('plppm.hki_dosen')
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
})->middleware(['auth:sanctum', 'role:admin'])->name('notif.open');

//수랏 투가스
Route::get('/p3m/surat-tugas/download/{id}/{filename?}', [suratcontroller::class, 'downloadSuratTugas'])
    ->middleware('auth')
    ->name('p3m.surat-tugas.download');

Route::get('/p3m/surat-tugaspen/download/{id}/{filename?}', [suratcontroller::class, 'downsurtagpen'])
    ->middleware('auth')
    ->name('p3m.surat-tugaspen.download');

Route::middleware('auth')->get('/dokumen-pengajuan/{type}/{id}/download', [SubmissionDocumentController::class, 'download'])
    ->whereIn('type', ['proposal-pengabdian', 'proposal-penelitian', 'laporan-pengabdian', 'laporan-penelitian'])
    ->name('submission.document.download');

// Public download for approved reports only
Route::get('/public/laporan/{type}/{id}/download', [SubmissionDocumentController::class, 'publicDownload'])
    ->whereIn('type', ['laporan-penelitian', 'laporan-pengabdian'])
    ->name('submission.public.download');

Route::middleware(['auth'])->get('/Propengabdian/{tipe}/{id}', [ViewlprnController::class, 'dajupeneliti'])->name('detail.detail');
Route::middleware(['auth'])->get('/Lappengabdian/{tipe}/{id}', [ViewlprnController::class, 'kumpengneli'])->name('detail.detailk');
// Note: Route profil dosen (/profil/{id}) hanya tersedia di dalam group dosdash
// dengan middleware ['auth:sanctum', 'role:dosen'] yang benar (lihat di bawah).

    Route::prefix('dosdash')->middleware('auth:sanctum', 'role:dosen')->group(function () {
        // Profil Dosen
        Route::get('/profil/{id}', [DosenController::class, 'update'])->name('dosen.profil');
        Route::put('/profil/{id}', [DosenController::class, 'edit'])->name('dosen.profil.update');

        Route::get('/dash', [DosenController::class, 'dash'])->name('dosen.dash');

        //ajuan pengabdian
        Route::get('/ajupengabdi', [DosenController::class, 'upp3m'])->name('dosen.upp3m');
        Route::get('/datapengabdian', [DosenController::class, 'addp3m'])->name('dosen.addp3m');
        Route::post('/storep3m', [DosenController::class, 'storep3m'])->name('dosen.storep3m');
        Route::get('/editproposal/{id}', [DosenController::class, 'editp3m'])->name('dosen.edit_ajupengab');
        Route::post('/updatep3m/{id}', [DosenController::class, 'updatep3m'])->name('dosen.updatep3m');
        // Route::get('/dajupengab/{tipe}/{id}', [DosenController::class, 'dajupeneliti'])->name('detail.detail');
        Route::delete('/propengdelete/{id}', [DosenController::class, 'deletep3m'])->name('dosen.deletep3m');
        // //route edit

        //pengumpulan laporan pengabdian
        Route::get('/kpengabdian', [DosenController::class, 'kpengabdianp3m'])->name('dosen.dash_kpengabdian');
        Route::get('/addkpengabdian', [DosenController::class, 'addkumpulanp3m'])->name('dosen.addkpengabdian');
        Route::post('/storepengabdian', [DosenController::class, 'storekumpulanp3m'])->name('dosen.storekumpulanp3m');
        Route::get('/editkpengabdian/{id}', [DosenController::class, 'editkumpulanp3m'])->name('dosen.edit_kpengabdian');
        Route::post('/updatekpengabdian/{id}', [DosenController::class, 'updatekumpulanp3m'])->name('dosen.updatekumpulanp3m');
        // Route::get('/kdpenelitian/{tipe}/{id}', [DosenController::class, 'kumpengneli'])->name('detail.detailk');
        Route::delete('/deletekpeng/{id}', [DosenController::class, 'deletekpeng'])->name('dosen.deletekpeng');

        //ajuan penelitian
        Route::get('/ajupeneliti', [DosenController::class, 'ajuanpeneliti'])->name('dosen.dash_ajuanpenelitian');
        Route::get('/tambahpenelitian', [DosenController::class, 'tambahpenelitian'])->name('dosen.add_ajuanpenelitian');
        Route::post('/storepenelitian', [DosenController::class, 'storepenelitian'])->name('dosen.storepenelitian');
        Route::get('/editpropenelitian/{id}', [DosenController::class, 'editpenelitian'])->name('dosen.edit_ajuanpenelitian');
        Route::post('/updatepropenelitian/{id}', [DosenController::class, 'updatepenelitian'])->name('dosen.updatepenelitian');
        // Route::get('/dpenelitian/{tipe}/{id}', [DosenController::class, 'dajupeneliti'])->name('detail.detail');
        Route::delete('/deletepropen/{id}', [DosenController::class, 'deletepropen'])->name('dosen.deletepropen');

        //pengumpulan laporan penelitian
        Route::get('/datakpenelitian', [DosenController::class, 'kpeneliti'])->name('dosen.dash_kpenelitian');
        Route::get('/kpenelitian', [DosenController::class, 'tambahkumpulanpenelitian'])->name('dosen.add_kumnpeneliti');
        Route::post('/storekpenelitian', [DosenController::class, 'storekumpulanpenelitian'])->name('dosen.storekumpulanpenelitian');
        Route::get('/editkpenelitian/{id}', [DosenController::class, 'editkumpulanpenelitian'])->name('dosen.edit_kpenliti');
        Route::post('/updatekpenelitian/{id}', [DosenController::class, 'updatekumpulanpenelitian'])->name('dosen.updatekumpulanpenelitian');
        Route::post('/up_kpenliti/{id}', [DosenController::class, 'updatekumpulanpenelitian']);
        // Route::get('/kddpenelitian/{tipe}/{id}', [DosenController::class, 'kumpengneli'])->name('detail.detailk');
        Route::delete('/deletekpen/{id}', [DosenController::class, 'deletekpen'])->name('dosen.deletekpen');

        // Upload Jurnal Dosen
        Route::get('/jurnal-upload', [DosenJurnalController::class, 'index'])->name('dosen.jurnal_upload.index');
        Route::get('/jurnal-upload/create/{kategori?}', [DosenJurnalController::class, 'create'])->name('dosen.jurnal_upload.create');
        Route::post('/jurnal-upload/store', [DosenJurnalController::class, 'store'])->name('dosen.jurnal_upload.store');
        Route::get('/jurnal-upload/{id}/edit', [DosenJurnalController::class, 'edit'])->name('dosen.jurnal_upload.edit');
        Route::post('/jurnal-upload/{id}/update', [DosenJurnalController::class, 'update'])->name('dosen.jurnal_upload.update');
        Route::delete('/jurnal-upload/{id}/delete', [DosenJurnalController::class, 'destroy'])->name('dosen.jurnal_upload.delete');
        Route::get('/jurnal-upload/{id}/download', [DosenJurnalController::class, 'download'])->name('dosen.jurnal_upload.download');

        // Data HKI Dosen
        Route::get('/hki', [DosenHkiController::class, 'index'])->name('dosen.hki.index');
        Route::get('/hki/create', [DosenHkiController::class, 'create'])->name('dosen.hki.create');
        Route::post('/hki/store', [DosenHkiController::class, 'store'])->name('dosen.hki.store');
        Route::get('/hki/{id}', [DosenHkiController::class, 'show'])->name('dosen.hki.show');
        Route::get('/hki/{id}/edit', [DosenHkiController::class, 'edit'])->name('dosen.hki.edit');
        Route::post('/hki/{id}/update', [DosenHkiController::class, 'update'])->name('dosen.hki.update');
        Route::delete('/hki/{id}/delete', [DosenHkiController::class, 'destroy'])->name('dosen.hki.delete');
        Route::get('/hki/{id}/download', [DosenHkiController::class, 'download'])->name('dosen.hki.download');
    });
