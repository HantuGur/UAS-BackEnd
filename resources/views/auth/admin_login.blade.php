<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - RestoPanel</title>
    <!-- Google Font Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --card-color: #1e293b;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --danger: #ef4444;
            --border-color: #334155;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .login-card {
            background-color: var(--card-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            text-align: center;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .logo span {
            color: #ffffff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background-color: #0f172a;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-color);
            outline: none;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            font-size: 15px;
            text-align: center;
            background-color: var(--primary);
            color: #fff;
        }

        .btn:hover {
            background-color: var(--primary-hover);
        }

        .error-message {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 500;
            font-size: 13px;
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo">Resto<span>Panel</span></div>
        <p style="color: var(--text-muted); text-align: center; font-size: 13px; margin-bottom: 30px;">Masuk panel admin/kasir menggunakan akun Karyawan.</p>

        @if($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username Karyawan</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username admin..." required value="{{ old('username') }}">
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password..." required>
            </div>

            <button type="submit" class="btn" style="margin-top: 30px;">Masuk Panel Admin</button>
        </form>

        <div style="text-align: center; margin-top: 24px; border-top: 1px solid var(--border-color); padding-top: 16px;">
            <a href="{{ route('customer.shop') }}" style="color: var(--text-muted); font-size: 12px; text-decoration: none;">➔ Kembali ke Halaman Utama (Customer)</a>
        </div>
    </div>

</body>
</html>