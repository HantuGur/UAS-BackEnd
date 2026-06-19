<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Google Font Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f3f4f6;
            --sidebar-color: #0f172a;
            --sidebar-text: #94a3b8;
            --card-color: #ffffff;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --success: #10b981;
            --success-hover: #059669;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --border-color: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }

        body { background-color: var(--bg-color); color: var(--text-color); min-height: 100vh; display: flex; }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-color);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 24px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .logo {
            font-size: 20px;
            font-weight: 800;
            color: #3b82f6;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .logo span { color: #ffffff; }
        
        .nav-links { list-style: none; display: flex; flex-direction: column; gap: 6px; }
        .nav-links a {
            color: var(--sidebar-text);
            text-decoration: none;
            padding: 10px 14px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            display: block;
        }
        .nav-links a:hover { background-color: rgba(255,255,255,0.05); color: #ffffff; }
        .nav-links a.active { background-color: var(--primary); color: #ffffff; }

        /* Main Content */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; min-height: 100vh; }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
        }
        .header h1 { font-size: 24px; font-weight: 700; color: var(--text-color); }
        
        .admin-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 14px;
        }
        
        .admin-badge {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
        }

        /* Alert */
        .alert { padding: 16px; border-radius: 6px; margin-bottom: 24px; font-weight: 500; }
        .alert-success { background-color: #ecfdf5; color: var(--success); border: 1px solid #a7f3d0; }
        .alert-danger { background-color: #fef2f2; color: var(--danger); border: 1px solid #fecaca; }

        /* Card */
        .card { background-color: var(--card-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }

        /* Buttons */
        .btn { display: inline-block; padding: 10px 20px; border-radius: 6px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s ease; border: none; font-size: 14px; text-align: center; }
        .btn-primary { background-color: var(--primary); color: #fff; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-success { background-color: var(--success); color: #fff; }
        .btn-success:hover { background-color: var(--success-hover); }
        .btn-danger { background-color: var(--danger); color: #fff; }
        .btn-danger:hover { background-color: var(--danger-hover); }
        .btn-secondary { background-color: #ffffff; border: 1px solid var(--border-color); color: var(--text-color); }
        .btn-secondary:hover { background-color: #f8fafc; border-color: #cbd5e1; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background-color: #f8fafc; color: var(--text-muted); text-align: left; padding: 14px 16px; font-weight: 600; border-bottom: 1px solid var(--border-color); font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 14px 16px; border-bottom: 1px solid var(--border-color); font-size: 14px; color: var(--text-color); }
        tr:hover td { background-color: #f8fafc; }

        /* Badges */
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-pending { background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-completed { background-color: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: var(--text-color); }
        .form-control { width: 100%; padding: 10px 14px; background-color: #ffffff; border: 1px solid var(--border-color); border-radius: 6px; color: var(--text-color); outline: none; transition: all 0.2s ease; font-size: 14px; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15); }
        .error-message { color: var(--danger); font-size: 12px; margin-top: 4px; }
    </style>
</head>
<body>

    <!-- Sidebar navigasi utama -->
    <div class="sidebar">
        <div class="logo">Resto<span>Panel</span></div>
        <ul class="nav-links">
            <li><a href="{{ route('orders.index') }}" class="{{ Request::is('admin/orders*') ? 'active' : '' }}">📋 Pesanan</a></li>
            <li><a href="{{ route('customers.index') }}" class="{{ Request::is('admin/customers*') ? 'active' : '' }}">👥 Pelanggan</a></li>
            <li><a href="{{ route('menus.index') }}" class="{{ Request::is('admin/menus*') ? 'active' : '' }}">🍽️ Menu Makanan</a></li>
            <li><a href="{{ route('orders.create') }}" class="{{ Request::is('admin/orders/create') ? 'active' : '' }}">➕ Buat Pesanan</a></li>

            <li style="padding:16px 14px 6px; font-size:10px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.1em;">Keuangan</li>
            <li><a href="{{ route('payments.index') }}" class="{{ Request::is('admin/payments*') ? 'active' : '' }}">💳 Pembayaran</a></li>
            <li><a href="{{ route('promos.index') }}" class="{{ Request::is('admin/promos*') ? 'active' : '' }}">🏷️ Promo</a></li>

            <li style="padding:16px 14px 6px; font-size:10px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.1em;">Operasional</li>
            <li><a href="{{ route('tables.index') }}" class="{{ Request::is('admin/tables*') ? 'active' : '' }}">🪑 Meja</a></li>
            <li><a href="{{ route('reservations.index') }}" class="{{ Request::is('admin/reservations*') ? 'active' : '' }}">📅 Reservasi</a></li>
            <li><a href="{{ route('categories.index') }}" class="{{ Request::is('admin/categories*') ? 'active' : '' }}">📂 Kategori</a></li>
            <li><a href="{{ route('reviews.index') }}" class="{{ Request::is('admin/reviews*') ? 'active' : '' }}">⭐ Ulasan</a></li>
            <li><a href="{{ route('feedbacks.index') }}" class="{{ Request::is('admin/feedbacks*') ? 'active' : '' }}">📬 Aduan</a></li>

            <li style="padding:16px 14px 6px; font-size:10px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:0.1em;">Manajemen</li>
            <li><a href="{{ route('employees.index') }}" class="{{ Request::is('admin/employees*') ? 'active' : '' }}">👤 Karyawan</a></li>
            <li><a href="{{ route('inventories.index') }}" class="{{ Request::is('admin/inventories*') ? 'active' : '' }}">📦 Inventori</a></li>
            <li><a href="{{ route('branches.index') }}" class="{{ Request::is('admin/branches*') ? 'active' : '' }}">🏪 Cabang</a></li>
            <li><a href="{{ route('suppliers.index') }}" class="{{ Request::is('admin/suppliers*') ? 'active' : '' }}">🚚 Supplier</a></li>
        </ul>
    </div>

    <!-- Area konten utama -->
    <div class="main-content">
        <div class="header" style="margin-bottom: 24px;">
            <div>
                <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Sistem Manajemen Restoran</span>
            </div>
            <div class="admin-profile">
                <span class="admin-badge">{{ session('employee_role') ? strtoupper(session('employee_role')) : 'STAFF' }}</span>
                <strong>{{ session('employee_name', 'Administrator') }}</strong>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="type" value="admin">
                    <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">Keluar</button>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>