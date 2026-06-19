@extends('layouts.app')
@section('title', 'Meja Makan')
@section('content')
<div class="header">
    <h1>🪑 Manajemen Meja Makan</h1>
    <a href="{{ route('tables.create') }}" class="btn btn-primary">+ Tambah Meja</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Nomor Meja</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tables as $table)
            <tr>
                <td><strong>Meja {{ $table->table_number }}</strong></td>
                <td>{{ $table->capacity }} Orang</td>
                <td>
                    @if($table->status === 'available')
                        <span class="badge badge-completed">✅ Tersedia</span>
                    @else
                        <span class="badge badge-pending">🔴 Terpakai</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('tables.edit', $table) }}" class="btn btn-secondary">Edit Status</a>
                    <form action="{{ route('tables.destroy', $table) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus meja ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#9ca3af;">Belum ada data meja.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection