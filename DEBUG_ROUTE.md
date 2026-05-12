# Debug Route /perpus

## Masalah
Error: "The requested resource /perpus was not found on this server."

## Analisis

### Route Configuration
File: `app/Config/Routes.php`

```php
// Route default
$routes->get('/', 'Perpus::index');

// Route group perpus
$routes->group('perpus', function($routes) {
    $routes->get('/', 'Perpus::index');  // Ini adalah /perpus
    // ... routes lainnya
});
```

### URL yang Seharusnya Berfungsi
1. `/` → `Perpus::index` → `perpus/beranda.php` ✅
2. `/perpus` → `Perpus::index` → `perpus/beranda.php` ✅

### Penyebab Masalah yang Sudah Diperbaiki
1. ❌ Route `perpus/perpus` yang salah → **SUDAH DIHAPUS**
2. ❌ Method `perpus()` yang tidak digunakan → **SUDAH DIHAPUS**

## Solusi yang Sudah Diterapkan

### 1. Hapus Route Duplikat
**File**: `app/Config/Routes.php`
```php
// DIHAPUS:
$routes->get('perpus', 'Perpus::perpus');
```

### 2. Hapus Method Tidak Digunakan
**File**: `app/Controllers/Perpus.php`
```php
// DIHAPUS:
public function perpus()
{
    return view('perpus/perpus');
}
```

## Testing

### Test 1: Akses Root
```bash
curl http://localhost:8080/
# Harus menampilkan halaman beranda
```

### Test 2: Akses /perpus
```bash
curl http://localhost:8080/perpus
# Harus menampilkan halaman beranda yang sama
```

### Test 3: Cek Route List
```bash
php spark routes | findstr perpus
```

**Expected Output:**
```
GET     /perpus                                Perpus::index
GET     /perpus/login                          Perpus::login
GET     /perpus/login-admin                    Perpus::loginAdmin
POST    /perpus/auth-siswa                     Perpus::authSiswa
POST    /perpus/auth-admin                     Perpus::authAdmin
GET     /perpus/logout                         Perpus::logout
GET     /perpus/dashboard                      Perpus::dashboard
GET     /perpus/dashboard-admin                Perpus::dashboardAdmin
... (dan seterusnya)
```

## Langkah Troubleshooting

### Jika masih error 404:

#### 1. Clear Cache
```bash
php spark cache:clear
```

#### 2. Restart Server
```bash
# Stop server (Ctrl+C)
php spark serve
```

#### 3. Cek .htaccess
File: `public/.htaccess`

Pastikan ada:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```

#### 4. Cek .env
File: `.env`

Pastikan ada:
```
app.baseURL = 'http://localhost:8080/'
app.indexPage = ''
```

#### 5. Cek app/Config/App.php
```php
public string $indexPage = '';
public string $uriProtocol = 'REQUEST_URI';
```

### Jika menggunakan Apache (bukan php spark serve):

#### 1. Enable mod_rewrite
```bash
# Linux/Mac
sudo a2enmod rewrite
sudo service apache2 restart

# Windows (XAMPP)
# Sudah enabled by default
```

#### 2. Cek Virtual Host
Pastikan `AllowOverride All` di konfigurasi Apache

## Verifikasi Perbaikan

### Checklist:
- [x] Route `/perpus/perpus` dihapus dari Routes.php
- [x] Method `perpus()` dihapus dari Controller
- [ ] Cache di-clear
- [ ] Server di-restart
- [ ] Test akses `/perpus` berhasil

## Kesimpulan

Route `/perpus` seharusnya sudah berfungsi setelah:
1. Menghapus route duplikat
2. Menghapus method yang tidak digunakan
3. Clear cache
4. Restart server

Jika masih error, kemungkinan masalah ada di:
- Konfigurasi web server
- File .htaccess
- File .env
- Cache yang belum ter-clear
