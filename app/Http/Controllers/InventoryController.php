<?php
namespace App\Http\Controllers;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Http\Requests\StoreInventoryRequest;

class InventoryController extends Controller
{
    public function index() {
        $inventories = Inventory::with('supplier')->orderBy('item_name')->get();
        return view('inventories.index', compact('inventories'));
    }
    public function create() {
        $suppliers = Supplier::all();
        return view('inventories.create', compact('suppliers'));
    }
    public function store(StoreInventoryRequest $request) {
        Inventory::create($request->validated());
        return redirect()->route('inventories.index')->with('success', 'Bahan baku berhasil ditambahkan.');
    }
    public function edit(Inventory $inventory) {
        $suppliers = Supplier::all();
        return view('inventories.edit', compact('inventory', 'suppliers'));
    }
    public function update(StoreInventoryRequest $request, Inventory $inventory) {
        $inventory->update($request->validated());
        return redirect()->route('inventories.index')->with('success', 'Data bahan baku berhasil diperbarui.');
    }
    public function destroy(Inventory $inventory) {
        $inventory->delete();
        return redirect()->route('inventories.index')->with('success', 'Bahan baku berhasil dihapus.');
    }
}