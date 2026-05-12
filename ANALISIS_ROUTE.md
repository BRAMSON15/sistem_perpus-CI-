# Analisis Route - Perpustakaan

## Route yang Terdaftar di Routes.php

### ✅ Route yang Sudah Benar
1. `/` → `Perpus::index` (Beranda)
2. `/perpus` → `Perpus::index` (Beranda)
3. `/perpus/login` → `Perpus::login`
4. `/perpus/login-admin` → `Perpus::loginAdmin`
5. `/perpus/auth-siswa` → `Perpus::authSiswa` (POST)
6. `/perpus/auth-admin` → `Perpus::authAdmin` (POST)
7. `/perpus/logout` → `Perpus::logout`
8. `/perpus/dashboard` → `Perpus::dashboard`
9. `/perpus/dashboard-admin` → `Perpus::dashboardAdmin`
10. `/perpus/kelola-buku` → `Admin::kelolaBuku`
11. `/perpus/tambah-buku` → `Admin::tambahBuku`
12. `/perpus/edit-buku/{id}` → `Admin::editBuku`
13. `/perpus/hapus-buku/{id}` → `Admin::hapusBuku`
14. `/perpus/kelola-peminjaman` → `Admin::kelolaPeminjaman`
15. `/perpus/kelola-user` → `Admin::kelolaUser`
16. `/perpus/tambah-user` → `Admin::tambahUser`
17. `/perpus/katalog` → `Siswa::katalog`
18. `/perpus/pinjam-buku/{id}` → `Siswa::pinjamBuku`
19. `/perpus/proses-pinjam` → `Siswa::prosesPinjam` (POST)
20. `/perpus/peminjaman-saya` → `Siswa::peminjamanSaya`

## ❌ Route yang TIDAK Terdaftar (404 Error)

### Dari beranda.php:
1. `/perpus/peminjaman` - TIDAK ADA
2. `/perpus/tentang` - TIDAK ADA

### Dari dashboard.php (Siswa):
3. `/perpus/profil` - TIDAK ADA
4. `/perpus/bantuan` - TIDAK ADA

### Dari dashboard_admin.php:
5. `/perpus/laporan` - TIDAK ADA
6. `/perpus/pengaturan` - TIDAK ADA

### Dari login.php:
7. `/perpus/auth` - TIDAK ADA (seharusnya `/perpus/auth-siswa`)

## 🔧 Perbaikan yang Diperlukan

### 1. Perbaiki form action di login.php
- Ubah: `perpus/auth` → `perpus/auth-siswa`

### 2. Hapus atau tambahkan route untuk menu yang tidak ada:
- Opsi A: Hapus link menu yang tidak ada
- Opsi B: Tambahkan route dan controller untuk menu tersebut

### 3. Tambahkan route yang hilang (jika diperlukan):
```php
// Route tambahan untuk siswa
$routes->get('profil', 'Siswa::profil');
$routes->get('bantuan', 'Siswa::bantuan');

// Route tambahan untuk admin
$routes->get('laporan', 'Admin::laporan');
$routes->get('pengaturan', 'Admin::pengaturan');

// Route tambahan untuk beranda
$routes->get('peminjaman', 'Perpus::peminjaman');
$routes->get('tentang', 'Perpus::tentang');
```

## Status Perbaikan
- [x] Identifikasi route yang bermasalah
- [ ] Perbaiki form action di login.php
- [ ] Hapus atau tambahkan route yang hilang
- [ ] Test semua link
