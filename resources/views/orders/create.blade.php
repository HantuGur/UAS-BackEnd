@extends('layouts.app')
@section('title', 'Buat Pesanan - RestoUAS')
@section('content')
<div class="header">
    <h1> Buat Pesanan Baru</h1>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@if ($customers->isEmpty() || $menus->isEmpty())
    <div class="card" style="text-align:center;padding:40px">
        <h2 style="margin-bottom:16px;color:var(--danger)"> Data Belum Lengkap</h2>
        <p style="color:var(--text-muted);margin-bottom:24px">Tambahkan minimal 1 Pelanggan dan 1 Menu terlebih dahulu.</p>
        <div style="display:flex;gap:12px;justify-content:center">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
            <a href="{{ route('menus.create') }}" class="btn btn-success">Tambah Menu</a>
        </div>
    </div>
@else
<form method="POST" action="{{ route('orders.store') }}">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 2fr;gap:24px">
        <div class="card">
            <h2 style="font-size:18px;margin-bottom:20px;color:var(--primary)"> Pilih Pelanggan</h2>
            <div class="form-group">
                <label for="customer_id">Nama Pelanggan</label>
                <select id="customer_id" name="customer_id" class="form-control" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card">
            <h2 style="font-size:18px;margin-bottom:20px;color:var(--primary)"> Pilih Menu</h2>
            <div id="items-container">
                <div class="item-row" style="display:flex;gap:16px;align-items:flex-end;margin-bottom:16px">
                    <div class="form-group" style="flex:3;margin-bottom:0">
                        <label>Menu</label>
                        <select name="items[0][menu_id]" class="form-control" required>
                            <option value="">-- Pilih Menu --</option>
                            @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->name }} - Rp {{ number_format($menu->price, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;margin-bottom:0">
                        <label>Jumlah</label>
                        <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-remove" style="padding:12px 16px;display:none"></button>
                </div>
            </div>
            <div style="margin-top:20px;display:flex;justify-content:space-between;align-items:center">
                <button type="button" id="btn-add-item" class="btn btn-secondary">+ Tambah Item</button>
                <button type="submit" class="btn btn-primary" style="font-size:16px;padding:12px 24px">Buat Pesanan</button>
            </div>
        </div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('items-container');
    const btnAdd = document.getElementById('btn-add-item');
    const firstRowHTML = container.querySelector('.item-row').innerHTML;
    let rowIndex = 1;
    function updateRemove() {
        const rows = container.querySelectorAll('.item-row');
        container.querySelectorAll('.btn-remove').forEach(btn => {
            btn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }
    btnAdd.addEventListener('click', function () {
        const div = document.createElement('div');
        div.className = 'item-row';
        div.style = 'display:flex;gap:16px;align-items:flex-end;margin-bottom:16px';
        div.innerHTML = firstRowHTML;
        div.querySelector('select').name = `items[${rowIndex}][menu_id]`;
        div.querySelector('select').value = '';
        div.querySelector('input').name = `items[${rowIndex}][quantity]`;
        div.querySelector('input').value = 1;
        container.appendChild(div);
        rowIndex++;
        updateRemove();
    });
    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('.item-row').remove();
            updateRemove();
        }
    });
    updateRemove();
});
</script>
@endif
@endsection