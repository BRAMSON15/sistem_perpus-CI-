-- Update tabel buku untuk menambahkan kolom gambar
-- Jalankan query ini jika tabel buku sudah ada

USE perpus;

-- Cek apakah kolom gambar sudah ada, jika belum tambahkan
ALTER TABLE buku ADD COLUMN IF NOT EXISTS gambar VARCHAR(255) NULL AFTER tersedia;

-- Atau gunakan query ini jika database tidak support IF NOT EXISTS
-- ALTER TABLE buku ADD COLUMN gambar VARCHAR(255) NULL AFTER tersedia;
