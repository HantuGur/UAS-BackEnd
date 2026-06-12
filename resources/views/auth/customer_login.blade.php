<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pelanggan - Resto 3D</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #1e3a8a; display: flex; align-items: center; justify-content: center; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
        .login-box { background: white; padding: 40px; border-radius: 12px; width: 380px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
        .logo { font-size: 28px; font-weight: 800; color: #1e3a8a; text-align: center; margin-bottom: 8px; }
        .logo span { background: #1e3a8a; color: white; padding: 4px 8px; border-radius: 4px; }
        h2 { text-align: center; font-size: 16px; color: #64748b; margin-bottom: 28px; font-weight: 400; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #374151; }
        input { width: 100%; padding: 12px 14px; border: 1.5px solid #d1d5db; border-radius: 6px; font-size: 14px; outline: none; transition: border-color 0.2s; }
        input:focus { border-color: #1e3a8a; }
        .btn-submit { width: 100%; padding: 14px; background: #1e3a8a; color: white; border: none; border-radius: 6px; font-weight: 700; font-size: 15px; cursor: pointer; margin-top: 8px; }
        .alert-danger { background: #fef2f2; color: #b91c1c; padding: 12px; border-radius: 6px; font-size: 13px; margin-bottom: 16px; border-left: 3px solid #dc2626; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">Resto<span>3D</span></div>
        <h2>Masuk atau daftar sebagai pelanggan</h2>
        @if($errors->any()) <div class="alert-danger">{{ $errors->first() }}</div> @endif
        <form method="POST" action="{{ route('customer.login') }}">
            @csrf
            <div class="form-group">
                <label>Nama Anda</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
            </div>
            <button type="submit" class="btn-submit">Masuk / Daftar Sekarang</button>
        </form>
    </div>
</body>
</html>