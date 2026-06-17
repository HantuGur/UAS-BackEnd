@extends('layouts.app')
@section('title', 'Tambah Menu - RestoUAS')
@section('content')
<div class="header">
    <h1> Tambah Menu Baru</h1>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('menus.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nama Menu</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Nasi Goreng Spesial" value="{{ old('name') }}" required>
            @error('name') <div class="error-message">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="price">Harga (Rupiah)</label>
            <input type="number" id="price" name="price" class="form-control" placeholder="Contoh: 25000" value="{{ old('price') }}" required>
            @error('price') <div class="error-message">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="category">Kategori</label>
            <select id="category" name="category" class="form-control">
                @forelse($categories as $cat)
                    <option value="{{ $cat->name }}" {{ old('category') === $cat->name ? 'selected' : '' }}>{{ ucfirst($cat->name) }}</option>
                @empty
                    <option value="makanan" {{ old('category') === 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('category') === 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="dessert" {{ old('category') === 'dessert' ? 'selected' : '' }}>Dessert</option>
                @endforelse
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Menu</button>
    </form>
</div>
@endsection