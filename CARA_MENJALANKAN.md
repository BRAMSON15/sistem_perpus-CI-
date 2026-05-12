# 🚀 Cara Menjalankan Aplikasi Perpustakaan

## ⚠️ PENTING - Baca Ini Dulu!

Aplikasi ini HARUS dijalankan menggunakan **PHP Spark Server**, bukan langsung dari Laragon/XAMPP.

---

## 📋 Langkah-Langkah Setup

### 1️⃣ Pastikan Database Sudah Siap

```bash
# Jalankan migration
php spark migrate

# Jalankan seeder untuk data dummy
php spark db:seed UserSeeder
php spark db:seed BukuSeeder
```

### 2️⃣ Jalankan Server

**WAJIB menggunakan perintah ini:**

```bash
php spark serve
```

**Output yang benar:**
```
CodeIgniter v4.x.x development server started on http://localhost:8080
```

### 3️⃣ Akses Aplikasi

Buka browser dan akses:
```
http://localhost:8080/perpus
```

---

## ✅ Checklist Sebelum Menjalankan

- [ ] MySQL/MariaDB sudah running (cek di Laragon)
- [ ] Database `perpus` sudah dibuat
- [ ] Migration sudah dijalankan (`php spark migrate`)
- [ ] Seeder sudah dijalankan (`php spark db:seed UserSeeder` dan `php spark db:seed BukuSeeder`)
- [ ] File `.env` sudah ada di root folder
- [ ] Jalankan `php spark serve` (BUKAN akses langsung dari Laragon)

---

## 🔗 Link Akses Setelah Server Running

### Halaman Utama
```
http://localhost:8080/perpus
```

### Login Admin
```
http://localhost:8080/perpus/login-admin
```
- Username: `admin`
- Password: `password`

### Login Siswa
Login di halaman utama (`http://localhost:8080/perpus`)
- Username: `siswa`
- Password: `12345`

---

## ❌ JANGAN Lakukan Ini

### ❌ SALAH - Akses Langsung dari Laragon
```
http://localhost/mentahan%20perpus%20(codignitter)/app_perpus%20-%20Copy/public/perpus
```
**Ini akan error 404!**

### ✅ BENAR - Gunakan PHP Spark
```bash
php spark serve
```
Lalu akses:
```
http://localhost:8080/perpus
```

---

## 🐛 Troubleshooting

### Error: 404 Not Found

**Penyebab:** Tidak menggunakan `php spark serve`

**Solusi:**
1. Stop akses dari Laragon
2. Buka terminal di folder project
3. Jalankan: `php spark serve`
4. Akses: `http://localhost:8080/perpus`

### Error: Database connection failed

**Solusi:**
1. Pastikan MySQL running di Laragon
2. Cek file `.env`:
   ```
   database.default.hostname = localhost
   database.default.database = perpus
   database.default.username = root
   database.default.password = 
   ```
3. Buat database `perpus` jika belum ada

### Error: Table doesn't exist

**Solusi:**
```bash
php spark migrate:refresh
php spark db:seed UserSeeder
php spark db:seed BukuSeeder
```

### Port 8080 sudah digunakan

**Solusi:** Gunakan port lain
```bash
php spark serve --port=8081
```
Lalu akses: `http://localhost:8081/perpus`

---

## 📝 Perintah Lengkap

```bash
# 1. Masuk ke folder project
cd "c:\laragon\www\mentahan perpus (codignitter)\app_perpus - Copy"

# 2. Setup database (hanya sekali)
php spark migrate
php spark db:seed UserSeeder
php spark db:seed BukuSeeder

# 3. Jalankan server (setiap kali mau pakai)
php spark serve

# 4. Buka browser
# Akses: http://localhost:8080/perpus
```

---

## 🎯 Quick Start (Copy-Paste)

Buka terminal dan jalankan:

```bash
cd "c:\laragon\www\mentahan perpus (codignitter)\app_perpus - Copy"
php spark serve
```

Lalu buka browser:
```
http://localhost:8080/perpus
```

---

## 📞 Masih Error?

1. Cek log error di: `writable/logs/`
2. Pastikan semua file ada (tidak ada yang terhapus)
3. Pastikan PHP versi 7.4 atau lebih tinggi
4. Pastikan extension PHP yang diperlukan aktif:
   - intl
   - mbstring
   - json
   - mysqlnd

---

## ✨ Fitur Aplikasi

### Admin
- Dashboard dengan statistik
- Kelola Buku (CRUD + Upload Gambar)
- Kelola Peminjaman
- Kelola User Siswa

### Siswa
- Dashboard pribadi
- Katalog Buku dengan gambar
- Pinjam Buku
- Riwayat Peminjaman

---

**Selamat Menggunakan! 🎉**
