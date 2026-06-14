-- =====================================================
-- Migration: Tabel card_scans untuk aktivitas scan kartu perpustakaan
-- Jalankan SQL ini di database 'perpus'
-- =====================================================

USE perpus;

CREATE TABLE IF NOT EXISTS card_scans (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED NOT NULL,
    scan_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('aktif') DEFAULT 'aktif',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
