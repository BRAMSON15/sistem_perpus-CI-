<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('perpus/css/admin_style.css') ?>">
</head>
<body>
    <div class="admin-container">
        <?php include APPPATH . 'Views/perpus/admin/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Tambah User';
                include APPPATH . 'Views/perpus/admin/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="card-admin" style="margin-bottom: 20px; max-width: 700px;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: white;"><i class="bi bi-person-plus-fill"></i> Daftarkan Siswa</h2>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Lengkapi informasi akun di bawah ini.</p>
                </div>

                <div class="form-solid">
                    <form action="<?= base_url('perpus/simpan-user') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-row-modern">
                            <div class="form-group-modern">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" placeholder="Masukkan ID unik" required>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="password">Password Default</label>
                                <input type="password" id="password" name="password" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="nama_lengkap">Nama Lengkap Siswa</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama sesuai dapodik" required>
                        </div>

                        <div class="form-group-modern">
                            <label for="email">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="contoh@sekolah.sch.id" required>
                        </div>

                        <div class="form-group-modern">
                            <label for="kelas">Kelas / Tingkat</label>
                            <input type="text" id="kelas" name="kelas" placeholder="Misal: XI RPL 1" required>
                        </div>

                        <div style="margin-top: 40px; display: flex; gap: 15px;">
                            <button type="submit" class="btn-primary-modern" style="flex: 1; justify-content: center; padding: 15px;">
                                <i class="bi bi-save-fill"></i> Simpan Data Siswa
                            </button>
                            <a href="<?= base_url('perpus/kelola-user') ?>" class="btn-primary-modern" style="background: #f1f2f6; color: #7f8c8d; box-shadow: none; padding: 15px;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
