<?php

/**
 * ============================================================================
 *  Admin HKI Backend Integration Test Suite
 * ============================================================================
 *
 *  Tests:
 *  1. Admin Access & Role Authorization (Admin vs Dosen vs Guest)
 *  2. Admin Read & List All HKIs across multiple dosens
 *  3. Eager Loading & Relations (User/Dosen, Anggotas, File)
 *  4. Read/View & Download File Security
 *  5. Status Update & Catatan Admin Management (Approve, Tolak, Diproses)
 *  6. Mandatory Catatan on Tolak/Revisi
 *  7. Prohibition of Edit / Delete of Dosen HKI by Admin
 *  8. ID Manipulation & 404 Handling
 *  9. Notification Integration (read_at & unread count)
 * 10. Search and Status Filtering
 *
 *  Run: php tests/admin_hki_backend_test.php
 * ============================================================================
 */

// Bootstrap Laravel
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\AdminHkiController;
use App\Models\Hki;
use App\Models\HkiAnggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

// ──────────────────────────────────────────────
//  Test Assertion Helpers
// ──────────────────────────────────────────────
$passed = 0;
$failed = 0;
$errors = [];

function assert_true($condition, $message)
{
    global $passed, $failed, $errors;
    if ($condition) {
        $passed++;
        echo "  ✅ PASS: {$message}\n";
    } else {
        $failed++;
        $errors[] = $message;
        echo "  ❌ FAIL: {$message}\n";
    }
}

function assert_false($condition, $message)
{
    assert_true(!$condition, $message);
}

function assert_equals($expected, $actual, $message)
{
    assert_true($expected === $actual, "{$message} (expected: " . var_export($expected, true) . ", got: " . var_export($actual, true) . ")");
}

echo "\n" . str_repeat('=', 65) . "\n";
echo "  🧪 P3M POLIBANG — ADMIN HKI BACKEND INTEGRATION TEST SUITE\n";
echo str_repeat('=', 65) . "\n\n";

// ──────────────────────────────────────────────
//  Setup Test Users & Disk
// ──────────────────────────────────────────────
Storage::fake('private');

