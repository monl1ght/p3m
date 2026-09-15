<?php

namespace App\Http\Controllers;

use App\Models\ajuan_penelitianModel;
use App\Models\anggotap3mModel;
use App\Models\kum_penelitianModel;
use App\Models\kum_pengabdianModel;
use App\Models\M_categories;
use App\Models\p3mModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\UploadedFile;

class DosenController extends Controller
{
    public function dash(Request $request)
    {
        $user = Auth::user();
        $data = $user;

        return view('dosen.dash', compact('user', 'data'));
    }
    //PROFIL DOSEN 
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        abort_unless((int) $id === (int) $user->id, 403);

        $data = $user;

        $layout = $request->get('layout') ?? (($user->role === 'admin') ? 'layout.main' : 'layout.doslayout');

        return view('dosen.profildos', compact('data', 'user', 'layout'));
    }

    public function edit(Request $request, $id)
    {
        $find = User::findOrFail($id);
        abort_unless($find->is($request->user()), 403);

        $validator = Validator::make($request->all(), [
            'email'         => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($find)],
            'name'          => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($find)],
            'password'      => 'nullable|string|min:8',
            'image'         => 'nullable|mimes:png,jpg,jpeg,webp|max:5120',
            'image_base64'  => 'nullable|string',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['email'] = $request->email;
        $data['name']  = $request->name;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $imageBase64 = $request->input('image_base64');
        $imageFile   = $request->file('image');

        if ($imageBase64) {
            $imageService = app(\App\Services\ImageService::class);
            $filename = $imageService->storeBase64($imageBase64, 'photo-user');

            if ($find->image) {
                Storage::disk('public')->delete('photo-user/' . $find->image);
            }
            $data['image'] = $filename;

        } elseif ($imageFile) {
            $imageService = app(\App\Services\ImageService::class);
            $filename = $imageService->processAndStore($imageFile, 'photo-user');

            if ($find->image) {
                Storage::disk('public')->delete('photo-user/' . $find->image);
            }
            $data['image'] = $filename;
        }

        $find->update($data);

        $routeParams = ['id' => Auth::id()];
        if ($request->filled('layout')) {
            $routeParams['layout'] = $request->input('layout');
        }

        return redirect()->route('dosen.profil', $routeParams)
            ->with('success', 'Profil akun berhasil diperbarui!');
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

    public function ajuanpeneliti(Request $request)
    {
        $pagetitle = 'Proposal Penelitian Masyarakat';
        $user = Auth::user();
        $data = $user;
        $penelitians = ajuan_penelitianModel::where('user_id', $user->id)
            // ->orWhereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->with('anggotap3m')
            ->get();
        // dd($penelitians);
        return view('dosen.dash_ajuanpenelitian', compact('user', 'data', 'penelitians', 'pagetitle'));
    }

    public function kpeneliti(Request $request)
    {
        $pagetitle = 'Laporan Penelitian Masyarakat';
        $user = Auth::user();
        $data = $user;
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
        $uploadCacheService = app(\App\Services\SubmissionUploadCacheService::class);
        $cachedUploads = $uploadCacheService->captureCachedUploads($request, Auth::id());
        $hasCachedPdf = !empty($cachedUploads['cached_uppdf']);

        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => ['required', 'numeric', 'min:0'],
            'uppdf' => $hasCachedPdf ? 'nullable|mimes:pdf|max:20480' : 'required|mimes:pdf|max:20480',
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
        ], [
            'uppdf.required' => 'Dokumen proposal pengabdian wajib diunggah.',
            'uppdf.mimes' => 'Dokumen proposal pengabdian harus berupa file PDF.',
            'uppdf.max' => 'Ukuran proposal pengabdian maksimal 20 MB.',
        ], [
            'uppdf' => 'proposal pengabdian',
            'anggota.0.nama' => 'nama'
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput(array_merge($request->all(), [
                    'cached_uppdf' => $cachedUploads['cached_uppdf'],
                    'cached_uppdf_name' => $cachedUploads['cached_uppdf_name'],
                ]))
                ->with('cached_uppdf', $cachedUploads['cached_uppdf'])
                ->with('cached_uppdf_name', $cachedUploads['cached_uppdf_name'])
                ->withErrors($validator);
        }

        $filenamepdf = null;

        try {
            $filenamepdf = $uploadCacheService->resolveFinalPdf(
                $request,
                $cachedUploads['cached_uppdf'],
                fn($file) => $this->storeSubmissionPdf($file)
            );
            $uploadCacheService->cleanUserTempFiles(Auth::id());

            $this->createSubmissionWithMembers(p3mModel::class, [
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'bidang' => $request->bidang,
                'jeniskategori' => $request->jeniskategori,
                'lokasi' => $request->lokasi,
                'lamapenelitian' => $request->lamapenelitian,
                'biaya' => $request->biaya,
                'uppdf' => $filenamepdf,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'ketua' => $request->ketua,
                'jabatan' => $request->jabatan,
                'nidn' => $request->nidn,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'jeniskelamin' => $request->jeniskelamin,
                'prodi' => $request->prodi,
            ], 'ajupengab_model_id', $request->anggota);
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($filenamepdf);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal disimpan. Silakan coba kembali.');
        }

        return redirect()->route('dosen.upp3m')->with('success', 'Data berhasil disimpan!');
    }

    //EDIT AJUAN PENGABDIAN

    public function editp3m($id)
    {
        $user = Auth::user();
        $pagetitle = 'Proposal Pengabdian Masyarakat';
        // $categories = M_categories::all();
        $penelitian = p3mModel::where('user_id', Auth::id())
            ->with('anggotap3m')
            ->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);
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
            'biaya' => ['required', 'numeric', 'min:0'],
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

        $penelitian = p3mModel::where('user_id', Auth::id())->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);

        $data = [
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


        $oldPdfFilename = $penelitian->uppdf;
        $newPdfFilename = null;

        try {
            if ($request->hasFile('uppdf')) {
                $newPdfFilename = $this->storeSubmissionPdf($request->file('uppdf'));
                $data['uppdf'] = $newPdfFilename;
            }

            $this->updateSubmissionWithMembers(
                $penelitian,
                $data,
                'ajupengab_model_id',
                $request->anggota
            );
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($newPdfFilename);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal diperbarui. Silakan coba kembali.');
        }

        $this->deleteReplacedSubmissionFiles($oldPdfFilename, $newPdfFilename);

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
        $uploadCacheService = app(\App\Services\SubmissionUploadCacheService::class);
        $cachedUploads = $uploadCacheService->captureCachedUploads($request, Auth::id());
        $hasCachedPdf = !empty($cachedUploads['cached_uppdf']);
        $hasCachedPhoto = !empty($cachedUploads['cached_foto']);

        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => ['required', 'numeric', 'min:0'],
            'uppdf' => $hasCachedPdf ? 'nullable|mimes:pdf|max:20480' : 'required|mimes:pdf|max:20480',
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
            'foto' => $hasCachedPhoto ? 'nullable|mimes:png,jpg,jpeg|max:2048' : 'required|mimes:png,jpg,jpeg|max:2048',
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
        ], [
            'uppdf.required' => 'Laporan pengabdian wajib diunggah.',
            'uppdf.mimes' => 'Laporan pengabdian harus berupa file PDF.',
            'uppdf.max' => 'Ukuran laporan pengabdian maksimal 20 MB.',
            'foto.required' => 'Foto kegiatan wajib diunggah.',
            'foto.mimes' => 'Foto kegiatan harus berupa PNG, JPG, atau JPEG.',
            'foto.max' => 'Ukuran foto kegiatan maksimal 2 MB.',
        ], [
            'uppdf' => 'laporan pengabdian',
            'foto' => 'foto kegiatan',
            'anggota.0.nama' => 'nama'
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput(array_merge($request->all(), [
                    'cached_uppdf' => $cachedUploads['cached_uppdf'],
                    'cached_uppdf_name' => $cachedUploads['cached_uppdf_name'],
                    'cached_foto' => $cachedUploads['cached_foto'],
                    'cached_foto_name' => $cachedUploads['cached_foto_name'],
                ]))
                ->with('cached_uppdf', $cachedUploads['cached_uppdf'])
                ->with('cached_uppdf_name', $cachedUploads['cached_uppdf_name'])
                ->with('cached_foto', $cachedUploads['cached_foto'])
                ->with('cached_foto_name', $cachedUploads['cached_foto_name'])
                ->withErrors($validator);
        }

        $filenamepdf = null;
        $filenamephoto = null;

        try {
            $filenamephoto = $uploadCacheService->resolveFinalPhoto(
                $request,
                $cachedUploads['cached_foto'],
                fn($file) => $this->storeSubmissionPhoto($file)
            );
            $filenamepdf = $uploadCacheService->resolveFinalPdf(
                $request,
                $cachedUploads['cached_uppdf'],
                fn($file) => $this->storeSubmissionPdf($file)
            );
            $uploadCacheService->cleanUserTempFiles(Auth::id());

            $this->createSubmissionWithMembers(kum_pengabdianModel::class, [
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'bidang' => $request->bidang,
                'jeniskategori' => $request->jeniskategori,
                'lokasi' => $request->lokasi,
                'lamapenelitian' => $request->lamapenelitian,
                'biaya' => $request->biaya,
                'uppdf' => $filenamepdf,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'ketua' => $request->ketua,
                'jabatan' => $request->jabatan,
                'nidn' => $request->nidn,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'jeniskelamin' => $request->jeniskelamin,
                'prodi' => $request->prodi,
                'foto' => $filenamephoto,
            ], 'kpengab_model_id', $request->anggota);
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($filenamepdf, $filenamephoto);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal disimpan. Silakan coba kembali.');
        }

        return redirect()->route('dosen.dash_kpengabdian')->with('success', 'Data berhasil disimpan!');
    }

    //EDIT KUMPULAN PENGABDIAN
    public function editkumpulanp3m($id)
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Pengabdian Masyarakat';
        $penelitian = kum_pengabdianModel::where('user_id', Auth::id())->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);
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
            'biaya' => ['required', 'numeric', 'min:0'],
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

        $penelitian = kum_pengabdianModel::where('user_id', Auth::id())->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);

        $data = [
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

        $oldPdfFilename = $penelitian->uppdf;
        $oldPhotoFilename = $penelitian->foto;
        $newPdfFilename = null;
        $newPhotoFilename = null;

        try {
            if ($request->hasFile('foto')) {
                $newPhotoFilename = $this->storeSubmissionPhoto($request->file('foto'));
                $data['foto'] = $newPhotoFilename;
            }

            if ($request->hasFile('uppdf')) {
                $newPdfFilename = $this->storeSubmissionPdf($request->file('uppdf'));
                $data['uppdf'] = $newPdfFilename;
            }

            $this->updateSubmissionWithMembers(
                $penelitian,
                $data,
                'kpengab_model_id',
                $request->anggota
            );
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($newPdfFilename, $newPhotoFilename);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal diperbarui. Silakan coba kembali.');
        }

        $this->deleteReplacedSubmissionFiles(
            $oldPdfFilename,
            $newPdfFilename,
            $oldPhotoFilename,
            $newPhotoFilename
        );

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
        $uploadCacheService = app(\App\Services\SubmissionUploadCacheService::class);
        $cachedUploads = $uploadCacheService->captureCachedUploads($request, Auth::id());
        $hasCachedPdf = !empty($cachedUploads['cached_uppdf']);

        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => ['required', 'numeric', 'min:0'],
            'uppdf' => $hasCachedPdf ? 'nullable|mimes:pdf|max:20480' : 'required|mimes:pdf|max:20480',
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
        ], [
            'uppdf.required' => 'Dokumen proposal penelitian wajib diunggah.',
            'uppdf.mimes' => 'Dokumen proposal penelitian harus berupa file PDF.',
            'uppdf.max' => 'Ukuran proposal penelitian maksimal 20 MB.',
        ], [
            'uppdf' => 'proposal penelitian',
            'anggota.0.nama' => 'nama'
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) {
            return redirect()->back()
                ->withInput(array_merge($request->all(), [
                    'cached_uppdf' => $cachedUploads['cached_uppdf'],
                    'cached_uppdf_name' => $cachedUploads['cached_uppdf_name'],
                ]))
                ->with('cached_uppdf', $cachedUploads['cached_uppdf'])
                ->with('cached_uppdf_name', $cachedUploads['cached_uppdf_name'])
                ->withErrors($validator);
        }

        $filenamepdf = null;

        try {
            $filenamepdf = $uploadCacheService->resolveFinalPdf(
                $request,
                $cachedUploads['cached_uppdf'],
                fn($file) => $this->storeSubmissionPdf($file)
            );
            $uploadCacheService->cleanUserTempFiles(Auth::id());

            $this->createSubmissionWithMembers(ajuan_penelitianModel::class, [
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'bidang' => $request->bidang,
                'jeniskategori' => $request->jeniskategori,
                'lokasi' => $request->lokasi,
                'lamapenelitian' => $request->lamapenelitian,
                'biaya' => $request->biaya,
                'uppdf' => $filenamepdf,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'ketua' => $request->ketua,
                'jabatan' => $request->jabatan,
                'nidn' => $request->nidn,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'jeniskelamin' => $request->jeniskelamin,
                'prodi' => $request->prodi,
            ], 'ajupenel_model_id', $request->anggota);
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($filenamepdf);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal disimpan. Silakan coba kembali.');
        }

        return redirect()->route('dosen.dash_ajuanpenelitian')->with('success', 'Data berhasil disimpan!');
    }

    //EDIT AJUAN PENELITIAN
    public function editpenelitian($id)
    {
        $user = Auth::user();
        $pagetitle = 'Pengajuan Penelitian';
        // $categories = M_categories::all();
        $penelitian = ajuan_penelitianModel::where('user_id', Auth::id())->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);
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
            'biaya' => ['required', 'numeric', 'min:0'],
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

        $penelitian = ajuan_penelitianModel::where('user_id', Auth::id())->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);

        $data = [
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


        $oldPdfFilename = $penelitian->uppdf;
        $newPdfFilename = null;

        try {
            if ($request->hasFile('uppdf')) {
                $newPdfFilename = $this->storeSubmissionPdf($request->file('uppdf'));
                $data['uppdf'] = $newPdfFilename;
            }

            $this->updateSubmissionWithMembers(
                $penelitian,
                $data,
                'ajupenel_model_id',
                $request->anggota
            );
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($newPdfFilename);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal diperbarui. Silakan coba kembali.');
        }

        $this->deleteReplacedSubmissionFiles($oldPdfFilename, $newPdfFilename);
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
        $uploadCacheService = app(\App\Services\SubmissionUploadCacheService::class);
        $cachedUploads = $uploadCacheService->captureCachedUploads($request, Auth::id());
        $hasCachedPdf = !empty($cachedUploads['cached_uppdf']);
        $hasCachedPhoto = !empty($cachedUploads['cached_foto']);

        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'bidang' => 'required',
            'jeniskategori' => 'required',
            'lokasi' => 'required',
            'lamapenelitian' => 'nullable',
            'biaya' => ['required', 'numeric', 'min:0'],

            // Laporan penelitian: PDF wajib, maksimal 5 MB.
            // 5120 KB = 5 MB.
            'uppdf' => $hasCachedPdf ? 'nullable|mimes:pdf|max:5120' : 'required|mimes:pdf|max:5120',

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
            'foto' => $hasCachedPhoto ? 'nullable|mimes:png,jpg,jpeg|max:2048' : 'required|mimes:png,jpg,jpeg|max:2048',
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
        ], [
            'uppdf.required' => 'Laporan penelitian wajib diunggah.',
            'uppdf.mimes' => 'Laporan penelitian harus berupa file PDF.',
            'uppdf.max' => 'Ukuran laporan penelitian maksimal 5 MB.',
            'foto.required' => 'Foto kegiatan wajib diunggah.',
            'foto.mimes' => 'Foto kegiatan harus berupa PNG, JPG, atau JPEG.',
            'foto.max' => 'Ukuran foto kegiatan maksimal 2 MB.',
        ], [
            'uppdf' => 'laporan penelitian',
            'foto' => 'foto kegiatan',
            'anggota.0.nama' => 'nama',
        ]);

        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput(array_merge($request->all(), [
                    'cached_uppdf' => $cachedUploads['cached_uppdf'],
                    'cached_uppdf_name' => $cachedUploads['cached_uppdf_name'],
                    'cached_foto' => $cachedUploads['cached_foto'],
                    'cached_foto_name' => $cachedUploads['cached_foto_name'],
                ]))
                ->with('cached_uppdf', $cachedUploads['cached_uppdf'])
                ->with('cached_uppdf_name', $cachedUploads['cached_uppdf_name'])
                ->with('cached_foto', $cachedUploads['cached_foto'])
                ->with('cached_foto_name', $cachedUploads['cached_foto_name'])
                ->withErrors($validator);
        }

        $filenamepdf = null;
        $filenamephoto = null;

        try {
            $filenamephoto = $uploadCacheService->resolveFinalPhoto(
                $request,
                $cachedUploads['cached_foto'],
                fn($file) => $this->storeSubmissionPhoto($file)
            );
            $filenamepdf = $uploadCacheService->resolveFinalPdf(
                $request,
                $cachedUploads['cached_uppdf'],
                fn($file) => $this->storeSubmissionPdf($file)
            );
            $uploadCacheService->cleanUserTempFiles(Auth::id());

            $this->createSubmissionWithMembers(kum_penelitianModel::class, [
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'bidang' => $request->bidang,
                'jeniskategori' => $request->jeniskategori,
                'lokasi' => $request->lokasi,
                'lamapenelitian' => $request->lamapenelitian,
                'uppdf' => $filenamepdf,
                'biaya' => $request->biaya,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'ketua' => $request->ketua,
                'jabatan' => $request->jabatan,
                'nidn' => $request->nidn,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'jeniskelamin' => $request->jeniskelamin,
                'prodi' => $request->prodi,
                'foto' => $filenamephoto,
            ], 'kpenel_model_id', $request->anggota);
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($filenamepdf, $filenamephoto);
            report($exception);

            return back()->withInput()->with('error', 'Data gagal disimpan. Silakan coba kembali.');
        }

        return redirect()->route('dosen.dash_kpenelitian')->with('success', 'Data berhasil disimpan!');
    }
    //EDIT KUMPULAN PENELITIAN
    public function editkumpulanpenelitian($id)
    {
        $user = Auth::user();
        $pagetitle = 'Laporan Penelitian';
        $penelitian = kum_penelitianModel::where('user_id', Auth::id())->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);
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
            'biaya' => ['required', 'numeric', 'min:0'],

            // Laporan penelitian: PDF opsional saat edit, maksimal 5 MB.
            // File lama tetap dipertahankan bila tidak ada upload baru.
            'uppdf' => 'nullable|mimes:pdf|max:5120',

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
        ], [
            'uppdf.mimes' => 'Laporan penelitian harus berupa file PDF.',
            'uppdf.max' => 'Ukuran laporan penelitian maksimal 5 MB.',
            'foto.mimes' => 'Foto harus berupa PNG, JPG, atau JPEG.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ], [
            'uppdf' => 'laporan penelitian',
            'foto' => 'foto',
            'anggota.0.nama' => 'nama',
        ]);
        foreach ($validator->errors()->getMessages() as $key => $messages) {
            if (Str::startsWith($key, 'anggota.') && Str::endsWith($key, '.nama')) {
                $validator->errors()->add('nama', $messages[0]);
            }
        }
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $penelitian = kum_penelitianModel::where('user_id', Auth::id())->findOrFail($id);
        $this->ensureSubmissionIsEditable($penelitian);

        $data = [
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

        $oldPdfFilename = $penelitian->uppdf;
        $oldPhotoFilename = $penelitian->foto;
        $newPdfFilename = null;
        $newPhotoFilename = null;

        try {
            if ($request->hasFile('foto')) {
                $newPhotoFilename = $this->storeSubmissionPhoto($request->file('foto'));
                $data['foto'] = $newPhotoFilename;
            }

            if ($request->hasFile('uppdf')) {
                $newPdfFilename = $this->storeSubmissionPdf($request->file('uppdf'));
                $data['uppdf'] = $newPdfFilename;
            }

            $this->updateSubmissionWithMembers($penelitian, $data, 'kpenel_model_id', $request->anggota);
        } catch (\Throwable $exception) {
            $this->discardNewSubmissionFiles($newPdfFilename, $newPhotoFilename);
            report($exception);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Data laporan penelitian tidak dapat diperbarui. Silakan coba lagi.');
        }

        $this->deleteReplacedSubmissionFiles(
            $oldPdfFilename,
            $newPdfFilename,
            $oldPhotoFilename,
            $newPhotoFilename
        );

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
            'documentType' => 'proposal-pengabdian',
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
                $documentType = 'proposal-pengabdian';
                break;
            case 'ajupenel':
                $data = ajuan_penelitianModel::with('anggotap3m')->findOrFail($id);
                $documentType = 'proposal-penelitian';
                break;
            default:
                abort(404);
        }

        return view('detail.detail', [
            'penelitians' => $data,
            'type' => 'penelitian',
            'documentType' => $documentType,
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
                $documentType = 'laporan-pengabdian';
                break;
            case 'kpeneliti':
                $data = kum_penelitianModel::with('anggotap3m')->findOrFail($id);
                $documentType = 'laporan-penelitian';
                break;

            default:
                abort(404);
        }

        return view('detail.detailk', [
            'penelitians' => $data,
            'type' => 'penelitian',
            'documentType' => $documentType,
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
        \Log::info('Delete p3m called with ID: ' . $id);
        $data = p3mModel::where('user_id', Auth::id())->with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        $this->ensureSubmissionIsEditable($data);

        $this->deleteSubmissionPdf($data->uppdf);

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
        \Log::info('Delete propen called with ID: ' . $id);
        $data = ajuan_penelitianModel::where('user_id', Auth::id())->with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        $this->ensureSubmissionIsEditable($data);

        $this->deleteSubmissionPdf($data->uppdf);

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
        $data = kum_pengabdianModel::where('user_id', Auth::id())->with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        $this->ensureSubmissionIsEditable($data);

        $this->deleteSubmissionPdf($data->uppdf);

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
        $data = kum_penelitianModel::where('user_id', Auth::id())->with('anggotap3m')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
        $this->ensureSubmissionIsEditable($data);

        $this->deleteSubmissionPdf($data->uppdf);

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

    private function storeSubmissionPdf(UploadedFile $file): string
    {
        $filename = Str::uuid()->toString().'.pdf';
        $stored = Storage::disk('private')->putFileAs('submissions', $file, $filename);

        if ($stored === false) {
            throw new \RuntimeException('PDF tidak dapat disimpan.');
        }

        return $filename;
    }

    private function storeSubmissionPhoto(UploadedFile $file): string
    {
        $imageService = app(\App\Services\ImageService::class);
        return $imageService->processAndStore($file, 'photo-upp3m');
    }

    private function deleteSubmissionPdf(?string $filename): void
    {
        if (! $filename) {
            return;
        }

        $privatePath = 'submissions/'.$filename;
        if (Storage::disk('private')->exists($privatePath)) {
            Storage::disk('private')->delete($privatePath);

            return;
        }

        Storage::disk('public')->delete('uppdf/'.$filename);
    }

    private function deleteSubmissionPhoto(?string $filename): void
    {
        if ($filename) {
            Storage::disk('public')->delete('photo-upp3m/'.$filename);
        }
    }

    private function createSubmissionWithMembers(
        string $modelClass,
        array $data,
        string $memberForeignKey,
        array $members
    ): void {
        DB::transaction(function () use ($modelClass, $data, $memberForeignKey, $members) {
            $submission = $modelClass::create($data);
            $this->replaceSubmissionMembers($submission->id, $memberForeignKey, $members);
        });
    }

    private function updateSubmissionWithMembers(
        Model $submission,
        array $data,
        string $memberForeignKey,
        array $members
    ): void {
        DB::transaction(function () use ($submission, $data, $memberForeignKey, $members) {
            $submission->update($data);
            anggotap3mModel::where($memberForeignKey, $submission->id)->delete();
            $this->replaceSubmissionMembers($submission->id, $memberForeignKey, $members);
        });
    }

    private function replaceSubmissionMembers(int $submissionId, string $memberForeignKey, array $members): void
    {
        foreach ($members as $member) {
            anggotap3mModel::create([
                $memberForeignKey => $submissionId,
                'nama' => $member['nama'],
                'nim' => $member['nim'] ?? null,
                'prodi' => $member['prodi'] ?? null,
                'jabatan' => $member['jabatan'] ?? null,
            ]);
        }
    }

    private function discardNewSubmissionFiles(?string $pdfFilename, ?string $photoFilename = null): void
    {
        if ($pdfFilename) {
            Storage::disk('private')->delete('submissions/'.$pdfFilename);
        }

        $this->deleteSubmissionPhoto($photoFilename);
    }

    private function deleteReplacedSubmissionFiles(
        ?string $oldPdfFilename,
        ?string $newPdfFilename,
        ?string $oldPhotoFilename = null,
        ?string $newPhotoFilename = null
    ): void {
        try {
            if ($newPdfFilename) {
                $this->deleteSubmissionPdf($oldPdfFilename);
            }

            if ($newPhotoFilename) {
                $this->deleteSubmissionPhoto($oldPhotoFilename);
            }
        } catch (\Throwable $exception) {
            report($exception);
        }
    }

    private function ensureSubmissionIsEditable(Model $submission): void
    {
        abort_if(
            $submission->status === 'approve',
            403,
            'Data yang sudah disetujui tidak dapat diubah atau dihapus.'
        );
    }
}
