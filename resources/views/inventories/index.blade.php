```html
@extends('layouts.admin')
@section('title', 'Manajemen Inventori')
@section('content')
<div class="page-header">
    <h1 class="page-title">📦 Stok Bahan Baku</h1>
    <a href="{{ route('inventories.create') }}" class="btn btn-primary">+ Tambah Bahan</a>
</div>
<div class="card">
    <table>
        <thead><tr><th>#</th><th>Nama Bahan</th><th>Supplier</th><th>Stok</th><th>Satuan</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($inventories as $i => $inv)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $inv->item_name }}</td><td>{{ $inv->supplier->name }}</td>
                <td><span class="badge {{ $inv->quantity < 10 ? 'badge-danger' : 'badge-success' }}">{{ $inv->quantity }}</span></td>
                <td>{{ $inv->unit }}</td>
                <td>
                    <a href="{{ route('inventories.edit', $inv) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('inventories.destroy', $inv) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                        @csrf @method('DELETE') <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection