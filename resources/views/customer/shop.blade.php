@extends('layouts.customer')
@section('title', 'Katalog Menu Terbaik - Resto 3D')
@section('content')
<div style="display:flex; gap:10px; margin-bottom:20px; justify-content:center; flex-wrap:wrap;">
    <a href="{{ route('customer.shop', ['category' => 'semua']) }}" class="btn {{ !request('category') || request('category') === 'semua' ? 'btn-navy' : 'btn-secondary' }}">🍽️ Semua</a>
    @foreach($categories as $cat)
        <a href="{{ route('customer.shop', ['category' => $cat->name]) }}" class="btn {{ request('category') === $cat->name ? 'btn-navy' : 'btn-secondary' }}">{{ ucfirst($cat->name) }}</a>
    @endforeach
</div>
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:20px;">
    @forelse($menus as $menu)
    <div class="card" style="display:flex; flex-direction:column; justify-content:space-between; padding:15px;">
        <div>
            <h3 style="font-size:16px; margin-bottom:10px;">{{ $menu->name }}</h3>
            <p style="color:var(--text-muted); font-size:12px; margin-bottom:15px;">{{ $menu->category }}</p>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <strong style="color:var(--navy-primary);">Rp {{ number_format($menu->price, 0, ',', '.') }}</strong>
            @if(session()->has('customer_id'))
                <button class="btn btn-navy" onclick="openModal({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})">+ Tambah</button>
            @else
                <a href="{{ route('customer.login') }}" class="btn btn-secondary">Login</a>
            @endif
        </div>
    </div>
    @empty
    <p style="text-align:center; color:var(--text-muted); padding:40px; grid-column:1/-1;">Menu tidak ditemukan.</p>
    @endforelse
</div>

<div id="cartModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:1000;">
    <div style="background:white; padding:24px; border-radius:12px; width:400px; max-width:90%;">
        <h3 id="modalMenuName" style="margin-bottom:6px;"></h3>
        <p id="modalMenuPrice" style="color:var(--navy-primary); font-weight:700; margin-bottom:20px;"></p>
        <form action="{{ route('customer.cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="menu_id" id="modalMenuId">
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:4px;">Jumlah</label>
            <input type="number" name="quantity" class="form-control" value="1" min="1" style="margin-bottom:10px;" required>
            <label style="display:block; font-size:13px; font-weight:600; margin-bottom:4px;">Catatan (opsional)</label>
            <input type="text" name="note" class="form-control" placeholder="Contoh: tanpa cabai" style="margin-bottom:16px;">
            <button type="submit" class="btn btn-navy" style="width:100%;">Masukkan Keranjang</button>
            <button type="button" class="btn btn-secondary" style="width:100%; margin-top:6px;" onclick="document.getElementById('cartModal').style.display='none'">Batal</button>
        </form>
    </div>
</div>
<script>
    function openModal(id, name, price) {
        document.getElementById('modalMenuId').value = id;
        document.getElementById('modalMenuName').textContent = name;
        document.getElementById('modalMenuPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('cartModal').style.display = 'flex';
    }
</script>
@endsection