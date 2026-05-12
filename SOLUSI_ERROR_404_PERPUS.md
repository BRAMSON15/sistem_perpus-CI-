# 🔧 Solusi Error 404: /perpus Not Found

## ❌ Error yang Muncul
```
The requested resource /perpus was not found on this server.
```

## ✅ Perbaikan yang Sudah Dilakukan

### 1. Hapus Route Duplikat
**File**: `app/Config/Routes.php`
- ❌ Dihapus: `$routes->get('perpus', 'Perpus::perpus');`
- ✅ Yang benar: `$routes->get('/', 'Perpus::index');` di dalam group perpus

### 2. Hapus Method Tidak Digunakan
**File**: `app/Controllers/Perpus.php`
- ❌ Dihapus: Method `perpus()` yang tidak digunakan
- ✅ Hanya gunakan: Method `index()` untuk beranda

## 🚀 Langkah-Langkah Mengatasi Error

### Langkah 1: Stop Server
Tekan `Ctrl + C` di terminal untuk stop server

### Langkah 2: Clear Cache
```bash
php spark cache:clear
```

### Langkah 3: Jalankan Server Lagi
```bash
php spark serve
```

### Langkah 4: Test di Browser
Buka browser dan akses:
```
http://localhost:8080/
http://localhost:8080/perpus
```

Kedua URL harus menampilkan halaman beranda yang sama.

## 🔍 Verifikasi Route

### Cek Route yang Terdaftar
```bash
php spark routes
```

Cari baris yang mengandung `/perpus`:
```
GET     /perpus                    Perpus::index
GET     /perpus/login              Perpus::login
GET     /perpus/login-admin        Perpus::loginAdmin
...
```

### Jika Route Tidak Muncul
Berarti ada masalah di file `app/Config/Routes.php`

Pastikan strukturnya seperti ini:
```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route default - langsung ke beranda perpustakaan
$routes->get('/', 'Perpus::index');

// Route perpustakaan
$routes->group('perpus', function($routes) {
    // Beranda
    $routes->get('/', 'Perpus::index');
    
    // Auth
    $routes->get('login', 'Perpus::login');
    $routes->get('login-admin', 'Perpus::loginAdmin');
    $routes->post('auth-siswa', 'Perpus::authSiswa');
    $routes->post('auth-admin', 'Perpus::authAdmin');
    $routes->get('logout', 'Perpus::logout');
    
    // ... routes lainnya
});
```

## 🔧 Troubleshooting Lanjutan

### Jika Masih Error Setelah Clear Cache

#### 1. Cek File .htaccess
**Lokasi**: `public/.htaccess`

Pastikan isinya:
```apache
# Disable directory browsing
Options -Indexes

# Rewrite engine
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    
    # Redirect to index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>

<IfModule !mod_rewrite.c>
    ErrorDocument 404 index.php
</IfModule>
```

#### 2. Cek Konfigurasi App
**File**: `app/Config/App.php`

Pastikan:
```php
public string $indexPage = '';
public string $uriProtocol = 'REQUEST_URI';
```

#### 3. Cek File .env
**File**: `.env`

Pastikan:
```
app.baseURL = 'http://localhost:8080/'
app.indexPage = ''
```

#### 4. Hapus Cache Manual
```bash
# Windows
rmdir /s /q writable\cache
mkdir writable\cache

# Linux/Mac
rm -rf writable/cache/*
```

#### 5. Restart Server dengan Port Berbeda
```bash
php spark serve --port=8081
```

Lalu akses:
```
http://localhost:8081/perpus
```

## 📝 Checklist Perbaikan

Centang setiap langkah yang sudah dilakukan:

- [ ] Stop server (Ctrl+C)
- [ ] Clear cache: `php spark cache:clear`
- [ ] Restart server: `php spark serve`
- [ ] Test akses `/` - berhasil
- [ ] Test akses `/perpus` - berhasil
- [ ] Test akses `/perpus/login` - berhasil
- [ ] Test akses `/perpus/login-admin` - berhasil

## 🎯 Test Lengkap

Setelah server running, test semua URL ini:

### ✅ Harus Berhasil (200 OK)
```
http://localhost:8080/
http://localhost:8080/perpus
http://localhost:8080/perpus/login
http://localhost:8080/perpus/login-admin
```

### ❌ Harus Error 404 (Memang Tidak Ada)
```
http://localhost:8080/perpus/perpus  (sudah dihapus)
http://localhost:8080/perpus/profil  (tidak ada)
http://localhost:8080/perpus/bantuan (tidak ada)
```

## 💡 Penjelasan Teknis

### Kenapa Error Terjadi?

**Sebelum Perbaikan:**
```php
$routes->group('perpus', function($routes) {
    $routes->get('/', 'Perpus::index');        // /perpus
    $routes->get('perpus', 'Perpus::perpus');  // /perpus/perpus ❌
});
```

Route `perpus` di dalam group `perpus` membuat URL menjadi `/perpus/perpus`, bukan `/perpus`.

**Setelah Perbaikan:**
```php
$routes->group('perpus', function($routes) {
    $routes->get('/', 'Perpus::index');  // /perpus ✅
});
```

Route `/` di dalam group `perpus` membuat URL menjadi `/perpus` yang benar.

## 🆘 Jika Masih Bermasalah

### Cek Error Log
```bash
# Windows
type writable\logs\log-*.php

# Linux/Mac
cat writable/logs/log-*.php
```

### Cek PHP Error
```bash
php -v
php -m | findstr rewrite
```

### Test Route Secara Manual
```bash
curl -I http://localhost:8080/perpus
```

Expected output:
```
HTTP/1.1 200 OK
...
```

Jika output:
```
HTTP/1.1 404 Not Found
```

Berarti route belum terdaftar dengan benar.

## 📞 Bantuan Lebih Lanjut

Jika semua langkah sudah dilakukan tapi masih error:

1. Screenshot error yang muncul
2. Copy output dari `php spark routes`
3. Copy isi file `app/Config/Routes.php`
4. Copy error log dari `writable/logs/`
5. Hubungi developer dengan informasi di atas

---

**Catatan**: Perbaikan ini sudah dilakukan pada file Routes.php dan Controller. Anda hanya perlu clear cache dan restart server.
