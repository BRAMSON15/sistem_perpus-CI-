<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Digital Library System</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('beranda/css/admin_login_modern.css') ?>">
</head>
<body>
    <div class="login-layout">
        <div class="image-side">
            <div>
                <h1>Management<br>Control Center</h1>
                <p>Akses panel administrasi sistem perpustakaan digital untuk pengelolaan data pustaka, pengguna, dan log transaksi.</p>
            </div>
        </div>
        
        <div class="form-side">
            <div class="login-card">
                <div class="brand-logo">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h2>Administrator Login</h2>
                <p class="subtitle">Silakan autentikasi untuk akses kontrol panel.</p>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-octagon-fill"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('perpus/auth-admin') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="input-group">
                        <label>ID Administrator</label>
                        <div class="input-wrapper">
                            <i class="bi bi-person"></i>
                            <input type="text" name="username" placeholder="Masukkan username" required autofocus>
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Secure Password</label>
                        <div class="input-wrapper">
                            <i class="bi bi-key"></i>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-admin-login">
                        Masuk Sistem <i class="bi bi-arrow-right"></i>
                    </button>
                </form>

                <div class="footer-links">
                    <a href="<?= base_url('/') ?>"><i class="bi bi-house-door"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
