# Cara Setup Aplikasi Perpustakaan

## Langkah 1: Setup Database

### Opsi A - Menggunakan Migration (Recommended)
```bash
# 1. Jalankan migration
php spark migrate

# 2. Jalankan seeder untuk data dummy
php spark db:seed UserSeeder
php spark db:seed BukuSeeder
```

### Opsi B - Import SQL Manual
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Import file `database_setup.sql`

## Langkah 2: Konfigurasi

File konfigurasi sudah diatur di `app/Config/Database.php`:
- Host: localhost
- Username: root
- Password: (kosong)
- Database: perpus

## Langkah 3: Akses Aplikasi

### Beranda Publik
URL: `http://localhost:8080/perpus`

### Login Admin
URL: `http://localhost:8080/perpus/login-admin`
- Username: `admin`
- Password: `password` atau `admin123`

### Login Siswa
Login langsung di beranda atau:
URL: `http://localhost:8080/perpus`
- Username: `siswa`
- Password: `12345`

## Fitur Aplikasi

### Admin Panel
1. **Dashboard** - Statistik perpustakaan
2. **Kelola Buku** - CRUD buku dengan upload gambar
3. **Kelola Peminjaman** - Proses peminjaman dan pengembalian
4. **Kelola User** - Manajemen siswa

### Siswa Panel
1. **Dashboard** - Statistik peminjaman pribadi
2. **Katalog Buku** - Browse dan pinjam buku
3. **Peminjaman Saya** - Riwayat peminjaman

## Upload Gambar Buku

Folder upload: `public/uploads/buku/`
- Format: JPG, PNG, JPEG
- Ukuran maksimal: 2MB
- Gambar otomatis tampil di katalog

## Troubleshooting

### Error: Whoops!
- Pastikan migration sudah dijalankan
- Pastikan database `perpus` sudah dibuat
- Cek koneksi database di `app/Config/Database.php`

### Error: Table doesn't exist
```bash
php spark migrate:refresh
php spark db:seed UserSeeder
php spark db:seed BukuSeeder
```

### Error: Upload gambar gagal
- Pastikan folder `public/uploads/buku/` ada dan writable
- Cek ukuran file (max 2MB)
- Cek format file (JPG, PNG, JPEG)

## Data Dummy

### User Admin
- Username: admin
- Password: password

### User Siswa
- Username: siswa
- Password: 12345

### Buku (5 buku dummy)
- Laskar Pelangi
- Bumi Manusia
- Negeri 5 Menara
- Filosofi Teras
- Sapiens

## Struktur Database

### Tabel: users
- id, username, password, nama_lengkap, kelas, user_type, created_at, updated_at

### Tabel: buku
- id, kode_buku, judul, pengarang, penerbit, tahun_terbit, kategori, stok, tersedia, gambar, created_at, updated_at

### Tabel: peminjaman
- id, user_id, buku_id, tanggal_pinjam, tanggal_kembali, tanggal_dikembalikan, status, denda, created_at, updated_at

## Teknologi

- Framework: CodeIgniter 4
- Database: MySQL
- Frontend: HTML, CSS, JavaScript
- Icons: Bootstrap Icons
- PHP Version: 7.4+
