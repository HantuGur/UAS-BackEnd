@extends('layouts.app')
@section('title', 'Tambah Cabang')
@section('content')
<div class="header">
    <h1>➕ Tambah Cabang Baru</h1>
    <a href="{{ route('branches.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:500px;">
    <form action="{{ route('branches.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Cabang <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="cth: Cabang Sudirman, Outlet Kemang" value="{{ old('name') }}" required>
            @error('name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Nomor Telepon <span style="color:red">*</span></label>
            <input type="text" name="phone" class="form-control" placeholder="021-xxxx-xxxx" value="{{ old('phone') }}" required>
            @error('phone')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Alamat Lengkap <span style="color:red">*</span></label>
            <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap cabang..." required>{{ old('address') }}</textarea>
            @error('address')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Cabang</button>
    </form>
</div>
@endsection
