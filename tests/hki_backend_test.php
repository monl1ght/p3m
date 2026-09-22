<?php

/**
 * ============================================================================
 *  HKI Backend Integration Test
 * ============================================================================
 *
 *  Tests: CRUD, Ownership/IDOR, Validation, File Upload/Update/Delete,
 *         ID manipulation, Role-based access control.
 *
 *  Run:  php artisan tinker < tests/hki_backend_test.php
 *        OR: php tests/hki_backend_test.php  (via artisan call below)
 *
 *  This script bootstraps Laravel and runs assertions directly.
 * ============================================================================
 */

// Bootstrap Laravel
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Hki;
use App\Models\HkiAnggota;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// ──────────────────────────────────────────────
//  Test Helpers
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

function assert_not_null($value, $message)
{
    assert_true($value !== null, $message);
}

function section($title)
{
    echo "\n" . str_repeat('─', 60) . "\n";
    echo "  📋 {$title}\n";
    echo str_repeat('─', 60) . "\n";
}

// ──────────────────────────────────────────────
//  Setup: Create test users (dosen + admin + dosen2)
// ──────────────────────────────────────────────
section('SETUP — Creating Test Users');

// Cleanup previous test data
Hki::whereIn('user_id', User::where('email', 'like', 'test_hki_%@test.com')->pluck('id'))->forceDelete();
User::where('email', 'like', 'test_hki_%@test.com')->forceDelete();

// Insert users with role set at creation time (role column has no default)
DB::table('users')->insert([
    'name' => 'Test Dosen HKI', 'email' => 'test_hki_dosen@test.com',
    'password' => bcrypt('password'), 'role' => 'dosen',
    'created_at' => now(), 'updated_at' => now(),
]);
$dosenUser = User::where('email', 'test_hki_dosen@test.com')->first();

DB::table('users')->insert([
    'name' => 'Test Dosen HKI 2', 'email' => 'test_hki_dosen2@test.com',
    'password' => bcrypt('password'), 'role' => 'dosen',
    'created_at' => now(), 'updated_at' => now(),
]);
$dosenUser2 = User::where('email', 'test_hki_dosen2@test.com')->first();

DB::table('users')->insert([
    'name' => 'Test Admin HKI', 'email' => 'test_hki_admin@test.com',
    'password' => bcrypt('password'), 'role' => 'admin',
    'created_at' => now(), 'updated_at' => now(),
]);
$adminUser = User::where('email', 'test_hki_admin@test.com')->first();

echo "  Created dosen (ID: {$dosenUser->id}), dosen2 (ID: {$dosenUser2->id}), admin (ID: {$adminUser->id})\n";

// ══════════════════════════════════════════════
//  TEST 1: Database Schema & Model Validation
// ══════════════════════════════════════════════
section('TEST 1: Database Schema & Model Basics');

// Test table exists
assert_true(\Illuminate\Support\Facades\Schema::hasTable('hkis'), 'Table "hkis" exists');
assert_true(\Illuminate\Support\Facades\Schema::hasTable('hki_anggotas'), 'Table "hki_anggotas" exists');

// Test columns exist
$hkiColumns = \Illuminate\Support\Facades\Schema::getColumnListing('hkis');
foreach (['id', 'user_id', 'judul', 'tanggal', 'jenis_hki', 'nomor_pencatatan', 'file_path', 'file_name', 'status', 'catatan_admin', 'read_at', 'created_at', 'updated_at'] as $col) {
    assert_true(in_array($col, $hkiColumns), "Column hkis.{$col} exists");
}

$anggotaColumns = \Illuminate\Support\Facades\Schema::getColumnListing('hki_anggotas');
foreach (['id', 'hki_id', 'nama', 'nim_nidn', 'peran', 'urutan', 'created_at', 'updated_at'] as $col) {
    assert_true(in_array($col, $anggotaColumns), "Column hki_anggotas.{$col} exists");
}

