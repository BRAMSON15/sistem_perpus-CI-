@echo off
echo ========================================
echo   PERBAIKAN ERROR 404 - PERPUSTAKAAN
echo ========================================
echo.

echo [1/3] Membersihkan cache...
php spark cache:clear
echo Cache berhasil dibersihkan!
echo.

echo [2/3] Menghapus cache manual...
if exist writable\cache\* (
    del /q writable\cache\*
    echo Cache manual berhasil dihapus!
) else (
    echo Folder cache sudah kosong.
)
echo.

echo [3/3] Memulai server...
echo.
echo ========================================
echo   SERVER SIAP DIGUNAKAN
echo ========================================
echo.
echo Akses aplikasi di:
echo   - http://localhost:8080/
echo   - http://localhost:8080/perpus
echo.
echo Login Admin:
echo   Username: admin
echo   Password: admin123
echo.
echo Login Siswa:
echo   Username: siswa
echo   Password: 12345
echo.
echo Tekan Ctrl+C untuk stop server
echo ========================================
echo.

php spark serve
