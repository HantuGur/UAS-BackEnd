@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('content')
<div class="page-header"><h1 class="page-title">+ Tambah Kategori Baru</h1><a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a></div>
<div class="card" style="max-width:500px;">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group"><label>Nama Kategori</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="form-group"><label>Deskripsi (Opsional)</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
    </form>
</div>
@endsection