@echo off
cls
echo ========================================
echo   APLIKASI PERPUSTAKAAN - CODEIGNITER
echo ========================================
echo.

echo [1/3] Membersihkan cache...
php spark cache:clear
echo.

echo [2/3] Memeriksa route perpus...
php spark routes | findstr /C:"Perpus::index"
echo.

echo [3/3] Menjalankan server...
echo.
echo ========================================
echo   SERVER BERJALAN DI:
echo   http://localhost:8080
echo.
echo   AKSES APLIKASI:
echo   http://localhost:8080/perpus
echo   atau
echo   http://localhost:8080/
echo ========================================
echo.
echo Tekan Ctrl+C untuk menghentikan server
echo.

php spark serve --host=localhost --port=8080

pause
