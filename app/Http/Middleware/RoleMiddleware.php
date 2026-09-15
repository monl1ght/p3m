<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan pengguna sudah terautentikasi
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $userRole = $user->role ?? null;

        // 2. Normalisasi format roles (mendukung format koma, pipe, atau variadic)
        $allowedRoles = [];
        foreach ($roles as $r) {
            $allowedRoles = array_merge($allowedRoles, preg_split('/[,|]/', (string) $r));
        }
        $allowedRoles = array_filter(array_map('trim', $allowedRoles));

        // 3. Jika role pengguna diizinkan, lanjutkan request
        if ($userRole && in_array($userRole, $allowedRoles, true)) {
            return $next($request);
        }

        // 4. Penanganan akses ditolak secara profesional (Anti Infinite Redirect Loop)
        if ($request->expectsJson() || $request->ajax()) {
            abort(403, 'Akses tidak diizinkan untuk peran Anda.');
        }

        // Tentukan landing page sesuai role pengguna untuk mencegah redirect ke role yang salah
        $fallbackRoute = match ($userRole) {
            'admin' => route('dash.dashadmin'),
            'dosen' => route('dosen.dash'),
            default => null,
        };

        // Jika halaman tujuan sama dengan URL saat ini atau tidak ada fallback valid, lempar HTTP 403
        if (!$fallbackRoute || $request->url() === $fallbackRoute) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuka halaman ini.');
        }

        return redirect($fallbackRoute)->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
    }
}
