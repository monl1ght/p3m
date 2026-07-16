<?php

namespace App\Http\Controllers;

// use Illuminate\Contracts\Session\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proses_login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        // $data = [
        //     'name' => $request->name,
        //     'password' => $request->password,
        // ];

        // // if (Auth::attempt($data)) {
        // //     $data = auth()->user();
        // //     // return redirect()->route('dash.dashboard');
        // //     return match ($data->role) {
        // //         'admin' => redirect()->route('dash.dashboard'),
        // //         'dosen' => redirect()->route('dosdash.dash'),
        // //         // 'guest' => redirect()->route('dash.dashboard'),
        // //         // default => redirect()->route('tampilan')
        // //     };
        // //     // 'dosen' => redirect()->route('dash.hki');
        // // }
        // if (auth()->user()->role == 'admin') {
        //     return redirect()->route('dash.dashboard');
        // } elseif (auth()->user()->role == 'dosen') {
        //     // return redirect()->route('dosdash.dash');
        //     dd(auth()->user());
        // } else {
        //     // return redirect()->route('login')->with('error');
        //     // return redirect()->route('dashboard');
        //     Session::flash('error', 'name atau password salah');
        //     return redirect()->back()->withInput();
        // }
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $user = Auth::user(); // Ambil user yang sudah login

            // Redirect sesuai role user
            // return match ($user->role) {
            //     'admin' => redirect()->route('dash.dashboard'),
            //     'dosen' => redirect()->route('dosdash.dash'),
            //     default => redirect('/login')->with('error', 'Role tidak dikenali.')
            // };
            // dd($user);
            if ($user->role == 'admin') {
                return redirect()->route('dash.dashadmin');
            } elseif ($user->role == 'dosen') {
                return redirect()->route('dosen.dash');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak valid!');
            }
        }
        // Jika login gagal, kembali ke halaman login dengan pesan error
        // Session::flash('error', 'Nama atau password salah');
        // return redirect()->back()->withInput();
        return redirect()->back()->with('error', 'Nama atau password salah!');
    }

    public function logout()
    {
        // dd('oke');
        Auth::logout();
        return redirect()->route('tampilan');
    }
    // ->with('success', 'kamu berhasil')

    public function register()
    {
        return view('auth.register');
    }

    public function proses_register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            // 'role' => 'nullable|string',

        ]);

        // $request = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required',
        //         'email' => 'required,|email|unique:user,email',
        //         'password' => 'required |min:8',
        //     ]
        // );
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'dosen',
            // 'is_admin' => true,
        ];
        User::create($data);
        return redirect()->route('login')->with('success', 'kamu berhasil');
    }
}
