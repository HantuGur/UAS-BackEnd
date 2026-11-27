@extends('layouts.admin')
@section('title', 'Simulator Pembayaran QRIS')
@section('content')
<div class="page-header">
    <h1 class="page-title">📱 Simulator Pembayaran QRIS</h1>
    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Kembali ke Pesanan</a>
</div>

<div class="card" style="max-width: 500px; margin: 0 auto; text-align: center;">
    <div style="background-color: #f8fafc; padding: 24px; border-radius: 8px; margin-bottom: 24px;">
        <h2 style="margin: 0; color: #0f172a; font-size: 20px;">RESTOPANEL QRIS</h2>
        <p style="color: var(--text-muted); margin-top: 8px;">Pesanan #{{ $order->id }}</p>
    </div>

    <!-- Kotak QR Code Palsu/Simulasi -->
    <div style="border: 2px solid var(--primary); padding: 16px; display: inline-block; border-radius: 12px; margin-bottom: 24px;">
        <div style="width: 200px; height: 200px; background-color: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 64px; border-radius: 8px;">
            <span style="opacity: 0.5;">📱</span>
        </div>
    </div>

    <div style="margin-bottom: 24px;">
        <p style="color: var(--text-muted); margin-bottom: 4px;">Total Tagihan Kasir:</p>
        <h3 style="color: var(--primary); font-size: 28px; margin: 0;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h3>
    </div>

    <form action="{{ route('admin.orders.qris.confirm', $order->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success" style="width: 100%; padding: 14px; font-size: 16px; display: flex; justify-content: center; align-items: center; gap: 8px;">
            <span>✅</span> Konfirmasi Pembayaran Selesai (Simulasi Kasir)
        </button>
    </form>

    <div style="margin-top: 24px; font-size: 13px; color: #94a3b8;">
        <p>Silakan tunjukkan layar ini kepada pelanggan atau tunggu pelanggan memindai QRIS di mesin kasir sungguhan.</p>
    </div>
</div>
@endsection