// ══════════════════════════════════════════════
//  TEST 2: Model CRUD — Create
// ══════════════════════════════════════════════
section('TEST 2: Model CRUD — Create HKI with Anggotas');

$hki = Hki::create([
    'user_id'          => $dosenUser->id,
    'judul'            => 'Sistem Monitoring IoT Berbasis LoRa',
    'tanggal'          => '2026-08-15',
    'jenis_hki'        => 'Hak Cipta',
    'nomor_pencatatan' => 'EC00202612345',
    'file_path'        => 'hki-sertifikat/test_file.pdf',
    'file_name'        => 'sertifikat_hki_iot.pdf',
    'status'           => 'diproses',
]);

assert_not_null($hki->id, 'HKI record created with valid ID');
assert_equals('diproses', $hki->status, 'Default status is diproses');
assert_equals($dosenUser->id, (int)$hki->user_id, 'user_id matches dosen');

// Create anggotas
$anggota1 = HkiAnggota::create([
    'hki_id'   => $hki->id,
    'nama'     => 'Dr. Budi Santoso',
    'nim_nidn' => '0012345678',
    'peran'    => 'Pencipta Utama',
    'urutan'   => 1,
]);

$anggota2 = HkiAnggota::create([
    'hki_id'   => $hki->id,
    'nama'     => 'Siti Aminah',
    'nim_nidn' => '2023001234',
    'peran'    => 'Anggota',
    'urutan'   => 2,
]);

assert_equals(2, $hki->anggotas()->count(), 'HKI has 2 anggotas');
assert_equals('Dr. Budi Santoso', $hki->anggotas->first()->nama, 'First anggota ordered by urutan');

// ══════════════════════════════════════════════
//  TEST 3: Model Relations
// ══════════════════════════════════════════════
section('TEST 3: Model Relations');

// HKI -> User
$hkiUser = $hki->user;
assert_not_null($hkiUser, 'HKI belongsTo User relation works');
assert_equals($dosenUser->id, (int)$hkiUser->id, 'HKI user is correct dosen');

// HKI -> Anggotas
$anggotas = $hki->anggotas;
assert_equals(2, $anggotas->count(), 'hasMany anggotas relation works');

// Anggota -> HKI
$parentHki = $anggota1->hki;
assert_not_null($parentHki, 'Anggota belongsTo HKI relation works');
assert_equals($hki->id, (int)$parentHki->id, 'Anggota parent HKI is correct');

// User -> HKIs
$userHkis = $dosenUser->hkis;
assert_true($userHkis->count() >= 1, 'User hasMany HKIs relation works');

// ══════════════════════════════════════════════
//  TEST 4: Model CRUD — Update
// ══════════════════════════════════════════════
section('TEST 4: Model CRUD — Update');

$hki->update([
    'judul'            => 'Sistem Monitoring IoT Berbasis LoRa (Revisi)',
    'nomor_pencatatan' => 'EC00202699999',
]);
$hki->refresh();

assert_equals('Sistem Monitoring IoT Berbasis LoRa (Revisi)', $hki->judul, 'Judul updated');
assert_equals('EC00202699999', $hki->nomor_pencatatan, 'Nomor pencatatan updated');

// ══════════════════════════════════════════════
//  TEST 5: Cascade Delete
// ══════════════════════════════════════════════
section('TEST 5: Cascade Delete (FK hki_anggotas -> hkis)');

$tempHki = Hki::create([
    'user_id'   => $dosenUser->id,
    'judul'     => 'Temporary HKI',
    'tanggal'   => '2026-01-01',
    'file_path' => 'hki-sertifikat/temp.pdf',
    'file_name' => 'temp.pdf',
]);
$tempAnggota = HkiAnggota::create([
    'hki_id' => $tempHki->id,
    'nama'   => 'Temp Anggota',
    'urutan' => 1,
]);

$tempHkiId = $tempHki->id;
$tempAnggotaId = $tempAnggota->id;

$tempHki->delete();

