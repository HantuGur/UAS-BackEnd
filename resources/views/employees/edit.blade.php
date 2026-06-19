@extends('layouts.app')
@section('title', 'Edit Karyawan')
@section('content')
<div class="header">
    <h1>✏️ Edit Karyawan</h1>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('employees.update', $employee) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Lengkap <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
        </div>
        <div class="form-group">
            <label>Jabatan <span style="color:red">*</span></label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role', $employee->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="cashier" {{ old('role', $employee->role) == 'cashier' ? 'selected' : '' }}>Kasir</option>
                <option value="kitchen" {{ old('role', $employee->role) == 'kitchen' ? 'selected' : '' }}>Dapur</option>
                <option value="waiter" {{ old('role', $employee->role) == 'waiter' ? 'selected' : '' }}>Pelayan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nomor Telepon <span style="color:#94a3b8">(Opsional)</span></label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
        </div>
        <div class="form-group">
            <label>Cabang</label>
            <select name="branch_id" class="form-control">
                <option value="">-- Kantor Pusat --</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id', $employee->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        </div>
        <hr style="margin: 20px 0; border-color:#e5e7eb;">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $employee->username) }}">
        </div>
        <div class="form-group">
            <label>Password Baru (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control" placeholder="minimal 6 karakter">
        </div>
        <button type="submit" class="btn btn-primary">Update Karyawan</button>
    </form>
</div>
@endsection
