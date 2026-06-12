<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-color: #0f172a; --primary: #3b82f6; --bg-color: #f3f4f6; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-color); display: flex; }
        .sidebar { width: 260px; background-color: var(--sidebar-color); position: fixed; height: 100vh; padding: 24px; overflow-y: auto; }
        .sidebar-logo { color: white; font-size: 20px; font-weight: 800; margin-bottom: 30px; display: flex; align-items: center; gap: 10px; }
        .sidebar-logo span { background: var(--primary); padding: 4px 8px; border-radius: 4px; font-size: 14px; }
        .sidebar-nav a { display: flex; align-items: center; gap: 10px; color: #94a3b8; text-decoration: none; padding: 10px 12px; border-radius: 8px; margin-bottom: 4px; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-section-title { color: #475569; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin: 20px 0 8px 12px; }
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .page-title { font-size: 24px; font-weight: 700; color: #0f172a; }
        .card { background: white; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.07); margin-bottom: 20px; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-size: 14px; }
        .btn-primary { background-color: var(--primary); color: white; }
        .btn-danger { background-color: #ef4444; color: white; }
        .btn-secondary { background-color: #f1f5f9; color: #0f172a; border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { background: #f8fafc; text-align: left; padding: 12px 16px; font-weight: 600; color: #475569; border-bottom: 1px solid #e2e8f0; }
        td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; color: #0f172a; }
        tr:hover td { background: #f8fafc; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger  { background: #fee2e2; color: #b91c1c; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #374151; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .alert { padding: 14px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid; font-size: 14px; }
        .alert-success { background: #f0fdf4; color: #15803d; border-left-color: #16a34a; }
        .alert-danger  { background: #fef2f2; color: #b91c1c; border-left-color: #dc2626; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo"><span>Admin</span> Resto 3D</div>
        <nav class="sidebar-nav">
            <div class="sidebar-section-title">Transaksi</div>
            <a href="{{ route('orders.index') }}"> Pesanan</a>
            <a href="{{ route('payments.index') }}"> Pembayaran</a>
            <a href="{{ route('reservations.index') }}"> Reservasi</a>
            <div class="sidebar-section-title">Menu & Katalog</div>
            <a href="{{ route('menus.index') }}"> Daftar Menu</a>
            <a href="{{ route('categories.index') }}"> Kategori</a>
            <div class="sidebar-section-title">Pelanggan</div>
            <a href="{{ route('customers.index') }}"> Pelanggan</a>
            <a href="{{ route('feedbacks.index') }}"> Aduan</a>
            <a href="{{ route('reviews.index') }}"> Ulasan</a>
            <div class="sidebar-section-title">Manajemen</div>
            <a href="{{ route('employees.index') }}"> Karyawan</a>
            <a href="{{ route('branches.index') }}"> Cabang</a>
            <a href="{{ route('suppliers.index') }}"> Supplier</a>
            <a href="{{ route('inventories.index') }}"> Inventori</a>
            <a href="{{ route('tables.index') }}"> Meja</a>
            <a href="{{ route('promos.index') }}"> Promo</a>
            <div style="margin-top:20px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf <input type="hidden" name="type" value="admin">
                    <button type="submit" class="btn btn-secondary" style="width:100%;">🚪 Keluar</button>
                </form>
            </div>
        </nav>
    </div>
    <div class="main-content">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        @yield('content')
    </div>
</body>
</html>