<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rental Game</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'Poppins',sans-serif;
            min-height:100vh;
            display:flex; align-items:center; justify-content:center;
            background:linear-gradient(135deg, #2c1810 0%, #3d2317 50%, #5c3a2e 100%);
            padding:2rem;
        }
        .auth-card {
            background:#fffdf7; border-radius:20px; padding:2.5rem; width:100%; max-width:500px;
            box-shadow:0 20px 60px rgba(0,0,0,0.3);
        }
        .logo { text-align:center; margin-bottom:1.8rem; }
        .logo i { font-size:2.5rem; color:#c9a84c; }
        .logo h2 { font-family:'Playfair Display',serif; font-size:1.5rem; color:#2c1810; margin-top:8px; }
        .logo p { color:#8b6e5a; font-size:0.85rem; }
        .form-group { margin-bottom:1.1rem; }
        .form-group label { display:block; font-size:0.85rem; font-weight:600; margin-bottom:5px; color:#5c3a2e; }
        .form-control {
            width:100%; padding:12px 16px; background:#faf3e0; border:2px solid #e8d5b0;
            border-radius:10px; color:#2c1810; font-family:'Poppins'; font-size:0.9rem; transition:0.3s;
        }
        .form-control:focus { outline:none; border-color:#c9a84c; box-shadow:0 0 0 4px rgba(201,168,76,0.15); background:white; }
        select.form-control {
            appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%235c3a2e' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 14px center; padding-right:40px;
        }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        .btn-register {
            width:100%; padding:14px; border:none; border-radius:10px;
            background:linear-gradient(135deg, #a68628, #c9a84c); color:#1a0f0a;
            font-family:'Poppins'; font-size:0.95rem; font-weight:700; cursor:pointer; transition:0.3s;
            display:flex; align-items:center; justify-content:center; gap:10px; letter-spacing:0.5px;
        }
        .btn-register:hover { opacity:0.88; transform:translateY(-2px); box-shadow:0 8px 25px rgba(201,168,76,0.3); }
        .alert { padding:12px 16px; border-radius:10px; margin-bottom:1rem; font-size:0.85rem; border-left:4px solid; }
        .alert-error { background:#fce4e4; color:#8b3a3a; border-left-color:#8b3a3a; }
        .alert-error ul { margin:6px 0 0 18px; list-style:disc; }
        .auth-footer { text-align:center; margin-top:1.5rem; font-size:0.85rem; color:#8b6e5a; }
        .auth-footer a { color:#c9a84c; font-weight:700; text-decoration:none; }
        .back-link { display:block; text-align:center; margin-top:1rem; color:#8b6e5a; font-size:0.85rem; text-decoration:none; }
        .back-link:hover { color:#c9a84c; }
        @media(max-width:500px) { .form-row { grid-template-columns:1fr; } }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo">
            <i class="fas fa-user-plus"></i>
            <h2>Buat Akun Baru</h2>
            <p>Daftar untuk mulai menyewa game</p>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-error">
                <div><i class="fas fa-exclamation-triangle"></i> <strong>Error:</strong>
                    <ul><?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul>
                </div>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST">
            <?= csrf_field() ?>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?= old('username') ?>" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> No. HP</label>
                    <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" value="<?= old('phone') ?>">
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@contoh.com" value="<?= old('email') ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Konfirmasi</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-user-tag"></i> Daftar Sebagai</label>
                <select name="role" class="form-control" required>
                    <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>User (Penyewa)</option>
                    <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin (Pengelola)</option>
                </select>
            </div>

            <button type="submit" class="btn-register"><i class="fas fa-user-plus"></i> Daftar Sekarang</button>
        </form>

        <div class="auth-footer">Sudah punya akun? <a href="/login">Login</a></div>
        <a href="/" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
    </div>
</body>
</html>