@extends('layouts.app')
@section('title', 'Edit Bahan Baku')
@section('content')
<div class="header">
    <h1>✏️ Edit Bahan Baku</h1>
    <a href="{{ route('inventories.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:500px;">
    <form action="{{ route('inventories.update', $inventory) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Bahan Baku <span style="color:red">*</span></label>
            <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $inventory->item_name) }}" required>
        </div>
        <div class="form-group">
            <label>Jumlah Stok <span style="color:red">*</span></label>
            <input type="number" name="stock_quantity" class="form-control" min="0" value="{{ old('stock_quantity', $inventory->stock_quantity) }}" required>
        </div>
        <div class="form-group">
            <label>Satuan <span style="color:red">*</span></label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit', $inventory->unit) }}" required>
        </div>
        <div class="form-group">
            <label>Supplier <span style="color:red">*</span></label>
            <select name="supplier_id" class="form-control" required>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $inventory->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Bahan Baku</button>
    </form>
</div>
@endsection
