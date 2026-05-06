<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div style="text-align:center; padding:4rem 2rem; background:linear-gradient(135deg, var(--brown-700), var(--brown-600)); border-radius:20px; margin-bottom:3rem; position:relative; overflow:hidden;">
    <div style="position:absolute; top:0; left:0; right:0; bottom:0; background:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2260%22 height=%2260%22><circle cx=%2230%22 cy=%2230%22 r=%221%22 fill=%22rgba(201,168,76,0.08)%22/></svg>');"></div>
    <div style="position:relative; z-index:1;">
        <div style="font-size:4rem; margin-bottom:1rem;">🎮</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:2.8rem; font-weight:800; color:var(--gold); margin-bottom:0.8rem;">
            Rental Game Center
        </h1>
        <p style="color:var(--cream-400); font-size:1.1rem; max-width:600px; margin:0 auto 2rem; line-height:1.8;">
            Sewa game favoritmu dengan mudah dan cepat!
            Tersedia berbagai pilihan game dari PS5, Nintendo Switch, PC dan lainnya.
        </p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <?php if (session()->get('isLoggedIn')): ?>
                <?php if (session()->get('role') === 'admin'): ?>
                    <a href="/admin/dashboard" class="btn btn-gold"><i class="fas fa-chart-pie"></i> Admin Dashboard</a>
                <?php else: ?>
                    <a href="/user/games" class="btn btn-gold"><i class="fas fa-gamepad"></i> Lihat Katalog</a>
                    <a href="/user/dashboard" class="btn btn-outline" style="border-color:var(--cream-400); color:var(--cream-300);">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="/login" class="btn btn-gold"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                <a href="/register" class="btn btn-outline" style="border-color:var(--cream-400); color:var(--cream-300);">
                    <i class="fas fa-user-plus"></i> Daftar Baru
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- FEATURES -->
<div class="stats-grid" style="margin-bottom:3rem;">
    <div class="stat-card">
        <div class="stat-icon brown"><i class="fas fa-gamepad"></i></div>
        <div class="stat-info">
            <h3><?= $totalGames ?>+</h3>
            <p>Koleksi Game</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-coins"></i></div>
        <div class="stat-info">
            <h3>Murah</h3>
            <p>Harga Terjangkau</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-bolt"></i></div>
        <div class="stat-info">
            <h3>Cepat</h3>
            <p>Proses Mudah</p>
        </div>
    </div>
</div>

<!-- GAMES -->
<?php if (!empty($games)): ?>
<div class="page-header">
    <h1><i class="fas fa-fire"></i> Game Tersedia</h1>
    <?php if (session()->get('isLoggedIn') && session()->get('role') === 'user'): ?>
        <a href="/user/games" class="btn btn-primary"><i class="fas fa-th"></i> Lihat Semua</a>
    <?php endif; ?>
</div>

<div class="games-grid">
    <?php foreach ($games as $game): ?>
    <div class="game-card">
        <div class="game-card-image">
            <?php if ($game['image'] && file_exists('uploads/games/' . $game['image'])): ?>
                <img src="/uploads/games/<?= esc($game['image']) ?>" alt="<?= esc($game['title']) ?>">
            <?php else: ?>
                <i class="fas fa-gamepad"></i>
            <?php endif; ?>
        </div>
        <div class="game-card-body">
            <h3><?= esc($game['title']) ?></h3>
            <div class="game-meta">
                <span><i class="fas fa-tag"></i> <?= esc($game['genre']) ?></span>
                <span><i class="fas fa-desktop"></i> <?= esc($game['platform']) ?></span>
            </div>
            <div class="game-price">
                <i class="fas fa-coins"></i> Rp <?= number_format($game['price_per_day'], 0, ',', '.') ?>/hari
            </div>
            <p class="game-desc"><?= esc($game['description']) ?></p>
            <?php if (session()->get('isLoggedIn') && session()->get('role') === 'user'): ?>
                <a href="/user/rent/<?= $game['id'] ?>" class="btn btn-gold btn-sm btn-block">
                    <i class="fas fa-shopping-cart"></i> Sewa Sekarang
                </a>
            <?php elseif (!session()->get('isLoggedIn')): ?>
                <a href="/login" class="btn btn-outline btn-sm btn-block">
                    <i class="fas fa-sign-in-alt"></i> Login untuk Sewa
                </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?= $this->endSection() ?>