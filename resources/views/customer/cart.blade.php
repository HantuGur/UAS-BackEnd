```html
@extends('layouts.customer')
@section('title', 'Keranjang Belanja - Resto 3D')
@section('content')
<div class="card">
    <h2 style="font-size:20px; font-weight:700; margin-bottom:20px;">🛒 Keranjang Belanja</h2>
    @forelse($carts as $item)
    <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 0; border-bottom:1px solid #f1f5f9;">
        <div>
            <p style="font-weight:600;">{{ $item->menu->name }}</p>
            <p style="font-size:13px; color:var(--text-muted);">{{ $item->quantity }} × Rp {{ number_format($item->menu->price, 0, ',', '.') }}</p>
            @if($item->note) <p style="font-size:12px; color:#94a3b8;">📝 {{ $item->note }}</p> @endif
        </div>
        <div style="display:flex; align-items:center; gap:16px;">
            <strong>Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}</strong>
            <form action="{{ route('customer.cart.remove', $item->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-secondary" style="padding:6px 12px; font-size:12px;">🗑️ Hapus</button>
            </form>
        </div>
    </div>
    @empty
    <p style="text-align:center; color:var(--text-muted); padding:30px;">Keranjang Anda masih kosong. <a href="{{ route('customer.shop') }}" style="color:var(--navy-primary); font-weight:600;">Kembali belanja</a></p>
    @endforelse
    @if($carts->count() > 0)
    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
        <span style="font-size:18px; font-weight:700;">Total: Rp {{ number_format($total, 0, ',', '.') }}</span>
        <a href="{{ route('customer.checkout') }}" class="btn btn-navy" style="padding:12px 28px;">Lanjut Checkout →</a>
    </div>
    @endif
</div>
@endsection