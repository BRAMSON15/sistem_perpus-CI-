# 📖 Panduan Cepat - Aplikasi Perpustakaan

## 🚀 Cara Menjalankan Aplikasi

### 1. Jalankan Server
```bash
php spark serve
```

### 2. Buka Browser
```
http://localhost:8080
```

## 🔑 Login

### Login Siswa
1. Buka: `http://localhost:8080/perpus`
2. Isi form di sidebar kanan:
   - **Username**: `siswa`
   - **Password**: `12345`
3. Klik **Login**

### Login Admin
1. Buka: `http://localhost:8080/perpus/login-admin`
2. Isi form:
   - **Username**: `admin`
   - **Password**: `admin123`
3. Klik **Login sebagai Admin**

## 📋 Fitur Siswa

Setelah login sebagai siswa, Anda bisa:

1. **Dashboard** - Lihat ringkasan peminjaman
2. **Katalog Buku** - Lihat dan pinjam buku yang tersedia
3. **Peminjaman Saya** - Lihat riwayat peminjaman

## 🔧 Fitur Admin

Setelah login sebagai admin, Anda bisa:

1. **Dashboard** - Lihat statistik perpustakaan
2. **Kelola Buku** - Tambah, edit, hapus buku
3. **Kelola Peminjaman** - Proses pengembalian buku
4. **Kelola User** - Tambah, hapus user siswa

## 🔄 Alur Peminjaman Buku

### Untuk Siswa:
1. Login sebagai siswa
2. Klik menu **Katalog Buku**
3. Pilih buku yang ingin dipinjam
4. Klik **Pinjam Buku**
5. Konfirmasi peminjaman
6. Buku akan masuk ke **Peminjaman Saya**

### Untuk Admin (Pengembalian):
1. Login sebagai admin
2. Klik menu **Kelola Peminjaman**
3. Cari peminjaman yang akan dikembalikan
4. Klik **Kembalikan**
5. Stok buku akan bertambah otomatis

## 📝 Menambah Buku (Admin)

1. Login sebagai admin
2. Klik menu **Kelola Buku**
3. Klik **Tambah Buku**
4. Isi form:
   - Kode Buku
   - Judul
   - Pengarang
   - Penerbit
   - Tahun Terbit
   - Kategori
   - Stok
   - Upload gambar (opsional)
5. Klik **Simpan Buku**

## 👥 Menambah User Siswa (Admin)

1. Login sebagai admin
2. Klik menu **Kelola User**
3. Klik **Tambah User**
4. Isi form:
   - Username
   - Password
   - Nama Lengkap
   - Kelas
5. Klik **Simpan User**

## 🚪 Logout

Klik tombol **Logout** di pojok kanan atas

## ❓ Troubleshooting

### Tidak bisa login?
- Pastikan username dan password benar
- Cek apakah database sudah di-setup
- Cek apakah seeder sudah dijalankan

### Error 404?
- Pastikan server sudah running
- Cek URL yang diakses
- Lihat dokumentasi route di `PERBAIKAN_ROUTE_SELESAI.md`

### Gambar buku tidak muncul?
- Pastikan folder `public/uploads/buku` ada
- Cek permission folder
- Upload ulang gambar

## 📚 Dokumentasi Lengkap

Untuk informasi lebih detail, lihat:

1. **RINGKASAN_PERBAIKAN_FINAL.md** - Ringkasan lengkap perbaikan
2. **PERBAIKAN_ROUTE_SELESAI.md** - Detail perbaikan route
3. **PERBAIKAN_LOGIN_SELESAI.md** - Detail perbaikan login
4. **TEST_ROUTE.md** - Panduan testing route

## 🆘 Butuh Bantuan?

Jika mengalami masalah:
1. Cek dokumentasi di folder root
2. Cek error log di `writable/logs/`
3. Hubungi developer

---

**Selamat menggunakan Aplikasi Perpustakaan! 📚**
