<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-users"></i> Kelola User</h1>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead><tr><th>#</th><th>Username</th><th>Email</th><th>HP</th><th>Role</th><th>Tgl Daftar</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($users as $i => $user): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= esc($user['username']) ?></strong></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['phone'] ?? '-') ?></td>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="badge badge-gold"><i class="fas fa-crown"></i> Admin</span>
                        <?php else: ?>
                            <span class="badge badge-info"><i class="fas fa-user"></i> User</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                    <td>
                        <?php if ($user['id'] != session()->get('user_id')): ?>
                            <a href="/admin/users/delete/<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus user ini?')"><i class="fas fa-trash"></i></a>
                        <?php else: ?>
                            <span class="badge badge-success">Anda</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>