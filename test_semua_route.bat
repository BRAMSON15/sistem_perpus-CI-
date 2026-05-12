@echo off
echo ========================================
echo   TEST SEMUA ROUTE - PERPUSTAKAAN
echo ========================================
echo.

echo Memeriksa route yang terdaftar...
echo.
php spark routes | findstr perpus
echo.

echo ========================================
echo   HASIL PEMERIKSAAN
echo ========================================
echo.
echo Jika muncul daftar route di atas, berarti:
echo   [OK] Routes sudah terdaftar dengan benar
echo.
echo Jika TIDAK muncul atau ERROR, berarti:
echo   [ERROR] Ada masalah di file Routes.php
echo.
echo ========================================
echo   ROUTE YANG HARUS ADA
echo ========================================
echo.
echo GET     /perpus
echo GET     /perpus/login
echo GET     /perpus/login-admin
echo POST    /perpus/auth-siswa
echo POST    /perpus/auth-admin
echo GET     /perpus/logout
echo GET     /perpus/dashboard
echo GET     /perpus/dashboard-admin
echo GET     /perpus/kelola-buku
echo GET     /perpus/tambah-buku
echo POST    /perpus/simpan-buku
echo GET     /perpus/edit-buku/(:num)
echo POST    /perpus/update-buku/(:num)
echo GET     /perpus/hapus-buku/(:num)
echo GET     /perpus/kelola-peminjaman
echo POST    /perpus/proses-pengembalian/(:num)
echo GET     /perpus/kelola-user
echo GET     /perpus/tambah-user
echo POST    /perpus/simpan-user
echo GET     /perpus/hapus-user/(:num)
echo GET     /perpus/katalog
echo GET     /perpus/pinjam-buku/(:num)
echo POST    /perpus/proses-pinjam
echo GET     /perpus/peminjaman-saya
echo.
echo Total: 24 route
echo.

pause
