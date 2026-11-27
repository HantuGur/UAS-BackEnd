@extends('layouts.customer')
@section('title', 'Katalog Menu Terbaik - Resto 3D')
@section('content')

<style>
    /* Category Filter Pills */
    .filter-container {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-bottom: 30px;
    }

    .filter-pill {
        padding: 10px 24px;
        background: white;
        border: 1px solid var(--border-color);
        color: var(--text-color);
        border-radius: 20px;
        font-weight: 600;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .filter-pill:hover {
        border-color: var(--navy-primary);
        color: var(--navy-primary);
    }

    .filter-pill.active {
        background: var(--navy-primary);
        color: white;
        border-color: var(--navy-primary);
    }

    /* Food Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .menu-card {
        background: white;
        border-radius: 4px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .menu-image {
        height: 160px;
        background-size: cover;
        background-position: center;
        position: relative;
        background-color: #fcfcfc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    
    .menu-image svg {
        width: 60px;
        height: 60px;
        opacity: 0.15;
    }

    .menu-category-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 3px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .menu-info {
        padding: 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 12px;
    }

    .menu-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-color);
        line-height: 1.3;
        height: 40px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .menu-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .menu-price {
        font-size: 16px;
        font-weight: 700;
        color: var(--navy-primary);
    }

    /* Modal Popup */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .modal-content {
        background: white;
        border-radius: 4px;
        width: 100%;
        max-width: 460px;
        padding: 24px;
        position: relative;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transform: scale(0.9);
        transition: transform 0.25s ease;
    }

    .modal-overlay.active .modal-content {
        transform: scale(1);
    }

    .modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-muted);
    }

    .modal-close:hover {
        color: black;
    }

    .qty-counter {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .qty-btn {
        width: 36px;
        height: 36px;
        border: 1px solid var(--border-color);
        background: white;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        font-weight: 700;
    }

    .qty-btn:hover {
        border-color: var(--navy-primary);
        color: var(--navy-primary);
    }

    .qty-input {
        width: 60px;
        height: 36px;
        border: 1px solid var(--border-color);
        text-align: center;
        font-weight: 700;
        border-radius: 4px;
        outline: none;
    }
</style>

<div class="filter-container">
    <a href="{{ route('customer.shop', ['category' => 'semua']) }}" class="filter-pill {{ !request('category') || request('category') === 'semua' ? 'active' : '' }}">🍽️ Semua</a>
    @foreach($categories as $cat)
        @php
            $icons = ['makanan' => '🍽️', 'minuman' => '🍹', 'dessert' => '🍦', 'appetizer' => '🥗', 'snack' => '🍟', 'paket' => '📦'];
            $icon = $icons[strtolower($cat->name)] ?? '🍴';
        @endphp
        <a href="{{ route('customer.shop', ['category' => $cat->name]) }}"
           class="filter-pill {{ request('category') === $cat->name ? 'active' : '' }}">
            {{ $icon }} {{ ucfirst($cat->name) }}
        </a>
    @endforeach
</div>

@if($menus->isEmpty())
    <div class="card" style="text-align:center; padding:60px;">
        <p style="font-size:48px;">🔍</p>
        <p style="font-size:18px; font-weight:600; margin-top:16px; color:var(--text-muted);">Menu tidak ditemukan.</p>
    </div>
@else
    <div class="menu-grid">
        @foreach($menus as $menu)
            @php
                // Tentukan warna gradien visual soft dan ikon SVG sesuai kategori
                $gradient = 'linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%)';
                $svgIcon = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.66 3.84 3.75 3.97V22h2.5v-9.03C11.34 12.84 13 11.12 13 9V2h-2v7zm8-3h-3V2h-2v9c0 2.21 1.79 4 4 4v7h2v-7c2.21 0 4-1.79 4-4V2h-5v4z"/></svg>'; // Makanan
                
                if($menu->category === 'minuman') {
                    $gradient = 'linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%)';
                    $svgIcon = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 5V3H3v2l8 9v5H6v2h12v-2h-5v-5l8-9zM7.43 7L5.66 5h12.69l-1.78 2H7.43z"/></svg>'; // Minuman
                } elseif($menu->category === 'dessert') {
                    $gradient = 'linear-gradient(135deg, #fce4ec 0%, #f8bbd0 100%)';
                    $svgIcon = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.69 2 6 4.69 6 8c0 .54.07 1.07.2 1.57L4 18h16l-2.2-8.43c.13-.5.2-1.03.2-1.57 0-3.31-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/></svg>'; // Dessert
                }
            @endphp
            <div class="menu-card">
                <div class="menu-image" style="background: {{$gradient}};">
                    {!! $svgIcon !!}
                    <span class="menu-category-badge">{{ $menu->category ?? 'Lainnya' }}</span>
                </div>
                <div class="menu-info">
                    <div class="menu-name">{{ $menu->name }}</div>
                    <div class="menu-footer">
                        <span class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        <button class="btn btn-navy" style="padding:6px 14px; font-size:12px;" onclick="openAddToCartModal({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})">
                            + Tambah
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Add to Cart Modal Popup -->
<div class="modal-overlay" id="cartModal" onclick="closeAddToCartModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="modal-close" onclick="document.getElementById('cartModal').classList.remove('active')">✕</button>
        <h3 id="modalMenuName" style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">Nama Menu</h3>
        <p id="modalMenuPrice" style="color: var(--navy-primary); font-size: 16px; font-weight: 700; margin-bottom: 20px;">Rp 0</p>
        
        <form action="{{ route('customer.cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="menu_id" id="modalMenuId">
            
            <div class="form-group">
                <label style="font-weight: 600;">Jumlah Kuantitas</label>
                <div class="qty-counter">
                    <button type="button" class="qty-btn" onclick="updateQty(-1)">-</button>
                    <input type="number" name="quantity" id="modalQty" class="qty-input" min="1" value="1" readonly>
                    <button type="button" class="qty-btn" onclick="updateQty(1)">+</button>
                </div>
            </div>

            <div class="form-group">
                <label for="modalNote" style="font-weight: 600;">Catatan Khusus (Opsional)</label>
                <input type="text" name="note" id="modalNote" class="form-control" placeholder="Contoh: tidak pakai bawang, pedas sedang...">
            </div>

            <button type="submit" class="btn btn-navy" style="width: 100%; padding: 12px; margin-top: 10px;">
                Tambahkan Ke Keranjang Belanja
            </button>
        </form>
    </div>
</div>

<script>
    function openAddToCartModal(id, name, price) {
        document.getElementById('modalMenuId').value = id;
        document.getElementById('modalMenuName').textContent = name;
        document.getElementById('modalMenuPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('modalQty').value = 1;
        document.getElementById('modalNote').value = '';
        
        const modal = document.getElementById('cartModal');
        modal.classList.add('active');
    }

    function closeAddToCartModal(e) {
        document.getElementById('cartModal').classList.remove('active');
    }

    function updateQty(val) {
        const input = document.getElementById('modalQty');
        let current = parseInt(input.value) || 1;
        current = Math.max(1, current + val);
        input.value = current;
    }
</script>

@endsection