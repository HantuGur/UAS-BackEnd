<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resto 3D')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-primary: #1e3a8a;
            --bg-color: #f1f5f9;
            --card-color: #ffffff;
            --text-color: #0f172a;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-color); min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: var(--navy-primary); color: white; padding: 16px 8px; position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header-container { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 0 15px; }
        .logo { font-size: 24px; font-weight: 800; color: white; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .logo span { background: white; color: var(--navy-primary); padding: 4px 8px; border-radius: 4px; font-size: 16px; }
        .header-nav { display: flex; align-items: center; gap: 24px; }
        .nav-item { color: white; text-decoration: none; font-size: 14px; font-weight: 500; }
        .cart-badge { position: absolute; top: -8px; right: -12px; background: white; color: var(--navy-primary); border-radius: 50%; font-size: 11px; font-weight: 700; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; }
        main { flex: 1; max-width: 1200px; width: 100%; margin: 20px auto; padding: 0 15px; }
        .btn { display: inline-block; padding: 10px 20px; border-radius: 4px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-size: 14px; transition: all 0.2s ease; }
        .btn-navy { background-color: var(--navy-primary); color: white; }
        .btn-secondary { background-color: #fff; border: 1px solid var(--border-color); color: var(--text-color); }
        .card { background: var(--card-color); border-radius: 4px; padding: 20px; margin-bottom: 16px; box-shadow: 0 1px 1px rgba(0,0,0,0.05); }
        .alert { padding: 14px 20px; border-radius: 4px; margin-bottom: 20px; font-weight: 500; border-left: 4px solid; font-size: 14px; }
        .alert-success { background-color: #f0fdf4; color: #15803d; border-left-color: #16a34a; }
        .alert-danger  { background-color: #fef2f2; color: #b91c1c; border-left-color: #dc2626; }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border-color); border-radius: 4px; font-size: 14px; }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="{{ route('customer.shop') }}" class="logo">Resto<span>3D</span></a>
            <form action="{{ route('customer.shop') }}" method="GET" style="flex:1; max-width:600px; display:flex; background:white; border-radius:4px; overflow:hidden; padding:3px;">
                <input type="text" name="search" placeholder="Cari makanan..." value="{{ request('search') }}" style="flex:1; border:none; outline:none; padding:10px 14px; font-size:14px;">
                <button type="submit" style="background:var(--navy-primary); color:white; border:none; padding:0 20px; cursor:pointer; font-weight:600;">Cari</button>
            </form>
            <div class="header-nav">
                @if(session()->has('customer_id'))
                    <a href="{{ route('customer.orders') }}" class="nav-item">📋 Pesanan Saya</a>
                    <a href="{{ route('customer.cart') }}" class="nav-item" style="position:relative;">🛒 Keranjang
                        @if(isset($cartCount) && $cartCount > 0)<span class="cart-badge">{{ $cartCount }}</span>@endif
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf <input type="hidden" name="type" value="customer">
                        <button type="submit" class="nav-item" style="background:none; border:none; cursor:pointer;">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('customer.login') }}" class="nav-item">Masuk / Daftar</a>
                @endif
            </div>
        </div>
    </header>
    <main>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        @yield('content')
    </main>
    <footer style="background:white; border-top:4px solid var(--navy-primary); padding:30px 15px; text-align:center; color:var(--text-muted); margin-top:40px;">
        <p>&copy; {{ date('Y') }} Resto 3D. All rights reserved.</p>
    </footer>
</body>
</html>