<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Kelola User';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="card-admin" style="display: flex; justify-content: space-between; align-items: center; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                    <div>
                        <h2 style="font-size: 1.8rem; font-weight: 700; color: white;"><i class="bi bi-people-fill"></i> Kelola User</h2>
                        <p style="color: var(--text-muted);">Manajemen data akun siswa perpustakaan.</p>
                    </div>
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <form action="" method="get" style="display: flex; gap: 10px;">
                            <div style="position: relative;">
                                <i class="bi bi-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #95a5a6;"></i>
                                <input type="text" name="keyword" placeholder="Cari siswa..." value="<?= esc($keyword ?? '') ?>" 
                                       style="padding: 12px 15px 12px 45px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); border-radius: 12px; color: white; width: 200px; outline: none; transition: all 0.3s; font-family: inherit;">
                            </div>
                            <button type="submit" class="btn-primary-modern" style="padding: 10px 20px;">Cari</button>
                            <?php if(!empty($keyword)): ?>
                                <a href="<?= base_url('perpus/kelola-user') ?>" class="btn-primary-modern" style="background: rgba(255,255,255,0.1); width: 45px; justify-content: center; padding: 0;">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </form>
                        <a href="<?= base_url('perpus/tambah-user') ?>" class="btn-primary-modern" style="background: #2ecc71; box-shadow: 0 8px 15px rgba(46, 204, 113, 0.2);">
                            <i class="bi bi-person-plus-fill"></i> Tambah User
                        </a>
                    </div>
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
                                <th>User Info</th>
                                <th>Kelas</th>
                                <th>Email</th>
                                <th>Tgl Daftar</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($users)): ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 100px 20px;">
                                        <i class="bi bi-people" style="font-size: 4rem; color: #f1f2f6; display: block; margin-bottom: 15px;"></i>
                                        <h3 style="color: #bdc3c7;">Belum ada data user</h3>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($users as $index => $u): ?>
                                    <tr>
                                        <td style="color: #95a5a6; font-size: 0.8rem;"><?= $index + 1 ?></td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <div style="width: 40px; height: 40px; border-radius: 10px; background: #f1f2f6; color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                                    <?= strtoupper(substr($u['nama_lengkap'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div style="font-weight: 700; color: #2c3e50;"><?= esc($u['nama_lengkap']) ?></div>
                                                    <div style="font-size: 0.8rem; color: #7f8c8d;">@<?= esc($u['username']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge-modern" style="background: rgba(52, 152, 219, 0.1); color: var(--primary);"><?= esc($u['kelas']) ?></span></td>
                                        <td style="color: #7f8c8d;"><?= esc($u['email']) ?></td>
                                        <td style="font-size: 0.85rem; color: #95a5a6;"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                                        <td style="text-align: right;">
                                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                                <a href="<?= base_url('perpus/edit-user/' . $u['id']) ?>" class="btn-primary-modern" style="padding: 8px 12px; font-size: 0.85rem; background: #f1f2f6; color: #34495e; box-shadow: none;">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <a href="<?= base_url('perpus/hapus-user/' . $u['id']) ?>" 
                                                   class="btn-primary-modern" 
                                                   onclick="return confirm('Yakin ingin menghapus user ini?')"
                                                   style="padding: 8px 12px; font-size: 0.85rem; background: #fff5f5; color: #e74c3c; box-shadow: none;">
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
