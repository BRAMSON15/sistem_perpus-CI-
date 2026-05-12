<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Digital Library Gateway</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('beranda/css/auth_modern.css') ?>">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Lupa Password</h2>
            <p class="subtitle">Silakan masukkan email Anda yang terdaftar. Kami akan membuatkan password baru secara otomatis dan mengirimkannya ke kotak masuk Anda.</p>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('perpus/reset-password') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label>Alamat Email</label>
                    <div class="input-wrapper">
                        <i class="bi bi-envelope-at"></i>
                        <input type="email" name="email" placeholder="Masukkan email siswa Anda" required autofocus>
                    </div>
                </div>

                <button type="submit" class="btn-premium">
                    Kirim Password Baru <i class="bi bi-send-fill"></i>
                </button>
            </form>

            <div class="links">
                <a href="<?= base_url('/') ?>">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
