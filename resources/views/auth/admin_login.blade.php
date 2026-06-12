<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Resto 3D</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #0f172a; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
        .login-box { background: white; padding: 40px; border-radius: 12px; width: 380px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .logo { font-size: 28px; font-weight: 800; color: #0f172a; text-align: center; margin-bottom: 8px; }
        h2 { text-align: center; font-size: 14px; color: #64748b; margin-bottom: 28px; }
        label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #374151; }
        input { width: 100%; padding: 12px 14px; border: 1.5px solid #d1d5db; border-radius: 6px; font-size: 14px; margin-bottom: 14px; }
        .btn-submit { width: 100%; padding: 14px; background: #0f172a; color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; }
        .alert-danger { background: #fef2f2; color: #b91c1c; padding: 12px; border-radius: 6px; font-size: 13px; margin-bottom: 16px; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">🔐 Admin Panel</div>
        <h2>Akses terbatas untuk karyawan Resto 3D</h2>
        @if($errors->any()) <div class="alert-danger">{{ $errors->first() }}</div> @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" placeholder="Username admin" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-submit">Login sebagai Admin</button>
        </form>
    </div>
</body>
</html>