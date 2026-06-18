@extends('layouts.admin')
@section('title', 'Data Cabang')
@section('content')
<div class="page-header">
    <h1 class="page-title">🏢 Cabang Restoran</h1>
    <a href="{{ route('branches.create') }}" class="btn btn-primary">+ Tambah Cabang</a>
</div>
<div class="card">
    <table>
        <thead><tr><th>#</th><th>Nama Cabang</th><th>Alamat</th><th>Telepon</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($branches as $i => $b)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $b->name }}</td><td>{{ $b->address }}</td><td>{{ $b->phone ?? '-' }}</td>
                <td>
                    <a href="{{ route('branches.edit', $b) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('branches.destroy', $b) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                        @csrf @method('DELETE') <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection