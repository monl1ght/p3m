<?php

namespace App\Http\Controllers;

use App\Models\m_dashboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
// use Spatie\FlareClient\View;

class HomeController extends Controller
{


    public function index(Request $request)
    {
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
        $user = Auth::user();
        return view('create', compact('user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'     => 'required|mimes:png,jpg,jpeg|max:2048',
            'email'     => 'required|email',
            'name'      => 'required',
            'password'  => 'required',
            'role'      => 'required|in:admin,dosen',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'create_user');
        }

        $image = $request->file('image');
        $filename = date('Y-m-d') . $image->getClientOriginalName();
        $path = 'photo-user/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($image));

        $data['email']      = $request->email;
        $data['name']       = $request->name;
        $data['password']   = Hash::make($request->password);
        $data['image']      = $filename;
        $data['role']       = $request->role;

        User::create($data);

        return redirect()->route('index')->with('success', 'Data user berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $data = User::find($id);
        $user = Auth::user();

        return view('update', compact('data', 'user'));
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'name'      => 'required',
            'password'  => 'nullable',
            'image'     => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'role'      => 'required|in:admin,dosen',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'edit_user_' . $id);
        }

        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $find = User::findOrFail($id);

        $data['email']      = $request->email;
        $data['name']       = $request->name;
        $data['role']       = $request->role;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $image = $request->file('image');

        if ($image) {
            $filename = date('Y-m-d') . $image->getClientOriginalName();
            $path = 'photo-user/' . $filename;

            if ($find->image) {
                Storage::disk('public')->delete('photo-user/' . $find->image);
            }

            Storage::disk('public')->put($path, file_get_contents($image));

            $data['image'] = $filename;
        }

        $find->update($data);

        return redirect()->route('index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function delete(Request $request, $id)
    {
        $auth = Auth::user();
        if ($auth->role !== 'admin') {
            abort(403, 'Kamu tidak punya akses untuk menghapus data ini.');
        }

        // $user = Auth::user();
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('index', compact('user'))->with('success', 'Data berhasil dihapus!');
        // dd(request()->method('delete'));
    }

    public function detail(Request $request, $id)
    {
        $user = Auth::user();
        $data = User::find($id);

        return view('detail', compact('data', 'user'));
    }
}
