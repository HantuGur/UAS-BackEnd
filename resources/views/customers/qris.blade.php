@extends('layouts.customer')
@section('title', 'Bayar via QRIS - Resto 3D')
@section('content')
<div class="card" style="max-width:500px; margin:0 auto; text-align:center;">
    <h2 style="font-size:20px; font-weight:700; margin-bottom:20px;">💳 Pembayaran QRIS</h2>
    <p style="color:var(--text-muted); margin-bottom:20px;">Scan QR Code di bawah untuk menyelesaikan pembayaran pesanan #{{ $order->id }}</p>
    <div style="background:#f1f5f9; padding:30px; border-radius:8px; margin-bottom:20px;">
        <div style="width:200px; height:200px; margin:0 auto; background:white; display:flex; align-items:center; justify-content:center; font-size:60px; border-radius:8px; border:2px dashed #cbd5e1;">📱</div>
        <p style="margin-top:15px; font-size:13px; color:var(--text-muted);">[QR Code akan tampil di sini]</p>
    </div>
    <p style="font-size:22px; font-weight:800; color:var(--navy-primary); margin-bottom:20px;">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
    <form action="{{ route('customer.qris.confirm', $order->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-navy" style="width:100%; padding:14px; font-size:16px;">✅ Konfirmasi Pembayaran</button>
    </form>
</div>
@endsection