@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
<div class="header">
    <h1>✏️ Edit Kategori</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Kategori <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            @error('name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Deskripsi (Opsional)</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Kategori</button>
    </form>
</div>
@endsection
