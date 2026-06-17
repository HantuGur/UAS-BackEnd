@extends('layouts.admin')
@section('title', 'Riwayat Pembayaran')
@section('content')
<div class="page-header"><h1 class="page-title">💳 Riwayat Pembayaran</h1></div>
<div class="card">
    <table>
        <thead><tr><th>Pesanan #</th><th>Pelanggan</th><th>Metode</th><th>Total</th><th>Kembalian</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($payments as $p)
            <tr>
                <td>#{{ $p->order_id }}</td>
                <td>{{ $p->order->customer->name }}</td>
                <td>{{ strtoupper($p->payment_method) }}</td>
                <td>Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                <td>{{ $p->change_amount ? 'Rp '.number_format($p->change_amount, 0, ',', '.') : '-' }}</td>
                <td><span class="badge badge-success">{{ ucfirst($p->status) }}</span></td>
                <td><a href="{{ route('payments.show', $p) }}" class="btn btn-secondary">Detail</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection