<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resto 3D')</title>
    <!-- Google Font Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy-primary: #1e3a8a; /* Navy */
            --navy-hover: #0f172a; /* Blackish/Slate */
            --bg-color: #f1f5f9; /* White-Greyish */
            --card-color: #ffffff;
            --text-color: #0f172a;
            --text-muted: #64748b;
            --success: #10b981;
            --border-color: #cbd5e1;
            --font-family: 'Plus Jakarta Sans', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: var(--font-family);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Resto 3D */
        header {
            background-color: var(--navy-primary);
            color: white;
            padding: 16px 8px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 15px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: white;
            text-decoration: none;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo span {
            background: white;
            color: var(--navy-primary);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 16px;
        }

        .search-bar {
            flex: 1;
            max-width: 600px;
            display: flex;
            background: white;
            border-radius: 4px;
            overflow: hidden;
            padding: 3px;
        }

        .search-bar input {
            flex: 1;
            border: none;
            outline: none;
            padding: 10px 14px;
            font-size: 14px;
            color: #333;
        }

        .search-bar button {
            background: var(--navy-primary);
            color: white;
            border: none;
            outline: none;
            padding: 0 20px;
            border-radius: 2px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .search-bar button:hover {
            background: var(--navy-hover);
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .nav-item {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: opacity 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-item:hover {
            opacity: 0.9;
        }

        .cart-icon-container {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: white;
            color: var(--navy-primary);
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--navy-primary);
        }

        /* Main Section */
        main {
            flex: 1;
            max-width: 1200px;
            width: 100%;
            margin: 20px auto;
            padding: 0 15px;
        }

        /* Footer */
        footer {
            background: white;
            border-top: 4px solid var(--navy-primary);
            padding: 30px 15px;
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 40px;
        }

        /* Common Elements */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-size: 14px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .btn-navy {
            background-color: var(--navy-primary);
            color: white;
        }

        .btn-navy:hover {
            background-color: var(--navy-hover);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--navy-primary);
            color: var(--navy-primary);
        }

        .btn-outline:hover {
            background: rgba(30, 58, 138, 0.05);
        }

        .btn-secondary {
            background-color: #fff;
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background-color: #fafafa;
        }

        .card {
            background: var(--card-color);
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 16px;
        }

        .alert {
            padding: 14px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-weight: 500;
            border-left: 4px solid;
            font-size: 14px;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #15803d;
            border-left-color: #16a34a;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #b91c1c;
            border-left-color: #dc2626;
        }

        /* Micro-animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.35s ease forwards;
        }
        /* Form Elements */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            background-color: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-color);
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            font-size: 14px;
            font-family: var(--font-family);
        }

        .form-control:focus {
            border-color: var(--navy-primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <a href="{{ route('customer.shop') }}" class="logo">
                Resto<span>3D</span>
            </a>

            <form action="{{ route('customer.shop') }}" method="GET" class="search-bar">
                <input type="text" name="search" placeholder="Cari makanan, minuman, atau dessert terbaik..." value="{{ request('search') }}">
                <button type="submit">Cari</button>
            </form>

            <div class="header-nav">
                @if(session()->has('customer_id'))
                    <a href="{{ route('customer.orders') }}" class="nav-item">📋 Pesanan Saya</a>
                    <a href="{{ route('customer.feedback') }}" class="nav-item">📬 Kirim Aduan</a>
                    <a href="{{ route('customer.cart') }}" class="nav-item cart-icon-container">
                        🛒 Keranjang
                        @if(isset($cartCount) && $cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <span class="nav-item" style="cursor:default; opacity:0.8;">👤 {{ session('customer_name') }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="type" value="customer">
                        <button type="submit" class="nav-item" style="background:none; border:none; cursor:pointer;">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('customer.login') }}" class="nav-item">Masuk / Daftar</a>
                @endif
            </div>
        </div>
    </header>

    <main class="animate-fade-in">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 Resto 3D. All Rights Reserved.</p>
    </footer>

</body>
</html>