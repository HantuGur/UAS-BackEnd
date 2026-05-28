extends('layouts.app')
@section('title', 'Daftar Pesanan - RestoUAS')
@section('content')
<div class="header">
    <h1> Daftar Pesanan Restoran</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Buat Pesanan Baru</a>
</div>
<div style="display:flex;gap:12px;margin-bottom:24px">
    <a href="{{ route('orders.index') }}" class="btn {{ !isset($currentStatus) ? 'btn-primary' : 'btn-secondary' }}" style="padding:8px 16px">Semua</a>
    <a href="{{ route('orders.status', 'pending') }}" class="btn {{ isset($currentStatus) && $currentStatus === 'pending' ? 'btn-primary' : 'btn-secondary' }}" style="padding:8px 16px"> Pending</a>
    <a href="{{ route('orders.status', 'completed') }}" class="btn {{ isset($currentStatus) && $currentStatus === 'completed' ? 'btn-primary' : 'btn-secondary' }}" style="padding:8px 16px"> Completed</a>
</div>
<div class="card">
    @if ($orders->isEmpty())
        <p style="color:var(--text-muted);text-align:center;padding:20px">Belum ada pesanan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:60px;text-align:center">#</th>
                    <th>Pelanggan</th>
                    <th>Waktu</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th style="width:220px;text-align:center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td style="text-align:center"><strong>{{ $order->id }}</strong></td>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                    <td><span class="badge badge-{{ $order->status }}">{{ strtoupper($order->status) }}</span></td>
                    <td style="text-align:center">
                        <div style="display:flex;gap:6px;justify-content:center">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary" style="padding:6px 12px;font-size:12px">Rincian</a>
                            @if ($order->status === 'pending')
                            <form action="{{ route('orders.update', $order) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success" style="padding:6px 12px;font-size:12px">Selesai</button>
                            </form>
                            @endif
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding:6px 12px;font-size:12px">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection