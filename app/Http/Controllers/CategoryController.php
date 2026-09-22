<?php

namespace App\Http\Controllers;

use App\Models\M_categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = M_categories::withCount('news')->get();
        $pagetitle = 'Kategori Berita';
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
        $input = $request->all();
        $input['slug'] = Str::slug($request->slug ?: $request->name);

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:m_categories,slug',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'slug.required' => 'Slug kategori wajib diisi.',
            'slug.unique' => 'Slug kategori sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'create_category');
        }

        $data['name'] = $request->name;
        $data['slug'] = $input['slug'];

        M_categories::create($data);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
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
        $find = M_categories::findOrFail($id);
        $input = $request->all();
        $input['slug'] = Str::slug($request->slug ?: $request->name);

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('m_categories', 'slug')->ignore($find->id)],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'slug.required' => 'Slug kategori wajib diisi.',
            'slug.unique' => 'Slug kategori sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('form_context', 'edit_category_' . $id);
        }

        $data['name'] = $request->name;
        $data['slug'] = $input['slug'];

        $find->update($data);
        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function delete($id)
    {
        $category = M_categories::findOrFail($id);
        $newsCount = $category->news()->count();

        if ($newsCount > 0) {
            return redirect()->route('category.index')->with('error', "Kategori '{$category->name}' tidak dapat dihapus karena masih digunakan oleh {$newsCount} berita.");
        }

        $category->delete();
        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
