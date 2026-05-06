<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-gamepad"></i> Kelola Game</h1>
    <a href="/admin/games/create" class="btn btn-gold"><i class="fas fa-plus"></i> Tambah Game</a>
</div>

<div class="card">
    <?php if (!empty($games)): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>#</th><th>Gambar</th><th>Judul</th><th>Genre</th><th>Platform</th><th>Harga/Hari</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($games as $i => $game): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <?php if ($game['image'] && file_exists('uploads/games/' . $game['image'])): ?>
                            <img src="/uploads/games/<?= esc($game['image']) ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;border:2px solid var(--cream-400);">
                        <?php else: ?>
                            <div style="width:50px;height:50px;background:var(--cream-300);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-gamepad" style="color:var(--brown-400);"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= esc($game['title']) ?></strong></td>
                    <td><span class="badge badge-info"><?= esc($game['genre']) ?></span></td>
                    <td><?= esc($game['platform']) ?></td>
                    <td><strong>Rp <?= number_format($game['price_per_day'], 0, ',', '.') ?></strong></td>
                    <td><?= $game['stock'] ?></td>
                    <td>
                        <?php if ($game['status'] === 'tersedia'): ?>
                            <span class="badge badge-success">Tersedia</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Disewa</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="/admin/games/edit/<?= $game['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="/admin/games/delete/<?= $game['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus game ini?')"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty-state"><i class="fas fa-gamepad"></i><p>Belum ada game. <a href="/admin/games/create">Tambah game baru</a></p></div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>