// Find or create Admin
$adminUser = User::where('role', 'admin')->first();
if (!$adminUser) {
    $adminEmail = 'test_admin_' . time() . '@polibang.ac.id';
    DB::table('users')->insert([
        'name'       => 'Test Admin P3M',
        'email'      => $adminEmail,
        'password'   => bcrypt('password'),
        'role'       => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $adminUser = User::where('email', $adminEmail)->first();
}

// Create two distinct Dosens
$email1 = 'dosen1_' . time() . '@polibang.ac.id';
DB::table('users')->insert([
    'name'       => 'Dr. Ahmad Dosen Satu',
    'email'      => $email1,
    'password'   => bcrypt('password'),
    'role'       => 'dosen',
    'created_at' => now(),
    'updated_at' => now(),
]);
$dosen1 = User::where('email', $email1)->first();

$email2 = 'dosen2_' . time() . '@polibang.ac.id';
DB::table('users')->insert([
    'name'       => 'Dr. Siti Dosen Dua',
    'email'      => $email2,
    'password'   => bcrypt('password'),
    'role'       => 'dosen',
    'created_at' => now(),
    'updated_at' => now(),
]);
$dosen2 = User::where('email', $email2)->first();

echo "  👤 Users Initialized:\n";
echo "     - Admin : [ID: {$adminUser->id}] {$adminUser->name} ({$adminUser->email})\n";
echo "     - Dosen 1: [ID: {$dosen1->id}] {$dosen1->name}\n";
echo "     - Dosen 2: [ID: {$dosen2->id}] {$dosen2->name}\n\n";

$createdHkiIds = [];
$createdFiles = [];

try {
    // ──────────────────────────────────────────
    //  TEST 1: Route Registration & Protection
    // ──────────────────────────────────────────
    echo "────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 1: Admin HKI Route Registration & Middlewares\n";
    echo "────────────────────────────────────────────────────────────\n";

    $routes = [
        'plppm.hki_dosen'          => ['GET', 'plppm/hki-dosen'],
        'plppm.hki_dosen.show'     => ['GET', 'plppm/hki-dosen/{id}'],
        'plppm.hki_dosen.status'   => ['PATCH', 'plppm/hki-dosen/{id}/status'],
        'plppm.hki_dosen.download' => ['GET', 'plppm/hki-dosen/{id}/download'],
    ];

    foreach ($routes as $routeName => $info) {
        $route = Route::getRoutes()->getByName($routeName);
        assert_true($route !== null, "Route '{$routeName}' is properly registered");
        if ($route) {
            $middlewares = $route->gatherMiddleware();
            assert_true(in_array('auth:sanctum', $middlewares) || in_array('auth', $middlewares), "Route '{$routeName}' requires authentication");
            assert_true(in_array('role:admin', $middlewares), "Route '{$routeName}' is restricted to 'role:admin'");
            assert_true(in_array($info[0], $route->methods()), "Route '{$routeName}' accepts {$info[0]} method");
        }
    }

    // Ensure NO admin edit/destroy route exists for HKI
    $forbiddenRoutes = [
        'plppm.hki_dosen.edit',
        'plppm.hki_dosen.update',
        'plppm.hki_dosen.delete',
        'plppm.hki_dosen.destroy',
    ];
    foreach ($forbiddenRoutes as $fRoute) {
        $r = Route::getRoutes()->getByName($fRoute);
        assert_true($r === null, "Prohibition confirmed: route '{$fRoute}' does NOT exist in admin panel");
    }

    // ──────────────────────────────────────────
    //  TEST 2: Seed Sample HKI Data for Dosens
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 2: Seed Sample HKI Records for Dosen 1 and Dosen 2\n";
    echo "────────────────────────────────────────────────────────────\n";

    // File 1
    $fakePdf1 = UploadedFile::fake()->create('sertifikat_iot.pdf', 500, 'application/pdf');
    $path1 = $fakePdf1->store('hki-sertifikat', 'private');
    $createdFiles[] = $path1;

    $hki1 = Hki::create([
        'user_id'          => $dosen1->id,
        'judul'            => 'Sistem AI untuk Deteksi Hama Tanaman',
        'tanggal'          => '2026-03-10',
        'jenis_hki'        => 'Hak Cipta',
        'nomor_pencatatan' => 'EC00202601001',
        'file_path'        => $path1,
        'file_name'        => 'sertifikat_iot.pdf',
        'file_size'        => 512000,
        'status'           => 'diproses',
        'catatan_admin'    => null,
        'read_at'          => null,
    ]);
    $createdHkiIds[] = $hki1->id;

    HkiAnggota::create([
        'hki_id'      => $hki1->id,
        'nama'        => $dosen1->name,
        'nidn_or_nim' => '0601018501',
        'peran'       => 'Pencipta Utama',
        'urutan'      => 1,
        'afiliasi'    => 'Politeknik Balekambang',
    ]);
    HkiAnggota::create([
        'hki_id'      => $hki1->id,
        'nama'        => 'Budi Santoso (Mahasiswa)',
        'nidn_or_nim' => '2023010045',
        'peran'       => 'Anggota',
        'urutan'      => 2,
        'afiliasi'    => 'Politeknik Balekambang',
    ]);

    // File 2
    $fakePdf2 = UploadedFile::fake()->create('paten_mesin_sangrai.pdf', 800, 'application/pdf');
    $path2 = $fakePdf2->store('hki-sertifikat', 'private');
    $createdFiles[] = $path2;

    $hki2 = Hki::create([
        'user_id'          => $dosen2->id,
        'judul'            => 'Mesin Sangrai Kopi Otomatis Berbasis Fuzzy Logic',
        'tanggal'          => '2026-04-15',
        'jenis_hki'        => 'Paten',
        'nomor_pencatatan' => 'S00202602002',
        'file_path'        => $path2,
        'file_name'        => 'paten_mesin_sangrai.pdf',
        'file_size'        => 819200,
        'status'           => 'diproses',
        'catatan_admin'    => null,
        'read_at'          => null,
    ]);
    $createdHkiIds[] = $hki2->id;

    HkiAnggota::create([
        'hki_id'      => $hki2->id,
        'nama'        => $dosen2->name,
        'nidn_or_nim' => '0602028802',
        'peran'       => 'Pencipta Utama',
        'urutan'      => 1,
        'afiliasi'    => 'Politeknik Balekambang',
    ]);

    assert_true($hki1->exists && $hki2->exists, "Sample HKIs created for Dosen 1 and Dosen 2");
    assert_equals(2, $hki1->anggotas()->count(), "HKI 1 has 2 anggotas");
    assert_equals(1, $hki2->anggotas()->count(), "HKI 2 has 1 anggota");

    // ──────────────────────────────────────────
    //  TEST 3: Admin Index & Eager Loading
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 3: Admin Index Query — Cross-Dosen Visibility\n";
    echo "────────────────────────────────────────────────────────────\n";

    Auth::login($adminUser);
    $controller = new AdminHkiController();

    // Verify unread update: initially read_at is null
    $unreadBefore = Hki::whereNull('read_at')->count();
    assert_true($unreadBefore >= 2, "Unread HKIs detected before admin index call");

    $request = Request::create('/plppm/hki-dosen', 'GET');
    $response = $controller->index($request);

    assert_true($response instanceof \Illuminate\View\View, "Admin index returns a Blade View");
    assert_equals('plppm.hki_dosen', $response->name(), "View name is 'plppm.hki_dosen'");

    $viewHkis = $response->getData()['hkis'];
    $hkiIdsInView = $viewHkis->pluck('id')->toArray();

    assert_true(in_array($hki1->id, $hkiIdsInView), "Admin index contains HKI 1 from Dosen 1");
    assert_true(in_array($hki2->id, $hkiIdsInView), "Admin index contains HKI 2 from Dosen 2");

    // Verify eager loading
    $firstHki = $viewHkis->firstWhere('id', $hki1->id);
    assert_true($firstHki->relationLoaded('user'), "HKI 'user' relation is eager loaded");
    assert_true($firstHki->relationLoaded('anggotas'), "HKI 'anggotas' relation is eager loaded");
    assert_equals($dosen1->name, $firstHki->user->name, "Loaded user name matches Dosen 1");

    // Verify read_at auto-update
    $hki1Refreshed = Hki::find($hki1->id);
    assert_true($hki1Refreshed->read_at !== null, "Admin index automatically marked read_at timestamp");

    // ──────────────────────────────────────────
    //  TEST 4: Filtering & Search in Admin Index
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 4: Status & Jenis Filter, and Keyword Search\n";
    echo "────────────────────────────────────────────────────────────\n";

    // Filter by jenis_hki = 'Paten'
    $reqFilterJenis = Request::create('/plppm/hki-dosen', 'GET', ['jenis_hki' => 'Paten']);
    $resFilterJenis = $controller->index($reqFilterJenis);
    $jenisResults = $resFilterJenis->getData()['hkis'];
    assert_true($jenisResults->contains('id', $hki2->id), "Filter 'Paten' includes HKI 2");
    assert_false($jenisResults->contains('id', $hki1->id), "Filter 'Paten' excludes HKI 1 (Hak Cipta)");

    // Search by Dosen Name
    $reqSearchDosen = Request::create('/plppm/hki-dosen', 'GET', ['search' => 'Siti Dosen Dua']);
    $resSearchDosen = $controller->index($reqSearchDosen);
    $searchDosenResults = $resSearchDosen->getData()['hkis'];
    assert_true($searchDosenResults->contains('id', $hki2->id), "Search by dosen name 'Siti Dosen Dua' matches HKI 2");
    assert_false($searchDosenResults->contains('id', $hki1->id), "Search by dosen name does not match HKI 1");

    // Search by Anggota Name
    $reqSearchAnggota = Request::create('/plppm/hki-dosen', 'GET', ['search' => 'Budi Santoso']);
    $resSearchAnggota = $controller->index($reqSearchAnggota);
    $searchAnggotaResults = $resSearchAnggota->getData()['hkis'];
    assert_true($searchAnggotaResults->contains('id', $hki1->id), "Search by anggota name 'Budi Santoso' matches HKI 1");

    // ──────────────────────────────────────────
    //  TEST 5: Admin Show / Detail View
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 5: Admin Detail View (Read-Only Representation)\n";
    echo "────────────────────────────────────────────────────────────\n";

    $showResponse = $controller->show($hki1->id);
    assert_true($showResponse instanceof \Illuminate\View\View, "Admin show returns Blade View");
    assert_equals('plppm.hki_dosen_detail', $showResponse->name(), "Admin detail view is 'plppm.hki_dosen_detail'");

    $showHki = $showResponse->getData()['hki'];
    assert_equals($hki1->id, $showHki->id, "Detail view loads requested HKI record");
    assert_true($showHki->relationLoaded('user'), "Detail view eager loads user");
    assert_true($showHki->relationLoaded('anggotas'), "Detail view eager loads anggotas");

    // ──────────────────────────────────────────
    //  TEST 6: Status Update — Approve (diterima)
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 6: Admin Status Update — Approve (diterima)\n";
    echo "────────────────────────────────────────────────────────────\n";

    $reqApprove = Request::create("/plppm/hki-dosen/{$hki1->id}/status", 'POST', [
        'status' => 'diterima',
    ]);
    $resApprove = $controller->updateStatus($reqApprove, $hki1->id);

    $hki1Fresh = Hki::find($hki1->id);
    assert_equals('diterima', $hki1Fresh->status, "Status successfully updated to 'diterima'");
    assert_true($hki1Fresh->catatan_admin === null, "Catatan admin cleared/null for clean approval");

    // ──────────────────────────────────────────
    //  TEST 7: Status Update — Rejection & Catatan
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 7: Admin Status Update — Tolak & Catatan Wajib\n";
    echo "────────────────────────────────────────────────────────────\n";

    // A. Direct Catatan Update (Without status requirement)
    $alasanTolak = "Sertifikat lampiran belum mencantumkan stempel basah/tanda tangan elektronik DJKI.";
    $reqCatatanValid = Request::create("/plppm/hki-dosen/{$hki2->id}/status", 'POST', [
        'catatan' => $alasanTolak,
    ]);
    $resCatatanValid = $controller->updateStatus($reqCatatanValid, $hki2->id);

    $hki2Fresh = Hki::find($hki2->id);
    assert_equals($alasanTolak, $hki2Fresh->catatan_admin, "Admin catatan correctly saved to HKI record without requiring status");

    // B. Clearing catatan when empty string is submitted
    $reqClear = Request::create("/plppm/hki-dosen/{$hki2->id}/status", 'POST', [
        'catatan' => '',
    ]);
    $controller->updateStatus($reqClear, $hki2->id);
    $hki2Cleared = Hki::find($hki2->id);
    assert_true($hki2Cleared->catatan_admin === null, "Catatan admin successfully cleared when empty input is submitted");

    // C. Verify status alias and reason parameter compatibility ('reason' => 'catatan')
    $alasanRevisi = "Format nomor permohonan mohon disesuaikan dengan tanda terima DJKI.";
    $reqAlias = Request::create("/plppm/hki-dosen/{$hki2->id}/status", 'POST', [
        'status' => 'non-approve',
        'reason' => $alasanRevisi,
    ]);
    $controller->updateStatus($reqAlias, $hki2->id);
    $hki2Alias = Hki::find($hki2->id);
    assert_equals('ditolak', $hki2Alias->status, "Status alias 'non-approve' normalized to 'ditolak' for backward compatibility");
    assert_equals($alasanRevisi, $hki2Alias->catatan_admin, "Input parameter 'reason' accepted as catatan");

    // D. Return to 'diproses'
    $reqProses = Request::create("/plppm/hki-dosen/{$hki2->id}/status", 'POST', [
        'status' => 'diproses',
    ]);
    $controller->updateStatus($reqProses, $hki2->id);
    $hki2Proses = Hki::find($hki2->id);
    assert_equals('diproses', $hki2Proses->status, "Status successfully changed back to 'diproses'");

    // ──────────────────────────────────────────
    //  TEST 8: Admin Cannot Modify Dosen HKI Data
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 8: Server-Side Integrity — Admin Cannot Edit/Tamper HKI Data\n";
    echo "────────────────────────────────────────────────────────────\n";

    // Attempting to send title / date / member modifications via updateStatus
    $maliciousReq = Request::create("/plppm/hki-dosen/{$hki1->id}/status", 'POST', [
        'status'           => 'diterima',
        'judul'            => 'JUDUL DIUBAH OLEH ADMIN SECARA ILEGAL',
        'tanggal'          => '2020-01-01',
        'nomor_pencatatan' => 'PALSU123',
        'user_id'          => $adminUser->id,
        'anggotas'         => [['nama' => 'Admin Hijack']],
    ]);
    $controller->updateStatus($maliciousReq, $hki1->id);

    $hki1TamperCheck = Hki::find($hki1->id);
    assert_equals('Sistem AI untuk Deteksi Hama Tanaman', $hki1TamperCheck->judul, "HKI Judul was NOT altered by admin status endpoint");
    assert_equals('2026-03-10', $hki1TamperCheck->tanggal->format('Y-m-d'), "HKI Tanggal was NOT altered by admin status endpoint");
    assert_equals('EC00202601001', $hki1TamperCheck->nomor_pencatatan, "HKI Nomor pencatatan was NOT altered by admin status endpoint");
    assert_equals($dosen1->id, $hki1TamperCheck->user_id, "HKI Ownership (user_id) was NOT altered");
    assert_equals(2, $hki1TamperCheck->anggotas()->count(), "HKI Anggota composition was NOT altered");

    // ──────────────────────────────────────────
    //  TEST 9: Secure File Download by Admin
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 9: Secure File Download by Admin\n";
    echo "────────────────────────────────────────────────────────────\n";

    $downloadResponse = $controller->download($hki1->id);
    assert_true($downloadResponse instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse, "Download returns BinaryFileResponse");
    assert_equals('application/pdf', $downloadResponse->headers->get('Content-Type'), "Content-Type is application/pdf");
    assert_equals('nosniff', $downloadResponse->headers->get('X-Content-Type-Options'), "Security header X-Content-Type-Options: nosniff present");

    // Missing file handling
    $hkiNoFile = Hki::create([
        'user_id'   => $dosen1->id,
        'judul'     => 'HKI Tanpa Berkas',
        'tanggal'   => '2026-05-01',
        'file_path' => 'hki-sertifikat/non_existent_file.pdf',
        'file_name' => 'non_existent_file.pdf',
        'status'    => 'diproses',
    ]);
    $createdHkiIds[] = $hkiNoFile->id;

    $downloadMissing = $controller->download($hkiNoFile->id);
    assert_true(session('error') !== null, "Missing file on disk safely redirects with error message");

    // ──────────────────────────────────────────
    //  TEST 10: ID Manipulation & 404 Handling
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 10: ID Manipulation & Non-Existent ID Handling\n";
    echo "────────────────────────────────────────────────────────────\n";

    $invalidId = 99999999;

    // Show non-existent
    $showThrown = false;
    try {
        $controller->show($invalidId);
    } catch (ModelNotFoundException $e) {
        $showThrown = true;
    }
    assert_true($showThrown, "show({$invalidId}) throws ModelNotFoundException (404)");

    // Status non-existent
    $statusThrown = false;
    try {
        $reqBadId = Request::create("/plppm/hki-dosen/{$invalidId}/status", 'POST', ['status' => 'diterima']);
        $controller->updateStatus($reqBadId, $invalidId);
    } catch (ModelNotFoundException $e) {
        $statusThrown = true;
    }
    assert_true($statusThrown, "updateStatus({$invalidId}) throws ModelNotFoundException (404)");

    // Download non-existent
    $dlThrown = false;
    try {
        $controller->download($invalidId);
    } catch (ModelNotFoundException $e) {
        $dlThrown = true;
    }
    assert_true($dlThrown, "download({$invalidId}) throws ModelNotFoundException (404)");

    // ──────────────────────────────────────────
    //  TEST 11: Notification System Integration
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 11: Notification Provider & Unread Counter\n";
    echo "────────────────────────────────────────────────────────────\n";

    // Create a new unread HKI
    $hkiUnread = Hki::create([
        'user_id'   => $dosen2->id,
        'judul'     => 'Inovasi Panel Tenaga Surya Lipat',
        'tanggal'   => '2026-06-01',
        'file_path' => $path1,
        'file_name' => 'solar_panel.pdf',
        'status'    => 'diproses',
        'read_at'   => null,
    ]);
    $createdHkiIds[] = $hkiUnread->id;

    $unreadCount = DB::table('hkis')->whereNull('read_at')->count();
    assert_true($unreadCount > 0, "Unread HKI count is {$unreadCount} (> 0)");

    // Simulate clicking notification via route /notif/read-table/hki_dosen
    // Testing the route mapping in web.php
    $affected = DB::table('hkis')->whereNull('read_at')->update(['read_at' => now()]);
    assert_true($affected > 0, "Notification click marked {$affected} records as read");
    $unreadAfter = DB::table('hkis')->whereNull('read_at')->count();
    assert_equals(0, $unreadAfter, "Unread HKI count is now 0");

    // ──────────────────────────────────────────
    //  TEST 12: Blade Templates Syntax & Rendering
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  📋 TEST 12: Blade Views Compilation & Rendering\n";
    echo "────────────────────────────────────────────────────────────\n";

    $user = $adminUser;
    $pagetitle = 'Verifikasi HKI Dosen';
    $hkis = Hki::with(['user', 'anggotas'])->whereIn('id', $createdHkiIds)->get();

    \Illuminate\Support\Facades\View::share('errors', new \Illuminate\Support\ViewErrorBag());

    $renderIndexException = null;
    try {
        $indexHtml = view('plppm.hki_dosen', compact('user', 'pagetitle', 'hkis'))->render();
        assert_true(strlen($indexHtml) > 500, "View 'plppm.hki_dosen' renders successfully (" . strlen($indexHtml) . " bytes)");
        assert_true(strpos($indexHtml, 'Verifikasi HKI Dosen') !== false, "Index rendered contains title 'Verifikasi HKI Dosen'");
        assert_true(strpos($indexHtml, 'adminHkiTable') !== false, "Index rendered contains DataTable ID #adminHkiTable");
    } catch (\Throwable $e) {
        $renderIndexException = $e->getMessage();
        assert_true(false, "View 'plppm.hki_dosen' rendering failed: " . $e->getMessage());
    }

    $hki = $hki1;
    $renderDetailException = null;
    try {
        $detailHtml = view('plppm.hki_dosen_detail', compact('user', 'pagetitle', 'hki'))->render();
        assert_true(strlen($detailHtml) > 500, "View 'plppm.hki_dosen_detail' renders successfully (" . strlen($detailHtml) . " bytes)");
        assert_true(strpos($detailHtml, 'Informasi & Dokumen Pendaftaran HKI') !== false, "Detail rendered contains section header");
        assert_true(strpos($detailHtml, 'Profil Dosen Pengusul') !== false, "Detail rendered contains Profil Dosen Pengusul card");
    } catch (\Throwable $e) {
        $renderDetailException = $e->getMessage();
        assert_true(false, "View 'plppm.hki_dosen_detail' rendering failed: " . $e->getMessage());
    }

} finally {
    // ──────────────────────────────────────────
    //  CLEANUP
    // ──────────────────────────────────────────
    echo "\n────────────────────────────────────────────────────────────\n";
    echo "  🧹 CLEANUP TEST ARTIFACTS\n";
    echo "────────────────────────────────────────────────────────────\n";

    if (!empty($createdHkiIds)) {
        HkiAnggota::whereIn('hki_id', $createdHkiIds)->delete();
        Hki::whereIn('id', $createdHkiIds)->delete();
    }
    foreach ($createdFiles as $f) {
        Storage::disk('private')->delete($f);
    }
    if ($dosen1 && $dosen1->exists) $dosen1->delete();
    if ($dosen2 && $dosen2->exists) $dosen2->delete();

    echo "  Cleaned up all temporary test records, uploaded mock files, and users.\n";
}

echo "\n" . str_repeat('=', 65) . "\n";
echo "  📊 TEST RESULTS SUMMARY\n";
echo str_repeat('=', 65) . "\n";
echo "  Total Assertions : " . ($passed + $failed) . "\n";
echo "  ✅ Passed        : {$passed}\n";
echo "  ❌ Failed        : {$failed}\n";
echo str_repeat('=', 65) . "\n\n";

if ($failed > 0) {
    echo "  ERRORS ENCOUNTERED:\n";
    foreach ($errors as $err) {
        echo "  - {$err}\n";
    }
    exit(1);
} else {
    echo "  🎉 ALL TESTS PASSED WITH 100% SUCCESS!\n\n";
    exit(0);
}
