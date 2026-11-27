@extends('layouts.app')
@section('title', 'Edit Reservasi')
@section('content')
<div class="header">
    <h1>✏️ Edit Reservasi</h1>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('reservations.update', $reservation) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Pilih Pelanggan <span style="color:red">*</span></label>
            <select name="customer_id" class="form-control" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id', $reservation->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Pilih Meja <span style="color:red">*</span></label>
            <select name="table_id" class="form-control" required>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}" {{ old('table_id', $reservation->table_id) == $table->id ? 'selected' : '' }}>
                        Meja {{ $table->table_number }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal & Waktu</label>
            <input type="datetime-local" name="reservation_time" class="form-control" value="{{ old('reservation_time', \Carbon\Carbon::parse($reservation->reservation_time)->format('Y-m-d\TH:i')) }}" required>
        </div>
        <div class="form-group">
            <label>Jumlah Tamu</label>
            <input type="number" name="guests_count" class="form-control" min="1" value="{{ old('guests_count', $reservation->guests_count) }}" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="approved" {{ old('status', $reservation->status) == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Reservasi</button>
    </form>
</div>
@endsection
