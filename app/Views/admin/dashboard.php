<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-chart-pie"></i> Admin Dashboard</h1>
    <a href="/admin/games/create" class="btn btn-gold"><i class="fas fa-plus"></i> Tambah Game</a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon brown"><i class="fas fa-gamepad"></i></div>
        <div class="stat-info"><h3><?= $totalGames ?></h3><p>Total Game</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info"><h3><?= $gamesAvailable ?></h3><p>Tersedia</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-clock"></i></div>
        <div class="stat-info"><h3><?= $gamesRented ?></h3><p>Sedang Disewa</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon cream"><i class="fas fa-users"></i></div>
        <div class="stat-info"><h3><?= $totalUsers ?></h3><p>Total User</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon gold"><i class="fas fa-receipt"></i></div>
        <div class="stat-info"><h3><?= $totalTransactions ?></h3><p>Total Transaksi</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info"><h3>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h3><p>Total Pendapatan</p></div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
    <a href="/admin/games/create" class="btn btn-gold btn-block"><i class="fas fa-plus"></i> Tambah Game</a>
    <a href="/admin/games" class="btn btn-primary btn-block"><i class="fas fa-list"></i> Kelola Game</a>
    <a href="/admin/transactions" class="btn btn-success btn-block"><i class="fas fa-receipt"></i> Transaksi</a>
    <a href="/admin/users" class="btn btn-outline btn-block"><i class="fas fa-users"></i> Kelola User</a>
</div>

<div class="card mt-3">
    <div class="card-header"><i class="fas fa-history"></i> Transaksi Terbaru</div>
    <?php if (!empty($recentTransactions)): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>User</th><th>Game</th><th>Tanggal Sewa</th><th>Kembali</th><th>Total</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($recentTransactions, 0, 5) as $t): ?>
                <tr>
                    <td><strong><?= esc($t['username']) ?></strong></td>
                    <td><?= esc($t['game_title']) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['rental_date'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['return_date'])) ?></td>
                    <td><strong>Rp <?= number_format($t['total_price'], 0, ',', '.') ?></strong></td>
                    <td>
                        <?php if ($t['status'] === 'ongoing'): ?>
                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Disewa</span>
                        <?php elseif ($t['status'] === 'returned'): ?>
                            <span class="badge badge-success"><i class="fas fa-check"></i> Kembali</span>
                        <?php else: ?>
                            <span class="badge badge-danger"><i class="fas fa-exclamation"></i> Overdue</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada transaksi</p></div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>