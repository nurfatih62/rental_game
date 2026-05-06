<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Rental Game') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --brown-900: #1a0f0a;
            --brown-800: #2c1810;
            --brown-700: #3d2317;
            --brown-600: #5c3a2e;
            --brown-500: #6b4226;
            --brown-400: #8b5e3c;
            --brown-300: #a67c52;
            --brown-200: #c4a882;
            --brown-100: #dcc8a0;

            --cream-100: #fffdf7;
            --cream-200: #faf3e0;
            --cream-300: #f5e6c8;
            --cream-400: #e8d5b0;
            --cream-500: #d4b896;

            --gold: #c9a84c;
            --gold-dark: #a68628;
            --gold-light: #e8d48b;

            --success: #4a7c59;
            --success-light: #e8f5e9;
            --danger: #8b3a3a;
            --danger-light: #fce4e4;
            --warning: #8b6914;
            --warning-light: #fff8e1;
            --info: #4a6741;

            --text-dark: #2c1810;
            --text-medium: #5c3a2e;
            --text-light: #8b6e5a;
            --text-cream: #faf3e0;

            --shadow: 0 2px 15px rgba(44, 24, 16, 0.08);
            --shadow-md: 0 4px 25px rgba(44, 24, 16, 0.12);
            --shadow-lg: 0 8px 40px rgba(44, 24, 16, 0.15);
            --radius: 12px;
            --radius-lg: 16px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream-200);
            color: var(--text-dark);
            min-height: 100vh;
            line-height: 1.7;
        }

        a { color: var(--brown-500); text-decoration: none; transition: 0.3s; }
        a:hover { color: var(--gold-dark); }

        /* ========== NAVBAR ========== */
        .navbar {
            background: linear-gradient(135deg, var(--brown-800), var(--brown-700));
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(44, 24, 16, 0.3);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--gold);
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .navbar-brand i { font-size: 1.6rem; color: var(--gold-light); }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
        }

        .navbar-links a {
            color: var(--cream-300);
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .navbar-links a:hover,
        .navbar-links a.active {
            color: var(--gold);
            background: rgba(201, 168, 76, 0.12);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .navbar-user .user-info {
            text-align: right;
        }

        .navbar-user .user-info .name {
            font-weight: 600;
            color: var(--cream-100);
            font-size: 0.9rem;
        }

        .navbar-user .user-info .role {
            font-size: 0.72rem;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .btn-logout {
            background: rgba(139, 58, 58, 0.3);
            color: #e8a0a0;
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background: var(--danger);
            color: white;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            min-height: calc(100vh - 70px - 60px);
        }

        /* ========== ALERTS ========== */
        .alert {
            padding: 16px 22px;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            animation: fadeSlideDown 0.4s ease;
            border-left: 4px solid;
        }

        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-15px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: var(--success-light);
            color: var(--success);
            border-left-color: var(--success);
        }

        .alert-error {
            background: var(--danger-light);
            color: var(--danger);
            border-left-color: var(--danger);
        }

        .alert-warning {
            background: var(--warning-light);
            color: var(--warning);
            border-left-color: var(--warning);
        }

        /* ========== CARDS ========== */
        .card {
            background: var(--cream-100);
            border: 1px solid var(--cream-400);
            border-radius: var(--radius-lg);
            padding: 1.8rem;
            box-shadow: var(--shadow);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--brown-700);
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--cream-300);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header i { color: var(--gold-dark); }

        /* ========== STAT CARDS ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 1.2rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--cream-100);
            border: 1px solid var(--cream-400);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: 0.3s;
            box-shadow: var(--shadow);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon.brown   { background: linear-gradient(135deg, var(--brown-500), var(--brown-400)); color: var(--cream-100); }
        .stat-icon.gold    { background: linear-gradient(135deg, var(--gold-dark), var(--gold)); color: var(--brown-900); }
        .stat-icon.green   { background: linear-gradient(135deg, var(--success), var(--info)); color: white; }
        .stat-icon.red     { background: linear-gradient(135deg, var(--danger), #a04545); color: white; }
        .stat-icon.cream   { background: linear-gradient(135deg, var(--cream-500), var(--brown-200)); color: var(--brown-800); }

        .stat-info h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--brown-700);
            line-height: 1;
        }

        .stat-info p {
            color: var(--text-light);
            font-size: 0.82rem;
            margin-top: 4px;
            font-weight: 500;
        }

        /* ========== GAME CARDS ========== */
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .game-card {
            background: var(--cream-100);
            border: 1px solid var(--cream-400);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.4s;
            box-shadow: var(--shadow);
        }

        .game-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: var(--gold);
        }

        .game-card-image {
            width: 100%;
            height: 190px;
            background: linear-gradient(135deg, var(--brown-700), var(--brown-600));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: var(--gold);
            position: relative;
            overflow: hidden;
        }

        .game-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .game-card-body {
            padding: 1.3rem 1.5rem 1.5rem;
        }

        .game-card-body h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--brown-700);
            margin-bottom: 0.5rem;
        }

        .game-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 0.8rem;
        }

        .game-meta span {
            font-size: 0.73rem;
            padding: 4px 12px;
            border-radius: 20px;
            background: var(--cream-300);
            color: var(--brown-600);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .game-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--gold-dark);
            margin-bottom: 0.8rem;
        }

        .game-desc {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.6;
        }

        .game-stock {
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .game-stock i { color: var(--success); }

        /* ========== BUTTONS ========== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border: none;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            letter-spacing: 0.2px;
        }

        .btn-sm { padding: 7px 16px; font-size: 0.8rem; }

        .btn-primary {
            background: linear-gradient(135deg, var(--brown-600), var(--brown-500));
            color: var(--cream-100);
        }
        .btn-primary:hover { opacity: 0.88; color: var(--cream-100); transform: translateY(-2px); box-shadow: 0 4px 15px rgba(92,58,46,0.3); }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold));
            color: var(--brown-900);
        }
        .btn-gold:hover { opacity: 0.88; color: var(--brown-900); transform: translateY(-2px); box-shadow: 0 4px 15px rgba(201,168,76,0.3); }

        .btn-success {
            background: linear-gradient(135deg, var(--success), var(--info));
            color: white;
        }
        .btn-success:hover { opacity: 0.88; color: white; transform: translateY(-2px); }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #a04545);
            color: white;
        }
        .btn-danger:hover { opacity: 0.88; color: white; }

        .btn-warning {
            background: linear-gradient(135deg, var(--gold-dark), var(--brown-300));
            color: var(--brown-900);
        }
        .btn-warning:hover { opacity: 0.88; color: var(--brown-900); }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--cream-400);
            color: var(--text-medium);
        }
        .btn-outline:hover { background: var(--cream-300); color: var(--text-medium); border-color: var(--brown-200); }

        .btn-block { width: 100%; justify-content: center; }

        /* ========== FORMS ========== */
        .form-group { margin-bottom: 1.2rem; }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-medium);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--cream-100);
            border: 2px solid var(--cream-400);
            border-radius: 10px;
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.15);
            background: white;
        }

        .form-control::placeholder { color: var(--brown-200); }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%235c3a2e' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }

        textarea.form-control { min-height: 110px; resize: vertical; }

        /* ========== TABLE ========== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: var(--radius);
            border: 1px solid var(--cream-400);
        }

        table { width: 100%; border-collapse: collapse; }

        th, td {
            padding: 14px 18px;
            text-align: left;
            border-bottom: 1px solid var(--cream-300);
            font-size: 0.85rem;
        }

        th {
            background: var(--cream-300);
            font-weight: 700;
            color: var(--brown-700);
            text-transform: uppercase;
            font-size: 0.73rem;
            letter-spacing: 0.8px;
            font-family: 'Poppins', sans-serif;
        }

        tr:hover td { background: var(--cream-200); }
        tr:last-child td { border-bottom: none; }

        /* ========== BADGES ========== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .badge-success { background: var(--success-light); color: var(--success); }
        .badge-danger  { background: var(--danger-light); color: var(--danger); }
        .badge-warning { background: var(--warning-light); color: var(--warning); }
        .badge-info    { background: var(--cream-300); color: var(--brown-600); }
        .badge-gold    { background: rgba(201,168,76,0.15); color: var(--gold-dark); }

        /* ========== PAGE HEADER ========== */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--brown-700);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 i { color: var(--gold-dark); }

        /* ========== FILTER BAR ========== */
        .filter-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-bar .form-control { max-width: 300px; }

        /* ========== WELCOME BANNER ========== */
        .welcome-banner {
            background: linear-gradient(135deg, var(--brown-700), var(--brown-600));
            border-radius: var(--radius-lg);
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            color: var(--cream-100);
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::after {
            content: '🎮';
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 5rem;
            opacity: 0.15;
        }

        .welcome-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 0.3rem;
        }

        .welcome-banner p { color: var(--cream-400); font-size: 0.9rem; }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-light);
        }

        .empty-state i { font-size: 3.5rem; margin-bottom: 1rem; opacity: 0.25; color: var(--brown-300); }
        .empty-state p { font-size: 0.95rem; }

        /* ========== FOOTER ========== */
        .footer {
            text-align: center;
            padding: 1.8rem 2rem;
            color: var(--text-light);
            font-size: 0.82rem;
            border-top: 2px solid var(--cream-400);
            background: var(--cream-100);
        }

        .footer i.fa-heart { color: var(--danger); }

        /* ========== UTILITIES ========== */
        .text-center { text-align: center; }
        .text-muted  { color: var(--text-light); }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .d-flex { display: flex; }
        .gap-1 { gap: 0.5rem; }
        .flex-wrap { flex-wrap: wrap; }

        .divider {
            height: 2px;
            background: linear-gradient(to right, transparent, var(--cream-400), transparent);
            margin: 2rem 0;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar-inner { flex-wrap: wrap; height: auto; padding: 12px 0; gap: 10px; }
            .navbar-links { flex-wrap: wrap; width: 100%; justify-content: center; }
            .navbar-user { width: 100%; justify-content: center; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .games-grid { grid-template-columns: 1fr; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .main-content { padding: 1rem; }
            .welcome-banner::after { display: none; }
            .rent-grid { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body>

<?php if (session()->get('isLoggedIn')): ?>
<nav class="navbar">
    <div class="navbar-inner">
        <a href="/" class="navbar-brand">
            <i class="fas fa-gamepad"></i>
            <span>RentalGame</span>
        </a>

        <div class="navbar-links">
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="/admin/dashboard" class="<?= str_contains(current_url(), 'admin/dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <a href="/admin/games" class="<?= str_contains(current_url(), 'admin/games') ? 'active' : '' ?>">
                    <i class="fas fa-gamepad"></i> Game
                </a>
                <a href="/admin/users" class="<?= str_contains(current_url(), 'admin/users') ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> User
                </a>
                <a href="/admin/transactions" class="<?= str_contains(current_url(), 'admin/transactions') ? 'active' : '' ?>">
                    <i class="fas fa-receipt"></i> Transaksi
                </a>
            <?php else: ?>
                <a href="/user/dashboard" class="<?= str_contains(current_url(), 'user/dashboard') ? 'active' : '' ?>">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="/user/games" class="<?= str_contains(current_url(), 'user/games') ? 'active' : '' ?>">
                    <i class="fas fa-gamepad"></i> Katalog
                </a>
                <a href="/user/transactions" class="<?= str_contains(current_url(), 'user/transactions') ? 'active' : '' ?>">
                    <i class="fas fa-receipt"></i> Transaksi
                </a>
            <?php endif; ?>
        </div>

        <div class="navbar-user">
            <div class="user-info">
                <div class="name"><?= esc(session()->get('username')) ?></div>
                <div class="role"><?= esc(session()->get('role')) ?></div>
            </div>
            <a href="/logout" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="main-content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-error">
            <div>
                <i class="fas fa-exclamation-triangle"></i> <strong>Error:</strong>
                <ul style="margin: 8px 0 0 20px; list-style: disc;">
                    <?php foreach (session()->getFlashdata('errors') as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<div class="footer">
    &copy; <?= date('Y') ?> <strong>RentalGame</strong> — Dibuat dengan
    <i class="fas fa-heart"></i> menggunakan CodeIgniter 4
</div>

<script>
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(el) {
            el.style.transition = 'all 0.5s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            setTimeout(() => el.remove(), 500);
        });
    }, 5000);
</script>
</body>
</html>