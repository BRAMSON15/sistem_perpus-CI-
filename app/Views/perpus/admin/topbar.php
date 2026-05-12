<header class="topbar">
    <div class="topbar-left">
        <h1><?= $page_title ?? 'Admin Dashboard' ?></h1>
    </div>
    <div class="topbar-right">
        <!-- Notification Bell -->
        <div class="notification-wrapper" id="notificationBtn">
            <div class="notification-bell">
                <i class="bi bi-bell-fill"></i>
                <?php if (($unread_notifications_count ?? 0) > 0): ?>
                    <span class="notification-badge"><?= $unread_notifications_count ?></span>
                <?php endif; ?>
            </div>
            
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                    <h4>Notifikasi Sistem</h4>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <?php if (($unread_notifications_count ?? 0) > 0): ?>
                            <span class="badge" style="background: var(--primary); font-size: 0.7rem; padding: 2px 8px; border-radius: 10px;"><?= $unread_notifications_count ?> Baru</span>
                            <a href="javascript:void(0)" id="markAllRead" style="font-size: 0.7rem; color: var(--primary); text-decoration: none;">Tandai semua dibaca</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="notification-list">
                    <?php if (empty($recent_notifications ?? [])): ?>
                        <div class="notification-empty">
                            <i class="bi bi-bell-slash"></i>
                            <p>Tidak ada notifikasi baru</p>
                        </div>
                    <?php else: ?>
                        <?php foreach (($recent_notifications ?? []) as $notif): ?>
                            <div class="notification-item <?= !$notif['is_read'] ? 'unread' : '' ?>">
                                <h5><?= esc($notif['title']) ?></h5>
                                <p><?= esc($notif['message']) ?></p>
                                <span class="time"><?= date('d M Y, H:i', strtotime($notif['created_at'])) ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="notification-footer">
                    <a href="<?= base_url('perpus/notifications') ?>">Lihat Semua Notifikasi</a>
                </div>
            </div>
        </div>

        <div class="user-info">
            <div class="user-avatar"><?= strtoupper(substr(esc($username ?? 'A'), 0, 1)) ?></div>
            <span><?= esc($username ?? 'Administrator') ?></span>
        </div>
        <a href="<?= base_url('perpus/logout') ?>" class="logout-btn-nav" title="Logout">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>
</header>

<script>
    // Notification Toggle
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');

    if (notificationBtn) {
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('active');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (notificationDropdown && notificationDropdown.classList.contains('active')) {
            if (!notificationDropdown.contains(e.target) && !notificationBtn.contains(e.target)) {
                notificationDropdown.classList.remove('active');
            }
        }
    });

    // Mark All Read AJAX
    const markAllReadBtn = document.getElementById('markAllRead');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('<?= base_url('perpus/notifications/mark-as-read') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update UI: remove badges and unread classes
                    document.querySelectorAll('.notification-badge').forEach(el => el.remove());
                    document.querySelectorAll('.notification-item.unread').forEach(el => el.classList.remove('unread'));
                    if (markAllReadBtn) markAllReadBtn.parentElement.remove();
                    
                    // Optional: show toast or refresh count
                    console.log('Notifications marked as read');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
</script>
