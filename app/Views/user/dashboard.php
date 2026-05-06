<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-home"></i> Dashboard</h1>
</div>

<div class="welcome-banner">
    <h2>Halo, <?= esc(session()->get('username')) ?>! 👋</h2>
    <p>Selamat datang di Rental Game. Temukan dan sewa game favoritmu!</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-clock"></i></div>
        <div class="stat-info"><h3><?= $activeRentals ?></h3><p>Sedang Disewa</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon brown"><i class="fas fa-history"></i></div>
        <div class="stat-info"><h3><?= $totalRentals ?></h3><p>Total Penyewaan</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-gamepad"></i></div>
        <div class="stat-info"><h3><?= $availableGames ?></h3><p>Game Tersedia</p></div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <a href="/user/games" class="btn btn-gold btn-block"><i class="fas fa-gamepad"></i> Lihat Katalog</a>
    <a href="/user/transactions" class="btn btn-outline btn-block"><i class="fas fa-receipt"></i> Riwayat Transaksi</a>
</div>

<?php
$active = array_filter($transactions, fn($t) => $t['status'] === 'ongoing');
if (!empty($active)):
?>
<div class="card mt-3">
    <div class="card-header"><i class="fas fa-clock"></i> Game yang Sedang Disewa</div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>Game</th><th>Platform</th><th>Sewa</th><th>Batas Kembali</th><th>Total</th><th>Status</th></tr></thead>
            <tbody>
                <?php foreach ($active as $t): ?>
                <tr>
                    <td><strong><?= esc($t['game_title']) ?></strong></td>
                    <td><?= esc($t['platform']) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['rental_date'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['return_date'])) ?></td>
                    <td><strong>Rp <?= number_format($t['total_price'], 0, ',', '.') ?></strong></td>
                    <td><span class="badge badge-warning"><i class="fas fa-clock"></i> Disewa</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>