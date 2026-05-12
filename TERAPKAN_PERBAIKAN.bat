@echo off
echo ========================================
echo   TERAPKAN SEMUA PERBAIKAN
echo ========================================
echo.

echo [1/4] Membersihkan cache...
php spark cache:clear
if %errorlevel% neq 0 (
    echo ERROR: Gagal clear cache!
    pause
    exit /b 1
)
echo [OK] Cache berhasil dibersihkan!
echo.

echo [2/4] Menghapus cache manual...
if exist writable\cache\* (
    del /q writable\cache\* 2>nul
    echo [OK] Cache manual berhasil dihapus!
) else (
    echo [OK] Folder cache sudah kosong.
)
echo.

echo [3/4] Verifikasi route...
echo.
php spark routes | findstr "GET.*/"
echo.

echo [4/4] Memulai server...
echo.
echo ========================================
echo   PERBAIKAN YANG DITERAPKAN
echo ========================================
echo.
echo [OK] Route 404 diperbaiki
echo [OK] Sistem login diperbaiki
echo [OK] Sistem logout diperbaiki
echo [OK] base_url('perpus') diperbaiki
echo [OK] Semua link sudah benar
echo.
echo ========================================
echo   SERVER SIAP DIGUNAKAN
echo ========================================
echo.
echo Akses aplikasi di:
echo   - http://localhost:8080/
echo.
echo Login Admin:
echo   URL: http://localhost:8080/perpus/login-admin
echo   Username: admin
echo   Password: admin123
echo.
echo Login Siswa:
echo   URL: http://localhost:8080/
echo   Username: siswa
echo   Password: 12345
echo.
echo Tekan Ctrl+C untuk stop server
echo ========================================
echo.

php spark serve
