<?php

namespace App\Http\Controllers;

use App\Models\m_dashboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
// use Spatie\FlareClient\View;

class HomeController extends Controller
{


    /**
     * Defense-in-depth: Pastikan hanya pengguna dengan role admin yang dapat mengakses
     * fungsionalitas manajemen pengguna.
     */
    private function checkAdmin(): void
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. Hanya admin yang memiliki hak akses manajemen pengguna.');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdmin();
        $data = new User;
        $pagetitle = 'User P3M Polibang Jepara';
        $user = Auth::user();
        if ($request->get('search')) {
            $data = User::where('name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('email', 'like', '%' . $request->get('search') . '%');
        }

        $data = $data->get();

        return view('index', compact('data', 'request', 'pagetitle', 'user'));
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            dd('COMPOSER JALAN');
            $notifikasi = collect();

            // contoh pengajuan pengabdian
            $pengajuanPengabdian = DB::table('ajupengabdian')
                ->leftJoin('users', 'ajupengabdian.user_id', '=', 'users.id')
                ->select(
                    'ajupengabdian.id',
                    'users.name as nama_dosen',
                    'ajupengabdian.judul',
                    'ajupengabdian.created_at',
                    DB::raw("'pengajuan_pengabdian' as tipe")
                )
                ->latest()
                ->limit(5)
                ->get();

            $laporanPengabdian = DB::table('kum_pengabdian_models')
                ->leftJoin('users', 'kum_pengabdian_models.user_id', '=', 'users.id')
                ->select(
                    'kum_pengabdian_models.id',
                    'users.name as nama_dosen',
                    'kum_pengabdian_models.judul',
                    'kum_pengabdian_models.created_at',
                    DB::raw("'laporan_pengabdian' as tipe")
                )
                ->latest()
                ->limit(5)
                ->get();

            $pengajuanPenelitian = DB::table('ajuan_penelitian')
                ->leftJoin('users', 'ajuan_penelitian.user_id', '=', 'users.id')
                // ->leftJoin('users', 'ajupengabdian.user_id', '=', 'users.id')
                ->select(
                    'ajuan_penelitian.id',
                    'users.name as nama_dosen',
                    'ajuan_penelitian.judul',
                    'ajuan_penelitian.created_at',
                    DB::raw("'pengajuan_penelitian' as tipe")
                )
                ->latest()
                ->limit(5)
                ->get();

            // contoh laporan penelitian
            $laporanPenelitian = DB::table('kum_penelitian_models')
                ->leftJoin('users', 'kum_penelitian_models.user_id', '=', 'users.id')
                ->select(
                    'kum_penelitian_models.id',
                    'users.name as nama_dosen',
                    'kum_penelitian_models.judul',
                    'kum_penelitian_models.created_at',
                    DB::raw("'laporan_penelitian' as tipe")
                )
                ->latest()
                ->limit(5)
                ->get();

            $notifikasi = $notifikasi
                ->merge($pengajuanPengabdian)
                ->merge($laporanPenelitian)
                ->marge
                ->sortByDesc('created_at')
                ->take(5)
                ->values();

            // 🔥 INI INTINYA
            $notifikasi = $notifikasi->map(function ($n) {

                switch ($n->tipe) {

                    case 'pengajuan_pengabdian':
                        $n->link = route('plppm.lpengabdian');
                        break;

                    case 'pengajuan_penelitian':
                        $n->link = route('plppm.lpeneleitian');
                        break;

                    case 'laporan_pengabdian':
                        $n->link = route('plppm.kpengabdian');
                        break;

                    case 'laporan_penelitian':
                        $n->link = route('plppm.kpenelitian');
                        break;
                }

                return $n;
            });

            $view->with([
                'notifikasi' => $notifikasi,
                'totalNotif' => $notifikasi->count()
            ]);
            // dd('COMPOSER JALAN');
        });
    }

    public function create()
    {
        $this->checkAdmin();
        $user = Auth::user();
        return view('create', compact('user'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $validator = Validator::make($request->all(), [
            'image'        => 'nullable|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'image_base64' => 'nullable|string',
            'email'        => 'required|email|max:255|unique:users,email',
            'name'         => 'required|string|max:255|unique:users,name',
            'password'     => 'required|min:6',
            'role'         => 'required|in:admin,dosen',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'name.required'     => 'Nama lengkap wajib diisi.',
            'name.unique'       => 'Nama pengguna sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Role yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'create_user');
        }

        $image = $request->file('image');
        $imageBase64 = $request->input('image_base64');
        $imageService = app(\App\Services\ImageService::class);
        
        if ($imageBase64) {
            $filename = $imageService->storeBase64($imageBase64, 'photo-user');
        } else if ($image) {
            $filename = $imageService->processAndStore($image, 'photo-user');
        } else {
            return redirect()->back()->withInput()->withErrors(['image' => 'Foto profil wajib diisi.'])->with('form_context', 'create_user');
        }

        try {
            $user = User::create([
                'email'    => $request->email,
                'name'     => $request->name,
                'password' => Hash::make($request->password),
                'image'    => $filename,
            ]);
            // role diset secara eksplisit — bukan melalui fillable
            $user->role = $request->role;
            $user->save();

            // SEC-LOG-01: Log user creation by admin
            Log::info('User dibuat oleh admin', [
                'created_user_id' => $user->id,
                'role'            => $user->role,
                'admin_id'        => Auth::id(),
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            report($e);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['email' => 'Gagal menambahkan user. Email atau nama pengguna sudah terdaftar.'])
                ->with('form_context', 'create_user');
        }

        return redirect()->route('index')->with('success', 'Data user berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $data = User::findOrFail($id);
        $user = Auth::user();

        return view('update', compact('data', 'user'));
    }

    public function edit(Request $request, $id)
    {
        $this->checkAdmin();

        $find = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'email'        => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($find->id)],
            'name'         => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($find->id)],
            'password'     => 'nullable|min:6',
            'image'        => 'nullable|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'image_base64' => 'nullable|string',
            'role'         => 'required|in:admin,dosen',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan oleh akun lain.',
            'name.required'  => 'Nama lengkap wajib diisi.',
            'name.unique'    => 'Nama pengguna sudah digunakan oleh akun lain.',
            'password.min'   => 'Password minimal 6 karakter.',
            'role.required'  => 'Role wajib dipilih.',
            'role.in'        => 'Role yang dipilih tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'edit_user_' . $id);
        }

        $data['email'] = $request->email;
        $data['name']  = $request->name;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $image = $request->file('image');
        $imageBase64 = $request->input('image_base64');

        if ($imageBase64 || $image) {
            $imageService = app(\App\Services\ImageService::class);
            
            if ($imageBase64) {
                $filename = $imageService->storeBase64($imageBase64, 'photo-user');
            } else {
                $filename = $imageService->processAndStore($image, 'photo-user');
            }

            if ($find->image) {
                Storage::disk('public')->delete('photo-user/' . $find->image);
            }

            $data['image'] = $filename;
        }

        try {
            $oldRole = $find->role;
            $find->update($data);
            // Set role secara eksplisit karena bukan di $fillable
            $find->role = $request->role;
            $find->save();

            // SEC-LOG-01: Log role change if different
            if ($oldRole !== $find->role) {
                Log::info('Role user diubah oleh admin', [
                    'user_id'  => $find->id,
                    'old_role' => $oldRole,
                    'new_role' => $find->role,
                    'admin_id' => Auth::id(),
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            report($e);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['email' => 'Gagal memperbarui user. Email atau nama pengguna sudah digunakan oleh akun lain.'])
                ->with('form_context', 'edit_user_' . $id);
        }

        return redirect()->route('index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function delete(Request $request, $id)
    {
        $this->checkAdmin();

        // SEC-AUTHZ-03: Admin tidak diperbolehkan menghapus akun yang sedang aktif digunakan.
        // Ini mencegah hilangnya akses admin secara tidak sengaja maupun disengaja.
        if ((int)$id === (int)Auth::id()) {
            return redirect()->route('index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // $user = Auth::user();
        $user = User::find($id);
        if ($user) {
            // SEC-LOG-01: Log user deletion by admin
            Log::info('User dihapus oleh admin', [
                'deleted_user_id' => $user->id,
                'deleted_role'    => $user->role,
                'admin_id'        => Auth::id(),
            ]);

            $user->delete();
        }
        return redirect()->route('index', compact('user'))->with('success', 'Data berhasil dihapus!');
        // dd(request()->method('delete'));
    }

    public function detail(Request $request, $id)
    {
        $this->checkAdmin();
        $user = Auth::user();
        $data = User::findOrFail($id);

        return view('detail', compact('data', 'user'));
    }
}
