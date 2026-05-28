@extends('layouts.app')
@section('title', 'Detail Menu - RestoUAS')
@section('content')
<div class="header">
    <h1> Detail Menu</h1>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <p style="margin-bottom:12px"><strong>Nama Menu:</strong> {{ $menu->name }}</p>
    <p style="margin-bottom:12px"><strong>Kategori:</strong> {{ ucfirst($menu->category ?? '-') }}</p>
    <p style="margin-bottom:24px"><strong>Harga:</strong> Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
    <a href="{{ route('menus.edit', $menu) }}" class="btn btn-primary">Ubah Data</a>
</div>
@endsection