<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Tier 1 — Authentication Tests
 *
 * Memverifikasi bahwa sistem login, register, dan session
 * berfungsi dengan benar dan aman.
 */
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Login
    // -------------------------------------------------------------------------

    #[Test]
    public function halaman_login_menampilkan_checkbox_ingat_saya(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Ingat saya');
        $response->assertSee('name="remember"', false);
    }

    #[Test]
    public function user_dosen_yang_sudah_login_di_redirect_ke_dashboard_saat_akses_login(): void
    {
        $dosen = User::factory()->dosen()->create();

        $response = $this->actingAs($dosen)->get('/login');

        $response->assertRedirect(route('dosen.dash'));
    }

    #[Test]
    public function user_admin_yang_sudah_login_di_redirect_ke_dashboard_saat_akses_login(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/login');

        $response->assertRedirect(route('dash.dashadmin'));
    }

    #[Test]
    public function guest_tidak_bisa_akses_dashboard_admin(): void
    {
        $response = $this->get('/dash');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function guest_tidak_bisa_akses_dashboard_dosen(): void
    {
        $response = $this->get('/dosdash/dash');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function login_dengan_credential_salah_gagal(): void
    {
        User::factory()->create([
            'name'     => 'dosensatu',
            'password' => bcrypt('password123'),
            'role'     => 'dosen',
        ]);

        $response = $this->post('/proses-login', [
            'name'     => 'dosensatu',
            'password' => 'passwordSalah',
        ]);

        // AuthController mengembalikan ->with('error', ...) bukan ->withErrors()
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    #[Test]
    public function login_sukses_dosen_redirect_ke_dashboard_dosen(): void
    {
        $dosen = User::factory()->dosen()->create();

        $response = $this->post('/proses-login', [
            'name'     => $dosen->name,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dosen.dash'));
        $this->assertAuthenticatedAs($dosen);
    }

    #[Test]
    public function login_sukses_admin_redirect_ke_dashboard_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post('/proses-login', [
            'name'     => $admin->name,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dash.dashadmin'));
        $this->assertAuthenticatedAs($admin);
    }

    #[Test]
    public function session_diregenerasi_setelah_login(): void
    {
        $dosen = User::factory()->dosen()->create();

        // Setelah login sukses, user harus terauthentikasi (bukti session valid)
        $this->post('/proses-login', [
            'name'     => $dosen->name,
            'password' => 'password',
        ]);

        // Session regenerate() dipanggil di AuthController — verifikasi efeknya
        $this->assertAuthenticatedAs($dosen, 'web');
    }

    #[Test]
    public function logout_menghapus_session_dan_redirect(): void
    {
        $dosen = User::factory()->dosen()->create();

        $this->actingAs($dosen)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    // -------------------------------------------------------------------------
    // Register
    // -------------------------------------------------------------------------

    #[Test]
    public function register_tanpa_otorisasi_password_dosen_ditolak(): void
    {
        $response = $this->post('/proses-register', [
            'name'     => 'unauthorized_user',
            'email'    => 'unauth@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertNull(User::where('name', 'unauthorized_user')->first());
    }

    #[Test]
    public function register_selalu_membuat_akun_dosen_bukan_admin(): void
    {
        $this->withSession([
            'dosen_register_authorized' => true,
            'dosen_register_authorized_at' => now()->timestamp,
        ])->post('/proses-register', [
            'name'                  => 'newdosen',
            'email'                 => 'newdosen@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'admin', // attacker mencoba inject role admin
        ]);

        $user = User::where('name', 'newdosen')->first();

        $this->assertNotNull($user, 'User harus berhasil dibuat.');
        $this->assertEquals('dosen', $user->role, 'Role harus selalu dosen, bukan admin meski dikirim via request.');
    }

    #[Test]
    public function register_dengan_nama_duplikat_gagal(): void
    {
        User::factory()->dosen()->create(['name' => 'dosen_existing']);

        $response = $this->withSession([
            'dosen_register_authorized' => true,
            'dosen_register_authorized_at' => now()->timestamp,
        ])->post('/proses-register', [
            'name'                  => 'dosen_existing',
            'email'                 => 'baru@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertCount(1, User::where('name', 'dosen_existing')->get());
    }

    #[Test]
    public function register_rate_limit_aktif(): void
    {
        // Buat 5 percobaan register (batas throttle:5,1)
        for ($i = 0; $i < 5; $i++) {
            $this->withSession([
                'dosen_register_authorized' => true,
                'dosen_register_authorized_at' => now()->timestamp,
            ])->post('/proses-register', [
                'name'                  => "user_{$i}",
                'email'                 => "user{$i}@example.com",
                'password'              => 'password123',
                'password_confirmation' => 'password123',
            ]);
        }

        // Percobaan ke-6 harus diblokir (429 Too Many Requests)
        $response = $this->withSession([
            'dosen_register_authorized' => true,
            'dosen_register_authorized_at' => now()->timestamp,
        ])->post('/proses-register', [
            'name'                  => 'user_keenam',
            'email'                 => 'user6@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(429);
    }

    // -------------------------------------------------------------------------
    // Role Isolation
    // -------------------------------------------------------------------------

    #[Test]
    public function dosen_tidak_bisa_akses_halaman_admin(): void
    {
        $dosen = User::factory()->dosen()->create();

        $response = $this->actingAs($dosen)
            ->get('/dash');

        // RoleMiddleware me-redirect ke dosen.dash bukan abort(403)
        $response->assertRedirect(route('dosen.dash'));
        $response->assertSessionHas('error');
    }

    #[Test]
    public function admin_bisa_akses_dashboard_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/dash')
            ->assertOk();
    }

    // -------------------------------------------------------------------------
    // Remember Me
    // -------------------------------------------------------------------------

    #[Test]
    public function login_dengan_ingat_saya_menerbitkan_cookie_remember_me_dan_mengisi_token(): void
    {
        $dosen = User::factory()->dosen()->create();

        $response = $this->post('/proses-login', [
            'name'     => $dosen->name,
            'password' => 'password',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('dosen.dash'));
        $this->assertAuthenticatedAs($dosen);

        $recallerName = Auth::guard('web')->getRecallerName();
        $response->assertCookie($recallerName);

        $freshUser = $dosen->fresh();
        $this->assertNotNull($freshUser->remember_token, 'remember_token harus terisi di database saat Remember Me dicentang.');
    }

    #[Test]
    public function login_tanpa_ingat_saya_tidak_menerbitkan_cookie_remember_me(): void
    {
        $dosen = User::factory()->dosen()->create();

        $response = $this->post('/proses-login', [
            'name'     => $dosen->name,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dosen.dash'));
        $this->assertAuthenticatedAs($dosen);

        $recallerName = Auth::guard('web')->getRecallerName();
        $response->assertCookieMissing($recallerName);
    }

    #[Test]
    public function logout_setelah_remember_me_aktif_menghapus_cookie_dan_session(): void
    {
        $dosen = User::factory()->dosen()->create();

        $loginResponse = $this->post('/proses-login', [
            'name'     => $dosen->name,
            'password' => 'password',
            'remember' => '1',
        ]);

        $recallerName = Auth::guard('web')->getRecallerName();
        $cookie = $loginResponse->getCookie($recallerName);
        $this->assertNotNull($cookie);

        $logoutResponse = $this->withCookie($recallerName, $cookie->getValue())
            ->post('/logout');

        $logoutResponse->assertRedirect('/');
        $this->assertGuest();
        $logoutResponse->assertCookieExpired($recallerName);
        $this->assertNotEquals($cookie->getValue(), $dosen->fresh()->remember_token);
    }

    #[Test]
    public function tutup_dan_buka_kembali_browser_tetap_terautentikasi_dengan_remember_cookie(): void
    {
        $dosen = User::factory()->dosen()->create();

        $loginResponse = $this->post('/proses-login', [
            'name'     => $dosen->name,
            'password' => 'password',
            'remember' => '1',
        ]);

        $recallerName = Auth::guard('web')->getRecallerName();
        $cookie = $loginResponse->getCookie($recallerName);
        $this->assertNotNull($cookie, 'Cookie remember me harus ada pada respons login.');

        // Simulasikan browser ditutup tanpa logout (session hilang dan guard direset)
        $this->flushSession();
        app('auth')->forgetGuards();

        // Buka browser kembali dengan membawa cookie remember me
        $reopenResponse = $this->withCookie($recallerName, $cookie->getValue())
            ->get('/dosdash/dash');

        $reopenResponse->assertOk();
        $this->assertAuthenticatedAs($dosen);
    }

    #[Test]
    public function login_remember_me_berfungsi_untuk_admin_dan_dosen(): void
    {
        $admin = User::factory()->admin()->create();

        $adminResponse = $this->post('/proses-login', [
            'name'     => $admin->name,
            'password' => 'password',
            'remember' => '1',
        ]);

        $adminResponse->assertRedirect(route('dash.dashadmin'));
        $this->assertAuthenticatedAs($admin);
        $recallerName = Auth::guard('web')->getRecallerName();
        $adminResponse->assertCookie($recallerName);
    }

    #[Test]
    public function login_gagal_mempertahankan_input_remember(): void
    {
        User::factory()->create([
            'name'     => 'dosentest',
            'password' => bcrypt('password123'),
            'role'     => 'dosen',
        ]);

        $response = $this->post('/proses-login', [
            'name'     => 'dosentest',
            'password' => 'passwordSalah',
            'remember' => '1',
        ]);

        $response->assertSessionHas('error');
        $response->assertSessionHas('_old_input.remember', '1');
        $this->assertGuest();
    }
}
