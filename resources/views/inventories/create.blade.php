@extends('layouts.app')
@section('title', 'Tambah Bahan Baku')
@section('content')
<div class="header">
    <h1>➕ Tambah Bahan Baku</h1>
    <a href="{{ route('inventories.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:500px;">
    <form action="{{ route('inventories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Bahan Baku <span style="color:red">*</span></label>
            <input type="text" name="item_name" class="form-control" placeholder="cth: Tepung Terigu, Gula Pasir" value="{{ old('item_name') }}" required>
            @error('item_name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Jumlah Stok <span style="color:red">*</span></label>
            <input type="number" name="stock_quantity" class="form-control" min="0" placeholder="0" value="{{ old('stock_quantity') }}" required>
            @error('stock_quantity')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Satuan <span style="color:red">*</span></label>
            <input type="text" name="unit" class="form-control" placeholder="cth: kg, liter, pcs, karung" value="{{ old('unit') }}" required>
            @error('unit')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Supplier <span style="color:red">*</span></label>
            <select name="supplier_id" class="form-control" required>
                <option value="">-- Pilih Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
            @error('supplier_id')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Bahan Baku</button>
    </form>
</div>
@endsection
