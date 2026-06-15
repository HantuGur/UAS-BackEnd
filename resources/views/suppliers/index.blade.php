@extends('layouts.admin')
@section('title', 'Manajemen Supplier')
@section('content')
<div class="page-header">
    <h1 class="page-title">🚚 Daftar Supplier</h1>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">+ Tambah Supplier</a>
</div>
<div class="card">
    <table>
        <thead><tr><th>#</th><th>Nama Supplier</th><th>Telepon</th><th>Alamat</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($suppliers as $i => $s)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $s->name }}</td><td>{{ $s->phone ?? '-' }}</td><td>{{ $s->address ?? '-' }}</td>
                <td>
                    <a href="{{ route('suppliers.edit', $s) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('suppliers.destroy', $s) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                        @csrf @method('DELETE') <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection