<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('perpus/css/siswa_style.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .notif-page-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .notif-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .notif-item-full {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #f1f2f6;
            transition: all 0.3s;
        }
        .notif-item-full:last-child {
            border-bottom: none;
        }
        .notif-item-full.unread {
            background: rgba(var(--primary-rgb), 0.03);
            border-left: 4px solid var(--primary);
        }
        .notif-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .notif-icon.info { background: #e3f2fd; color: #2196f3; }
        .notif-icon.warning { background: #fff3e0; color: #ff9800; }
        .notif-icon.success { background: #e8f5e9; color: #4caf50; }
        .notif-icon.danger { background: #ffebee; color: #f44336; }

        .notif-content h4 {
            margin: 0 0 5px 0;
            color: #2c3e50;
        }
        .notif-content p {
            margin: 0 0 10px 0;
            color: #7f8c8d;
            line-height: 1.5;
        }
        .notif-meta {
            font-size: 0.8rem;
            color: #bdc3c7;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .notif-actions {
            display: flex;
            gap: 10px;
            margin-left: auto;
        }
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 1.1rem;
        }
        .action-btn.read { color: #2196f3; }
        .action-btn.read:hover { background: #e3f2fd; }
        .action-btn.delete { color: #f44336; }
        .action-btn.delete:hover { background: #ffebee; }
    </style>
</head>
<body>
    <div class="siswa-container">
        <?php include APPPATH . 'Views/perpus/siswa/sidebar.php'; ?>

        <div class="main-content">
            <?php 
                $page_title = 'Semua Notifikasi';
                include APPPATH . 'Views/perpus/siswa/topbar.php'; 
            ?>

            <main class="content-area">
                <div class="notif-page-container">
                    <div class="notif-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                            <h2 style="color: #2c3e50; font-weight: 700;"><i class="bi bi-bell-fill"></i> Riwayat Notifikasi</h2>
                            <?php if (!empty($all_notifications)): ?>
                                <div style="display: flex; gap: 10px;">
                                    <button id="pageMarkRead" class="btn-primary" style="padding: 8px 15px; font-size: 0.85rem; border: none; border-radius: 10px; cursor: pointer;">Tandai Semua Dibaca</button>
                                    <button id="pageClearAll" style="padding: 8px 15px; font-size: 0.85rem; border: none; border-radius: 10px; cursor: pointer; background: #ff6b6b; color: white;">Hapus Semua</button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (empty($all_notifications)): ?>
                            <div style="text-align: center; padding: 50px 0;">
                                <i class="bi bi-bell-slash" style="font-size: 4rem; color: #f1f2f6;"></i>
                                <p style="color: #bdc3c7; margin-top: 15px;">Belum ada notifikasi untuk Anda.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($all_notifications as $notif): ?>
                                <div class="notif-item-full <?= !$notif['is_read'] ? 'unread' : '' ?>">
                                    <div class="notif-icon <?= $notif['type'] ?? 'info' ?>">
                                        <i class="bi <?= ($notif['type'] ?? '') == 'warning' ? 'bi-exclamation-triangle' : (($notif['type'] ?? '') == 'success' ? 'bi-check-circle' : 'bi-info-circle') ?>"></i>
                                    </div>
                                    <div class="notif-content" style="flex: 1;">
                                        <h4><?= esc($notif['title']) ?></h4>
                                        <p><?= esc($notif['message']) ?></p>
                                        <div class="notif-meta">
                                            <span><i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($notif['created_at'])) ?></span>
                                            <span><i class="bi bi-clock"></i> <?= date('H:i', strtotime($notif['created_at'])) ?></span>
                                            
                                            <div class="notif-actions">
                                                <?php if (!$notif['is_read']): ?>
                                                    <button class="action-btn read mark-single-read" data-id="<?= $notif['id'] ?>" title="Tandai dibaca">
                                                        <i class="bi bi-check2-circle"></i>
                                                    </button>
                                                <?php endif; ?>
                                                <button class="action-btn delete delete-notif" data-id="<?= $notif['id'] ?>" title="Hapus notifikasi">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        document.getElementById('pageMarkRead')?.addEventListener('click', function() {
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
                    location.reload();
                }
            });
        });

        // Mark Single Read
        document.querySelectorAll('.mark-single-read').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                fetch('<?= base_url('perpus/notifications/mark-as-read') ?>/' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    }
                });
            });
        });

        // Delete Notification
        document.querySelectorAll('.delete-notif').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm('Hapus notifikasi ini?')) return;
                const id = this.getAttribute('data-id');
                fetch('<?= base_url('perpus/notifications/delete') ?>/' + id, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        location.reload();
                    }
                });
            });
        });

        // Clear All
        document.getElementById('pageClearAll')?.addEventListener('click', function() {
            if (!confirm('Hapus semua riwayat notifikasi Anda?')) return;
            fetch('<?= base_url('perpus/notifications/delete-all') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                }
            });
        });
    </script>
</body>
</html>
