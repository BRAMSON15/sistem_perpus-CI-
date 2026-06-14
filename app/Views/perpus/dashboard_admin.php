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

                <!-- Tabel Aktivitas Scan Kartu -->
                <div class="card-admin" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0; margin-top: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h2 style="font-size: 1.4rem; font-weight: 700; color: white; display: flex; align-items: center; gap: 10px;">
                                <i class="bi bi-upc-scan"></i> Aktivitas Scan Kartu
                            </h2>
                            <p style="color: var(--text-muted); font-size: 0.85rem;">Riwayat scan kartu perpustakaan terbaru</p>
                        </div>
                        <a href="<?= base_url('perpus/scan-kartu') ?>" class="btn-primary-modern" style="padding: 10px 20px;">
                            <i class="bi bi-upc-scan"></i> Buka Scanner
                        </a>
                    </div>
                </div>

                <div class="table-container-admin" style="border-top-left-radius: 0; border-top-right-radius: 0;">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Waktu</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($scan_activities)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 60px 20px;">
                                        <i class="bi bi-upc-scan" style="font-size: 3rem; color: #e1e8f0; display: block; margin-bottom: 10px;"></i>
                                        <h4 style="color: #bdc3c7; font-weight: 600;">Belum ada aktivitas scan</h4>
                                        <p style="color: #dfe6e9; font-size: 0.8rem;">Scan kartu perpustakaan untuk memulai pencatatan</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($scan_activities as $i => $scan): ?>
                                    <tr>
                                        <td style="color: #95a5a6; font-size: 0.8rem;"><?= $i + 1 ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <div style="width: 34px; height: 34px; border-radius: 8px; background: #f1f2f6; color: #3498db; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">
                                                    <?= strtoupper(substr($scan['nama_lengkap'], 0, 1)) ?>
                                                </div>
                                                <div style="font-weight: 700; color: #2c3e50;"><?= esc($scan['nama_lengkap']) ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-modern" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                                                <?= esc($scan['kelas'] ?? '-') ?>
                                            </span>
                                        </td>
                                        <td style="font-size: 0.85rem; color: #7f8c8d;">
                                            <i class="bi bi-clock" style="margin-right: 4px;"></i>
                                            <?= date('H:i:s', strtotime($scan['scan_time'])) ?>
                                        </td>
                                        <td style="font-size: 0.85rem; color: #95a5a6;">
                                            <i class="bi bi-calendar3" style="margin-right: 4px;"></i>
                                            <?= date('d M Y', strtotime($scan['scan_time'])) ?>
                                        </td>
                                        <td>
                                            <span class="badge-modern" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                                                <i class="bi bi-check-circle-fill"></i> Aktif
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
