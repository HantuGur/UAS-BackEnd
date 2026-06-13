@extends('layouts.customer')
@section('title', 'Riwayat Pesanan Saya - Resto 3D')
@section('content')
<div class="card">
    <h2 style="font-size:20px; font-weight:700; margin-bottom:20px;">📋 Riwayat Pesanan Saya</h2>
    @forelse($orders as $order)
    <div class="card" style="border-left: 4px solid {{ $order->status === 'completed' ? '#16a34a' : '#f59e0b' }};">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <p style="font-weight:600;">Pesanan #{{ $order->id }}</p>
                <p style="color:var(--text-muted); font-size:13px;">{{ $order->created_at->format('d M Y, H:i') }}</p>
                <p style="font-size:13px; margin-top:6px;">
                    @foreach($order->items as $item) {{ $item->name }} ({{ $item->quantity }}x)@if(!$loop->last), @endif @endforeach
                </p>
            </div>
            <div style="text-align:right;">
                <p style="font-weight:700; color:var(--navy-primary); font-size:18px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                <span style="padding:4px 10px; border-radius:20px; font-size:12px; background: {{ $order->status === 'completed' ? '#dcfce7' : '#fef3c7' }}; color: {{ $order->status === 'completed' ? '#15803d' : '#92400e' }}; font-weight:600;">
                    {{ $order->status === 'completed' ? '✅ Selesai' : '⏳ Diproses' }}
                </span>
                @if($order->status === 'pending')
                <a href="{{ route('customer.qris', $order->id) }}" class="btn btn-navy" style="display:block; margin-top:8px; font-size:12px; padding:6px 12px;">Bayar QRIS</a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <p style="text-align:center; color:var(--text-muted); padding:40px;">Belum ada pesanan. <a href="{{ route('customer.shop') }}" class="btn btn-navy" style="margin-top:10px; display:inline-block;">Belanja Sekarang</a></p>
    @endforelse
</div>
@endsection