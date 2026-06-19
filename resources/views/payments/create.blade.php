@extends('layouts.admin')
@section('title', 'Proses Pembayaran')
@section('content')
<div class="header">
    <h1>💳 Proses Pembayaran Kasir</h1>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Kembali ke Pesanan</a>
</div>

{{-- Pilih pesanan jika belum dipilih --}}
@if(!isset($order))
<div class="card" style="max-width:500px;">
    <form action="{{ route('payments.create') }}" method="GET">
        <div class="form-group">
            <label>Pilih ID Pesanan yang Akan Dibayar</label>
            <input type="number" name="order_id" class="form-control" placeholder="Masukkan ID Pesanan..." required>
        </div>
        <button type="submit" class="btn btn-primary">Lanjut ke Pembayaran</button>
    </form>
</div>
@else
<div class="card" style="max-width:700px;">
    {{-- Ringkasan Pesanan --}}
    <h3 style="margin-bottom:16px; font-size:14px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.1em;">Ringkasan Pesanan #{{ $order->id }}</h3>
    <p style="margin-bottom:16px;">Pelanggan: <strong>{{ $order->customer->name }}</strong></p>

    <table>
        <thead><tr><th>Menu</th><th>Catatan</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->note ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity); @endphp
    <div style="text-align:right; padding:12px 0; border-top:1px solid #e5e7eb; margin-top:8px;">
        <p style="font-size:14px; color:#64748b; margin-bottom:4px;">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
        <p id="discount-row-element" style="font-size:14px; color:#16a34a; margin-bottom:4px; {{ $order->discount_amount > 0 ? '' : 'display:none;' }}">
            🏷️ Diskon{{ $order->promo ? ' ('.$order->promo->code.')' : '' }}: - Rp {{ number_format($order->discount_amount, 0, ',', '.') }}
        </p>
        <p id="total-display-element" style="font-size:22px; font-weight:700;">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
    </div>

    {{-- Form Pembayaran --}}
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        <input type="hidden" name="amount" id="amount_hidden_input" value="{{ $order->total_price }}">

        @if(!$order->promo_id)
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="promo_id">Masukkan Kode Promo (Jika Lupa/Ada)</label>
            <select name="promo_id" id="promo_id" class="form-control" onchange="recalcPayment()">
                <option value="" data-amount="0" data-type="fixed" data-max="0">-- Pilih Promo --</option>
                @foreach($promos as $promo)
                    <option value="{{ $promo->id }}" 
                            data-amount="{{ $promo->discount_amount }}"
                            data-type="{{ $promo->discount_type }}"
                            data-max="{{ $promo->max_discount ?? 0 }}">
                        {{ $promo->code }} — 
                        @if($promo->discount_type === 'percent')
                            {{ $promo->discount_amount }}%{{ $promo->max_discount ? ' (Maks Rp '.number_format($promo->max_discount, 0, ',', '.').')' : '' }}
                        @else
                            Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        @else
        <div class="form-group" style="margin-bottom: 20px;">
            <label>Voucher Terpasang (Pilihan Customer)</label>
            <div style="padding: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; font-weight: 600; color: #166534; display: flex; align-items: center; gap: 8px;">
                🏷️ {{ $order->promo->code }} — 
                @if($order->promo->discount_type === 'percent')
                    Diskon {{ $order->promo->discount_amount }}% {{ $order->promo->max_discount ? '(Maks Rp '.number_format($order->promo->max_discount, 0, ',', '.').')' : '' }}
                @else
                    Potongan Rp {{ number_format($order->promo->discount_amount, 0, ',', '.') }}
                @endif
            </div>
            <input type="hidden" name="promo_id" value="{{ $order->promo_id }}">
        </div>
        @endif

        <div class="form-group">
            <label>Metode Pembayaran <span style="color:red">*</span></label>
            <div style="display:flex; gap:24px; margin-top:8px;">
                <label style="cursor:pointer; font-size:16px;">
                    <input type="radio" name="payment_method" value="cash" id="pay_cash" required> 💵 Tunai (Cash)
                </label>
                <label style="cursor:pointer; font-size:16px;">
                    <input type="radio" name="payment_method" value="qris" id="pay_qris"> 📱 QRIS
                </label>
            </div>
            @error('payment_method')<p class="error-message">{{ $message }}</p>@enderror
        </div>

        <div id="cash-section" style="display:none;">
            <div class="form-group">
                <label>Uang Diterima dari Pelanggan (Rp)</label>
                <input type="number" name="cash_received" id="cash_input" class="form-control" placeholder="Masukkan nominal uang...">
                @error('cash_received')<p class="error-message">{{ $message }}</p>@enderror
            </div>
            <div id="change-box" style="display:none; padding:16px; background:#f0fdf4; border-radius:8px; margin-bottom:16px;">
                <p style="font-size:18px; font-weight:700;">Kembalian: <span id="change-result" style="color:#16a34a;">Rp 0</span></p>
            </div>
        </div>

        <button type="submit" class="btn btn-success" style="width:100%; padding:14px; font-size:16px;">✅ Konfirmasi Pembayaran</button>
    </form>
