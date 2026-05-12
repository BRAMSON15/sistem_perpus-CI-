# Test Route - Perpustakaan

## Cara Testing Route

Jalankan aplikasi dengan perintah:
```bash
php spark serve
```

Kemudian akses URL berikut untuk memastikan tidak ada error 404:

## ✅ Route Beranda & Auth

1. **Beranda**
   - URL: http://localhost:8080
   - Status: Harus menampilkan halaman beranda dengan form login siswa

2. **Beranda Perpus**
   - URL: http://localhost:8080/perpus
   - Status: Harus menampilkan halaman beranda yang sama

3. **Login Siswa**
   - URL: http://localhost:8080/perpus/login
   - Status: Harus menampilkan form login siswa

4. **Login Admin**
   - URL: http://localhost:8080/perpus/login-admin
   - Status: Harus menampilkan form login admin

## ✅ Route Dashboard (Perlu Login)

5. **Dashboard Siswa**
   - URL: http://localhost:8080/perpus/dashboard
   - Status: Redirect ke login jika belum login, tampilkan dashboard jika sudah login

6. **Dashboard Admin**
   - URL: http://localhost:8080/perpus/dashboard-admin
   - Status: Redirect ke login admin jika belum login, tampilkan dashboard jika sudah login

## ✅ Route Admin - Kelola Buku (Perlu Login Admin)

7. **Kelola Buku**
   - URL: http://localhost:8080/perpus/kelola-buku
   - Status: Menampilkan daftar buku

8. **Tambah Buku**
   - URL: http://localhost:8080/perpus/tambah-buku
   - Status: Menampilkan form tambah buku

9. **Edit Buku** (ganti {id} dengan ID buku yang ada)
   - URL: http://localhost:8080/perpus/edit-buku/1
   - Status: Menampilkan form edit buku

## ✅ Route Admin - Kelola Peminjaman (Perlu Login Admin)

10. **Kelola Peminjaman**
    - URL: http://localhost:8080/perpus/kelola-peminjaman
    - Status: Menampilkan daftar peminjaman

## ✅ Route Admin - Kelola User (Perlu Login Admin)

11. **Kelola User**
    - URL: http://localhost:8080/perpus/kelola-user
    - Status: Menampilkan daftar user siswa

12. **Tambah User**
    - URL: http://localhost:8080/perpus/tambah-user
    - Status: Menampilkan form tambah user

## ✅ Route Siswa (Perlu Login Siswa)

13. **Katalog Buku**
    - URL: http://localhost:8080/perpus/katalog
    - Status: Menampilkan katalog buku yang tersedia

14. **Pinjam Buku** (ganti {id} dengan ID buku yang ada)
    - URL: http://localhost:8080/perpus/pinjam-buku/1
    - Status: Menampilkan form konfirmasi peminjaman

15. **Peminjaman Saya**
    - URL: http://localhost:8080/perpus/peminjaman-saya
    - Status: Menampilkan riwayat peminjaman siswa

## ✅ Route Logout

16. **Logout**
    - URL: http://localhost:8080/perpus/logout
    - Status: Logout dan redirect ke beranda

## Kredensial Login Default

### Admin
- Username: `admin`
- Password: `admin123`

### Siswa (jika sudah ada di database)
- Username: `siswa1`
- Password: `12345`

## Checklist Testing

- [ ] Semua route beranda dapat diakses
- [ ] Form login siswa berfungsi
- [ ] Form login admin berfungsi
- [ ] Dashboard siswa dapat diakses setelah login
- [ ] Dashboard admin dapat diakses setelah login admin
- [ ] Semua menu admin dapat diakses
- [ ] Semua menu siswa dapat diakses
- [ ] Logout berfungsi dengan baik
- [ ] Tidak ada error 404 di semua halaman
- [ ] Semua link navigasi berfungsi

## Hasil Testing

Tanggal: _______________
Tester: _______________

| No | Route | Status | Catatan |
|----|-------|--------|---------|
| 1  | Beranda | ⬜ OK / ⬜ Error | |
| 2  | Login Siswa | ⬜ OK / ⬜ Error | |
| 3  | Login Admin | ⬜ OK / ⬜ Error | |
| 4  | Dashboard Siswa | ⬜ OK / ⬜ Error | |
| 5  | Dashboard Admin | ⬜ OK / ⬜ Error | |
| 6  | Kelola Buku | ⬜ OK / ⬜ Error | |
| 7  | Tambah Buku | ⬜ OK / ⬜ Error | |
| 8  | Edit Buku | ⬜ OK / ⬜ Error | |
| 9  | Kelola Peminjaman | ⬜ OK / ⬜ Error | |
| 10 | Kelola User | ⬜ OK / ⬜ Error | |
| 11 | Tambah User | ⬜ OK / ⬜ Error | |
| 12 | Katalog Buku | ⬜ OK / ⬜ Error | |
| 13 | Pinjam Buku | ⬜ OK / ⬜ Error | |
| 14 | Peminjaman Saya | ⬜ OK / ⬜ Error | |
| 15 | Logout | ⬜ OK / ⬜ Error | |
