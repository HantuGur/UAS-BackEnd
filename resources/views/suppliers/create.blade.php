@extends('layouts.app')
@section('title', 'Tambah Supplier')
@section('content')
<div class="header">
    <h1>➕ Tambah Supplier Baru</h1>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Perusahaan <span style="color:red">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="cth: PT. Segar Selalu" value="{{ old('name') }}" required>
            @error('name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Nama PIC (Person in Charge) <span style="color:red">*</span></label>
            <input type="text" name="contact_name" class="form-control" placeholder="Nama penanggung jawab" value="{{ old('contact_name') }}" required>
            @error('contact_name')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Nomor Telepon <span style="color:red">*</span></label>
            <input type="text" name="phone" class="form-control" placeholder="08xx-xxxx-xxxx" value="{{ old('phone') }}" required>
            @error('phone')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Alamat <span style="color:red">*</span></label>
            <textarea name="address" class="form-control" rows="3" placeholder="Alamat lengkap supplier" required>{{ old('address') }}</textarea>
            @error('address')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan Supplier</button>
    </form>
</div>
@endsection
