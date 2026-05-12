<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - Perpustakaan</title>
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
                $page_title = 'Sistem Keamanan';
                include APPPATH . 'Views/perpus/siswa/topbar.php'; 
            ?>

            <!-- Content Area -->
            <main class="content-area" style="max-width: 800px; margin: 0 auto; width: 100%;">
                <div class="page-header-card">
                    <h2>Ubah Password</h2>
                    <p>Lindungi akun Anda dengan memperbarui kata sandi secara berkala.</p>
                </div>

                <div class="card-solid" style="background: #ffffff; color: #2c3e50; padding: 40px; border-radius: 24px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill"></i> 
                            <span><?= session()->getFlashdata('success') ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-error">
                            <i class="bi bi-exclamation-triangle-fill"></i> 
                            <span><?= session()->getFlashdata('error') ?></span>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('perpus/update-password') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required placeholder="Masukkan password lama">
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required placeholder="Minimal 5 karakter">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Konfirmasi Password Baru</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required placeholder="Ulangi password baru">
                        </div>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-shield-check"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
