<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-receipt"></i> Kelola Transaksi</h1>
</div>

<div class="card">
    <?php if (!empty($transactions)): ?>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>#</th><th>User</th><th>Game</th><th>Sewa</th><th>Kembali</th><th>Hari</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($transactions as $i => $t): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= esc($t['username']) ?></strong></td>
                    <td><?= esc($t['game_title']) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['rental_date'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($t['return_date'])) ?></td>
                    <td><?= $t['total_days'] ?> hari</td>
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
                    <td>
                        <?php if ($t['status'] === 'ongoing'): ?>
                            <a href="/admin/transactions/return/<?= $t['id'] ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi pengembalian?')"><i class="fas fa-undo"></i> Return</a>
                        <?php elseif ($t['actual_return_date']): ?>
                            <small class="text-muted"><?= date('d/m/Y', strtotime($t['actual_return_date'])) ?></small>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state"><i class="fas fa-receipt"></i><p>Belum ada transaksi</p></div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>