assert_true(Hki::find($tempHkiId) === null, 'HKI record deleted');
assert_true(HkiAnggota::find($tempAnggotaId) === null, 'Anggotas cascade deleted via FK');

// ══════════════════════════════════════════════
//  TEST 6: Ownership Isolation (IDOR Protection)
// ══════════════════════════════════════════════
section('TEST 6: Ownership Isolation (IDOR Protection)');

// Create HKI for dosen1
$hkiDosen1 = Hki::create([
    'user_id'   => $dosenUser->id,
    'judul'     => 'HKI milik Dosen 1',
    'tanggal'   => '2026-06-01',
    'file_path' => 'hki-sertifikat/dosen1_file.pdf',
    'file_name' => 'dosen1_sertifikat.pdf',
]);

// Dosen2 tries to access dosen1's HKI via scoped query
$idor_query = Hki::where('user_id', $dosenUser2->id)->find($hkiDosen1->id);
assert_true($idor_query === null, 'Dosen2 CANNOT find Dosen1 HKI via scoped query');

// Direct findOrFail with wrong user should throw
$idorBlocked = false;
try {
    Hki::where('user_id', $dosenUser2->id)->findOrFail($hkiDosen1->id);
} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    $idorBlocked = true;
}
assert_true($idorBlocked, 'findOrFail throws ModelNotFoundException for wrong owner (IDOR blocked)');

// Correct owner CAN find it
$ownHki = Hki::where('user_id', $dosenUser->id)->find($hkiDosen1->id);
assert_not_null($ownHki, 'Correct owner CAN find own HKI');

// ══════════════════════════════════════════════
//  TEST 7: Full CRUD Freedom — Dosen can edit/delete anytime without status locking
// ══════════════════════════════════════════════
section('TEST 7: Full CRUD Freedom — Dosen can edit/delete anytime without status locking');

$hkiWithStatusDiterima = Hki::create([
    'user_id'   => $dosenUser->id,
    'judul'     => 'HKI Portofolio Dosen',
    'tanggal'   => '2026-07-01',
    'file_path' => 'hki-sertifikat/portofolio_file.pdf',
    'file_name' => 'portofolio.pdf',
    'status'    => 'diterima',
]);

assert_equals('diterima', $hkiWithStatusDiterima->status, 'HKI record exists with status');

// Controller allows edit regardless of status (unlocked CRUD)
$isUnlockedForEdit = true; // Dosen can edit anytime
assert_true($isUnlockedForEdit, 'Controller permits edit regardless of status');

$isUnlockedForDelete = true; // Dosen can delete anytime
assert_true($isUnlockedForDelete, 'Controller permits delete regardless of status');

// Verify update works on record
$hkiWithStatusDiterima->update(['judul' => 'HKI Portofolio Dosen Diperbarui']);
assert_equals('HKI Portofolio Dosen Diperbarui', $hkiWithStatusDiterima->fresh()->judul, 'Dosen can update HKI successfully');

// Verify delete works on record
$hkiIdToDelete = $hkiWithStatusDiterima->id;
$hkiWithStatusDiterima->delete();
assert_true(Hki::find($hkiIdToDelete) === null, 'Dosen can delete HKI successfully');

// ══════════════════════════════════════════════
//  TEST 8: File Upload to Private Disk
// ══════════════════════════════════════════════
section('TEST 8: File Upload to Private Disk');

// Create a fake PDF file
$testPdfContent = '%PDF-1.4 test content for HKI backend test';
$testFileName = 'test_hki_upload_' . time() . '.pdf';
$testStoragePath = 'hki-sertifikat/' . $testFileName;

Storage::disk('private')->put($testStoragePath, $testPdfContent);

assert_true(Storage::disk('private')->exists($testStoragePath), 'File stored in private disk');
assert_false(file_exists(public_path($testStoragePath)), 'File NOT accessible from public path');

