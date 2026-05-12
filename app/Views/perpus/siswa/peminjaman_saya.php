<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya - Perpustakaan</title>
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
                $page_title = 'Histori Pinjam';
                include APPPATH . 'Views/perpus/siswa/topbar.php'; 
            ?>

            <!-- Content Area -->
            <main class="content-area">
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i> 
                        <span><?= session()->getFlashdata('success') ?></span>
                    </div>
                <?php endif; ?>

                <div class="page-header-card">
                    <h2>Riwayat Peminjaman</h2>
                    <p>Pantau koleksi yang sedang Anda pinjam dan riwayat pengembalian Anda.</p>
                </div>

                <div class="table-container-modern">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Dikembalikan</th>
                                <th>Status</th>
                                <th style="text-align: right;">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($peminjaman)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 100px 20px;">
                                        <i class="bi bi-folder-x" style="font-size: 4rem; color: rgba(255,255,255,0.1); display: block; margin-bottom: 20px;"></i>
                                        <h3 style="color: var(--text-muted); font-weight: 500;">Belum ada riwayat pinjam</h3>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($peminjaman as $index => $p): ?>
                                    <tr>
                                        <td style="color: var(--text-muted); font-weight: 600;"><?= $index + 1 ?></td>
                                        <td>
                                            <div style="font-weight: 700; color: white; font-size: 1.05rem; margin-bottom: 4px;"><?= esc($p['judul']) ?></div>
                                            <div style="font-size: 0.8rem; color: var(--text-muted);"><i class="bi bi-person-fill" style="font-size: 0.75rem;"></i> <?= esc($p['pengarang']) ?></div>
                                        </td>
                                        <td><div style="font-size: 0.9rem; font-weight: 500;"><?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?></div></td>
                                        <td><div style="font-size: 0.9rem; font-weight: 500;"><?= date('d M Y', strtotime($p['tanggal_kembali'])) ?></div></td>
                                        <td>
                                            <?php if($p['tanggal_dikembalikan']): ?>
                                                <div style="font-size: 0.9rem; font-weight: 500; color: #2ecc71;"><?= date('d M Y', strtotime($p['tanggal_dikembalikan'])) ?></div>
                                            <?php else: ?>
                                                <span style="color: rgba(255,255,255,0.2);">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge <?= $p['status'] ?>">
                                                <?= ucfirst($p['status']) ?>
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
                                                <span class="<?= $p['denda'] > 0 ? 'denda-text' : '' ?>" style="font-weight: 700; font-family: 'Inter', sans-serif;">
                                                    <?= $p['denda'] > 0 ? 'Rp ' . number_format($p['denda'], 0, ',', '.') : '<span style="color: rgba(255,255,255,0.2);">Rp 0</span>' ?>
                                                </span>
                                                <?php if($p['denda'] > 0): ?>
                                                    <?php if($p['is_denda_lunas']): ?>
                                                        <span style="font-size: 0.7rem; color: #2ecc71; font-weight: 600;"><i class="bi bi-patch-check"></i> LUNAS</span>
                                                    <?php else: ?>
                                                        <span style="font-size: 0.7rem; color: #e67e22; font-weight: 600;"><i class="bi bi-clock-history"></i> BELUM BAYAR</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
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
