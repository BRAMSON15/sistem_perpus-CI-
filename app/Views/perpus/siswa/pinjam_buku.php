<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pinjam - Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('perpus/css/siswa_style.css') ?>">
</head>
<body>
    <div class="siswa-container">
        <?php include APPPATH . 'Views/perpus/siswa/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Sewa Buku';
                include APPPATH . 'Views/perpus/siswa/topbar.php'; 
            ?>

            <!-- Content Area -->
            <main class="content-area">
                <div class="card-solid">
                    <div class="book-preview">
                        <div class="book-image-container">
                            <?php if($buku['gambar'] && file_exists(FCPATH . 'uploads/buku/' . $buku['gambar'])): ?>
                                <img src="<?= base_url('uploads/buku/' . $buku['gambar']) ?>" alt="<?= esc($buku['judul']) ?>">
                            <?php else: ?>
                                <div class="book-placeholder">
                                    <i class="bi bi-book"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="book-info-panel">
                        <div class="book-header">
                            <h2><?= esc($buku['judul']) ?></h2>
                            <p>Oleh <?= esc($buku['pengarang']) ?></p>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <label>Kategori</label>
                                <span><?= esc($buku['kategori']) ?></span>
                            </div>
                            <div class="info-item">
                                <label>Penerbit</label>
                                <span><?= esc($buku['penerbit']) ?></span>
                            </div>
                            <div class="info-item">
                                <label>Tahun</label>
                                <span><?= esc($buku['tahun_terbit']) ?></span>
                            </div>
                            <div class="info-item">
                                <label>Stok</label>
                                <span style="color: #2ecc71;"><?= esc($buku['tersedia']) ?> Tersedia</span>
                            </div>
                        </div>

                        <div class="pinjam-summary">
                            <div class="summary-row">
                                <label>Tanggal Pinjam</label>
                                <span><?= date('d M Y') ?></span>
                            </div>
                            <div class="summary-row">
                                <label>Batas Kembali</label>
                                <span style="color: #e67e22;"><?= date('d M Y', strtotime('+7 days')) ?></span>
                            </div>
                            <div class="summary-row">
                                <label>Durasi Sewa</label>
                                <span>7 Hari Kalender</span>
                            </div>
                        </div>

                        <form action="<?= base_url('perpus/proses-pinjam') ?>" method="post" class="action-group">
                            <?= csrf_field() ?>
                            <input type="hidden" name="buku_id" value="<?= $buku['id'] ?>">
                            <a href="<?= base_url('perpus/katalog') ?>" class="btn btn-cancel">Batal</a>
                            <button type="submit" class="btn btn-confirm">
                                <i class="bi bi-check-circle-fill"></i>
                                Pinjam Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
