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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$role)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        // $user = Auth::user();

        $userRole = auth()->user()->role;
        // dd([
        //     'User Role' => $userRole,
        //     'Allowed Roles' => $role,
        //     'Role Check' => in_array($userRole, $role),
        // ]);

        $role = is_array($role) ? $role : explode(',', $role);
        // Jika role user tidak sesuai, redirect ke home
        if (!in_array($userRole, $role)) {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses!');
        }

        // Periksa apakah pengguna memiliki role yang sesuai
        // if (auth()->user()->role !== $role) {
        //     return redirect('/home'); // Jika tidak sesuai, redirect ke halaman lain
        // }

        return $next($request);
    }
}
