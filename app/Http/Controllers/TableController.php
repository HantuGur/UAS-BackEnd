<?php
namespace App\Http\Controllers;
use App\Models\Table;
use App\Http\Requests\StoreTableRequest;

class TableController extends Controller
{
    public function index() {
        $tables = Table::orderBy('table_number')->get();
        $available = $tables->where('status', 'available')->count();
        $occupied  = $tables->where('status', 'occupied')->count();
        return view('tables.index', compact('tables', 'available', 'occupied'));
    }
    public function create() { return view('tables.create'); }
    public function store(StoreTableRequest $request) {
        Table::create($request->validated());
        return redirect()->route('tables.index')->with('success', 'Meja baru berhasil ditambahkan.');
    }
    public function edit(Table $table) { return view('tables.edit', compact('table')); }
    public function update(StoreTableRequest $request, Table $table) {
        $table->update($request->validated());
        return redirect()->route('tables.index')->with('success', 'Data meja berhasil diperbarui.');
    }
    public function destroy(Table $table) {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}
