@echo off
echo ========================================
echo   TEST LOGOUT - PERPUSTAKAAN
echo ========================================
echo.

echo Instruksi Testing Logout:
echo.
echo 1. Pastikan server sudah running
echo    Jika belum: php spark serve
echo.
echo 2. Test Logout Siswa:
echo    a. Login sebagai siswa di: http://localhost:8080/perpus
echo       Username: siswa
echo       Password: 12345
echo    b. Klik tombol "Logout"
echo    c. Harus redirect ke: http://localhost:8080/
echo    d. Harus muncul pesan: "Anda telah logout"
echo.
echo 3. Test Logout Admin:
echo    a. Login sebagai admin di: http://localhost:8080/perpus/login-admin
echo       Username: admin
echo       Password: admin123
echo    b. Klik tombol "Logout"
echo    c. Harus redirect ke: http://localhost:8080/perpus/login-admin
echo    d. Harus muncul pesan: "Anda telah logout"
echo.
echo 4. Verifikasi:
echo    - Setelah logout, tidak bisa akses dashboard
echo    - Harus login lagi untuk akses dashboard
echo.
echo ========================================
echo   PERBAIKAN YANG DILAKUKAN
echo ========================================
echo.
echo [OK] Redirect admin ke /perpus/login-admin
echo [OK] Redirect siswa ke / (beranda)
echo [OK] Flash message "Anda telah logout"
echo [OK] Session di-destroy dengan benar
echo.

pause
