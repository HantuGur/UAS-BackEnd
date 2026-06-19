@extends('layouts.app')
@section('title', 'Edit Cabang')
@section('content')
<div class="header">
    <h1>✏️ Edit Cabang</h1>
    <a href="{{ route('branches.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:500px;">
    <form action="{{ route('branches.update', $branch) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Cabang <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $branch->name) }}" required>
        </div>
        <div class="form-group">
            <label>Nomor Telepon <span style="color:red">*</span></label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $branch->phone) }}" required>
        </div>
        <div class="form-group">
            <label>Alamat Lengkap <span style="color:red">*</span></label>
            <textarea name="address" class="form-control" rows="3" required>{{ old('address', $branch->address) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Cabang</button>
    </form>
</div>
@endsection
