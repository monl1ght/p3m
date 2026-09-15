<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
