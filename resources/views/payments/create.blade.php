@extends('layouts.admin')
@section('title', 'Proses Pembayaran')
@section('content')
<div class="page-header"><h1 class="page-title">💳 Proses Pembayaran Kasir</h1></div>
@if($order)
<div class="card" style="max-width:600px;">
    <p style="font-weight:700; font-size:18px; margin-bottom:16px;">Pesanan #{{ $order->id }} — {{ $order->customer->name }}</p>
    @foreach($order->items as $item)
    <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px;">
        <span>{{ $item->quantity }}× {{ $item->name }}</span>
        <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
    </div>
    @endforeach
    <div style="border-top:2px solid #f1f5f9; margin:12px 0; padding-top:12px; display:flex; justify-content:space-between; font-size:20px; font-weight:800;">
        <span>Total</span><span style="color:var(--primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
    </div>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="amount" value="{{ $order->total_price }}">
        <div class="form-group"><label>Metode Pembayaran</label><select name="payment_method" class="form-control"><option value="cash">Cash</option><option value="qris">QRIS</option></select></div>
        <div class="form-group"><label>Uang Diterima (jika Cash)</label><input type="number" name="cash_received" class="form-control" placeholder="Nominal uang yang diterima dari pelanggan"></div>
        <button type="submit" class="btn btn-primary" style="width:100%; padding:12px;">✅ Proses Pembayaran</button>
    </form>
</div>
@endif
@endsection