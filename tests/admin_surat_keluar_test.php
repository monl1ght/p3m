<?php

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\AdminSuratKeluarController;
use App\Models\ajuan_penelitianModel;
use App\Models\p3mModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ViewErrorBag;

view()->share('errors', new ViewErrorBag());

$passed = 0;
$failed = 0;

function check_assert($cond, $msg) {
    global $passed, $failed;
    if ($cond) {
        $passed++;
        echo "  [PASS] $msg\n";
    } else {
        $failed++;
        echo "  [FAIL] $msg\n";
    }
}

echo "=== Testing Admin Riwayat Surat Keluar Integration ===\n";

// 1. Verify Route
check_assert(Route::has('plppm.surat_keluar'), "Route 'plppm.surat_keluar' exists");

// 2. Verify Controller
$adminUser = User::where('role', 'admin')->first();
if (!$adminUser) {
    $adminUser = new User([
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'role' => 'admin',
    ]);
    $adminUser->id = 9999;
}
Auth::setUser($adminUser);

$controller = new AdminSuratKeluarController();
$request = Request::create('/plppm/surat-keluar', 'GET');
$response = $controller->index($request);

check_assert($response->name() === 'plppm.surat_keluar', "Controller renders 'plppm.surat_keluar' view");
$viewData = $response->getData();
check_assert(isset($viewData['allSurat']), "View data contains 'allSurat'");
check_assert(isset($viewData['totalSurat']), "View data contains 'totalSurat'");
check_assert(isset($viewData['totalPenelitian']), "View data contains 'totalPenelitian'");
check_assert(isset($viewData['totalPengabdian']), "View data contains 'totalPengabdian'");

// 3. Render HTML
try {
    $html = $response->render();
    check_assert(strlen($html) > 500, "HTML rendered successfully (" . strlen($html) . " bytes)");
    check_assert(strpos($html, 'Riwayat Surat Keluar') !== false, "HTML contains title 'Riwayat Surat Keluar'");
    check_assert(strpos($html, 'Dokumen & Arsip Resmi') !== false, "HTML contains eyebrow 'Dokumen & Arsip Resmi'");
    check_assert(strpos($html, 'Total Surat Keluar') !== false, "HTML contains stat label 'Total Surat Keluar'");
} catch (\Throwable $e) {
    check_assert(false, "HTML rendering threw exception: " . $e->getMessage());
}

echo "\nSummary: $passed passed, $failed failed.\n";
exit($failed > 0 ? 1 : 0);
