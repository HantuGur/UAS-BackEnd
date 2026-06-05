<?php
namespace App\Http\Controllers;
use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;

class BranchController extends Controller
{
    public function index() {
        $branches = Branch::latest()->get();
        return view('branches.index', compact('branches'));
    }
    public function create() { return view('branches.create'); }
    public function store(StoreBranchRequest $request) {
        Branch::create($request->validated());
        return redirect()->route('branches.index')->with('success', 'Cabang baru berhasil ditambahkan.');
    }
    public function edit(Branch $branch) { return view('branches.edit', compact('branch')); }
    public function update(StoreBranchRequest $request, Branch $branch) {
        $branch->update($request->validated());
        return redirect()->route('branches.index')->with('success', 'Data cabang berhasil diperbarui.');
    }
    public function destroy(Branch $branch) {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Cabang berhasil dihapus.');
    }
}