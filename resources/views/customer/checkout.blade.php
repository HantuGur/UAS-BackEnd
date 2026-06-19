@extends('layouts.customer')
@section('title', 'Checkout Pesanan - Resto 3D')
@section('content')

<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 24px;">📝 Checkout Pemesanan</h2>

<form action="{{ route('customer.checkout.process') }}" method="POST" id="checkoutForm">
    @csrf
    <div style="display: grid; grid-template-columns: 1.8fr 1.2fr; gap: 24px;">
        <div>
            <!-- Detail Pesanan -->
            <div class="card" style="border: 1px solid var(--border-color);">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: var(--navy-primary);">📦 Pilihan Layanan</h3>
                
                <div class="form-group">
                    <label style="font-weight: 600; margin-bottom: 10px;">Tipe Pesanan</label>
                    <div style="display: flex; gap: 20px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
                            <input type="radio" name="order_type" value="dine_in" checked onchange="toggleTableSelection(true)">
                            Dine-In (Makan di Tempat)
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
                            <input type="radio" name="order_type" value="take_away" onchange="toggleTableSelection(false)">
                            Take-Away (Bawa Pulang)
                        </label>
                    </div>
                </div>

                <div class="form-group" id="tableSelectionGroup">
                    <label for="table_id" style="font-weight: 600;">Nomor Meja Restoran</label>
                    @if($tables->isEmpty())
                        <p style="color: var(--danger-hover); font-size: 14px; font-weight: 500;">Maaf, semua meja saat ini sedang penuh.</p>
                    @else
                        <select name="table_id" id="table_id" class="form-control">
                            <option value="">-- Pilih Meja Anda --</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">Meja {{ $table->table_number }} (Kapasitas: {{ $table->capacity }} Orang)</option>
                            @endforeach
                        </select>
                        @error('table_id') <p class="error-message">{{ $message }}</p> @enderror
                    @endif
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="card" style="border: 1px solid var(--border-color);">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: var(--navy-primary);">💳 Metode Pembayaran</h3>
                <div class="form-group" style="margin-bottom: 0;">
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--border-color); border-radius: 4px;">
                            <input type="radio" name="payment_method" value="qris" checked>
                            <div style="display: flex; flex-direction: column;">
                                <strong style="font-size: 14px;">QRIS / E-Wallet</strong>
                                <span style="font-size: 12px; color: var(--text-muted);">Simulasi pembayaran cepat via QR Code</span>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; padding: 12px; border: 1px solid var(--border-color); border-radius: 4px;">
                            <input type="radio" name="payment_method" value="cash">
                            <div style="display: flex; flex-direction: column;">
                                <strong style="font-size: 14px;">Cash (Bayar di Kasir)</strong>
                                <span style="font-size: 12px; color: var(--text-muted);">Lakukan pembayaran tunai ke kasir setelah checkout</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <!-- Ringkasan Checkout -->
            <div class="card" style="border: 1px solid var(--border-color);">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1.5px solid var(--border-color);">Rincian Belanja</h3>
                
                <div style="max-height: 180px; overflow-y: auto; margin-bottom: 20px; display: flex; flex-direction: column; gap: 10px; padding-right: 5px;">
                    @foreach($carts as $item)
                        <div style="display: flex; justify-content: space-between; font-size: 14px;">
                            <span>
                                <strong>{{ $item->quantity }}x</strong> {{ $item->menu->name }}
                                @if($item->note)
                                    <br><span style="font-size: 11px; color: var(--text-muted); font-style: italic;">catatan: {{ $item->note }}</span>
                                @endif
                            </span>
                            <span style="font-weight: 600;">Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="form-group" style="border-top: 1px solid var(--border-color); padding-top: 15px;">
                    <label for="promo_id_dropdown" style="font-weight: 600; font-size: 13px;">Pilih Voucher Diskon</label>
                    <select id="promo_id_dropdown" class="form-control" style="padding: 8px 12px; font-size: 13px;" onchange="applyDropdownPromo()">
                        <option value="" data-amount="0" data-type="fixed" data-max="0">-- Pilih Voucher --</option>
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

                <div class="form-group" style="margin-top: 12px;">
                    <label for="secret_promo_code" style="font-weight: 600; font-size: 13px;">Atau Masukkan Kode Voucher Rahasia</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" id="secret_promo_code" class="form-control" style="padding: 8px 12px; font-size: 13px; text-transform: uppercase;" placeholder="Masukkan kode voucher...">
                        <button type="button" class="btn btn-navy" style="padding: 8px 16px; font-size: 13px; border-radius: 4px;" onclick="applySecretPromo()">Terapkan</button>
                    </div>
                    <p id="promo-message" style="font-size: 12px; margin-top: 6px; display: none; font-weight: 500;"></p>
                </div>

                <input type="hidden" name="promo_id" id="promo_id" value="">

                <div style="border-top: 1.5px solid var(--border-color); padding-top: 16px; display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; justify-content: space-between; font-size: 14px; color: var(--text-muted);">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 14px; color: #b91c1c; display: none;" id="discountRow">
                        <span>Diskon Voucher:</span>
                        <span id="discountVal">-Rp 0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; margin-top: 8px;">
                        <span>Total Tagihan:</span>
                        <strong style="color: var(--navy-primary); font-size: 18px;" id="totalBill" data-base="{{ $total }}">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <button type="submit" class="btn btn-navy" style="width: 100%; padding: 12px; font-size: 15px; border-radius: 4px; margin-top: 24px;">
                    Selesaikan Checkout
                </button>
            </div>
            <a href="{{ route('customer.cart') }}" class="btn btn-secondary" style="width: 100%; border-radius: 4px; padding: 10px;">
                ← Kembali ke Keranjang
            </a>
        </div>
    </div>
