@extends('layouts.admin')
@section('title', 'Detail Pembayaran')
@section('content')
<div class="page-header">
    <h1 class="page-title">💳 Detail Pembayaran #{{ $payment->order_id }}</h1>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 24px;">
        <h2 style="margin:0; color:var(--primary);">RESTOPANEL</h2>
        <p style="margin:5px 0 0; color:var(--text-muted);">Bukti Pembayaran Transaksi</p>
    </div>

    <table style="width: 100%; margin-bottom: 24px;">
        <tr>
            <td style="padding: 8px 0; border: none; color:var(--text-muted); width: 40%;">Waktu Transaksi</td>
            <td style="padding: 8px 0; border: none; font-weight: 600; text-align: right;">{{ $payment->created_at->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border: none; color:var(--text-muted);">Nomor Pesanan</td>
            <td style="padding: 8px 0; border: none; font-weight: 600; text-align: right;">#{{ $payment->order_id }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border: none; color:var(--text-muted);">Pelanggan</td>
            <td style="padding: 8px 0; border: none; font-weight: 600; text-align: right;">{{ $payment->order->customer->name ?? 'Pelanggan Umum' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border: none; color:var(--text-muted);">Metode Pembayaran</td>
            <td style="padding: 8px 0; border: none; font-weight: 600; text-align: right;">
                <span class="badge" style="background:var(--primary); color:white;">{{ strtoupper($payment->payment_method) }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border: none; color:var(--text-muted);">Status Pembayaran</td>
            <td style="padding: 8px 0; border: none; font-weight: 600; text-align: right;">
                <span class="badge badge-success">{{ strtoupper($payment->status) }}</span>
            </td>
        </tr>
    </table>

    <hr style="border: 0; border-top: 1px dashed var(--border-color); margin: 16px 0;">

    <table style="width: 100%;">
        <tr>
            <td style="padding: 8px 0; border: none; font-size: 16px;">Total Tagihan</td>
            <td style="padding: 8px 0; border: none; font-weight: 700; font-size: 16px; text-align: right;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
        </tr>
        @if($payment->payment_method === 'cash')
        <tr>
            <td style="padding: 8px 0; border: none; color:var(--text-muted);">Tunai Diterima</td>
            <td style="padding: 8px 0; border: none; font-weight: 600; text-align: right;">Rp {{ number_format($payment->cash_received, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td style="padding: 8px 0; border: none; color:var(--success);">Kembalian</td>
            <td style="padding: 8px 0; border: none; font-weight: 600; text-align: right; color:var(--success);">Rp {{ number_format($payment->change_amount, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>

    <div style="text-align: center; margin-top: 32px;">
        <button onclick="window.print()" class="btn btn-primary" style="width: 100%;">🖨️ Cetak Struk</button>
    </div>
</div>
@endsection
