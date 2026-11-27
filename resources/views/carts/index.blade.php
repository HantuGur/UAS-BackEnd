@extends('layouts.app')
@section('title', 'Keranjang Belanja')
@section('content')
<div class="header">
    <h1>🛒 Keranjang Belanja</h1>
    <a href="{{ route('menus.index') }}" class="btn btn-secondary">← Tambah Menu Lagi</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($carts->isEmpty())
<div class="card" style="text-align:center; padding:60px;">
    <p style="font-size:48px;">🛒</p>
    <p style="font-size:18px; font-weight:600; margin:16px 0 8px;">Keranjang Masih Kosong</p>
    <p style="color:#6b7280;">Yuk, tambahkan menu favorit kamu!</p>
    <a href="{{ route('menus.index') }}" class="btn btn-primary" style="margin-top:20px; display:inline-block;">Lihat Menu</a>
</div>
@else
<div class="card">
    <table>
        <thead>
            <tr><th>Menu</th><th>Catatan Khusus</th><th>Harga</th><th>Qty</th><th>Subtotal</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($carts as $item)
            <tr>
                <td><strong>{{ $item->menu->name }}</strong></td>
                <td><em style="color:#6b7280;">{{ $item->note ?? '-' }}</em></td>
                <td>Rp {{ number_format($item->menu->price, 0, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}</td>
                <td>
                    <form action="{{ route('carts.destroy', $item) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus item?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:24px; text-align:right; padding:20px; background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
        <p style="font-size:20px; font-weight:700; margin-bottom:16px;">
            Total: Rp {{ number_format($total, 0, ',', '.') }}
        </p>
        <a href="{{ route('orders.create') }}" class="btn btn-success" style="font-size:16px; padding:12px 32px;">
            Checkout Sekarang →
        </a>
    </div>
</div>
@endif
@endsection
