================================================================================
                    APLIKASI PERPUSTAKAAN - CODEIGNITER 4
================================================================================

CARA MENJALANKAN APLIKASI:
================================================================================

1. Buka Terminal/Command Prompt

2. Masuk ke folder project:
   cd "c:\laragon\www\mentahan perpus (codignitter)\app_perpus - Copy"

3. Jalankan server:
   php spark serve

4. Buka browser dan akses:
   http://localhost:8080/perpus


KREDENSIAL LOGIN:
================================================================================

ADMIN:
- URL: http://localhost:8080/perpus/login-admin
- Username: admin
- Password: password

SISWA:
- URL: http://localhost:8080/perpus (form login ada di halaman ini)
- Username: siswa
- Password: 12345


PENTING!!!
================================================================================

❌ JANGAN akses dari Laragon langsung!
   http://localhost/mentahan%20perpus%20(codignitter)/... [SALAH!]

✅ HARUS menggunakan php spark serve!
   php spark serve
   http://localhost:8080/perpus [BENAR!]


SETUP DATABASE (Hanya Sekali):
================================================================================

php spark migrate
php spark db:seed UserSeeder
php spark db:seed BukuSeeder


TROUBLESHOOTING:
================================================================================

Error 404?
→ Pastikan menggunakan "php spark serve"
→ Akses: http://localhost:8080/perpus

Database error?
→ Pastikan MySQL running di Laragon
→ Database "perpus" sudah dibuat

Port 8080 sudah dipakai?
→ Gunakan: php spark serve --port=8081
→ Akses: http://localhost:8081/perpus


FITUR APLIKASI:
================================================================================

ADMIN:
✓ Dashboard dengan statistik
✓ Kelola Buku (Tambah, Edit, Hapus, Upload Gambar)
✓ Kelola Peminjaman (Proses pengembalian)
✓ Kelola User Siswa

SISWA:
✓ Dashboard pribadi
✓ Katalog Buku dengan gambar
✓ Pinjam Buku
✓ Riwayat Peminjaman


KONTAK:
================================================================================

Jika ada masalah, cek file:
- CARA_MENJALANKAN.md (panduan lengkap)
- LINK_AKSES.md (daftar semua link)
- writable/logs/ (log error)


================================================================================
                            SELAMAT MENGGUNAKAN!
================================================================================
