<?php

namespace App\Http\Controllers;

use App\Models\m_dashboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class MainController extends Controller
{
    public function index()
    {
        $dash = m_dashboard::all();
        $user = Auth::user();
        View::share('dash', $dash);
        // dd($dash);
        return view('dashadmin', ['dash' => $dash], compact('dash', 'user'));
        // }
        return abort(403);
    }

    public function dashadmin()
    {
        // $dash = m_dashboard::all();
        $user = Auth::user();
        // View::share('dash');
        // dd($dash);
        return view('dashadmin', compact('user'));
        // }
        return abort(403);
    }

    public function create_dash()
    {
        $user = Auth::user();
        return view('dashboard.createdash', compact('user'));
    }
    public function buat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg,webp,gif|max:5120',
            'title' => 'required',
            'instansi' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // dd($request->all());
        $image = $request->file('image');
        $imageService = app(\App\Services\ImageService::class);
        $filename = $imageService->processAndStore($image, 'photo-dash');
        $user = Auth::user();

        $data['title']      = $request->title;
        $data['instansi']       = $request->instansi;
        $data['image']      = $filename;

        // dd($data);

        m_dashboard::create($data);

        return redirect()->route('dash.dashboard', compact('user'));
    }
    public function edit_dash(Request $request, $id)
    {
        $data = m_dashboard::findOrFail($id);
        $user = Auth::user();
        return view('dashboard.editdash', compact('user', 'data'));
    }
    public function up_dash(Request $request, $id)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'instansi'      => 'required',
            'image'     => 'nullable|mimes:png,jpg,jpeg,webp,gif|max:5120',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $find = m_dashboard::findOrFail($id);

        $data['title']          = $request->title;
        $data['instansi']       = $request->instansi;
        $user = Auth::user();

        $image = $request->file('image');

        if ($image) {
            $imageService = app(\App\Services\ImageService::class);
            $filename = $imageService->processAndStore($image, 'photo-dash');

            if ($find->image) {
                Storage::disk('public')->delete('photo-dash/' . $find->image);
            }

            $data['image'] = $filename;
        }
        $find->update($data);

        return redirect()->route('dash.dashboard', compact('user'));
    }
}
