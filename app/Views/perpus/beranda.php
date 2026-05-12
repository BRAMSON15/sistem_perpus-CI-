<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pustaka - Digital Library Gateway</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('beranda/css/landing_modern.css') ?>">
</head>
<body>
    <main>
        <section class="hero-section">
            <div class="container">
                <div class="split-hero">
                    <div class="hero-text">
                        <h1>Selamat Datang<br>di E-Pustaka</h1>
                        <p>Akses ribuan koleksi literatur digital dalam satu genggaman. Perpustakaan modern untuk generasi pembelajar masa depan.</p>
                        <div style="display: flex; gap: 20px; justify-content: flex-start;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 12px; height: 12px; background: var(--accent); border-radius: 50%;"></div>
                                <span style="font-size: 0.9rem; color: #94a3b8;">Sistem Aktif</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="login-glass-card">
                        <h3>Akses Siswa</h3>
                        
                        <?php if(session()->getFlashdata('error_siswa')): ?>
                            <div style="background: rgba(231, 76, 60, 0.2); color: #ff7675; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid rgba(231, 76, 60, 0.3); font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                <?= session()->getFlashdata('error_siswa') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('perpus/auth-siswa') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="input-group">
                                <input type="text" name="username" placeholder="Student Username" required autofocus>
                            </div>

                            <div class="input-group">
                                <input type="password" name="password" placeholder="Account Password" required>
                            </div>

                            <button type="submit" class="btn-premium-login">
                                Sign In Now <i class="bi bi-arrow-right-short"></i>
                            </button>
                            
                            <div class="secondary-actions">
                                <a href="<?= base_url('perpus/lupa-password') ?>">Forgot credentials?</a>
                                <a href="<?= base_url('perpus/login-admin') ?>" style="color: var(--primary);">Admin Portal <i class="bi bi-person-badge"></i></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="features-section">
            <div class="container">
                <div class="section-header">
                    <h2>Modern Library Experience</h2>
                    <p style="color: #94a3b8;">Fasilitas digital unggulan untuk mendukung ekosistem akademik Anda.</p>
                </div>
                <div class="feature-grid">
                    <div class="feature-card">
                        <i class="bi bi-collection"></i>
                        <h4>Katalog Pintar</h4>
                        <p>Sistem pencarian buku yang cerdas memudahkan Anda menemukan referensi dalam hitungan detik.</p>
                    </div>
                    <div class="feature-card">
                        <i class="bi bi-lightning-charge"></i>
                        <h4>Peminjaman Instan</h4>
                        <p>Proses peminjaman dan pengembalian yang terautomasi melalui sistem dasbor personal siswa.</p>
                    </div>
                    <div class="feature-card">
                        <i class="bi bi-clock-history"></i>
                        <h4>Akses 24/7</h4>
                        <p>Pantau riwayat peminjaman dan ketersediaan buku kapan saja dan di mana saja secara online.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?= date('Y') ?> E-Pustaka Digital Library. Crafted with excellence.</p>
        </div>
    </footer>
</body>
</html>
