<?php
namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;

class SupplierController extends Controller
{
    public function index() {
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }
    public function create() { return view('suppliers.create'); }
    public function store(StoreSupplierRequest $request) {
        Supplier::create($request->validated());
        return redirect()->route('suppliers.index')->with('success', 'Supplier baru berhasil didaftarkan.');
    }
    public function edit(Supplier $supplier) { return view('suppliers.edit', compact('supplier')); }
    public function update(StoreSupplierRequest $request, Supplier $supplier) {
        $supplier->update($request->validated());
        return redirect()->route('suppliers.index')->with('success', 'Data supplier berhasil diperbarui.');
    }
    public function destroy(Supplier $supplier) {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}