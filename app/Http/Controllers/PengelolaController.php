<?php

namespace App\Http\Controllers;

use App\Models\M_Pengelola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PengelolaController extends Controller
{
    public function index(Request $request)
    {
        $query = M_Pengelola::query();

        if ($request->get('search')) {
            $search = $request->get('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama_pengelola', 'like', '%' . $search . '%')
                    ->orWhere('NIDN', 'like', '%' . $search . '%')
                    ->orWhere('jabatan_pengelola', 'like', '%' . $search . '%')
                    ->orWhere('email_pengelola', 'like', '%' . $search . '%');
            });
        }

        $pengelola = $query->get();
        $pagetitle = 'Pengelola P3M';
        $user = Auth::user();

        return view('pengelola.index', compact('pengelola', 'request', 'pagetitle', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $pagetitle = 'Tambah Pengelola P3M';

        return view('pengelola.create', compact('pagetitle', 'user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image'              => 'nullable|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'image_base64'       => 'nullable|string',
            'nama_pengelola'     => 'required|unique:m__pengelolas,nama_pengelola',
            'jabatan_pengelola'  => 'required',
            'email_pengelola'    => 'required|email',
            'NIDN'               => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'create_pengelola');
        }

        $image = $request->file('image');
        $imageBase64 = $request->input('image_base64');
        $imageService = app(\App\Services\ImageService::class);
        
        if ($imageBase64) {
            $filename = $imageService->storeBase64($imageBase64, 'photo-pengelola');
        } else if ($image) {
            $filename = $imageService->processAndStore($image, 'photo-pengelola');
        } else {
            return redirect()->back()->withInput()->withErrors(['image' => 'Foto pengelola wajib diisi.'])->with('form_context', 'create_pengelola');
        }

        $data['nama_pengelola']     = $request->nama_pengelola;
        $data['jabatan_pengelola']  = $request->jabatan_pengelola;
        $data['email_pengelola']    = $request->email_pengelola;
        $data['image']              = $filename;
        $data['NIDN']               = $request->NIDN;

        M_Pengelola::create($data);

        return redirect()
            ->route('pengelola.index')
            ->with('success', 'Data pengelola berhasil ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $pengelola = M_Pengelola::findOrFail($id);
        $pagetitle = 'Edit Data Pengelola P3M';

        return view('pengelola.update', compact('pengelola', 'pagetitle', 'user'));
    }

    public function update(Request $request, $id)
    {
        $find = M_Pengelola::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'image'              => 'nullable|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'image_base64'       => 'nullable|string',
            'nama_pengelola'     => 'required',
            'jabatan_pengelola'  => 'required',
            'email_pengelola'    => 'required|email',
            'NIDN'               => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'edit_pengelola_' . $id);
        }

        $data['nama_pengelola']     = $request->nama_pengelola;
        $data['jabatan_pengelola']  = $request->jabatan_pengelola;
        $data['email_pengelola']    = $request->email_pengelola;
        $data['NIDN']               = $request->NIDN;

        $image = $request->file('image');
        $imageBase64 = $request->input('image_base64');

        if ($imageBase64 || $image) {
            $imageService = app(\App\Services\ImageService::class);
            
            if ($imageBase64) {
                $filename = $imageService->storeBase64($imageBase64, 'photo-pengelola');
            } else {
                $filename = $imageService->processAndStore($image, 'photo-pengelola');
            }

            if ($find->image) {
                Storage::disk('public')->delete('photo-pengelola/' . $find->image);
            }

            $data['image'] = $filename;
        }

        $find->update($data);

        return redirect()
            ->route('pengelola.index')
            ->with('success', 'Data pengelola berhasil diperbarui!');
    }

    public function delete(Request $request, $id)
    {
        $data = M_Pengelola::findOrFail($id);

        if ($data->image) {
            Storage::disk('public')->delete('photo-pengelola/' . $data->image);
        }

        $data->delete();

        return redirect()
            ->route('pengelola.index')
            ->with('success', 'Data pengelola berhasil dihapus!');
    }
}
