<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="<?= base_url('perpus/css/report_style.css') ?>">
</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Kelola Laporan';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="card-admin" style="display: flex; justify-content: space-between; align-items: center; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 700; color: white;"><i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan Perpustakaan</h2>
                        <p style="color: var(--text-muted);">Statistik penggunaan, peminjaman, dan denda.</p>
                    </div>
                    <button onclick="window.print()" class="btn-print">
                        <i class="bi bi-printer-fill"></i> Cetak Laporan
                    </button>
                </div>

                <div class="filter-section">
                    <form action="" method="get" class="filter-form">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="start_date" value="<?= esc($start_date) ?>">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="end_date" value="<?= esc($end_date) ?>">
                        </div>
                        <button type="submit" class="btn-primary-modern" style="padding: 12px 25px;">
                            <i class="bi bi-filter"></i> Filter Data
                        </button>
                        <a href="<?= base_url('perpus/kelola-laporan') ?>" class="btn-primary-modern" style="padding: 12px 25px; background: #95a5a6;">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </form>
                </div>

                <div class="report-stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Pengguna Aktif (30 Hari)</h4>
                            <p class="value"><?= $user_aktif ?> / <?= $total_siswa ?></p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Total Peminjaman</h4>
                            <p class="value"><?= count($laporan_peminjaman) ?></p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(241, 196, 15, 0.1); color: #f1c40f;">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Denda Diterima</h4>
                            <p class="value">Rp <?= number_format($denda_lunas, 0, ',', '.') ?></p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="stat-info">
                            <h4>Denda Tertunda</h4>
                            <p class="value">Rp <?= number_format($denda_pending, 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>

                <div class="table-container-admin">
                    <div style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="margin: 0; color: #2c3e50;"><i class="bi bi-list-task"></i> Detail Aktivitas Peminjaman</h3>
                        <span style="font-size: 0.85rem; color: #7f8c8d;">Periode: <?= date('d M Y', strtotime($start_date)) ?> - <?= date('d M Y', strtotime($end_date)) ?></span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($laporan_peminjaman)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 60px 20px;">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #eee; display: block; margin-bottom: 10px;"></i>
                                        <p style="color: #bdc3c7;">Tidak ada aktivitas peminjaman pada periode ini.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($laporan_peminjaman as $index => $lp): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <div style="font-weight: 600; color: #2c3e50;"><?= esc($lp['nama_lengkap']) ?></div>
                                            <div style="font-size: 0.75rem; color: #95a5a6;"><?= esc($lp['kelas']) ?></div>
                                        </td>
                                        <td><?= esc($lp['judul']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($lp['tanggal_pinjam'])) ?></td>
                                        <td><?= date('d/m/Y', strtotime($lp['tanggal_kembali'])) ?></td>
                                        <td>
                                            <?php 
                                                $status_class = '';
                                                $status_label = ucfirst($lp['status']);
                                                if($lp['status'] == 'dipinjam') $status_class = 'background: #e3f2fd; color: #1976d2;';
                                                elseif($lp['status'] == 'dikembalikan') $status_class = 'background: #e8f5e9; color: #2e7d32;';
                                                elseif($lp['status'] == 'terlambat') $status_class = 'background: #fff3e0; color: #ef6c00;';
                                            ?>
                                            <span class="badge-modern" style="<?= $status_class ?>"><?= $status_label ?></span>
                                        </td>
                                        <td>
                                            <?php if($lp['denda'] > 0): ?>
                                                <span style="color: <?= $lp['is_denda_lunas'] ? '#2ecc71' : '#e74c3c' ?>; font-weight: 600;">
                                                    Rp <?= number_format($lp['denda'], 0, ',', '.') ?>
                                                    <?php if($lp['is_denda_lunas']): ?>
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    <?php endif; ?>
                                                </span>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
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
    
    <script>
        // Optional: Add some chart initialization here if needed in the future
    </script>
</body>
</html>
