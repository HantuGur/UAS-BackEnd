@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')
<div class="header">
    <h1>➕ Tambah Kategori Baru</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Kategori <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="cth: Makanan, Minuman, Dessert" value="{{ old('name') }}" required>
            @error('name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Deskripsi (Opsional)</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
    </form>
</div>
@endsection
