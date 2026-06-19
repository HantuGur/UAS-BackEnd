@extends('layouts.app')
@section('title', 'Kategori Menu')
@section('content')
<div class="header">
    <h1>📂 Kategori Menu</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah Menu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $index => $category)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $category->name }}</strong></td>
                <td>{{ $category->description ?? '-' }}</td>
                <td><span class="badge badge-completed">{{ $category->menus_count }} Menu</span></td>
                <td>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#9ca3af;">Belum ada data kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
