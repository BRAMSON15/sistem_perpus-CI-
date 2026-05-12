<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <?php 
                $page_title = 'Admin Dashboard';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <!-- Content Area -->
            <main class="content-area">
                <div class="welcome-banner">
                    <div style="font-size: 4rem; color: var(--primary);">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div class="welcome-text">
                        <h2>Halo, Admin <?= esc($username) ?></h2>
                        <p>Pantau semua aktivitas perpustakaan dalam satu kendali pusat.</p>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid-modern">
                    <div class="stat-card-glass">
                        <div class="stat-header">
                            <div class="stat-icon-box blue"><i class="bi bi-book-half"></i></div>
                            <i class="bi bi-three-dots-vertical" style="color: var(--text-muted);"></i>
                        </div>
                        <div class="stat-body">
                            <h3><?= $total_buku ?></h3>
                            <p>Total Koleksi</p>
                        </div>
                    </div>

                    <div class="stat-card-glass">
                        <div class="stat-header">
                            <div class="stat-icon-box green"><i class="bi bi-people-fill"></i></div>
                        </div>
                        <div class="stat-body">
                            <h3><?= $total_siswa ?></h3>
                            <p>Siswa Terdaftar</p>
                        </div>
                    </div>

                    <div class="stat-card-glass">
                        <div class="stat-header">
                            <div class="stat-icon-box orange"><i class="bi bi-arrow-left-right"></i></div>
                        </div>
                        <div class="stat-body">
                            <h3><?= $sedang_dipinjam ?></h3>
                            <p>Aktif Meminjam</p>
                        </div>
                    </div>

                    <div class="stat-card-glass">
                        <div class="stat-header">
                            <div class="stat-icon-box red"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        </div>
                        <div class="stat-body">
                            <h3><?= $total_terlambat ?></h3>
                            <p>Terlambat Kembali</p>
                        </div>
                    </div>

                    <div class="stat-card-glass">
                        <div class="stat-header">
                            <div class="stat-icon-box orange"><i class="bi bi-cash-coin"></i></div>
                        </div>
                        <div class="stat-body">
                            <h3>Rp <?= number_format($total_denda, 0, ',', '.') ?></h3>
                            <p>Total Denda Masuk</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
