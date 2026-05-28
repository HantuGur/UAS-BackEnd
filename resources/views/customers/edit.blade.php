@extends('layouts.app')
@section('title', 'Ubah Data Pelanggan - RestoUAS')
@section('content')
<div class="header">
    <h1> Ubah Data Pelanggan</h1>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('customers.update', $customer) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $customer->name) }}" required>
            @error('name') <div class="error-message">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
            @error('phone') <div class="error-message">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-success">Update Pelanggan</button>
    </form>
</div>
@endsection