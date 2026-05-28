@extends('layouts.app')
@section('title', 'Ubah Status Pesanan - RestoUAS')
@section('content')
<div class="header">
    <h1> Ubah Status Pesanan #{{ $order->id }}</h1>
    <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <form method="POST" action="{{ route('orders.update', $order) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="status">Status Pesanan</label>
            <select id="status" name="status" class="form-control">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}> Pending</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}> Completed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Status</button>
    </form>
</div>
@endsection