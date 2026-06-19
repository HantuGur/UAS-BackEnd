@extends('layouts.app')
@section('title', 'Edit Promo')
@section('content')
<div class="header">
<h1>✏️ Edit Promo</h1>
<a href="{{ route('promos.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card" style="max-width:560px;">
<form action="{{ route('promos.update', $promo) }}" method="POST">
    @csrf @method('PUT')
    <div class="form-group">
        <label>Kode Voucher <span style="color:red">*</span></label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $promo->code) }}" style="text-transform:uppercase;" required>
        @error('code')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Tipe Diskon <span style="color:red">*</span></label>
        <select name="discount_type" id="discountType" class="form-control" onchange="toggleDiscountType()" required>
            <option value="fixed" {{ old('discount_type', $promo->discount_type) === 'fixed' ? 'selected' : '' }}>💰 Nominal Tetap (Rp)</option>
            <option value="percent" {{ old('discount_type', $promo->discount_type) === 'percent' ? 'selected' : '' }}>📊 Persentase (%)</option>
        </select>
    </div>

    <div class="form-group">
        <label id="discountLabel">Nilai Diskon <span style="color:red">*</span></label>
        <input type="number" name="discount_amount" id="discountAmount" class="form-control" min="0" value="{{ old('discount_amount', $promo->discount_amount) }}" required>
        @error('discount_amount')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group" id="maxDiscountSection">
        <label>Batas Maksimal Diskon (Rp) <span style="color:#94a3b8">(Opsional)</span></label>
        <input type="number" name="max_discount" class="form-control" min="0" value="{{ old('max_discount', $promo->max_discount) }}" placeholder="Kosongkan jika tidak ada batas">
        @error('max_discount')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Tanggal Kadaluarsa <span style="color:red">*</span></label>
        <input type="date" name="expired_at" class="form-control" value="{{ old('expired_at', $promo->expired_at) }}" required>
        @error('expired_at')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Tipe Publikasi <span style="color:red">*</span></label>
        <select name="is_public" class="form-control" required>
            <option value="1" {{ old('is_public', $promo->is_public) == 1 ? 'selected' : '' }}>🌐 Publik (Dapat Dilihat Customer)</option>
            <option value="0" {{ old('is_public', $promo->is_public) == 0 ? 'selected' : '' }}>🔒 Privat / Rahasia (Hanya Bisa Diketik Manual)</option>
        </select>
        @error('is_public')<p class="error-message">{{ $message }}</p>@enderror
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" {{ old('status', $promo->status) == 'active' ? 'selected' : '' }}>✅ Aktif</option>
            <option value="inactive" {{ old('status', $promo->status) == 'inactive' ? 'selected' : '' }}>❌ Nonaktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Promo</button>
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
        amountInput.max = 100;
        maxSection.style.display = 'block';
    } else {
        label.innerHTML = 'Nominal Diskon (Rp) <span style="color:red">*</span>';
        amountInput.removeAttribute('max');
        maxSection.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', toggleDiscountType);
</script>
@endsection