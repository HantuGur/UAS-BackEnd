@extends('layouts.app')
@section('title', 'Tambah Pelanggan - RestoUAS')
@section('content')
<div class="header">
    <h1>Tambah Pelanggan Baru</h1>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>

<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                placeholder="Masukkan nama pelanggan"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                placeholder="Masukkan email pelanggan"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <div class="error-message">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            Simpan Pelanggan
        </button>
    </form>
</div>
@endsection