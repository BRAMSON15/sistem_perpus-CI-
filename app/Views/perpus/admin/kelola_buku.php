<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Kelola Buku';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="card-admin" style="display: flex; justify-content: space-between; align-items: center; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 700; color: white;"><i class="bi bi-journal-bookmark-fill"></i> Koleksi Buku</h2>
                        <p style="color: var(--text-muted);">Manajemen katalog dan ketersediaan koleksi perpustakaan.</p>
                    </div>
                    <a href="<?= base_url('perpus/tambah-buku') ?>" class="btn-primary-modern" style="background: #2ecc71; box-shadow: 0 8px 15px rgba(46, 204, 113, 0.2);">
                        <i class="bi bi-patch-plus-fill"></i> Tambah Koleksi
                    </a>
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
                                <th>Informasi Buku</th>
                                <th>Kode</th>
                                <th>Kategori</th>
                                <th>Stok / Sedia</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($buku)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 100px 20px;">
                                        <i class="bi bi-book" style="font-size: 4rem; color: #f1f2f6; display: block; margin-bottom: 15px;"></i>
                                        <h3 style="color: #bdc3c7;">Belum ada data buku</h3>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($buku as $index => $b): ?>
                                    <tr>
                                        <td style="color: #95a5a6; font-size: 0.8rem;"><?= $index + 1 ?></td>
                                        <td>
                                            <div style="display: flex; gap: 15px; align-items: center;">
                                                <div style="width: 50px; height: 75px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); flex-shrink: 0;">
                                                    <?php if($b['gambar'] && file_exists(FCPATH . 'uploads/buku/' . $b['gambar'])): ?>
                                                        <img src="<?= base_url('uploads/buku/' . $b['gambar']) ?>" alt="<?= esc($b['judul']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(155, 89, 182, 0.1)); color: var(--primary);">
                                                            <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <div style="font-weight: 700; color: #2c3e50; font-size: 1rem; margin-bottom: 2px;"><?= esc($b['judul']) ?></div>
                                                    <div style="font-size: 0.85rem; color: #7f8c8d;">Oleh <?= esc($b['pengarang']) ?></div>
                                                    <div style="font-size: 0.75rem; color: #bdc3c7;"><?= esc($b['penerbit']) ?> (<?= esc($b['tahun_terbit']) ?>)</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><code style="background: #f1f2f6; padding: 4px 8px; border-radius: 6px; color: #2c3e50; font-weight: 600; font-size: 0.85rem;"><?= esc($b['kode_buku']) ?></code></td>
                                        <td><span class="badge-modern" style="background: rgba(52, 152, 219, 0.1); color: var(--primary);"><?= esc($b['kategori']) ?></span></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <div style="text-align: center;">
                                                    <div style="font-size: 0.7rem; color: #bdc3c7; text-transform: uppercase;">Total</div>
                                                    <div style="font-weight: 700; color: #34495e;"><?= esc($b['stok']) ?></div>
                                                </div>
                                                <div style="width: 1px; height: 20px; background: #f1f2f6;"></div>
                                                <div style="text-align: center;">
                                                    <div style="font-size: 0.7rem; color: #bdc3c7; text-transform: uppercase;">Sedia</div>
                                                    <div style="font-weight: 700; color: #2ecc71;"><?= esc($b['tersedia']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: right;">
                                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                                <a href="<?= base_url('perpus/edit-buku/' . $b['id']) ?>" class="btn-primary-modern" style="padding: 10px 14px; background: #f1f2f6; color: #34495e; box-shadow: none;">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="<?= base_url('perpus/hapus-buku/' . $b['id']) ?>" 
                                                   class="btn-primary-modern" 
                                                   onclick="return confirm('Yakin ingin menghapus buku ini?')"
                                                   style="padding: 10px 14px; background: #fff5f5; color: #e74c3c; box-shadow: none;">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>
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
