-- Buat database perpus
CREATE DATABASE IF NOT EXISTS perpus CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Gunakan database perpus
USE perpus;

-- Tabel users untuk siswa dan admin
CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    kelas VARCHAR(50) NULL,
    user_type ENUM('siswa', 'admin') DEFAULT 'siswa',
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data user demo
INSERT INTO users (username, password, nama_lengkap, kelas, user_type, created_at) VALUES
('siswa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siswa Demo', 'XII IPA 1', 'siswa', NOW()),
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', NULL, 'admin', NOW());

-- Password untuk kedua user adalah: password
-- Untuk siswa bisa juga gunakan: username=siswa, password=12345