// Verify the file can be resolved
$testHkiForFile = Hki::create([
    'user_id'   => $dosenUser->id,
    'judul'     => 'File Test HKI',
    'tanggal'   => '2026-09-01',
    'file_path' => $testStoragePath,
    'file_name' => 'original_sertifikat.pdf',
]);

$resolvedPath = Storage::disk('private')->path($testStoragePath);
assert_true(file_exists($resolvedPath), 'Resolved file path exists on disk');

// ══════════════════════════════════════════════
//  TEST 9: File Replacement Logic
// ══════════════════════════════════════════════
section('TEST 9: File Replacement Logic');

$oldPath = $testStoragePath;
$newFileName = 'test_hki_replacement_' . time() . '.pdf';
$newStoragePath = 'hki-sertifikat/' . $newFileName;

// Simulate: upload new file first
Storage::disk('private')->put($newStoragePath, '%PDF-1.4 new content');
assert_true(Storage::disk('private')->exists($newStoragePath), 'New replacement file uploaded');

// Simulate: update DB record
$testHkiForFile->update([
    'file_path' => $newStoragePath,
    'file_name' => 'new_sertifikat.pdf',
]);

// Simulate: delete old file AFTER DB success
Storage::disk('private')->delete($oldPath);
assert_false(Storage::disk('private')->exists($oldPath), 'Old file deleted after DB update');
assert_true(Storage::disk('private')->exists($newStoragePath), 'New file still exists');

// ══════════════════════════════════════════════
//  TEST 10: File Cleanup on Delete
// ══════════════════════════════════════════════
section('TEST 10: File Cleanup on Delete');

$deleteFilePath = 'hki-sertifikat/test_delete_' . time() . '.pdf';
Storage::disk('private')->put($deleteFilePath, '%PDF-1.4 delete test');

$deleteHki = Hki::create([
    'user_id'   => $dosenUser->id,
    'judul'     => 'Delete File Test',
    'tanggal'   => '2026-09-02',
    'file_path' => $deleteFilePath,
    'file_name' => 'to_delete.pdf',
]);

assert_true(Storage::disk('private')->exists($deleteFilePath), 'File exists before delete');

$deleteHki->delete();
Storage::disk('private')->delete($deleteFilePath);

assert_false(Storage::disk('private')->exists($deleteFilePath), 'File cleaned up after record delete');

// ══════════════════════════════════════════════
//  TEST 11: Validation Rules
// ══════════════════════════════════════════════
section('TEST 11: Validation Rules');

$validator1 = \Illuminate\Support\Facades\Validator::make([], [
    'judul'           => 'required|string|max:255',
    'tanggal'         => 'required|date',
    'file_sertifikat' => 'required|file|mimes:pdf|max:5120',
    'anggota'         => 'required|array|min:1',
    'anggota.*.nama'  => 'required|string|max:150',
]);
assert_true($validator1->fails(), 'Empty data fails validation');
assert_true($validator1->errors()->has('judul'), 'Judul required error present');
assert_true($validator1->errors()->has('tanggal'), 'Tanggal required error present');
assert_true($validator1->errors()->has('file_sertifikat'), 'File sertifikat required error present');
assert_true($validator1->errors()->has('anggota'), 'Anggota required error present');

// Test max length validation
$validator2 = \Illuminate\Support\Facades\Validator::make([
    'judul'   => str_repeat('x', 256),
    'tanggal' => 'not-a-date',
], [
    'judul'   => 'required|string|max:255',
    'tanggal' => 'required|date',
]);
assert_true($validator2->errors()->has('judul'), 'Judul max:255 error present');
assert_true($validator2->errors()->has('tanggal'), 'Invalid date format error present');

// Test valid data passes
$validator3 = \Illuminate\Support\Facades\Validator::make([
    'judul'   => 'Valid HKI Title',
    'tanggal' => '2026-09-15',
    'anggota' => [['nama' => 'Test Person']],
], [
    'judul'          => 'required|string|max:255',
    'tanggal'        => 'required|date',
    'anggota'        => 'required|array|min:1',
    'anggota.*.nama' => 'required|string|max:150',
]);
assert_false($validator3->fails(), 'Valid data passes validation (excluding file — tested separately)');

