@extends('layouts.app')
@section('title', 'Tambah Promo')
@section('content')
<div class="header">
<h1>➕ Tambah Promo Baru</h1>
<a href="{{ route('promos.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:560px;">
<form action="{{ route('promos.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label>Kode Voucher <span style="color:red">*</span></label>
        <input type="text" name="code" class="form-control" placeholder="cth: DISKON20, PROMO50K" value="{{ old('code') }}" style="text-transform:uppercase;" required>
        @error('code')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Tipe Diskon <span style="color:red">*</span></label>
        <select name="discount_type" id="discountType" class="form-control" onchange="toggleDiscountType()" required>
            <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>💰 Nominal Tetap (Rp)</option>
            <option value="percent" {{ old('discount_type') === 'percent' ? 'selected' : '' }}>📊 Persentase (%)</option>
        </select>
        @error('discount_type')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group" id="fixedSection">
        <label id="discountLabel">Nominal Diskon (Rp) <span style="color:red">*</span></label>
        <input type="number" name="discount_amount" id="discountAmount" class="form-control" min="0" placeholder="cth: 10000" value="{{ old('discount_amount') }}" required>
        @error('discount_amount')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group" id="maxDiscountSection" style="display:none;">
        <label>Batas Maksimal Diskon (Rp) <span style="color:#94a3b8">(Opsional)</span></label>
        <input type="number" name="max_discount" class="form-control" min="0" placeholder="cth: 40000 → maks potongan Rp 40.000" value="{{ old('max_discount') }}">
        <p style="font-size:12px; color:#64748b; margin-top:4px;">Kosongkan jika tidak ada batas maksimal potongan.</p>
        @error('max_discount')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Kadaluarsa <span style="color:red">*</span></label>
        <input type="date" name="expired_at" class="form-control" value="{{ old('expired_at') }}" required>
        @error('expired_at')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Tipe Publikasi <span style="color:red">*</span></label>
        <select name="is_public" class="form-control" required>
            <option value="1" {{ old('is_public', '1') == '1' ? 'selected' : '' }}>🌐 Publik (Dapat Dilihat Customer)</option>
            <option value="0" {{ old('is_public') == '0' ? 'selected' : '' }}>🔒 Privat / Rahasia (Hanya Bisa Diketik Manual)</option>
        </select>
        @error('is_public')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>✅ Aktif</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>❌ Nonaktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Promo</button>
</form>
</div>

<script>
function toggleDiscountType() {
    const type = document.getElementById('discountType').value;
    const label = document.getElementById('discountLabel');
    const maxSection = document.getElementById('maxDiscountSection');
    const amountInput = document.getElementById('discountAmount');

    if (type === 'percent') {
        label.innerHTML = 'Persentase Diskon (%) <span style="color:red">*</span>';
        amountInput.placeholder = 'cth: 20 → berarti diskon 20%';
        amountInput.max = 100;
        maxSection.style.display = 'block';
    } else {
        label.innerHTML = 'Nominal Diskon (Rp) <span style="color:red">*</span>';
        amountInput.placeholder = 'cth: 10000';
        amountInput.removeAttribute('max');
        maxSection.style.display = 'none';
    }
}

// Inisialisasi saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    toggleDiscountType();
});
</script>
@endsection