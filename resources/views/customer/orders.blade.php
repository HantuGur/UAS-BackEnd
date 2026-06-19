@extends('layouts.customer')
@section('title', 'Riwayat Pesanan Saya - Resto 3D')
@section('content')

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 0;">📋 Riwayat Pesanan Saya</h2>
    <a href="{{ route('customer.shop') }}" class="btn btn-navy">🏪 Kembali ke Beranda</a>
</div>

@if($orders->isEmpty())
    <div class="card" style="text-align:center; padding:60px;">
        <p style="font-size:54px;">📋</p>
        <p style="font-size:18px; font-weight:600; margin:16px 0 8px;">Belum Ada Riwayat Pesanan</p>
        <p style="color:var(--text-muted); margin-bottom:24px;">Kamu belum pernah melakukan pemesanan makanan/minuman.</p>
        <a href="{{ route('customer.shop') }}" class="btn btn-navy">Pesan Sekarang</a>
    </div>
@else
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @foreach($orders as $order)
            <div class="card" style="border: 1px solid var(--border-color); padding: 24px; position: relative;">
                
                <!-- Order Header -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid var(--border-color); padding-bottom: 14px; margin-bottom: 16px;">
                    <div>
                        <span style="font-size: 12px; color: var(--text-muted); font-weight: 600;">WAKTU PESANAN: {{ $order->created_at->format('d M Y H:i') }}</span>
                        <h3 style="font-size: 16px; font-weight: 700; margin-top: 4px;">ID Pesanan: #{{ $order->id }}</h3>
                        <div style="margin-top: 6px; display: flex; gap: 8px;">
                            <span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
                                {{ $order->order_type === 'dine_in' ? '🍽️ Dine-In' : '🥡 Take-Away' }}
                            </span>
                            @if($order->table_id)
                                <span class="badge" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;">
                                    🪑 Meja {{ $order->table->table_number ?? $order->table_id }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($order->status === 'completed')
                            <span class="badge" style="background-color: #22c55e; color: white; border-radius: 4px; padding: 4px 8px; font-weight: bold; font-size: 12px;">Selesai</span>
                        @else
                            <span class="badge" style="background-color: #ef4444; color: white; border-radius: 4px; padding: 4px 8px; font-weight: bold; font-size: 12px;">Menunggu Pembayaran</span>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
                    @foreach($order->items as $item)
                        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                            <div>
                                <strong style="font-size: 15px;">{{ $item->name }}</strong>
                                <span style="color: var(--text-muted); margin-left: 8px;">x{{ $item->quantity }}</span>
                                @if($item->note)
                                    <br><span style="font-size: 11px; color: var(--text-muted); font-style: italic;">Catatan: {{ $item->note }}</span>
                                @endif
                            </div>
                            <div style="text-align: right;">
                                <span style="font-weight: 600;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                
                                <!-- Link Ulasan (Hanya jika pesanan selesai) -->
                                @if($order->status === 'completed')
                                    <br><a href="{{ route('customer.review', $item->menu_id) }}" class="btn-outline" style="display: inline-block; font-size: 11px; padding: 2px 8px; border-radius: 2px; text-decoration: none; margin-top: 4px; font-weight: 600;">Tulis Ulasan ⭐</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Footer -->
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 14px;">
                    <span style="font-weight: 600; color: var(--text-muted);">Total Pembayaran:</span>
                    <strong style="color: var(--navy-primary); font-size: 20px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                </div>

            </div>
        @endforeach
    </div>
@endif

@endsection