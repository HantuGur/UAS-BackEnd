@extends('layouts.admin')
@section('title', 'Manajemen Reservasi')
@section('content')
<div class="page-header">
    <h1 class="page-title">📅 Reservasi Meja</h1>
    <a href="{{ route('reservations.create') }}" class="btn btn-primary">+ Tambah Reservasi</a>
</div>
<div class="card">
    <table>
        <thead><tr><th>Pelanggan</th><th>Meja</th><th>Waktu Reservasi</th><th>Tamu</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($reservations->flatten() as $r)
            <tr>
                <td>{{ $r->customer->name }}</td>
                <td>Meja {{ $r->table->table_number }}</td>
                <td>{{ \Carbon\Carbon::parse($r->reservation_time)->format('d M Y, H:i') }}</td>
                <td>{{ $r->guests_count }} orang</td>
                <td><span class="badge {{ $r->status === 'approved' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($r->status) }}</span></td>
                <td>
                    <a href="{{ route('reservations.edit', $r) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('reservations.destroy', $r) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                        @csrf @method('DELETE') <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection