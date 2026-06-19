<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;

class BranchController extends Controller
{
    // Menampilkan daftar semua cabang restoran
    public function index()
    {
        $branches = Branch::latest()->get();
        return view('branches.index', compact('branches'));
    }

    // Form tambah cabang baru
    public function create()
    {
        return view('branches.create');
    }

    // Simpan cabang baru ke database
    public function store(StoreBranchRequest $request)
    {
        Branch::create($request->validated());
        return redirect()->route('branches.index')->with('success', 'Cabang baru berhasil ditambahkan.');
    }

    // Form edit cabang
    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    // Update data cabang
    public function update(StoreBranchRequest $request, Branch $branch)
    {
        $branch->update($request->validated());
        return redirect()->route('branches.index')->with('success', 'Data cabang berhasil diperbarui.');
    }

    // Hapus cabang
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Cabang berhasil dihapus.');
    }
}