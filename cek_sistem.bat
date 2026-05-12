@echo off
echo ========================================
echo   CEK SISTEM PERPUSTAKAAN
echo ========================================
echo.

echo [1] Cek versi PHP...
php -v
echo.

echo [2] Cek CodeIgniter...
php spark --version
echo.

echo [3] Cek database connection...
php spark db:table users
echo.

echo [4] Cek route perpus...
php spark routes | findstr /C:"perpus"
echo.

echo [5] Cek file penting...
if exist .env (
    echo [OK] File .env ada
) else (
    echo [ERROR] File .env tidak ada!
)

if exist app\Controllers\Perpus.php (
    echo [OK] Controller Perpus ada
) else (
    echo [ERROR] Controller Perpus tidak ada!
)

if exist app\Views\perpus\beranda.php (
    echo [OK] View beranda ada
) else (
    echo [ERROR] View beranda tidak ada!
)
echo.

echo ========================================
echo   CEK SELESAI
echo ========================================
echo.
echo Jika semua OK, jalankan: jalankan_aplikasi.bat
echo.

pause
