# Setup Database Perpustakaan

## Langkah-langkah Setup:

### 1. Buka Laragon
- Start Laragon (Apache & MySQL)

### 2. Import Database
Ada 2 cara:

#### Cara 1: Menggunakan phpMyAdmin
1. Buka browser: `http://localhost/phpmyadmin`
2. Klik tab "SQL"
3. Copy paste isi file `database_setup.sql`
4. Klik "Go"

#### Cara 2: Menggunakan Command Line
```bash
# Buka terminal di folder project
cd "c:\laragon\www\mentahan perpus (codignitter)\app_perpus - Copy"

# Import database
mysql -u root -p < database_setup.sql
# (tekan Enter saja jika diminta password, karena default Laragon tidak ada password)
```

#### Cara 3: Menggunakan CodeIgniter Migration (Recommended)
```bash
# Buka terminal di folder project
cd "c:\laragon\www\mentahan perpus (codignitter)\app_perpus - Copy"

# Jalankan migration
php spark migrate

# Jalankan seeder untuk data dummy
php spark db:seed UserSeeder
```

### 3. Konfigurasi Database (Sudah Dikonfigurasi)
File: `app/Config/Database.php`
```php
'hostname' => 'localhost',
'username' => 'root',
'password' => '',  // Kosong untuk Laragon default
'database' => 'perpus',
```

### 4. Test Login
Buka browser: `http://localhost:8080/perpus/login`

**Kredensial Login:**
- Username: `siswa`
- Password: `12345`

atau

- Username: `admin`
- Password: `password`

### 5. Verifikasi Database
Cek apakah database dan tabel sudah terbuat:
1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Pilih database `perpus`
3. Lihat tabel `users`
4. Cek apakah ada 2 data user (siswa dan admin)

## Troubleshooting

### Error: Database connection failed
- Pastikan MySQL di Laragon sudah running
- Cek username dan password di `app/Config/Database.php`

### Error: Table doesn't exist
- Jalankan migration: `php spark migrate`
- Atau import manual file `database_setup.sql`

### Error: Access denied
- Default Laragon: username=`root`, password=kosong
- Jika sudah diubah, sesuaikan di `app/Config/Database.php`
