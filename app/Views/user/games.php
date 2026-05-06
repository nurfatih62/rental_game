<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-gamepad"></i> Katalog Game</h1>
</div>

<form action="/user/games" method="GET" class="filter-bar">
    <input type="text" name="search" class="form-control" placeholder="🔍 Cari game..." value="<?= esc($search ?? '') ?>">
    <select name="genre" class="form-control" onchange="this.form.submit()" style="max-width:200px;">
        <option value="">Semua Genre</option>
        <?php foreach ($genres as $g): ?>
            <option value="<?= esc($g) ?>" <?= ($selectedGenre ?? '') === $g ? 'selected' : '' ?>><?= esc($g) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
    <?php if ($search || $selectedGenre): ?>
        <a href="/user/games" class="btn btn-outline"><i class="fas fa-times"></i> Reset</a>
    <?php endif; ?>
</form>

<?php if (!empty($games)): ?>
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
            <div class="game-price"><i class="fas fa-coins"></i> Rp <?= number_format($game['price_per_day'], 0, ',', '.') ?> / hari</div>
            <div class="game-stock"><i class="fas fa-boxes-stacked"></i> Stok: <?= $game['stock'] ?></div>
            <p class="game-desc"><?= esc($game['description']) ?></p>
            <a href="/user/rent/<?= $game['id'] ?>" class="btn btn-gold btn-sm btn-block"><i class="fas fa-shopping-cart"></i> Sewa Sekarang</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="empty-state">
    <i class="fas fa-search"></i>
    <p>Tidak ada game ditemukan.</p>
    <a href="/user/games" class="btn btn-outline mt-2">Lihat semua game</a>
</div>
<?php endif; ?>

<?= $this->endSection() ?>