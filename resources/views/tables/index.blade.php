@extends('layouts.admin')
@section('title', 'Manajemen Meja')
@section('content')
<div class="page-header">
    <h1 class="page-title">🪑 Status Meja</h1>
    <a href="{{ route('tables.create') }}" class="btn btn-primary">+ Tambah Meja</a>
</div>
<div style="display:flex; gap:16px; margin-bottom:24px;">
    <div class="card" style="flex:1; text-align:center;"><p style="color:var(--text-muted); font-size:13px;">Tersedia</p><p style="font-size:32px; font-weight:800; color:#16a34a;">{{ $available }}</p></div>
    <div class="card" style="flex:1; text-align:center;"><p style="color:var(--text-muted); font-size:13px;">Terisi</p><p style="font-size:32px; font-weight:800; color:#dc2626;">{{ $occupied }}</p></div>
</div>
<div class="card">
    <table>
        <thead><tr><th>No. Meja</th><th>Kapasitas</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($tables as $t)
            <tr>
                <td>Meja {{ $t->table_number }}</td><td>{{ $t->capacity }} orang</td>
                <td><span class="badge {{ $t->status === 'available' ? 'badge-success' : 'badge-danger' }}">{{ $t->status === 'available' ? '✅ Tersedia' : '🔴 Terisi' }}</span></td>
                <td>
                    <a href="{{ route('tables.edit', $t) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('tables.destroy', $t) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                        @csrf @method('DELETE') <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection