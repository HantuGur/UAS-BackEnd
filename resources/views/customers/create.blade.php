@extends('layouts.app')
@section('title', 'Tambah Pelanggan - RestoUAS')
@section('content')
<div class="header">
    <h1> Tambah Pelanggan Baru</h1>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama pelanggan" value="{{ old('name') }}" required>
            @error('name') <div class="error-message">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-control" placeholder="Nomor telepon (opsional)" value="{{ old('phone') }}">
            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
    </form>
</div>
@endsection