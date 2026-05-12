<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Perpustakaan</title>
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
                $page_title = 'Ringkasan Aktifitas';
                include APPPATH . 'Views/perpus/siswa/topbar.php'; 
            ?>

            <!-- Content Area -->
            <main class="content-area">
                <div class="welcome-card">
                    <h2><i class="bi bi-hand-wave"></i> Selamat Datang, <?= esc($username) ?>!</h2>
                    <p>Jelajahi koleksi buku dan kelola peminjaman Anda dengan mudah</p>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="bi bi-book-fill"></i></div>
                        <div class="stat-info">
                            <h3><?= $total_dipinjam ?></h3>
                            <p>Buku Dipinjam</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="bi bi-journal-check"></i></div>
                        <div class="stat-info">
                            <h3><?= $total_riwayat ?></h3>
                            <p>Riwayat Peminjaman</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="bi bi-clock-history"></i></div>
                        <div class="stat-info">
                            <h3><?= $total_jatuh_tempo ?></h3>
                            <p>Buku Jatuh Tempo</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;"><i class="bi bi-wallet2"></i></div>
                        <div class="stat-info">
                            <h3>Rp <?= number_format($total_denda_saya, 0, ',', '.') ?></h3>
                            <p>Tagihan Denda</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
