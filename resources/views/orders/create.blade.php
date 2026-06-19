@extends('layouts.app')
@section('title', 'Buat Pesanan Baru')
@section('content')

<style>
    .order-grid { display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start; }
    .item-row { display: grid; grid-template-columns: 1fr 80px 32px; gap: 8px; margin-bottom: 8px; align-items: center; }
    .total-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; margin-top: 16px; }
    .total-row { display: flex; justify-content: space-between; font-size: 14px; padding: 4px 0; }
    .total-row.final { font-weight: 700; font-size: 18px; color: var(--navy-primary); border-top: 2px solid #e2e8f0; margin-top: 8px; padding-top: 12px; }
    .discount-row { color: #16a34a; }
    @media (max-width: 900px) { .order-grid { grid-template-columns: 1fr; } }
</style>

<div class="header">
    <h1>🧾 Buat Pesanan Baru</h1>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Kembali ke Pesanan</a>
</div>

<form action="{{ route('orders.store') }}" method="POST" id="orderForm">
@csrf
<div class="order-grid">

    {{-- KIRI: Form Input --}}
    <div>
        {{-- Customer --}}
        <div class="card" style="margin-bottom:16px;">
            <h3 style="font-size:16px; font-weight:700; margin-bottom:16px;">👤 Data Pelanggan</h3>

            <div class="form-group">
                <label>Tipe Pelanggan</label>
                <select name="customer_type" id="customerType" class="form-control" onchange="toggleCustomerType()">
                    <option value="existing">Pelanggan Terdaftar</option>
                    <option value="new">Pelanggan Baru (Walk-in)</option>
                </select>
            </div>

            <div id="existingCustomerSection">
                <div class="form-group">
                    <label>Pilih Pelanggan</label>
                    <select name="customer_id" id="customerSelect" class="form-control">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                        @endforeach
                    </select>
                    @error('customer_id')<p class="error-message">{{ $message }}</p>@enderror
                </div>
            </div>

            <div id="newCustomerSection" style="display:none;">
                <div class="form-group">
                    <label>Nama Pelanggan <span style="color:red">*</span></label>
                    <input type="text" name="new_customer_name" class="form-control" placeholder="Nama pelanggan walk-in">
                    @error('new_customer_name')<p class="error-message">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label>Email (Opsional)</label>
                    <input type="email" name="new_customer_email" class="form-control" placeholder="email@contoh.com (bisa dikosongkan)">
                    @error('new_customer_email')<p class="error-message">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Tipe Order & Meja --}}
        <div class="card" style="margin-bottom:16px;">
            <h3 style="font-size:16px; font-weight:700; margin-bottom:16px;">🍽️ Tipe Pesanan</h3>
            <div class="form-group">
                <label>Tipe</label>
                <select name="order_type" id="orderType" class="form-control" onchange="toggleTableSelect()">
                    <option value="dine_in">Makan di Tempat (Dine-in)</option>
                    <option value="take_away">Bawa Pulang (Take-away)</option>
                </select>
            </div>
            <div class="form-group" id="tableSection">
                <label>Pilih Meja</label>
                <select name="table_id" class="form-control">
                    <option value="">-- Pilih Meja --</option>
                    @foreach($tables as $t)
                        <option value="{{ $t->id }}">Meja #{{ $t->table_number }} (Kapasitas: {{ $t->capacity }})</option>
                    @endforeach
                </select>
                @error('table_id')<p class="error-message">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Item Menu --}}
        <div class="card" style="margin-bottom:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h3 style="font-size:16px; font-weight:700;">🛒 Item Pesanan</h3>
                <button type="button" class="btn btn-primary" style="padding:6px 14px; font-size:13px;" onclick="addItemRow()">+ Tambah Item</button>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 80px 32px; gap:8px; margin-bottom:8px;">
                <span style="font-size:12px; font-weight:600; color:#64748b;">MENU</span>
                <span style="font-size:12px; font-weight:600; color:#64748b;">QTY</span>
                <span></span>
            </div>

            <div id="itemsContainer">
                {{-- Row pertama selalu ada --}}
                <div class="item-row" id="itemRow0">
                    <select name="items[0][menu_id]" class="form-control" onchange="recalcTotal()">
                        <option value="">-- Pilih Menu --</option>
                        @foreach($menus as $m)
                            <option value="{{ $m->id }}" data-price="{{ $m->price }}">
                                {{ ucfirst($m->category) }} - {{ $m->name }} (Rp {{ number_format($m->price,0,',','.') }})
                            </option>
                        @endforeach
                    </select>
                    <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" onchange="recalcTotal()">
                    <button type="button" class="btn btn-danger" style="padding:6px 10px; font-size:16px;" onclick="removeItemRow('itemRow0')" title="Hapus">✕</button>
                </div>
            </div>

            @error('items')<p class="error-message" style="margin-top:8px;">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- KANAN: Ringkasan & Pembayaran --}}
    <div>
        <div class="card" style="position:sticky; top:20px;">
            <h3 style="font-size:16px; font-weight:700; margin-bottom:16px;">💰 Ringkasan & Pembayaran</h3>

            {{-- Promo --}}
            <div class="form-group">
                <label>Voucher / Promo Publik</label>
                <select id="promoSelect" class="form-control" onchange="applyDropdownPromo()">
                    <option value="">-- Tidak Pakai Promo --</option>
                    @foreach($promos->where('is_public', true) as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->code }} —
                            @if($p->discount_type === 'percent')
                                {{ $p->discount_amount }}%{{ $p->max_discount ? ' (maks Rp '.number_format($p->max_discount,0,',','.').')' : '' }}
                            @else
                                Rp {{ number_format($p->discount_amount,0,',','.') }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-top:12px;">
                <label>Atau Masukkan Kode Voucher Private</label>
                <div style="display:flex;gap:8px;">
                    <input type="text" id="privatePromoCode" class="form-control" placeholder="Ketik kode voucher..." style="text-transform: uppercase;">
                    <button type="button" class="btn btn-secondary" onclick="applyPrivatePromo()">Cek</button>
                </div>
                <p id="privatePromoMsg" style="font-size:12px; margin-top:4px; display:none; font-weight: 500;"></p>
            </div>
            
            <input type="hidden" name="promo_id" id="hiddenPromoId" value="">

            {{-- Kalkulasi --}}
            <div class="total-box">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span id="subtotalDisplay">Rp 0</span>
                </div>
                <div class="total-row discount-row" id="discountRow" style="display:none;">
                    <span id="discountLabel">Diskon</span>
                    <span id="discountDisplay">- Rp 0</span>
                </div>
                <div class="total-row final">
                    <span>Total Bayar</span>
                    <span id="totalDisplay">Rp 0</span>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="form-group" style="margin-top:16px;">
                <label>Metode Pembayaran <span style="color:red">*</span></label>
                <select name="payment_method" class="form-control">
                    <option value="cash">💵 Tunai (Cash)</option>
                    <option value="qris">📱 QRIS</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; font-size:15px; margin-top:8px;">
                ✅ Buat Pesanan
            </button>
        </div>
    </div>
</div>
</form>

<script>
    let rowIndex = 1;

    // Data menu dari PHP ke JS
    const menuData = {
        @foreach($menus as $m)
        {{ $m->id }}: { price: {{ $m->price }}, name: '{{ addslashes($m->name) }}' },
        @endforeach
    };

    const allPromos = [
        @foreach($promos as $p)
        { id: "{{ $p->id }}", code: "{{ strtoupper($p->code) }}", type: "{{ $p->discount_type }}", amount: {{ $p->discount_amount }}, max: {{ $p->max_discount ?? 0 }} },
        @endforeach
    ];
    let currentPromo = null;

    function applyDropdownPromo() {
        document.getElementById('privatePromoCode').value = '';
        document.getElementById('privatePromoMsg').style.display = 'none';

        const val = document.getElementById('promoSelect').value;
        currentPromo = allPromos.find(p => p.id == val) || null;
        recalcTotal();
    }

    function applyPrivatePromo() {
        document.getElementById('promoSelect').value = '';
        const code = document.getElementById('privatePromoCode').value.trim().toUpperCase();
        const msg = document.getElementById('privatePromoMsg');
        
        if (!code) {
            msg.textContent = 'Masukkan kode voucher.';
            msg.style.color = '#dc2626';
            msg.style.display = 'block';
            currentPromo = null;
            recalcTotal();
            return;
        }

        const promo = allPromos.find(p => p.code === code);
        if (promo) {
            currentPromo = promo;
            msg.textContent = '🏷️ Voucher ' + promo.code + ' berhasil digunakan!';
            msg.style.color = '#15803d';
            msg.style.display = 'block';
        } else {
            currentPromo = null;
            msg.textContent = 'Kode voucher tidak valid atau kadaluarsa.';
            msg.style.color = '#dc2626';
            msg.style.display = 'block';
        }
        recalcTotal();
    }

    function toggleCustomerType() {
        const type = document.getElementById('customerType').value;
        document.getElementById('existingCustomerSection').style.display = type === 'existing' ? 'block' : 'none';
        document.getElementById('newCustomerSection').style.display = type === 'new' ? 'block' : 'none';
    }

    function toggleTableSelect() {
        const type = document.getElementById('orderType').value;
        document.getElementById('tableSection').style.display = type === 'dine_in' ? 'block' : 'none';
    }

    function addItemRow() {
        const container = document.getElementById('itemsContainer');
        const rowId = 'itemRow' + rowIndex;
        const div = document.createElement('div');
        div.className = 'item-row';
        div.id = rowId;
        div.innerHTML = `
            <select name="items[${rowIndex}][menu_id]" class="form-control" onchange="recalcTotal()">
                <option value="">-- Pilih Menu --</option>
                @foreach($menus as $m)
                <option value="{{ $m->id }}" data-price="{{ $m->price }}">{{ ucfirst($m->category) }} - {{ $m->name }} (Rp {{ number_format($m->price,0,',','.') }})</option>
                @endforeach
            </select>
            <input type="number" name="items[${rowIndex}][quantity]" class="form-control" min="1" value="1" onchange="recalcTotal()">
            <button type="button" class="btn btn-danger" style="padding:6px 10px; font-size:16px;" onclick="removeItemRow('${rowId}')" title="Hapus">✕</button>
        `;
        container.appendChild(div);
        rowIndex++;
        recalcTotal();
    }

    function removeItemRow(id) {
        const row = document.getElementById(id);
        if (row) { row.remove(); recalcTotal(); }
    }

    function recalcTotal() {
        // Hitung subtotal dari semua baris item
        let subtotal = 0;
        const selects = document.querySelectorAll('#itemsContainer select');
        const quantities = document.querySelectorAll('#itemsContainer input[type="number"]');
        selects.forEach((sel, i) => {
            const menuId = parseInt(sel.value);
            const qty = parseInt(quantities[i]?.value) || 1;
            if (menuId && menuData[menuId]) {
                subtotal += menuData[menuId].price * qty;
            }
        });

        // Hitung diskon
        let discount = 0;
        document.getElementById('hiddenPromoId').value = currentPromo ? currentPromo.id : '';
        if (currentPromo) {
            if (currentPromo.type === 'percent') {
                let raw = Math.round(subtotal * currentPromo.amount / 100);
                discount = (currentPromo.max > 0) ? Math.min(raw, currentPromo.max) : raw;
            } else {
                discount = currentPromo.amount;
            }
        }

        const total = Math.max(0, subtotal - discount);

        // Update tampilan
        document.getElementById('subtotalDisplay').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');

        const discountRow = document.getElementById('discountRow');
        if (discount > 0) {
            discountRow.style.display = 'flex';
            document.getElementById('discountLabel').textContent = 'Diskon (' + currentPromo.code + ')';
            document.getElementById('discountDisplay').textContent = '- Rp ' + discount.toLocaleString('id-ID');
        } else {
            discountRow.style.display = 'none';
        }
    }
</script>
@endsection