@extends('layouts.app')
@section('title', 'Rincian Pesanan #' . $order->id . ' - RestoUAS')
@section('content')
<div class="header">
<h1>Rincian Pesanan #{{ $order->id }}</h1>
<a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:24px">
<div class="card">
    <h2 style="font-size:18px;margin-bottom:16px;color:var(--primary)">Data Pelanggan</h2>
    <p style="margin-bottom:8px"><strong>Nama:</strong> {{ $order->customer->name }}</p>
    <p style="margin-bottom:8px"><strong>Email:</strong> {{ $order->customer->email ?? '-' }}</p>
    <p style="margin-bottom:8px"><strong>Tipe:</strong> {{ $order->order_type === 'dine_in' ? '🍽️ Makan di Tempat' : '🥡 Bawa Pulang' }}</p>
    <p style="margin-bottom:16px"><strong>Waktu:</strong> {{ $order->created_at->format('d F Y, H:i') }}</p>
    <hr style="border:0;border-top:1px solid var(--border-color);margin-bottom:16px">
    <p style="margin-bottom:8px"><strong>Status:</strong></p>
    <span class="badge badge-{{ $order->status }}" style="font-size:14px;padding:6px 12px">{{ strtoupper($order->status) }}</span>

    @if($order->promo)
    <hr style="border:0;border-top:1px solid var(--border-color);margin:16px 0">
    <p style="margin-bottom:4px; font-size:13px; font-weight:600; color:#64748b;">🏷️ VOUCHER DIGUNAKAN</p>
    <p style="font-size:16px; font-weight:700; color:#2563eb; letter-spacing:1px;">{{ $order->promo->code }}</p>
    <p style="font-size:13px; color:#16a34a; margin-top:4px;">
        Potongan: Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
    </p>
    @endif
</div>

<div class="card">
    <h2 style="font-size:18px;margin-bottom:16px;color:var(--primary)">Rincian Item Pesanan</h2>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th style="text-align:right">Harga</th>
                <th style="text-align:center">Qty</th>
                <th style="text-align:right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong>{{ $item->note ? '<br><span style="font-size:12px;color:#94a3b8;">Catatan: '.$item->note.'</span>' : '' }}</td>
                <td style="text-align:right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td style="text-align:center">{{ $item->quantity }}</td>
                <td style="text-align:right"><strong>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
            @php $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity); @endphp
            @if($order->discount_amount > 0)
            <tr>
                <td colspan="3" style="text-align:right; color:#64748b;">Subtotal</td>
                <td style="text-align:right; color:#64748b;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:right; color:#16a34a; font-weight:600;">
                    🏷️ Diskon{{ $order->promo ? ' ('.$order->promo->code.')' : '' }}
                </td>
                <td style="text-align:right; color:#16a34a; font-weight:600;">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="3" style="text-align:right;font-weight:700;font-size:16px;border-top:2px solid var(--primary)">Total Pembayaran:</td>
                <td style="text-align:right;font-weight:700;font-size:18px;color:var(--primary);border-top:2px solid var(--primary)">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    @if ($order->status === 'pending')
    <div style="margin-top:24px; display:flex; gap:12px; justify-content:flex-end;">
        <a href="{{ route('payments.create', ['order_id' => $order->id]) }}" class="btn btn-success">💳 Proses Pembayaran Cash</a>
        <form action="{{ route('orders.update', $order) }}" method="POST" style="display:inline-block">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="completed">
            <button type="submit" class="btn btn-secondary">✅ Tandai Selesai</button>
        </form>
    </div>
    @endif
</div>
</div>
@endsection