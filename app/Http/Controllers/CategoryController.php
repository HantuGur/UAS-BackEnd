<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar semua kategori menu beserta jumlah menunya
    public function index()
    {
        $categories = Category::withCount('menus')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    // Form tambah kategori baru
    public function create()
    {
        return view('categories.create');
    }

    // Simpan kategori baru ke database
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    // Form edit kategori yang sudah ada
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update data kategori di database
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // Hapus kategori dari database
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}