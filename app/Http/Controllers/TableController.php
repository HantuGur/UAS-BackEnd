<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Requests\StoreTableRequest;

class TableController extends Controller
{
    // Menampilkan semua meja dan statusnya
    public function index()
    {
        $tables = Table::orderBy('table_number')->get();
        return view('tables.index', compact('tables'));
    }

    // Form tambah meja baru
    public function create()
    {
        return view('tables.create');
    }

    // Simpan meja baru ke database
    public function store(StoreTableRequest $request)
    {
        Table::create($request->validated());
        return redirect()->route('tables.index')->with('success', 'Meja baru berhasil ditambahkan.');
    }

    // Form edit data meja
    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    // Update status atau data meja
    public function update(StoreTableRequest $request, Table $table)
    {
        $table->update($request->validated());
        return redirect()->route('tables.index')->with('success', 'Data meja berhasil diperbarui.');
    }

    // Hapus meja dari sistem
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}
