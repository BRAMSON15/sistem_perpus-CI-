<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Peminjaman - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Kelola Peminjaman';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="card-admin" style="border-bottom-left-radius: 0; border-bottom-right-radius: 0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 700; color: white;"><i class="bi bi-arrow-repeat"></i> Log Peminjaman</h2>
                        <p style="color: var(--text-muted);">Pantau status peminjaman, tenggat waktu, dan denda keterlambatan.</p>
                    </div>
                    
                    <form action="<?= base_url('perpus/kelola-peminjaman') ?>" method="get" class="search-form" style="flex: 1; max-width: 400px; position: relative;">
                        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari peminjam, buku, atau status..." 
                               style="width: 100%; padding: 12px 45px 12px 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: white;">
                        <button type="submit" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--primary);">
                            <i class="bi bi-search" style="font-size: 1.2rem;"></i>
                        </button>
                    </form>
                </div>

                <div class="table-container-admin">
                    <?php if(session()->getFlashdata('success')): ?>
                        <div style="padding: 15px 20px; background: #eafaf1; color: #2ecc71; margin: 10px; border-radius: 12px; display: flex; align-items: center; gap: 10px; font-weight: 500;">
                            <i class="bi bi-check-circle-fill"></i> <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Peminjam</th>
                                <th>Buku</th>
                                <th>Rentang Waktu</th>
                                <th>Status</th>
                                <th>Denda</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($peminjaman)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 100px 20px;">
                                        <i class="bi bi-clipboard-x" style="font-size: 4rem; color: #f1f2f6; display: block; margin-bottom: 15px;"></i>
                                        <h3 style="color: #bdc3c7;">Belum ada data peminjaman</h3>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($peminjaman as $index => $p): ?>
                                    <tr>
                                        <td style="color: #95a5a6; font-size: 0.8rem;"><?= $index + 1 ?></td>
                                        <td>
                                            <div style="font-weight: 700; color: #2c3e50;"><?= esc($p['nama_lengkap']) ?></div>
                                            <div style="font-size: 0.8rem; color: #7f8c8d;">Siswa Terdaftar</div>
                                        </td>
                                        <td style="max-width: 250px;">
                                            <div style="font-weight: 600; color: var(--primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= esc($p['judul']) ?></div>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 10px; align-items: center;">
                                                <div style="text-align: center;">
                                                    <div style="font-size: 0.7rem; color: #bdc3c7; text-transform: uppercase;">Pinjam</div>
                                                    <div style="font-size: 0.85rem; font-weight: 600; color: #34495e;"><?= date('d/m/y', strtotime($p['tanggal_pinjam'])) ?></div>
                                                </div>
                                                <i class="bi bi-arrow-right" style="color: #bdc3c7;"></i>
                                                <div style="text-align: center;">
                                                    <div style="font-size: 0.7rem; color: #bdc3c7; text-transform: uppercase;">Kembali</div>
                                                    <div style="font-size: 0.85rem; font-weight: 600; color: #e67e22;"><?= date('d/m/y', strtotime($p['tanggal_kembali'])) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-modern <?= $p['status'] ?>">
                                                <?= strtoupper($p['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($p['denda'] > 0): ?>
                                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                                    <span style="color: #e74c3c; font-weight: 700;">Rp <?= number_format($p['denda'], 0, ',', '.') ?></span>
                                                    <?php if($p['is_denda_lunas']): ?>
                                                        <span style="font-size: 0.7rem; color: #2ecc71; font-weight: 600;"><i class="bi bi-patch-check"></i> LUNAS</span>
                                                    <?php else: ?>
                                                        <span style="font-size: 0.7rem; color: #e67e22; font-weight: 600;"><i class="bi bi-clock-history"></i> BELUM BAYAR</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php else: ?>
                                                <span style="color: #bdc3c7;">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                                <?php if($p['status'] != 'dikembalikan'): ?>
                                                    <form action="<?= base_url('perpus/proses-pengembalian/' . $p['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn-primary-modern" style="padding: 8px 15px; font-size: 0.85rem; border-radius: 10px;" onclick="return confirm('Proses pengembalian buku ini?')">
                                                            Selesaikan
                                                        </button>
                                                    </form>
                                                <?php elseif($p['denda'] > 0 && !$p['is_denda_lunas']): ?>
                                                    <form action="<?= base_url('perpus/proses-pembayaran-denda/' . $p['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn-primary-modern" style="padding: 8px 15px; font-size: 0.85rem; border-radius: 10px; background: #e67e22; border-color: #e67e22;" onclick="return confirm('Tandai denda ini sebagai Lunas?')">
                                                            Bayar Lunas
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <div style="color: #2ecc71; font-weight: 600; font-size: 0.85rem;">
                                                        <i class="bi bi-check2-all"></i> Selesai
                                                    </div>
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
