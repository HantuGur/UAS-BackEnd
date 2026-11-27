@extends('layouts.app')
@section('title', 'Edit Meja')
@section('content')
<div class="header">
    <h1>✏️ Edit Meja {{ $table->table_number }}</h1>
    <a href="{{ route('tables.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:500px;">
    <form action="{{ route('tables.update', $table) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nomor / Kode Meja <span style="color:red">*</span></label>
            <input type="text" name="table_number" class="form-control" value="{{ old('table_number', $table->table_number) }}" required>
            @error('table_number')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Kapasitas Tamu <span style="color:red">*</span></label>
            <input type="number" name="capacity" class="form-control" min="1" value="{{ old('capacity', $table->capacity) }}" required>
            @error('capacity')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Status <span style="color:red">*</span></label>
            <select name="status" class="form-control" required>
                <option value="available" {{ old('status', $table->status) == 'available' ? 'selected' : '' }}>✅ Tersedia</option>
                <option value="occupied" {{ old('status', $table->status) == 'occupied' ? 'selected' : '' }}>🔴 Terpakai</option>
            </select>
            @error('status')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Meja</button>
    </form>
</div>
@endsection