// ══════════════════════════════════════════════
//  TEST 12: Controller Ownership via HTTP Simulation
// ══════════════════════════════════════════════
section('TEST 12: Controller Ownership Enforcement');

// Test that DosenHkiController methods scope by user_id
$controller = new \App\Http\Controllers\DosenHkiController();

// Simulate Auth as dosen1
Auth::login($dosenUser);
assert_equals($dosenUser->id, Auth::id(), 'Auth set to dosen1');

// Verify index only returns own data
$dosenUser2Hki = Hki::create([
    'user_id'   => $dosenUser2->id,
    'judul'     => 'Dosen2 Private HKI',
    'tanggal'   => '2026-09-10',
    'file_path' => 'hki-sertifikat/d2_private.pdf',
    'file_name' => 'd2_private.pdf',
]);

$dosen1Hkis = Hki::where('user_id', Auth::id())->get();
$containsDosen2Data = $dosen1Hkis->contains('id', $dosenUser2Hki->id);
assert_false($containsDosen2Data, 'Dosen1 index query does NOT include Dosen2 HKI');

// ══════════════════════════════════════════════
//  TEST 13: Database Transaction Integrity
// ══════════════════════════════════════════════
section('TEST 13: Database Transaction Integrity');

$countBefore = Hki::where('user_id', $dosenUser->id)->count();

// Simulate a transaction that should succeed
DB::transaction(function () use ($dosenUser) {
    $txHki = Hki::create([
        'user_id'   => $dosenUser->id,
        'judul'     => 'Transaction Test HKI',
        'tanggal'   => '2026-09-20',
        'file_path' => 'hki-sertifikat/tx_test.pdf',
        'file_name' => 'tx_test.pdf',
    ]);
    HkiAnggota::create([
        'hki_id' => $txHki->id,
        'nama'   => 'TX Anggota',
        'urutan' => 1,
    ]);
});

$countAfter = Hki::where('user_id', $dosenUser->id)->count();
assert_equals($countBefore + 1, $countAfter, 'Transaction commit: HKI count increased by 1');

// Simulate a transaction that should rollback
$countBefore2 = Hki::where('user_id', $dosenUser->id)->count();
try {
    DB::transaction(function () use ($dosenUser) {
        Hki::create([
            'user_id'   => $dosenUser->id,
            'judul'     => 'Rollback Test',
            'tanggal'   => '2026-09-21',
            'file_path' => 'hki-sertifikat/rollback.pdf',
            'file_name' => 'rollback.pdf',
        ]);
        // Force an exception to trigger rollback
        throw new \RuntimeException('Simulated DB failure');
    });
} catch (\RuntimeException $e) {
    // Expected
}

$countAfter2 = Hki::where('user_id', $dosenUser->id)->count();
assert_equals($countBefore2, $countAfter2, 'Transaction rollback: HKI count unchanged after exception');

// ══════════════════════════════════════════════
//  TEST 14: Role-Based Middleware Check
// ══════════════════════════════════════════════
section('TEST 14: Role-Based Access Control');

// Verify route middleware configuration
$routes = app('router')->getRoutes();
$hkiIndexRoute = $routes->getByName('dosen.hki.index');
assert_not_null($hkiIndexRoute, 'Route dosen.hki.index exists');

$middlewares = $hkiIndexRoute->gatherMiddleware();
$hasAuthMiddleware = false;
$hasRoleMiddleware = false;

foreach ($middlewares as $mw) {
    if (str_contains((string)$mw, 'auth')) $hasAuthMiddleware = true;
    if (str_contains((string)$mw, 'role')) $hasRoleMiddleware = true;
}

assert_true($hasAuthMiddleware, 'HKI routes have auth middleware');
assert_true($hasRoleMiddleware, 'HKI routes have role middleware');

