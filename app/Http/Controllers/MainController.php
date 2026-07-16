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
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
            'title' => 'required',
            'instansi' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // dd($request->all());
        $image = $request->file('image');
        $filename = date('Y-m-d') . $image->getClientOriginalName();
        $path = 'photo-dash/' . $filename;
        $user = Auth::user();

        Storage::disk('public')->put($path, file_get_contents($image));

        $data['title']      = $request->title;
        $data['instansi']       = $request->instansi;
        $data['image']      = $filename;

        // dd($data);

        m_dashboard::create($data);

        return redirect()->route('dash.dashboard', compact('user'));
    }
    public function edit_dash(Request $request, $id)
    {
        $data = m_dashboard::find($id);
        $user = Auth::user();
        return view('dashboard.editdash', compact('user', 'data'));
    }
    public function up_dash(Request $request, $id)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'title'     => 'required',
            'instansi'      => 'required',
            'image'     => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $find = m_dashboard::find($id);

        $data['title']          = $request->title;
        $data['instansi']       = $request->instansi;
        $user = Auth::user();

        $image = $request->file('image');

        if ($image) {

            $filename = date('Y-m-d') . $image->getClientOriginalName();
            $path = 'photo-dash/' . $filename;

            if ($find->image) {

                // $image->storeAs('public/photo-user/', $image->hashName());
                Storage::disk('public')->delete('photo-dash/' . $find->image);
            }

            Storage::disk('public')->put($path, file_get_contents($image));

            $data['image'] = $filename;
        }
        $find->update($data);

        return redirect()->route('dash.dashboard', compact('user'));
    }
}
