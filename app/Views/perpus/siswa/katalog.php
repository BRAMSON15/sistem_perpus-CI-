<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Buku - Perpustakaan</title>
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
                $page_title = 'Explore Katalog';
                include APPPATH . 'Views/perpus/siswa/topbar.php'; 
            ?>

            <!-- Content Area -->
            <main class="content-area">
                <div class="page-header-card">
                    <h2>Koleksi Buku Terkini</h2>
                    <p>Temukan sumber pengetahuan terbaik untuk mendukung belajar Anda.</p>
                </div>

                <div class="book-grid">
                    <?php if(empty($buku)): ?>
                        <div style="grid-column: 1/-1; text-align: center; padding: 100px 20px; background: rgba(255,255,255,0.02); border-radius: 20px; border: 1px dashed var(--glass-border);">
                            <i class="bi bi-inbox-fill" style="font-size: 5rem; color: rgba(255,255,255,0.1); margin-bottom: 20px; display: block;"></i>
                            <h3 style="font-size: 1.5rem; margin-bottom: 10px;">Belum ada buku tersedia</h3>
                            <p style="color: var(--text-muted);">Silakan kembali lagi nanti atau hubungi petugas perpustakaan.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($buku as $b): ?>
                            <div class="book-card">
                                <div class="book-image-container">
                                    <?php if($b['gambar'] && file_exists(FCPATH . 'uploads/buku/' . $b['gambar'])): ?>
                                        <img src="<?= base_url('uploads/buku/' . $b['gambar']) ?>" alt="<?= esc($b['judul']) ?>">
                                    <?php else: ?>
                                        <div class="book-placeholder">
                                            <i class="bi bi-journal-bookmark"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="book-details">
                                    <span class="book-category"><?= esc($b['kategori']) ?></span>
                                    <h3 class="book-title"><?= esc($b['judul']) ?></h3>
                                    <div class="book-meta">
                                        <div class="meta-item">
                                            <i class="bi bi-person-fill"></i>
                                            <span><?= esc($b['pengarang']) ?></span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="bi bi-building"></i>
                                            <span><?= esc($b['penerbit']) ?></span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="bi bi-calendar-check"></i>
                                            <span>Tahun: <?= esc($b['tahun_terbit']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="book-footer">
                                    <span class="stock-badge">Stok: <?= esc($b['tersedia']) ?></span>
                                    <a href="<?= base_url('perpus/pinjam-buku/' . $b['id']) ?>" class="btn-pinjam">
                                        <i class="bi bi-cart-plus"></i> Pinjam
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
