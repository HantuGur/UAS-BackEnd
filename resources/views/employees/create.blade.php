@extends('layouts.app')
@section('title', 'Tambah Karyawan')
@section('content')
<div class="header">
    <h1>➕ Tambah Karyawan Baru</h1>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Nama karyawan" value="{{ old('name') }}" required>
            @error('name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Jabatan <span style="color:red">*</span></label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Kasir</option>
                <option value="kitchen" {{ old('role') == 'kitchen' ? 'selected' : '' }}>Dapur</option>
                <option value="waiter" {{ old('role') == 'waiter' ? 'selected' : '' }}>Pelayan</option>
            </select>
            @error('role')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Nomor Telepon <span style="color:#94a3b8">(Opsional)</span></label>
            <input type="text" name="phone" class="form-control" placeholder="08xx-xxxx-xxxx" value="{{ old('phone') }}">
            @error('phone')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Cabang</label>
            <select name="branch_id" class="form-control">
                <option value="">-- Kantor Pusat --</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <hr style="margin: 20px 0; border-color:#e5e7eb;">
        <p style="font-size:13px; color:#6b7280; margin-bottom:16px;">Isi username & password di bawah jika karyawan ini akan mendapat akses login admin.</p>
        <div class="form-group">
            <label>Username (Opsional)</label>
            <input type="text" name="username" class="form-control" placeholder="username untuk login..." value="{{ old('username') }}">
            @error('username')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Password (Opsional)</label>
            <input type="password" name="password" class="form-control" placeholder="minimal 6 karakter">
            @error('password')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Karyawan</button>
    </form>
</div>
@endsection
