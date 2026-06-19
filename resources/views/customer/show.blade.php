@extends('layouts.app')
@section('title', 'Detail Pelanggan - RestoUAS')
@section('content')
<div class="header">
    <h1> Detail Pelanggan</h1>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <p style="margin-bottom:12px"><strong>Nama:</strong> {{ $customer->name }}</p>
    <p style="margin-bottom:12px"><strong>No Telepon:</strong> {{ $customer->phone ?? '-' }}</p>
    <p style="margin-bottom:24px"><strong>Bergabung:</strong> {{ $customer->created_at->format('d F Y') }}</p>
    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">Ubah Data</a>
</div>
@endsection