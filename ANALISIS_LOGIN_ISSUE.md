# Analisis Masalah Login

## Masalah yang Ditemukan

### 1. ❌ Route `perpus/auth` Tidak Digunakan
- **Lokasi**: `app/Config/Routes.php` line 19
- **Masalah**: Route ini terdaftar tapi tidak ada method `auth()` di controller Perpus
- **Solusi**: Hapus route ini karena tidak digunakan

### 2. ⚠️ Logika Password Verification Bermasalah
- **Lokasi**: `app/Controllers/Perpus.php`
- **Masalah**: 
  ```php
  if (password_verify($password, $user['password']) || $password === '12345') {
  ```
  Ini memungkinkan login dengan password '12345' atau 'admin123' tanpa cek hash
- **Risiko**: Security issue - bypass password hash
- **Solusi**: Hapus hardcoded password check

### 3. ⚠️ Error Message Redirect Berbeda
- **authSiswa**: Redirect ke `perpus` dengan flashdata `error_siswa`
- **authAdmin**: Redirect ke `back()` dengan flashdata `error`
- **Masalah**: Inconsistent error handling
- **Solusi**: Standardisasi error handling

### 4. ✅ Method `getUserByUsername()` Sudah Benar
- Model sudah memiliki method yang diperlukan
- Query sudah benar

### 5. ✅ User Seeder Sudah Benar
- Admin: username `admin`, password `admin123`
- Siswa: username `siswa`, password `12345`
- Password sudah di-hash dengan benar

## Perbaikan yang Diperlukan

### Perbaikan 1: Hapus Route yang Tidak Digunakan
File: `app/Config/Routes.php`
```php
// HAPUS baris ini:
$routes->post('auth', 'Perpus::auth');
```

### Perbaikan 2: Perbaiki Password Verification
File: `app/Controllers/Perpus.php`

**Method authSiswa():**
```php
// SEBELUM (SALAH):
if (password_verify($password, $user['password']) || $password === '12345') {

// SESUDAH (BENAR):
if (password_verify($password, $user['password'])) {
```

**Method authAdmin():**
```php
// SEBELUM (SALAH):
if (password_verify($password, $user['password']) || $password === 'admin123') {

// SESUDAH (BENAR):
if (password_verify($password, $user['password'])) {
```

### Perbaikan 3: Standardisasi Error Handling
File: `app/Controllers/Perpus.php`

**Method authSiswa():**
```php
// Tetap redirect ke beranda dengan error_siswa
return redirect()->to(base_url('perpus'))->with('error_siswa', 'Username atau password salah!');
```

**Method authAdmin():**
```php
// Ubah redirect back() menjadi redirect ke login-admin
return redirect()->to(base_url('perpus/login-admin'))->with('error', 'Username atau password salah atau Anda bukan admin!');
```

## Alur Login yang Benar

### Login Siswa:
1. User mengisi form di `/perpus` (beranda)
2. Form submit ke `/perpus/auth-siswa` (POST)
3. Controller `Perpus::authSiswa()` memproses
4. Jika berhasil → redirect ke `/perpus/dashboard`
5. Jika gagal → redirect ke `/perpus` dengan error message

### Login Admin:
1. User mengisi form di `/perpus/login-admin`
2. Form submit ke `/perpus/auth-admin` (POST)
3. Controller `Perpus::authAdmin()` memproses
4. Jika berhasil → redirect ke `/perpus/dashboard-admin`
5. Jika gagal → redirect ke `/perpus/login-admin` dengan error message

## Testing Setelah Perbaikan

### Test Login Siswa:
1. Buka: `http://localhost:8080/perpus`
2. Login dengan:
   - Username: `siswa`
   - Password: `12345`
3. Harus redirect ke dashboard siswa

### Test Login Admin:
1. Buka: `http://localhost:8080/perpus/login-admin`
2. Login dengan:
   - Username: `admin`
   - Password: `admin123`
3. Harus redirect ke dashboard admin

### Test Login Gagal:
1. Coba login dengan password salah
2. Harus muncul error message
3. Harus tetap di halaman login

## Checklist Perbaikan

- [ ] Hapus route `perpus/auth` yang tidak digunakan
- [ ] Hapus hardcoded password check di `authSiswa()`
- [ ] Hapus hardcoded password check di `authAdmin()`
- [ ] Ubah redirect error di `authAdmin()` dari `back()` ke `login-admin`
- [ ] Test login siswa dengan kredensial benar
- [ ] Test login admin dengan kredensial benar
- [ ] Test login dengan password salah
- [ ] Test login dengan username yang tidak ada
