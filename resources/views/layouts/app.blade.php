<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
    :root {
        --bg-color: #f3f4f6;
        --sidebar-color: #1f2937;
        --sidebar-text: #d1d5db;
        --card-color: #ffffff;
        --text-color: #1f2937;
        --text-muted: #6b7280;
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --success: #16a34a;
        --success-hover: #15803d;
        --danger: #dc2626;
        --danger-hover: #b91c1c;
        --border-color: #e5e7eb;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }

    body { background-color: var(--bg-color); color: var(--text-color); min-height: 100vh; display: flex; }

    /* Sidebar */
    .sidebar {
        width: 260px; background-color: var(--sidebar-color);
        border-right: 1px solid var(--border-color);
        display: flex; flex-direction: column; padding: 24px;
        position: fixed; height: 100vh;
    }
    .logo { font-size: 20px; font-weight: 700; color: #60a5fa; margin-bottom: 40px; display: flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
    .logo span { color: #ffffff; }
    .nav-links { list-style: none; display: flex; flex-direction: column; gap: 8px; }
    .nav-links a { color: var(--sidebar-text); text-decoration: none; padding: 12px 16px; border-radius: 6px; font-weight: 500; transition: all 0.2s ease; display: block; }
    .nav-links a:hover { background-color: rgba(255,255,255,0.08); color: #ffffff; }
    .nav-links a.active { background-color: var(--primary); color: #ffffff; }

    /* Main Content */
    .main-content { margin-left: 260px; flex: 1; padding: 40px; min-height: 100vh; }
    .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; border-bottom: 1px solid var(--border-color); padding-bottom: 16px; }
    .header h1 { font-size: 24px; font-weight: 700; color: var(--text-color); }

    /* Alert */
    .alert { padding: 16px; border-radius: 6px; margin-bottom: 24px; font-weight: 500; }
    .alert-success { background-color: #f0fdf4; color: var(--success); border: 1px solid #bbf7d0; }

    /* Card */
    .card { background-color: var(--card-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }

    /* Buttons */
    .btn { display: inline-block; padding: 10px 20px; border-radius: 6px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s ease; border: none; font-size: 14px; text-align: center; }
    .btn-primary { background-color: var(--primary); color: #fff; }
    .btn-primary:hover { background-color: var(--primary-hover); }
    .btn-success { background-color: var(--success); color: #fff; }
    .btn-success:hover { background-color: var(--success-hover); }
    .btn-danger { background-color: var(--danger); color: #fff; }
    .btn-danger:hover { background-color: var(--danger-hover); }
    .btn-secondary { background-color: #ffffff; border: 1px solid var(--border-color); color: var(--text-color); }
    .btn-secondary:hover { background-color: #f9fafb; border-color: #d1d5db; }

    /* Tables */
    table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    th { background-color: #f9fafb; color: var(--text-muted); text-align: left; padding: 14px 16px; font-weight: 600; border-bottom: 1px solid var(--border-color); font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; }
    td { padding: 14px 16px; border-bottom: 1px solid var(--border-color); font-size: 14px; color: var(--text-color); }
    tr:hover td { background-color: #f9fafb; }

    /* Badges */
    .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .badge-pending { background-color: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }
    .badge-completed { background-color: #f0fdf4; color: #166534; border: 1px solid #86efac; }

    /* Forms */
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: var(--text-color); }
    .form-control { width: 100%; padding: 10px 14px; background-color: #ffffff; border: 1px solid var(--border-color); border-radius: 6px; color: var(--text-color); outline: none; transition: all 0.2s ease; font-size: 14px; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
    .error-message { color: var(--danger); font-size: 12px; margin-top: 4px; }
</style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"> <span>RestoUAS</span></div>
        <ul class="nav-links">
            <li><a href="/orders"> Pesanan (Orders)</a></li>
            <li><a href="/customers"> Pelanggan</a></li>
            <li><a href="/menus"> Menu Makanan</a></li>
        </ul>
    </div>
    <div class="main-content">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>