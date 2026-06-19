@extends('layouts.admin')
@section('title', 'Manajemen Kategori')
@section('content')
<div class="page-header">
    <h1 class="page-title">📁 Kategori Menu</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>
<div class="card">
    <table>
        <thead><tr><th>#</th><th>Nama Kategori</th><th>Jumlah Menu</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($categories as $i => $cat)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $cat->name }}</td>
                <td>{{ $cat->menus_count }} menu</td>
                <td>
                    <a href="{{ route('categories.edit', $cat) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection