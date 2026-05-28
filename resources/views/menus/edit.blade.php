@extends('layouts.app')
@section('title', 'Ubah Menu - RestoUAS')
@section('content')
<div class="header">
<h1> Ubah Data Menu</h1>
<a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
</div>
<div class="card" style="max-width:600px">
<form method="POST" action="{{ route('menus.update', $menu) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Nama Menu</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $menu->name) }}" required>
        @error('name') <div class="error-message">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="price">Harga (Rupiah)</label>
        <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $menu->price) }}" required>
        @error('price') <div class="error-message">{{ $message }}</div> @enderror
    </div>
    <div class="form-group">
        <label for="category">Kategori</label>
        <select id="category" name="category" class="form-control">
            <option value="makanan" {{ old('category', $menu->category) === 'makanan' ? 'selected' : '' }}>Makanan</option>
            <option value="minuman" {{ old('category', $menu->category) === 'minuman' ? 'selected' : '' }}>Minuman</option>
            <option value="lainnya" {{ old('category', $menu->category) === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Update Menu</button>
</form>
</div>
@endsection