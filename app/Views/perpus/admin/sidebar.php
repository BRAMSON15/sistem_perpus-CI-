<aside class="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-shield-lock-fill"></i>
        <h2>Perpustakaan</h2>
        <p>Admin Panel</p>
    </div>
    <nav class="sidebar-menu">
        <a href="<?= base_url('perpus/dashboard-admin') ?>" class="menu-item <?= uri_string() == 'perpus/dashboard-admin' ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
            <?php if (($unread_notifications_count ?? 0) > 0): ?>
                <span class="menu-badge"><?= $unread_notifications_count ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= base_url('perpus/kelola-buku') ?>" class="menu-item <?= strpos(uri_string(), 'kelola-buku') !== false || strpos(uri_string(), 'tambah-buku') !== false || strpos(uri_string(), 'edit-buku') !== false ? 'active' : '' ?>">
            <i class="bi bi-journal-bookmark-fill"></i>
            <span>Kelola Buku</span>
        </a>
        <a href="<?= base_url('perpus/kelola-peminjaman') ?>" class="menu-item <?= strpos(uri_string(), 'kelola-peminjaman') !== false ? 'active' : '' ?>">
            <i class="bi bi-arrow-repeat"></i>
            <span>Peminjaman</span>
            <?php if (($total_overdue_global ?? 0) > 0): ?>
                <span class="menu-badge" style="background: #e67e22;"><?= $total_overdue_global ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= base_url('perpus/kelola-user') ?>" class="menu-item <?= strpos(uri_string(), 'kelola-user') !== false || strpos(uri_string(), 'tambah-user') !== false || strpos(uri_string(), 'edit-user') !== false ? 'active' : '' ?>">
            <i class="bi bi-people-fill"></i>
            <span>Kelola User</span>
        </a>
        <a href="<?= base_url('perpus/kelola-laporan') ?>" class="menu-item <?= strpos(uri_string(), 'kelola-laporan') !== false || strpos(uri_string(), 'tambah-laporan') !== false || strpos(uri_string(), 'edit-laporan') !== false ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-text-fill"></i>
            <span>Kelola Laporan</span>
        </a>
        <div class="menu-divider"></div>
    </nav>
</aside>
