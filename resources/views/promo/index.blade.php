@extends('layouts.admin')
@section('title', 'Manajemen Promo')
@section('content')
<div class="page-header">
    <h1 class="page-title">🏷️ Kode Promo</h1>
    <a href="{{ route('promos.create') }}" class="btn btn-primary">+ Tambah Promo</a>
</div>
<div class="card">
    <table>
        <thead><tr><th>Kode</th><th>Diskon</th><th>Tipe</th><th>Publik</th><th>Berlaku Hingga</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($promos as $p)
            <tr>
                <td><strong>{{ $p->code }}</strong></td>
                <td>{{ $p->discount_type === 'percent' ? $p->discount_amount.'%' : 'Rp '.number_format($p->discount_amount,0,',','.') }}</td>
                <td>{{ $p->discount_type === 'percent' ? 'Persentase' : 'Nominal' }}</td>
                <td>{{ $p->is_public ? '✅ Publik' : '🔒 Rahasia' }}</td>
                <td>{{ \Carbon\Carbon::parse($p->expired_at)->format('d M Y') }}</td>
                <td><span class="badge {{ $p->status === 'active' ? 'badge-success' : 'badge-danger' }}">{{ ucfirst($p->status) }}</span></td>
                <td>
                    <a href="{{ route('promos.edit', $p) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('promos.destroy', $p) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin?')">
                        @csrf @method('DELETE') <button class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection