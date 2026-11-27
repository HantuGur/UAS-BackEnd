@extends('layouts.customer')
@section('title', 'Masuk / Daftar Pelanggan - Resto 3D')
@section('content')

<div class="card" style="max-width: 420px; margin: 60px auto; border: 1px solid var(--border-color); padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
    <div style="text-align: center; margin-bottom: 28px;">
        <h2 style="font-size: 22px; font-weight: 800; color: var(--navy-primary);">Masuk Pelanggan</h2>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Gunakan nama dan email Anda untuk memesan makanan/minuman.</p>
    </div>

    <form action="{{ route('customer.login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name" style="font-weight: 600;">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama Anda..." required value="{{ old('name') }}">
            @error('name') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label for="email" style="font-weight: 600;">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Contoh: pelanggan@email.com" required value="{{ old('email') }}">
            @error('email') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-navy" style="width: 100%; padding: 12px; font-size: 15px; border-radius: 4px; margin-top: 24px;">
            Masuk / Daftar Sekarang
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 24px; border-top: 1px solid var(--border-color); padding-top: 16px; display: flex; flex-direction: column; gap: 12px;">
        <span style="font-size: 12px; color: var(--text-muted);">Belum punya akun? Akun baru otomatis dibuat menggunakan email Anda saat masuk.</span>
        <a href="{{ route('customer.shop') }}" style="color: var(--text-color); font-size: 13px; text-decoration: none; font-weight: 600; margin-top: 8px; border: 1px solid var(--border-color); padding: 8px; border-radius: 4px; display: inline-block;">← Kembali ke Beranda</a>
        <a href="{{ route('admin.login') }}" style="color: var(--navy-primary); font-size: 13px; text-decoration: none; font-weight: 600; margin-top: 8px;">🔑 Masuk Sebagai Staf / Admin</a>
    </div>
</div>

@endsection