# Link Akses Aplikasi Perpustakaan

## Cara Menjalankan Aplikasi

### Opsi 1: Menggunakan PHP Spark (Recommended)
```bash
php spark serve
```
Aplikasi akan berjalan di: **http://localhost:8080**

### Opsi 2: Menggunakan Laragon
Jika menggunakan Laragon, aplikasi otomatis berjalan.
Akses melalui browser sesuai konfigurasi virtual host Anda.

---

## 🌐 Link Akses Lengkap

### 📌 HALAMAN PUBLIK

#### Beranda Utama
```
http://localhost:8080/perpus
```
- Halaman landing page perpustakaan
- Form login siswa tersedia di halaman ini

---

### 👨‍💼 ADMIN PANEL

#### Login Admin
```
http://localhost:8080/perpus/login-admin
```
**Kredensial:**
- Username: `admin`
- Password: `password`

#### Dashboard Admin
```
http://localhost:8080/perpus/dashboard-admin
```

#### Kelola Buku
```
http://localhost:8080/perpus/kelola-buku
http://localhost:8080/perpus/tambah-buku
```

#### Kelola Peminjaman
```
http://localhost:8080/perpus/kelola-peminjaman
```

#### Kelola User
```
http://localhost:8080/perpus/kelola-user
http://localhost:8080/perpus/tambah-user
```

---

### 👨‍🎓 SISWA PANEL

#### Login Siswa
Login langsung di beranda:
```
http://localhost:8080/perpus
```
**Kredensial:**
- Username: `siswa`
- Password: `12345`

#### Dashboard Siswa
```
http://localhost:8080/perpus/dashboard
```

#### Katalog Buku
```
http://localhost:8080/perpus/katalog
```

#### Peminjaman Saya
```
http://localhost:8080/perpus/peminjaman-saya
```

---

## 🔐 Kredensial Login

### Admin
| Username | Password | Role |
|----------|----------|------|
| admin    | password | Admin |

### Siswa
| Username | Password | Role  |
|----------|----------|-------|
| siswa    | 12345    | Siswa |

---

## 📋 Daftar Route Lengkap

### Public Routes
- `GET /` - Home
- `GET /perpus` - Beranda Perpustakaan

### Auth Routes
- `GET /perpus/login` - Login Siswa (deprecated, gunakan form di beranda)
- `GET /perpus/login-admin` - Login Admin
- `POST /perpus/auth-siswa` - Proses Login Siswa
- `POST /perpus/auth-admin` - Proses Login Admin
- `GET /perpus/logout` - Logout

### Dashboard Routes
- `GET /perpus/dashboard` - Dashboard Siswa
- `GET /perpus/dashboard-admin` - Dashboard Admin

### Admin Routes - Buku
- `GET /perpus/kelola-buku` - List Buku
- `GET /perpus/tambah-buku` - Form Tambah Buku
- `POST /perpus/simpan-buku` - Simpan Buku Baru
- `GET /perpus/edit-buku/{id}` - Form Edit Buku
- `POST /perpus/update-buku/{id}` - Update Buku
- `GET /perpus/hapus-buku/{id}` - Hapus Buku

### Admin Routes - Peminjaman
- `GET /perpus/kelola-peminjaman` - List Peminjaman
- `POST /perpus/proses-pengembalian/{id}` - Proses Pengembalian

### Admin Routes - User
- `GET /perpus/kelola-user` - List User
- `GET /perpus/tambah-user` - Form Tambah User
- `POST /perpus/simpan-user` - Simpan User Baru
- `GET /perpus/hapus-user/{id}` - Hapus User

### Siswa Routes
- `GET /perpus/katalog` - Katalog Buku
- `GET /perpus/pinjam-buku/{id}` - Form Pinjam Buku
- `POST /perpus/proses-pinjam` - Proses Peminjaman
- `GET /perpus/peminjaman-saya` - Riwayat Peminjaman

---

## 🚀 Quick Start

1. **Start Server**
   ```bash
   php spark serve
   ```

2. **Akses Beranda**
   ```
   http://localhost:8080/perpus
   ```

3. **Login sebagai Admin**
   - Klik "Login sebagai Admin" atau akses: `http://localhost:8080/perpus/login-admin`
   - Username: `admin`, Password: `password`

4. **Login sebagai Siswa**
   - Gunakan form login di beranda
   - Username: `siswa`, Password: `12345`

---

## ⚠️ Troubleshooting

### Route tidak berfungsi?
```bash
# Clear cache
php spark cache:clear

# Cek route list
php spark routes
```

### Error 404?
Pastikan:
1. Server sudah running (`php spark serve`)
2. Akses URL dengan benar (gunakan `/perpus` bukan `/public/perpus`)
3. File `.htaccess` ada di folder `public/`

### Tidak bisa login?
1. Pastikan database sudah di-setup
2. Jalankan migration: `php spark migrate`
3. Jalankan seeder: `php spark db:seed UserSeeder`

---

## 📞 Support

Jika ada masalah, cek:
1. Log error di `writable/logs/`
2. Pastikan database connection di `app/Config/Database.php`
3. Pastikan semua migration sudah dijalankan
