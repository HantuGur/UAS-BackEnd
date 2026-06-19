@extends('layouts.app')
@section('title', 'Promo')
@section('content')
<div class="header">
    <h1>🏷️ Manajemen Promo & Voucher</h1>
    <a href="{{ route('promos.create') }}" class="btn btn-primary">+ Tambah Promo</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr><th>Kode Voucher</th><th>Diskon</th><th>Tipe Akses</th><th>Berlaku Hingga</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($promos as $promo)
            <tr>
                <td><strong style="font-size:16px; color:#2563eb; letter-spacing:1px;">{{ $promo->code }}</strong></td>
                <td>
                    @if($promo->discount_type === 'percent')
                        <strong>{{ $promo->discount_amount }}%</strong>
                        @if($promo->max_discount)
                            <span style="font-size:12px; color:#64748b;"> (maks Rp {{ number_format($promo->max_discount, 0, ',', '.') }})</span>
                        @endif
                    @else
                        Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}
                    @endif
                </td>
                <td>
                    @if($promo->is_public)
                        <span class="badge" style="background:#dbeafe; color:#1e40af;">🌐 Publik</span>
                    @else
                        <span class="badge" style="background:#f3f4f6; color:#374151;">🔒 Privat (Secret)</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($promo->expired_at)->format('d M Y') }}</td>
                <td>
                    @if($promo->status === 'active')
                        <span class="badge badge-completed">Aktif</span>
                    @else
                        <span class="badge badge-pending">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('promos.edit', $promo) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('promos.destroy', $promo) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus promo?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#9ca3af;">Belum ada data promo.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection