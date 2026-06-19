@extends('layouts.app')
@section('title', 'Daftar Pelanggan - RestoUAS')
@section('content')
<div class="header">
    <h1> Daftar Pelanggan</h1>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">+ Tambah Pelanggan Baru</a>
</div>
<div class="card">
    @if ($customers->isEmpty())
        <p style="color: var(--text-muted); text-align: center; padding: 20px;">Belum ada data pelanggan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:60px;text-align:center">No</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor Telepon</th>
                    <th style="width:180px;text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td style="text-align:center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $customer->name }}</strong></td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td style="text-align:center">
                        <div style="display:flex;gap:8px;justify-content:center">
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-secondary" style="padding:6px 12px;font-size:12px">Ubah</a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Yakin hapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:6px 12px;font-size:12px">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection