<?php

namespace App\Http\Controllers;

// use Illuminate\Contracts\Session\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withInput($request->only('name'))
                ->with('error', 'Nama atau password salah!');
        }

        $request->session()->regenerate();
        $user = $request->user();

        return match ($user->role) {
            'admin' => redirect()->route('dash.dashadmin'),
            'dosen' => redirect()->route('dosen.dash'),
            default => $this->logoutInvalidRole($request),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tampilan');
    }

    /**
     * Verifikasi kode akses / passcode otorisasi sebelum masuk ke form registrasi dosen.
     */
    public function verify_gate(Request $request)
    {
        $validated = $request->validate([
            'passcode' => ['required', 'string'],
        ], [
            'passcode.required' => 'Kode otorisasi wajib diisi.',
        ]);

        $expectedPasscode = (string) config('auth.dosen_registration_passcode', 'V7#qLp2!oZ9@xR4$kP8');
        $givenPasscode    = (string) $validated['passcode'];

        // Menggunakan hash_equals untuk mitigasi timing attack
        if (!hash_equals($expectedPasscode, $givenPasscode)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode otorisasi pendaftaran dosen tidak valid! Hubungi admin P3M Polibang.',
                ], 422);
            }

            return back()->with('error', 'Kode otorisasi pendaftaran dosen tidak valid! Hubungi admin P3M Polibang.');
        }

        // Set session otorisasi dengan timestamp berlaku 30 menit
        $request->session()->put('dosen_register_authorized', true);
        $request->session()->put('dosen_register_authorized_at', now()->timestamp);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('register'),
            ]);
        }

        return redirect()->route('register');
    }

    public function register(Request $request)
    {
        if (!$this->isRegisterAuthorized($request)) {
            return redirect()->route('login')
                ->with('error', 'Akses registrasi ditolak. Silakan masukkan kode otorisasi pendaftaran dosen terlebih dahulu.');
        }

        return view('auth.register');
    }

    public function proses_register(Request $request)
    {
        if (!$this->isRegisterAuthorized($request)) {
            return redirect()->route('login')
                ->with('error', 'Sesi pendaftaran tidak valid atau telah kedaluwarsa. Silakan masukkan kode otorisasi pendaftaran kembali.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user           = new User();
        $user->name     = $validated['name'];
        $user->email    = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role     = 'dosen'; // Eksplisit — bukan mass assignment
        $user->save();

        // Hanguskan session otorisasi agar tidak bisa dipakai ulang
        $request->session()->forget(['dosen_register_authorized', 'dosen_register_authorized_at']);

        return redirect()->route('login')->with('success', 'Akun dosen berhasil didaftarkan! Silakan masuk dengan akun Anda.');
    }

    /**
     * Memeriksa keabsahan dan masa berlaku sesi otorisasi registrasi dosen.
     */
    private function isRegisterAuthorized(Request $request): bool
    {
        if (!$request->session()->get('dosen_register_authorized', false)) {
            return false;
        }

        $authorizedAt = (int) $request->session()->get('dosen_register_authorized_at', 0);
        // Masa berlaku maksimal 30 menit (1800 detik)
        if (now()->timestamp - $authorizedAt > 1800) {
            $request->session()->forget(['dosen_register_authorized', 'dosen_register_authorized_at']);
            return false;
        }

        return true;
    }

    private function logoutInvalidRole(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('error', 'Role tidak valid!');
    }
}