</div>

<script>
    const cashRadio = document.getElementById('pay_cash');
    const qrisRadio = document.getElementById('pay_qris');
    const cashSection = document.getElementById('cash-section');
    const cashInput = document.getElementById('cash_input');
    const changeBox = document.getElementById('change-box');
    const changeResult = document.getElementById('change-result');
    const subtotal = {{ $subtotal }};
    let total = {{ $order->total_price }};

    cashRadio.addEventListener('change', () => cashSection.style.display = 'block');
    qrisRadio.addEventListener('change', () => cashSection.style.display = 'none');

    function recalcPayment() {
        const promoSelect = document.getElementById('promo_id');
        let discount = 0;
        
        if (promoSelect && promoSelect.value) {
            const selectedOpt = promoSelect.options[promoSelect.selectedIndex];
            const amountVal = parseInt(selectedOpt.dataset.amount) || 0;
            const type = selectedOpt.dataset.type;
            const maxD = parseInt(selectedOpt.dataset.max) || 0;

            if (type === 'percent') {
                let raw = Math.round(subtotal * amountVal / 100);
                discount = (maxD > 0) ? Math.min(raw, maxD) : raw;
            } else {
                discount = amountVal;
            }
        }

        total = Math.max(0, subtotal - discount);

        // Update total display
        document.getElementById('total-display-element').textContent = 'Total: Rp ' + total.toLocaleString('id-ID');

        // Update discount display row
        const discountRow = document.getElementById('discount-row-element');
        if (discount > 0) {
            discountRow.style.display = 'block';
            const promoCode = promoSelect.options[promoSelect.selectedIndex].text.split(' —')[0];
            discountRow.textContent = '🏷️ Diskon (' + promoCode + '): - Rp ' + discount.toLocaleString('id-ID');
        } else {
            discountRow.style.display = 'none';
        }

        // Update hidden input amount
        document.getElementById('amount_hidden_input').value = total;

        // Recalculate change
        updateChange();
    }

    function updateChange() {
        const received = parseInt(cashInput.value) || 0;
        if (received === 0) {
            changeBox.style.display = 'none';
            return;
        }
        const change = received - total;
        changeBox.style.display = 'block';
        if (change >= 0) {
            changeResult.textContent = 'Rp ' + change.toLocaleString('id-ID');
            changeResult.style.color = '#16a34a';
        } else {
            changeResult.textContent = '⚠️ Kurang Rp ' + Math.abs(change).toLocaleString('id-ID');
            changeResult.style.color = '#dc2626';
        }
    }

    cashInput.addEventListener('input', updateChange);
</script>
@endif
@endsection