<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <h1><i class="fas fa-shopping-cart"></i> Sewa Game</h1>
    <a href="/user/games" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="rent-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; align-items:start;">
    <div class="card">
        <div class="game-card-image" style="height:220px; border-radius:10px; margin-bottom:1.2rem;">
            <?php if ($game['image'] && file_exists('uploads/games/' . $game['image'])): ?>
                <img src="/uploads/games/<?= esc($game['image']) ?>" alt="<?= esc($game['title']) ?>">
            <?php else: ?>
                <i class="fas fa-gamepad"></i>
            <?php endif; ?>
        </div>
        <h2 style="font-family:'Playfair Display',serif; color:var(--brown-700); margin-bottom:0.5rem;"><?= esc($game['title']) ?></h2>
        <div class="game-meta" style="margin-bottom:1rem;">
            <span><i class="fas fa-tag"></i> <?= esc($game['genre']) ?></span>
            <span><i class="fas fa-desktop"></i> <?= esc($game['platform']) ?></span>
        </div>
        <div class="game-price" style="font-size:1.4rem; margin-bottom:1rem;"><i class="fas fa-coins"></i> Rp <?= number_format($game['price_per_day'], 0, ',', '.') ?> / hari</div>
        <div class="game-stock mb-2"><i class="fas fa-boxes-stacked"></i> Stok tersedia: <?= $game['stock'] ?></div>
        <p class="text-muted" style="font-size:0.9rem; line-height:1.7;"><?= esc($game['description']) ?></p>
    </div>

    <div class="card">
        <div class="card-header"><i class="fas fa-file-invoice"></i> Form Penyewaan</div>

        <form action="/user/rent/<?= $game['id'] ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Nama Penyewa</label>
                <input type="text" class="form-control" value="<?= esc(session()->get('username')) ?>" disabled style="background:var(--cream-300);">
            </div>

            <div class="form-group">
                <label>Game</label>
                <input type="text" class="form-control" value="<?= esc($game['title']) ?>" disabled style="background:var(--cream-300);">
            </div>

            <div class="form-group">
                <label>Tanggal Sewa</label>
                <input type="text" class="form-control" value="<?= date('d/m/Y') ?>" disabled style="background:var(--cream-300);">
            </div>

            <div class="form-group">
                <label><i class="fas fa-calendar-alt"></i> Lama Sewa (Hari) *</label>
                <input type="number" name="total_days" id="totalDays" class="form-control" min="1" max="30" value="<?= old('total_days', 1) ?>" required oninput="hitungHarga()">
            </div>

            <div style="background:var(--cream-300); border:2px solid var(--cream-400); border-radius:12px; padding:1.2rem; margin-bottom:1.2rem;">
                <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                    <span class="text-muted">Harga/hari:</span>
                    <span>Rp <?= number_format($game['price_per_day'], 0, ',', '.') ?></span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                    <span class="text-muted">Lama sewa:</span>
                    <span id="tampilHari">1 hari</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding-top:0.8rem; border-top:2px solid var(--cream-400);">
                    <span style="font-weight:800; font-size:1.1rem; color:var(--brown-700);">Total Bayar:</span>
                    <span style="font-weight:800; font-size:1.2rem; color:var(--gold-dark);" id="totalHarga">
                        Rp <?= number_format($game['price_per_day'], 0, ',', '.') ?>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-gold btn-block" onclick="return confirm('Konfirmasi sewa game ini?')">
                <i class="fas fa-check-circle"></i> Konfirmasi Sewa
            </button>
        </form>
    </div>
</div>

<script>
    const hargaPerHari = <?= $game['price_per_day'] ?>;
    function hitungHarga() {
        const hari = parseInt(document.getElementById('totalDays').value) || 1;
        const total = hari * hargaPerHari;
        document.getElementById('tampilHari').textContent = hari + ' hari';
        document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>

<?= $this->endSection() ?>