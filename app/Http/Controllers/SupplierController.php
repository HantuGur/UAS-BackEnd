<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;

class SupplierController extends Controller
{
    // Menampilkan daftar semua supplier
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    // Form tambah supplier baru
    public function create()
    {
        return view('suppliers.create');
    }

    // Simpan supplier baru ke database
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();
        $data['phone'] = $data['phone'] ?? '-';
        $data['address'] = $data['address'] ?? '-';
        $data['contact_name'] = $data['contact_name'] ?? '-';
        Supplier::create($data);
        return redirect()->route('suppliers.index')->with('success', 'Supplier baru berhasil didaftarkan.');
    }

    // Form edit supplier
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    // Update data supplier di database
    public function update(StoreSupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();
        $data['phone'] = $data['phone'] ?? '-';
        $data['address'] = $data['address'] ?? '-';
        $data['contact_name'] = $data['contact_name'] ?? '-';
        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success', 'Data supplier berhasil diperbarui.');
    }

    // Hapus supplier dari sistem
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}