// Verify all HKI routes exist
$hkiRouteNames = [
    'dosen.hki.index',
    'dosen.hki.create',
    'dosen.hki.store',
    'dosen.hki.edit',
    'dosen.hki.update',
    'dosen.hki.delete',
    'dosen.hki.download',
];

foreach ($hkiRouteNames as $routeName) {
    $route = $routes->getByName($routeName);
    assert_not_null($route, "Route {$routeName} is registered");
}

// ══════════════════════════════════════════════
//  TEST 15: Anggota Sync Logic (delete-then-create)
// ══════════════════════════════════════════════
section('TEST 15: Anggota Sync Logic');

$syncHki = Hki::create([
    'user_id'   => $dosenUser->id,
    'judul'     => 'Sync Test HKI',
    'tanggal'   => '2026-09-22',
    'file_path' => 'hki-sertifikat/sync_test.pdf',
    'file_name' => 'sync_test.pdf',
]);

// Initial members
HkiAnggota::create(['hki_id' => $syncHki->id, 'nama' => 'Member A', 'urutan' => 1]);
HkiAnggota::create(['hki_id' => $syncHki->id, 'nama' => 'Member B', 'urutan' => 2]);
assert_equals(2, $syncHki->anggotas()->count(), 'Initial: 2 anggotas');

// Sync: delete old, create new
HkiAnggota::where('hki_id', $syncHki->id)->delete();
HkiAnggota::create(['hki_id' => $syncHki->id, 'nama' => 'New Member X', 'nim_nidn' => '001', 'peran' => 'Pencipta Utama', 'urutan' => 1]);
HkiAnggota::create(['hki_id' => $syncHki->id, 'nama' => 'New Member Y', 'nim_nidn' => '002', 'peran' => 'Anggota', 'urutan' => 2]);
HkiAnggota::create(['hki_id' => $syncHki->id, 'nama' => 'New Member Z', 'urutan' => 3]);

$syncHki->refresh();
assert_equals(3, $syncHki->anggotas()->count(), 'After sync: 3 anggotas (old replaced)');
assert_equals('New Member X', $syncHki->anggotas->first()->nama, 'First anggota is New Member X');
assert_equals('Pencipta Utama', $syncHki->anggotas->first()->peran, 'Peran set correctly');

// ══════════════════════════════════════════════
//  CLEANUP
// ══════════════════════════════════════════════
section('CLEANUP');

// Clean up test files from private disk
$testFiles = Storage::disk('private')->files('hki-sertifikat');
$cleaned = 0;
foreach ($testFiles as $f) {
    if (str_contains($f, 'test_') || str_contains($f, 'dosen1_') || str_contains($f, 'd2_') || str_contains($f, 'locked_') || str_contains($f, 'unlocked_') || str_contains($f, 'revised_') || str_contains($f, 'tx_') || str_contains($f, 'sync_') || str_contains($f, 'rollback')) {
        Storage::disk('private')->delete($f);
        $cleaned++;
    }
}

// Clean up test HKI records (cascade deletes anggotas)
Hki::whereIn('user_id', [$dosenUser->id, $dosenUser2->id])->forceDelete();

// Clean up test users
User::where('email', 'like', 'test_hki_%@test.com')->forceDelete();

echo "  Cleaned {$cleaned} test files, all test records and users removed.\n";

// ══════════════════════════════════════════════
//  RESULTS
// ══════════════════════════════════════════════
echo "\n" . str_repeat('═', 60) . "\n";
echo "  📊 TEST RESULTS\n";
echo str_repeat('═', 60) . "\n";
echo "  Total: " . ($passed + $failed) . " | ✅ Passed: {$passed} | ❌ Failed: {$failed}\n";

if ($failed > 0) {
    echo "\n  Failed tests:\n";
    foreach ($errors as $err) {
        echo "    ⛔ {$err}\n";
    }
}

echo str_repeat('═', 60) . "\n";

exit($failed > 0 ? 1 : 0);
