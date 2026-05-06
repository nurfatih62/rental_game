<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-<?= $game ? 'edit' : 'plus-circle' ?>"></i> <?= $game ? 'Edit Game' : 'Tambah Game Baru' ?></h1>
    <a href="/admin/games" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card" style="max-width:700px;">
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label><i class="fas fa-heading"></i> Judul Game *</label>
            <input type="text" name="title" class="form-control" value="<?= old('title', $game['title'] ?? '') ?>" placeholder="Masukkan judul game" required>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label><i class="fas fa-tag"></i> Genre *</label>
                <select name="genre" class="form-control" required>
                    <option value="">Pilih Genre</option>
                    <?php foreach (['Action Adventure','Action RPG','Sports','Racing','Horror','Puzzle','Fighting','Simulation','Strategy'] as $g): ?>
                        <option value="<?= $g ?>" <?= (old('genre', $game['genre'] ?? '') === $g) ? 'selected' : '' ?>><?= $g ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label><i class="fas fa-desktop"></i> Platform *</label>
                <select name="platform" class="form-control" required>
                    <option value="">Pilih Platform</option>
                    <?php foreach (['PS5','PS4','Nintendo Switch','Xbox Series X','PC','PS5/PC','Multi-Platform'] as $p): ?>
                        <option value="<?= $p ?>" <?= (old('platform', $game['platform'] ?? '') === $p) ? 'selected' : '' ?>><?= $p ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div class="form-group">
                <label><i class="fas fa-coins"></i> Harga/Hari (Rp) *</label>
                <input type="number" name="price_per_day" class="form-control" value="<?= old('price_per_day', $game['price_per_day'] ?? '') ?>" placeholder="15000" min="1000" required>
            </div>
            <div class="form-group">
                <label><i class="fas fa-boxes-stacked"></i> Stok *</label>
                <input type="number" name="stock" class="form-control" value="<?= old('stock', $game['stock'] ?? 1) ?>" placeholder="1" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label><i class="fas fa-image"></i> Gambar Game</label>
            <?php if ($game && $game['image']): ?>
                <div style="margin-bottom:8px;">
                    <img src="/uploads/games/<?= esc($game['image']) ?>" style="width:100px;height:100px;object-fit:cover;border-radius:10px;border:2px solid var(--cream-400);">
                    <p style="font-size:0.8rem;color:var(--text-light);margin-top:4px;">Upload baru untuk mengganti</p>
                </div>
            <?php endif; ?>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="form-group">
            <label><i class="fas fa-align-left"></i> Deskripsi *</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Deskripsi singkat game" required><?= old('description', $game['description'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-gold btn-block" style="margin-top:0.5rem;">
            <i class="fas fa-save"></i> <?= $game ? 'Update Game' : 'Simpan Game' ?>
        </button>
    </form>
</div>

<?= $this->endSection() ?>