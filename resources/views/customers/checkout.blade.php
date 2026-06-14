@extends('layouts.customer')
@section('title', 'Checkout Pesanan - Resto 3D')
@section('content')
<form action="{{ route('customer.checkout.process') }}" method="POST">
    @csrf
    <div style="display:grid; grid-template-columns:1.8fr 1.2fr; gap:24px;">
        <div>
            <div class="card">
                <h3 style="margin-bottom:16px; font-weight:700;">Pilihan Layanan</h3>
                <div style="display:flex; gap:16px; margin-bottom:16px;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="radio" name="order_type" value="dine_in" checked onchange="toggleTable(this)"> Makan di Tempat</label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="radio" name="order_type" value="take_away" onchange="toggleTable(this)"> Bawa Pulang</label>
                </div>
                <div id="tableSelect">
                    <select name="table_id" class="form-control">
                        <option value="">-- Pilih Meja --</option>
                        @foreach($tables as $t) <option value="{{ $t->id }}">Meja No. {{ $t->table_number }} (Kapasitas: {{ $t->capacity }})</option> @endforeach
                    </select>
                </div>
            </div>
            <div class="card">
                <h3 style="margin-bottom:16px; font-weight:700;">Metode Pembayaran</h3>
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer; margin-bottom:10px;"><input type="radio" name="payment_method" value="qris" checked> QRIS (Bayar Sekarang)</label>
                <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="radio" name="payment_method" value="cash"> Cash di Kasir</label>
            </div>
        </div>
        <div>
            <div class="card">
                <h3 style="margin-bottom:16px; font-weight:700;">Rincian Belanja</h3>
                @foreach($carts as $item)
                <div style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:14px;">
                    <span>{{ $item->quantity }}× {{ $item->menu->name }}</span>
                    <span>Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div style="border-top:1px solid #f1f5f9; padding-top:12px; margin-top:8px;">
                    <input type="text" id="voucherCode" class="form-control" placeholder="Kode voucher rahasia..." style="margin-bottom:8px;">
                    <button type="button" class="btn btn-secondary" onclick="applyVoucher()" style="width:100%; margin-bottom:12px;">Gunakan Voucher</button>
                    <p id="voucherMsg" style="font-size:13px; margin-bottom:12px; display:none;"></p>
                    <input type="hidden" name="promo_id" id="promoId">
                    <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:800; color:var(--navy-primary);">
                        <span>Total Bayar</span>
                        <span id="totalDisplay" data-base="{{ $total }}">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="btn btn-navy" style="width:100%; padding:14px; margin-top:16px; font-size:15px;">Selesaikan Checkout →</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function toggleTable(el) {
        document.getElementById('tableSelect').style.display = el.value === 'dine_in' ? 'block' : 'none';
    }
    let promo = { type: 'fixed', amount: 0, max: 0 };
    function applyVoucher() {
        const code = document.getElementById('voucherCode').value;
        const msg = document.getElementById('voucherMsg');
        msg.style.display = 'block';
        fetch("{{ route('customer.promo.validate') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code })
        }).then(r => r.json()).then(data => {
            if (data.success) {
                msg.style.color = 'green';
                msg.textContent = '✅ Voucher valid! Diskon diterapkan.';
                document.getElementById('promoId').value = data.promo.id;
                promo = { type: data.promo.discount_type, amount: data.promo.discount_amount, max: data.promo.max_discount };
                updateTotal();
            } else {
                msg.style.color = 'red';
                msg.textContent = '❌ ' + data.message;
            }
        });
    }
    function updateTotal() {
        const base = parseInt(document.getElementById('totalDisplay').dataset.base);
        let discount = promo.type === 'percent'
            ? Math.min(Math.round(base * promo.amount / 100), promo.max || Infinity)
            : promo.amount;
        document.getElementById('totalDisplay').textContent = 'Rp ' + Math.max(0, base - discount).toLocaleString('id-ID');
    }
</script>
@endsection