</form>

<script>
    function toggleTableSelection(show) {
        const group = document.getElementById('tableSelectionGroup');
        const select = document.getElementById('table_id');
        if (show) {
            group.style.display = 'block';
            select.required = true;
        } else {
            group.style.display = 'none';
            select.required = false;
            select.value = '';
        }
    }

    let currentPromo = {
        id: '',
        amount: 0,
        type: 'fixed',
        max: 0
    };

    function applyDropdownPromo() {
        const select = document.getElementById('promo_id_dropdown');
        const secretInput = document.getElementById('secret_promo_code');
        const promoMsg = document.getElementById('promo-message');
        
        secretInput.value = '';
        promoMsg.style.display = 'none';

        if (select.value === '') {
            currentPromo = { id: '', amount: 0, type: 'fixed', max: 0 };
        } else {
            const opt = select.options[select.selectedIndex];
            currentPromo = {
                id: select.value,
                amount: parseInt(opt.dataset.amount) || 0,
                type: opt.dataset.type || 'fixed',
                max: parseInt(opt.dataset.max) || 0
            };
        }

        updateCalculations();
    }

    function applySecretPromo() {
        const code = document.getElementById('secret_promo_code').value.trim();
        const promoMsg = document.getElementById('promo-message');
        const select = document.getElementById('promo_id_dropdown');

        if (!code) {
            promoMsg.style.display = 'block';
            promoMsg.style.color = '#dc2626';
            promoMsg.textContent = 'Harap masukkan kode voucher.';
            return;
        }

        fetch("{{ route('customer.promo.validate') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                select.value = '';

                currentPromo = {
                    id: data.promo.id,
                    amount: data.promo.discount_amount,
                    type: data.promo.discount_type,
                    max: data.promo.max_discount || 0
                };

                promoMsg.style.display = 'block';
                promoMsg.style.color = '#15803d';
                promoMsg.textContent = '🏷️ Voucher ' + data.promo.code + ' berhasil digunakan!';
            } else {
                currentPromo = { id: '', amount: 0, type: 'fixed', max: 0 };
                promoMsg.style.display = 'block';
                promoMsg.style.color = '#dc2626';
                promoMsg.textContent = data.message;
            }
            updateCalculations();
        })
        .catch(err => {
            console.error(err);
            promoMsg.style.display = 'block';
            promoMsg.style.color = '#dc2626';
            promoMsg.textContent = 'Terjadi kesalahan sistem. Coba lagi.';
        });
    }

    function updateCalculations() {
        document.getElementById('promo_id').value = currentPromo.id;

        const totalBillElement = document.getElementById('totalBill');
        const baseTotal = parseInt(totalBillElement.getAttribute('data-base')) || 0;
        const discountRow = document.getElementById('discountRow');
        const discountVal = document.getElementById('discountVal');

        let discount = 0;
        if (currentPromo.amount > 0) {
            if (currentPromo.type === 'percent') {
                let raw = Math.round(baseTotal * currentPromo.amount / 100);
                discount = (currentPromo.max > 0) ? Math.min(raw, currentPromo.max) : raw;
            } else {
                discount = currentPromo.amount;
            }
        }

        if (discount > 0) {
            discountRow.style.display = 'flex';
            discountVal.textContent = '-Rp ' + discount.toLocaleString('id-ID');
            
            const newTotal = Math.max(0, baseTotal - discount);
            totalBillElement.textContent = 'Rp ' + newTotal.toLocaleString('id-ID');
        } else {
            discountRow.style.display = 'none';
            totalBillElement.textContent = 'Rp ' + baseTotal.toLocaleString('id-ID');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleTableSelection(true);
    });
</script>

@endsection