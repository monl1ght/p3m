<?php

namespace App\Http\Controllers;

use App\Models\M_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = M_categories::all();
        $pagetitle = 'Kategory Berita';
        return view('category.index', compact('categories', 'pagetitle', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $pagetitle = 'Buat Kategori';
        return view('category.create', compact('pagetitle', 'user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        // dd($request->all());

        $data['name']      = $request->name;
        $data['slug']       = $request->slug;

        M_categories::create($data);

        return redirect()->route('category.index');
    }

    public function edit(Request $request, $id)
    {
        $user = Auth::user();
        $category = M_categories::findOrFail($id);
        $pagetitle = 'Edit Kategori';
        return view('category.edit', compact('category', 'pagetitle', 'user'));
    }

    public function ubah(Request $request, $id)
    {
        $find = M_categories::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
        ]);
        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['name'] = $request->name;
        $data['slug'] = $request->slug;

        $find->update($data);
        return redirect()->route('category.index');
    }
}
