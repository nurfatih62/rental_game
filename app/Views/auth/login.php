<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Game</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            display:flex;
            background:linear-gradient(135deg, #2c1810 0%, #3d2317 50%, #5c3a2e 100%);
        }
        .auth-left {
            flex:1;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:3rem;
        }
        .auth-right {
            flex:1;
            background: linear-gradient(135deg, #1a0f0a, #2c1810);
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            color:#c9a84c;
            padding:3rem;
            position:relative;
            overflow:hidden;
        }
        .auth-right::before {
            content:'';
            position:absolute;
            top:0;left:0;right:0;bottom:0;
            background:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2280%22><circle cx=%2240%22 cy=%2240%22 r=%222%22 fill=%22rgba(201,168,76,0.06)%22/></svg>');
        }
        .auth-right-content { position:relative; z-index:1; text-align:center; }
        .auth-right-content .icon { font-size:5rem; margin-bottom:1.5rem; }
        .auth-right-content h2 { font-family:'Playfair Display',serif; font-size:2.2rem; margin-bottom:0.5rem; }
        .auth-right-content p { color:#a67c52; font-size:0.95rem; max-width:350px; line-height:1.7; }

        .auth-card {
            background:#fffdf7;
            border-radius:20px;
            padding:2.8rem;
            width:100%;
            max-width:440px;
            box-shadow:0 20px 60px rgba(0,0,0,0.3);
        }
        .auth-card .logo { text-align:center; margin-bottom:2rem; }
        .auth-card .logo i { font-size:2.5rem; color:#c9a84c; }
        .auth-card .logo h2 { font-family:'Playfair Display',serif; font-size:1.6rem; color:#2c1810; margin-top:8px; }
        .auth-card .logo p { color:#8b6e5a; font-size:0.85rem; }

        .form-group { margin-bottom:1.3rem; }
        .form-group label { display:block; font-size:0.85rem; font-weight:600; margin-bottom:6px; color:#5c3a2e; }
        .form-control {
            width:100%; padding:13px 16px; background:#faf3e0; border:2px solid #e8d5b0;
            border-radius:10px; color:#2c1810; font-family:'Poppins'; font-size:0.9rem; transition:0.3s;
        }
        .form-control:focus { outline:none; border-color:#c9a84c; box-shadow:0 0 0 4px rgba(201,168,76,0.15); background:white; }

        .btn-login {
            width:100%; padding:14px; border:none; border-radius:10px;
            background:linear-gradient(135deg, #5c3a2e, #6b4226);
            color:#faf3e0; font-family:'Poppins'; font-size:0.95rem; font-weight:700;
            cursor:pointer; transition:0.3s; display:flex; align-items:center; justify-content:center; gap:10px;
            letter-spacing:0.5px;
        }
        .btn-login:hover { background:linear-gradient(135deg, #6b4226, #8b5e3c); transform:translateY(-2px); box-shadow:0 8px 25px rgba(92,58,46,0.3); }

        .alert {
            padding:12px 16px; border-radius:10px; margin-bottom:1rem; font-size:0.85rem;
            display:flex; align-items:center; gap:8px; border-left:4px solid;
        }
        .alert-error { background:#fce4e4; color:#8b3a3a; border-left-color:#8b3a3a; }
        .alert-success { background:#e8f5e9; color:#4a7c59; border-left-color:#4a7c59; }

        .auth-footer { text-align:center; margin-top:1.5rem; font-size:0.85rem; color:#8b6e5a; }
        .auth-footer a { color:#c9a84c; font-weight:700; text-decoration:none; }
        .auth-footer a:hover { color:#a68628; }
        .back-link { display:block; text-align:center; margin-top:1rem; color:#8b6e5a; font-size:0.85rem; text-decoration:none; }
        .back-link:hover { color:#c9a84c; }

        @media (max-width:768px) {
            .auth-right { display:none; }
            body { justify-content:center; }
        }
    </style>
</head>
<body>
    <div class="auth-left">
        <div class="auth-card">
            <div class="logo">
                <i class="fas fa-gamepad"></i>
                <h2>Selamat Datang</h2>
                <p>Masuk ke akun Rental Game kamu</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form action="/login" method="POST">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Username / Email</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email" value="<?= old('username') ?>" required autofocus>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Masuk</button>
            </form>

            <div class="auth-footer">Belum punya akun? <a href="/register">Daftar Sekarang</a></div>
            <a href="/" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-right-content">
            <div class="icon">🎮</div>
            <h2>Rental Game Center</h2>
            <p>Sewa game favoritmu dengan mudah. Tersedia berbagai pilihan dari PS5, Nintendo Switch, hingga PC.</p>
        </div>
    </div>
</body>
</html>