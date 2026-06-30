<aside class="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-book-half"></i>
        <h2>Perpustakaan</h2>
        <p>Portal Siswa</p>
    </div>
    <nav class="sidebar-menu">
        <a href="<?= base_url('perpus/dashboard') ?>" class="menu-item <?= uri_string() == 'perpus/dashboard' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
            <?php if (($unread_notifications_count ?? 0) > 0): ?>
                <span class="menu-badge"><?= $unread_notifications_count ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= base_url('perpus/katalog') ?>" class="menu-item <?= strpos(uri_string(), 'perpus/katalog') !== false || strpos(uri_string(), 'perpus/pinjam-buku') !== false ? 'active' : '' ?>">
            <i class="bi bi-search-heart"></i>
            <span>Katalog Buku</span>
        </a>
        <a href="<?= base_url('perpus/peminjaman-saya') ?>" class="menu-item <?= strpos(uri_string(), 'perpus/peminjaman-saya') !== false ? 'active' : '' ?>">
            <i class="bi bi-bookmark-star-fill"></i>
            <span>Peminjaman Saya</span>
            <?php if (($total_overdue_siswa ?? 0) > 0): ?>
                <span class="menu-badge" style="background: #e67e22;"><?= $total_overdue_siswa ?></span>
            <?php endif; ?>
        </a>
        <div class="menu-divider"></div>
        <!-- <a href="<?= base_url('perpus/ubah-password') ?>" class="menu-item <?= strpos(uri_string(), 'perpus/ubah-password') !== false ? 'active' : '' ?>">
            <i class="bi bi-shield-lock-fill"></i>
            <span>Ubah Password</span>
        </a> -->
        <!-- <a href="<?= base_url('perpus/logout') ?>" class="menu-item" style="color: #ff6b6b; margin-top: auto;">
            <i class="bi bi-box-arrow-right"></i>
            <span>Keluar Sesi</span>
        </a> -->
    </nav>
</aside>
