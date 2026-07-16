<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\anggotap3mModel;
use App\Models\kum_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\M_categories;
use App\Models\p3mModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function dash(Request $id)
    {
        // $data = new M_news();
        $user = Auth::user();
        $data = User::find($id);
        // $jurnal = JurnalModel::get();
        // if ($request->get('search')) {
        //     $data = M_news::where('title', 'like', '%' . $request->get('search') . '%');
        // }
        // $pagetitle = 'Jurnal P3M';
        // $data = $data->get();
        // return view('jurnal.index', compact('jurnal', 'pagetitle', 'user'));
        return view('dosen.dash', compact('user', 'data'));
    }
    //PROFIL DOSEN 
    public function update(Request $request, $id)
    {
        $data = User::find($id);
        $user = Auth::user();

        $layout = $request->get('layout') ?? (($user->role === 'admin') ? 'layout.main' : 'layout.doslayout');

        return view('dosen.profildos', compact('data', 'user', 'layout'));
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'name'      => 'required',
            'password'  => 'nullable',
            'image'     => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $find = User::findOrFail($id);
        $currentUser = Auth::user();

        $data['email']      = $request->email;
        $data['name']       = $request->name;
        $user = Auth::user();


        if ($request->password) {
            $data['password']   = Hash::make($request->password);
        }
        $image = $request->file('image');

        if ($image) {

            $filename = date('Y-m-d') . $image->getClientOriginalName();
            $path = 'photo-user/' . $filename;

            if ($find->image) {

                // $image->storeAs('public/photo-user/', $image->hashName());
                Storage::disk('public')->delete('photo-user/' . $find->image);
            }

            Storage::disk('public')->put($path, file_get_contents($image));

            $data['image'] = $filename;
        }
        $find->update($data);



        return redirect()->route('dosen.profil', ['id' => Auth::id()]);
    }
    //PENGAJUAN PENELITIAN
    public function upp3m(Request $request)
    {
        // $data = new M_news();
        $pagetitle = 'Proposal Pengabdian Masyarakat';
        $user = Auth::user();
        $penelitians = p3mModel::where('user_id', $user->id)
            ->with('anggotap3m')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('judul', 'like', '%' . $request->search . '%')
                        ->orWhere('bidang', 'like', '%' . $request->search . '%')
                        ->orWhere('jeniskategori', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('dosen.upp3m', compact('user', 'penelitians', 'pagetitle'));
    }

    // public function kpengabdian(Request  $id)
    // {
    //     $pagetitle = 'Laporan Penelitian Masyarakat';
    //     $user = Auth::user();
    //     $data = User::find($id);
    //     $penelitians = kum_pengabdianModel::where('user_id', $user->id)
    //         // ->orWhereNull('user_id')
    //         ->orderBy('created_at', 'desc')
    //         ->with('anggotap3m')
    //         ->get();
    //     // dd($penelitians);
    //     return view('dosen.dash_kpengabdian', compact('user', 'data', 'penelitians', 'pagetitle'));
    // }

    public function ajuanpeneliti(Request  $id)
    {
        // $data = new M_news();
        $pagetitle = 'Proposal Penelitian Masyarakat';
        $user = Auth::user();
        $data = User::find($id);
        $penelitians = ajuan_penelitianModel::where('user_id', $user->id)
            // ->orWhereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->with('anggotap3m')
            ->get();
        // dd($penelitians);
        return view('dosen.dash_ajuanpenelitian', compact('user', 'data', 'penelitians', 'pagetitle'));
    }

    public function kpeneliti(Request  $id)
    {
        // $data = new M_news();
        $pagetitle = 'Laporan Penelitian Masyarakat';
        $user = Auth::user();
        $data = User::find($id);
        $penelitians = kum_penelitianModel::where('user_id', $user->id)
            // ->orWhereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->with('anggotap3m')
            ->get();
        // dd($penelitians);
        return view('dosen.dash_kpenelitian', compact('user', 'data', 'penelitians', 'pagetitle'));
    }
    //TAMBAH  AJUAN PENELITIAN
    public function addp3m()
    {
        $user = Auth::user();
        $pagetitle = 'Proposal Pengabdian Masyarakat';
        return view('dosen.addp3m', compact('user', 'pagetitle'));
    }

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         //untuk data
    //         'judul' => 'required',
    //         'bidang' => 'required',
    //         'kategori_id' => 'required',
    //         'lokasi' => 'required',
    //         'lamapenelitian' => 'required',
    //         'biaya' => 'required',
    //         'uppdf' => 'required|mimes:pdf|max:2048',
    //         //untuk profil
    //         'ketua' => 'required',
    //         'jabatan' => 'required',
    //         'nidn' => 'required',
    //         'telp' => 'required',
    //         'alamat' => 'required',
    //         'jeniskelamin' => 'required|in:L,P',
    //         'prodi' => 'required',
    //         //untuk up gambar
    //         'foto' => 'required|mimes:png,jpg,jpeg|max:2048',

    //         //untuk input anggota
    //         'anggota' => 'required|array',
    //         'anggota.*.nama' => 'required|string|max:100',
    //         'anggota.*.prodi' => 'nullable|string|max:100',
    //         'anggota.*.jabatan' => 'nullable|string|max:100',
    //     ], [], [
    //         'anggota.0.nama' => 'nama'

    //         //untuk user login yang up this data
    //         // 'user_id' => auth()->user()->id,
    //     ]);

    //     foreach ($validator->errors()->getMessages() as $key => $messages) {
    //         if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
    //             $validator->errors()->add('nama', $messages[0]);
    //         }
    //     }
    //     if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
    //     // dd($validator->errors());
    //     //proses up data 
    //     $image = $request->file('foto');
    //     $filename = date('d-m-Y') . $image->getClientOriginalName();
    //     $path = 'photo-upp3m/' . $filename;

    //     Storage::disk('public')->put($path, file_get_contents($image));

    //     //proses up pdf
    //     $uppdf = $request->file('uppdf');
    //     $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
    //     $pathpdf = 'uppdf/' . $filenamepdf;
    //     Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

    //     $penelitian = p3mModel::create([
    //         'user_id' => auth()->user()->id,
    //         'judul' => $request->judul,
    //         'bidang' => $request->bidang,
    //         'kategori_id' => $request->kategori_id,
    //         'lokasi' => $request->lokasi,
    //         'lamapenelitian' => $request->lamapenelitian,
    //         'biaya' => $request->biaya,
    //         'uppdf' => $filenamepdf,
    //         'ketua' => $request->ketua,
    //         'jabatan' => $request->jabatan,
    //         'nidn' => $request->nidn,
    //         'telp' => $request->telp,
    //         'alamat' => $request->alamat,
    //         'jeniskelamin' => $request->jeniskelamin,
    //         'prodi' => $request->prodi,
    //         'foto' => $filename,
    //         // 'anggota' => json_encode($request->anggota),
    //     ]);

    //     foreach ($request->anggota as $anggota) {
    //         anggotap3mModel::create([
    //             'p3m_model_id' => $penelitian->id,
    //             'nama' => $anggota['nama'],
    //             'prodi' => $anggota['prodi'],
    //             'jabatan' => $anggota['jabatan'],
    //         ]);
    //     }

    //     // dd($request->all());
    //     return redirect()->route('dosen.upp3m')->with('success', 'Data berhasil disimpan!');
    // }

    //tambah ajuan pengabdian
    public function storep3m(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => 'required',
            'uppdf' => 'required|mimes:pdf|max:20480',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK,AB,AP',
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

            //untuk user login yang up this data
            // 'user_id' => auth()->user()->id,
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        //proses up pdf
        $uppdf = $request->file('uppdf');
        $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
        $pathpdf = 'uppdf/' . $filenamepdf;
        Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

        $penelitian = p3mModel::create([
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'biaya' => $request->biaya,
            'uppdf' => $filenamepdf,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,

        ]);

        foreach ($request->anggota as $anggota) {
            // dd($anggota);
            anggotap3mModel::create([
                'ajupengab_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }

        return redirect()->route('dosen.upp3m')->with('success', 'Data berhasil disimpan!');
    }

    //EDIT AJUAN PENGABDIAN

    public function editp3m($id)
    {
        $user = Auth::user();
        $pagetitle = 'Proposal Pengabdian Masyarakat';
        // $categories = M_categories::all();
        $penelitian = p3mModel::with('anggotap3m')->findOrFail($id);
        $anggota = anggotap3mModel::where('ajupengab_model_id', $id)->get();

        return view('dosen.edit_ajupengab', compact('user', 'pagetitle', 'penelitian', 'anggota'));
    }
    public function updatep3m(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'biaya' => 'required',
            'uppdf' => 'nullable|mimes:pdf|max:20480',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK,AB,AP',
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

            //untuk user login yang up this data
            // 'user_id' => auth()->user()->id,
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $penelitian = p3mModel::findOrFail($id);

        $data = [
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'biaya' => $request->biaya,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,
        ];


        if ($request->hasFile('uppdf')) {
            $uppdf = $request->file('uppdf');
            $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
            $pathpdf = 'uppdf/' . $filenamepdf;

            Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

            // Hapus PDF lama jika ada
            if ($penelitian->uppdf) {
                Storage::disk('public')->delete('uppdf/' . $penelitian->uppdf);
            }

            $data['uppdf'] = $filenamepdf;
        } else {
            $filenamepdf = $request->old_uppdf; // pakai file lama
        }

        // Update penelitian
        $penelitian->update($data);

        if ($request->filled('anggota_dihapus')) {
            $idsToDelete = explode(',', $request->anggota_dihapus);
            anggotap3mModel::whereIn('id', $idsToDelete)->delete();
        }
        // Update anggota
        anggotap3mModel::where('ajupengab_model_id', $id)->delete();
        foreach ($request->anggota as $anggota) {
            anggotap3mModel::create([
                'ajupengab_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }

        return redirect()->route('dosen.upp3m')->with('success', 'Data berhasil diperbarui!');
    }
    //TAMBAH  KUMPULAN PENGABDIAN
    public function kpengabdianp3m()
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Pengabdian Masyarakat';
        $penelitians = kum_pengabdianModel::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with('anggotap3m')
            ->get();
        return view('dosen.dash_kpengabdian', compact('user', 'pagetitle', 'penelitians'));
    }
    public function addkumpulanp3m()
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Pengabdian Masyarakat';
        return view('dosen.add_kpengabdian', compact('user', 'pagetitle'));
    }
    public function storekumpulanp3m(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => 'required',
            'uppdf' => 'required|mimes:pdf|max:20480',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK, AB, AP',
            //untuk up gambar
            'foto' => 'required|mimes:png,jpg,jpeg|max:2048',
            //anggota
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

        ]);
        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        //proses up data 
        $image = $request->file('foto');
        $filename = date('d-m-Y') . $image->getClientOriginalName();
        $path = 'photo-upp3m/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($image));

        //proses up pdf
        $uppdf = $request->file('uppdf');
        $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
        $pathpdf = 'uppdf/' . $filenamepdf;
        Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

        $penelitian = kum_pengabdianModel::create([
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'biaya' => $request->biaya,
            'uppdf' => $filenamepdf,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,
            //untuk up gambar
            'foto' => $filename,
        ]);
        // dd($request->all());
        //input anggota
        foreach ($request->anggota as $anggota) {
            // dd($anggota);
            anggotap3mModel::create([
                'kpengab_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }
        return redirect()->route('dosen.dash_kpengabdian')->with('success', 'Data berhasil disimpan!');
    }

    //EDIT KUMPULAN PENGABDIAN
    public function editkumpulanp3m($id)
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Pengabdian Masyarakat';
        $penelitian = kum_pengabdianModel::findOrFail($id);
        $anggota = anggotap3mModel::where('kpengab_model_id', $id)->get();

        return view('dosen.edit_kpengabdian', compact('user', 'pagetitle', 'penelitian', 'anggota'));
    }
    public function updatekumpulanp3m(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => 'required',
            'uppdf' => 'nullable|mimes:pdf|max:20480',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK,AB,AP',
            //untuk up gambar
            'foto' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            //anggota
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

        ]);
        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $penelitian = kum_pengabdianModel::findOrFail($id);

        $data = [
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'biaya' => $request->biaya,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,
            //untuk up gambar

        ];

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = date('d-m-Y') . $image->getClientOriginalName();
            $path = 'photo-upp3m/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($image));

            // Hapus gambar lama jika ada
            if ($penelitian->foto) {
                Storage::disk('public')->delete('photo-upp3m/' . $penelitian->foto);
            }

            $data['foto'] = $filename;
        } elseif ($request->hasFile('uppdf')) {

            $uppdf = $request->file('uppdf');
            $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
            $pathpdf = 'uppdf/' . $filenamepdf;

            Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

            // Hapus PDF lama jika ada
            if ($penelitian->uppdf) {
                Storage::disk('public')->delete('uppdf/' . $penelitian->uppdf);
            }

            $data['uppdf'] = $filenamepdf;
        } else {
            $filenamepdf = $request->old_foto; // pakai file lama
            $filenamepdf = $request->old_uppdf; // pakai file lama
        }


        // Update penelitian
        $penelitian->update($data);

        // Update anggota
        anggotap3mModel::where('kpengab_model_id', $id)->delete();
        foreach ($request->anggota as $anggota) {
            anggotap3mModel::create([
                'kpengab_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }

        return redirect()->route('dosen.dash_kpengabdian')->with('success', 'Data berhasil disimpan!');
    }

    //TAMBAH AJUAN PENELITIAN
    public function tambahpenelitian()
    {
        $user = Auth::user();
        $pagetitle = 'Proposal Penelitian';
        // $categories = ajuan_penelitianModel::all();
        return view('dosen.add_ajuanpenelitian', compact('user', 'pagetitle'));
    }
    public function storepenelitian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => 'required',
            'uppdf' => 'required|mimes:pdf|max:20480',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK,AB,AP',
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

            //untuk user login yang up this data
            // 'user_id' => auth()->user()->id,
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        //proses up pdf
        $uppdf = $request->file('uppdf');
        $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
        $pathpdf = 'uppdf/' . $filenamepdf;
        Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

        $penelitian = ajuan_penelitianModel::create([
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'biaya' => $request->biaya,
            'uppdf' => $filenamepdf,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,

        ]);
        // dd($request->all());
        foreach ($request->anggota as $anggota) {
            // dd($anggota);
            anggotap3mModel::create([
                'ajupenel_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }

        return redirect()->route('dosen.dash_ajuanpenelitian')->with('success', 'Data berhasil disimpan!');
    }

    //EDIT AJUAN PENELITIAN
    public function editpenelitian($id)
    {
        $user = Auth::user();
        $pagetitle = 'Pengajuan Penelitian';
        // $categories = M_categories::all();
        $penelitian = ajuan_penelitianModel::findOrFail($id);
        $anggota = anggotap3mModel::where('ajupenel_model_id', $id)->get();

        return view('dosen.edit_ajuanpenelitian', compact('user', 'pagetitle', 'penelitian', 'anggota'));
    }
    public function updatepenelitian(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => 'required',
            'uppdf' => 'nullable|mimes:pdf|max:20480',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK,AB,AP',
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

            //untuk user login yang up this data
            // 'user_id' => auth()->user()->id,
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $penelitian = ajuan_penelitianModel::findOrFail($id);

        $data = [
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'biaya' => $request->biaya,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,
        ];


        if ($request->hasFile('uppdf')) {
            $uppdf = $request->file('uppdf');
            $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
            $pathpdf = 'uppdf/' . $filenamepdf;

            Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

            // Hapus PDF lama jika ada
            if ($penelitian->uppdf) {
                Storage::disk('public')->delete('uppdf/' . $penelitian->uppdf);
            }

            $data['uppdf'] = $filenamepdf;
        } else {
            $filenamepdf = $request->old_uppdf; // pakai file lama
        }

        // Update penelitian
        $penelitian->update($data);

        if ($request->filled('anggota_dihapus')) {
            $idsToDelete = explode(',', $request->anggota_dihapus);
            anggotap3mModel::whereIn('id', $idsToDelete)->delete();
        }
        // Update anggota
        anggotap3mModel::where('ajupenel_model_id', $id)->delete();
        foreach ($request->anggota as $anggota) {
            anggotap3mModel::create([
                'ajupenel_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }
        return redirect()->route('dosen.dash_ajuanpenelitian')->with('success', 'Data berhasil diperbarui!');
    }

    //TAMBAH KUMPULAN PENELITIAN
    public function tambahkumpulanpenelitian()
    {
        $user = Auth::user();
        $pagetitle = 'Tambah Laporan Penelitian';
        return view('dosen.add_kumpeneliti', compact('user', 'pagetitle'));
    }
    public function storekumpulanpenelitian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => 'required',
            'uppdf' => 'required|mimes:pdf|max:20480',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK,AB,AP',
            //untuk up gambar
            'foto' => 'required|mimes:png,jpg,jpeg|max:2048',
            //anggota
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

        ]);
        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        //proses up data 
        $image = $request->file('foto');
        $filename = date('d-m-Y') . $image->getClientOriginalName();
        $path = 'photo-upp3m/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($image));

        //proses up pdf
        $uppdf = $request->file('uppdf');
        $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
        $pathpdf = 'uppdf/' . $filenamepdf;
        Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

        $penelitian = kum_penelitianModel::create([
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'uppdf' => $filenamepdf,
            'biaya' => $request->biaya,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,
            //untuk up gambar
            'foto' => $filename,
        ]);
        // dd($request->anggota);
        //input anggota
        foreach ($request->anggota as $anggota) {
            // dd($anggota);
            anggotap3mModel::create([
                'kpenel_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }
        return redirect()->route('dosen.dash_kpenelitian')->with('success', 'Data berhasil disimpan!');
    }
    //EDIT KUMPULAN PENELITIAN
    public function editkumpulanpenelitian($id)
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Penelitian';
        $penelitian = kum_penelitianModel::findOrFail($id);
        $anggota = anggotap3mModel::where('kpenel_model_id', $id)->get();

        return view('dosen.edit_kpenliti', compact('user', 'pagetitle', 'penelitian', 'anggota'));
    }
    public function updatekumpulanpenelitian(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => 'required',
            'uppdf' => 'nullable|mimes:pdf|max:20480',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            //untuk profil
            'ketua' => 'required',
            'jabatan' => 'required|in:DR,LT,KP,DS',
            'nidn' => 'required',
            'telp' => 'required',
            'alamat' => 'required',
            'jeniskelamin' => 'required|in:L,P',
            'prodi' => 'required|in:R,A,AK,AB,AP',
            //untuk up gambar
            'foto' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            //anggota
            'anggota' => 'required|array',
            'anggota.*.nama' => 'required|string|max:100',
            'anggota.*.nim' => 'nullable|string|max:100',
            'anggota.*.prodi' => [
                'nullable',
                Rule::in(['R', 'A', 'AK', 'AB', 'AP'])
            ],
            'anggota.*.jabatan' => [
                'nullable',
                Rule::in(['DR', 'LT', 'KP', 'DS', 'MHS'])
            ],
        ], [], [
            'anggota.0.nama' => 'nama'

        ]);
        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $penelitian = kum_penelitianModel::findOrFail($id);

        $data = [
            //untuk user login yang up this data
            'user_id' => auth()->user()->id,
            //untuk data
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'jeniskategori' => $request->jeniskategori,
            'lokasi' => $request->lokasi,
            'lamapenelitian' => $request->lamapenelitian,
            'biaya' => $request->biaya,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            //untuk profil
            'ketua' => $request->ketua,
            'jabatan' => $request->jabatan,
            'nidn' => $request->nidn,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'jeniskelamin' => $request->jeniskelamin,
            'prodi' => $request->prodi,
            //untuk up gambar

        ];

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = date('d-m-Y') . $image->getClientOriginalName();
            $path = 'photo-upp3m/' . $filename;

            Storage::disk('public')->put($path, file_get_contents($image));

            // Hapus gambar lama jika ada
            if ($penelitian->foto) {
                Storage::disk('public')->delete('photo-upp3m/' . $penelitian->foto);
            }

            $data['foto'] = $filename;
        } else {
            $filenamepdf = $request->old_foto; // pakai file lama
        }

        if ($request->hasFile('uppdf')) {
            $uppdf = $request->file('uppdf');
            $filenamepdf = date('d-m-Y') . $uppdf->getClientOriginalName();
            $pathpdf = 'uppdf/' . $filenamepdf;

            Storage::disk('public')->put($pathpdf, file_get_contents($uppdf));

            // Hapus PDF lama jika ada
            if ($penelitian->uppdf) {
                Storage::disk('public')->delete('uppdf/' . $penelitian->uppdf);
            }

            $data['uppdf'] = $filenamepdf;
        } else {
            $filenamepdf = $request->old_uppdf; // pakai file lama
        }

        // Update penelitian
        $penelitian->update($data);

        // Update anggota
        anggotap3mModel::where('kpenel_model_id', $id)->delete();
        foreach ($request->anggota as $anggota) {
            anggotap3mModel::create([
                'kpenel_model_id' => $penelitian->id,
                'nama' => $anggota['nama'],
                'nim' => $anggota['nim'],
                'prodi' => $anggota['prodi'],
                'jabatan' => $anggota['jabatan'],
            ]);
        }

        return redirect()->route('dosen.dash_kpenelitian')->with('success', 'Data berhasil disimpan!');
    }

    /* detail */
    public function dajupengab($id)
    {
        $user = Auth::user();
        $pagetitle = 'Pengabdian Masyarakat';
        $data = p3mModel::with('anggotap3m')->findOrFail($id);

        return view('detail.detail', [
            'penelitians' => $data,
            'type' => 'penelitian',
            'user' => $user,
            'pagetitle' => $pagetitle
        ]);
    }

    public function dajupeneliti($tipe, $id)
    {
        $user = Auth::user();
        $pagetitle = 'Detail Data Proposal';
        // $tipe = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        switch ($tipe) {
            case 'ajupengab':
                $data = p3mModel::with('anggotap3m')->findOrFail($id);
                break;
            case 'ajupenel':
                $data = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
                break;
            default:
                abort(404);
        }

        return view('detail.detail', [
            'penelitians' => $data,
            'type' => 'penelitian',
            'user' => $user,
            'pagetitle' => $pagetitle
        ]);
    }

    public function kumpengneli($tipe, $id)
    {
        $user = Auth::user();
        $pagetitle = 'Detail Data Laporan';
        // $tipe = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
        switch ($tipe) {
            case 'kpengeabdian':
                $data = kum_pengabdianModel::with('anggotap3m')->findOrFail($id);
                break;
            case 'kpeneliti':
                $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
                break;

            default:
                abort(404);
        }

        return view('detail.detailk', [
            'penelitians' => $data,
            'type' => 'penelitian',
            'user' => $user,
            'pagetitle' => $pagetitle
        ]);
    }

    public function kpengab($id)
    {
        $user = Auth::user();
        $pagetitle = 'Pengabdian Masyarakat';
        $penelitians = p3mModel::with('anggotap3m')->findOrFail($id);

        return view('detail.detail', [
            'penelitians' => $penelitians,
            'user' => $user,
            'pagetitle' => $pagetitle,
            'type' => 'pengabdian'
        ]);
    }

    public function kteliti($id)
    {
        $user = Auth::user();
        $pagetitle = 'Pengabdian Masyarakat';
        $penelitians = p3mModel::with('anggotap3m')->findOrFail($id);

        return view('detail.detail', [
            'penelitians' => $penelitians,
            'user' => $user,
            'pagetitle' => $pagetitle,
            'type' => 'pengabdian'
        ]);
    }


    //hapus proposal pengabdian
    public function deletep3m($id)
    {
        $data = p3mModel::with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file PDF kalau ada
        if ($data->uppdf && Storage::disk('public')->exists('uppdf/' . $data->uppdf)) {
            Storage::disk('public')->delete('uppdf/' . $data->uppdf);
        }

        // Hapus foto kalau ada
        if ($data->foto && Storage::disk('public')->exists('photo-upp3m/' . $data->foto)) {
            Storage::disk('public')->delete('photo-upp3m/' . $data->foto);
        }

        // Hapus relasi anggotanya
        $data->anggotap3m()->delete();

        // Hapus data utama
        $data->delete();

        return redirect()->route('dosen.upp3m')->with('success', 'Data dan file terkait berhasil dihapus!');
    }

    //hapus proposal penelitian
    public function deletepropen($id)
    {
        $data = ajuan_penelitianModel::with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file PDF kalau ada
        if ($data->uppdf && Storage::disk('public')->exists('uppdf/' . $data->uppdf)) {
            Storage::disk('public')->delete('uppdf/' . $data->uppdf);
        }

        // Hapus foto kalau ada
        if ($data->foto && Storage::disk('public')->exists('photo-upp3m/' . $data->foto)) {
            Storage::disk('public')->delete('photo-upp3m/' . $data->foto);
        }

        // Hapus relasi anggotanya
        $data->anggotap3m()->delete();

        // Hapus data utama
        $data->delete();

        return redirect()->route('dosen.dash_ajuanpenelitian')->with('success', 'Data dan file terkait berhasil dihapus!');
    }

    //hapus kumpulan pengabdian
    public function deletekpeng($id)
    {
        $data = kum_pengabdianModel::with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file PDF kalau ada
        if ($data->uppdf && Storage::disk('public')->exists('uppdf/' . $data->uppdf)) {
            Storage::disk('public')->delete('uppdf/' . $data->uppdf);
        }

        // Hapus foto kalau ada
        if ($data->foto && Storage::disk('public')->exists('photo-upp3m/' . $data->foto)) {
            Storage::disk('public')->delete('photo-upp3m/' . $data->foto);
        }

        // Hapus relasi anggotanya
        $data->anggotap3m()->delete();

        // Hapus data utama
        $data->delete();

        return redirect()->route('dosen.dash_kpengabdian')->with('success', 'Data dan file terkait berhasil dihapus!');
    }

    //hapus kumpulan penelitian
    public function deletekpen($id)
    {
        $data = kum_penelitianModel::with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file PDF kalau ada
        if ($data->uppdf && Storage::disk('public')->exists('uppdf/' . $data->uppdf)) {
            Storage::disk('public')->delete('uppdf/' . $data->uppdf);
        }

        // Hapus foto kalau ada
        if ($data->foto && Storage::disk('public')->exists('photo-upp3m/' . $data->foto)) {
            Storage::disk('public')->delete('photo-upp3m/' . $data->foto);
        }

        // Hapus relasi anggotanya
        $data->anggotap3m()->delete();

        // Hapus data utama
        $data->delete();

        return redirect()->route('dosen.dash_kpenelitian')->with('success', 'Data dan file terkait berhasil dihapus!');
    }

    //LOGOUT
    public function logout()
    {
        // dd('oke');
        Auth::logout();
        return redirect()->route('tampilan');
    }
}
