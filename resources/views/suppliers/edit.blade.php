@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('content')
<div class="header">
    <h1>✏️ Edit Supplier</h1>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Perusahaan <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
            @error('name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Nama PIC <span style="color:red">*</span></label>
            <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name', $supplier->contact_name) }}" required>
            @error('contact_name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Nomor Telepon <span style="color:red">*</span></label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}" required>
            @error('phone')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Alamat <span style="color:red">*</span></label>
            <textarea name="address" class="form-control" rows="3" required>{{ old('address', $supplier->address) }}</textarea>
            @error('address')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Supplier</button>
    </form>
</div>
@endsection
