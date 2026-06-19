@extends('layouts.app')
@section('title', 'Buat Reservasi')
@section('content')
<div class="header">
    <h1>📅 Buat Reservasi Meja</h1>
    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:600px;">
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Pilih Pelanggan <span style="color:red">*</span></label>
            <select name="customer_id" class="form-control" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Pilih Meja <span style="color:red">*</span></label>
            <select name="table_id" class="form-control" required>
                <option value="">-- Pilih Meja Tersedia --</option>
                @foreach($tables as $table)
                    <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                        Meja {{ $table->table_number }} (Kapasitas: {{ $table->capacity }} orang)
                    </option>
                @endforeach
            </select>
            @error('table_id')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Tanggal & Waktu Reservasi <span style="color:red">*</span></label>
            <input type="datetime-local" name="reservation_time" class="form-control" value="{{ old('reservation_time') }}" required>
            @error('reservation_time')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label>Jumlah Tamu <span style="color:red">*</span></label>
            <input type="number" name="guests_count" class="form-control" min="1" placeholder="Berapa orang?" value="{{ old('guests_count') }}" required>
            @error('guests_count')<p class="error-message">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Buat Reservasi</button>
    </form>
</div>
@endsection
