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
    $routes->get('lupa-password', 'Perpus::forgotPassword');
    $routes->post('reset-password', 'Perpus::resetPassword');
    
    // Dashboard
    $routes->get('dashboard', 'Perpus::dashboard');
    $routes->get('dashboard-admin', 'Perpus::dashboardAdmin');
    
    // Notifikasi
    $routes->get('notifications', 'Perpus::notifications');
    $routes->post('notifications/mark-as-read', 'Perpus::markNotificationsAsRead');
    $routes->post('notifications/mark-as-read/(:num)', 'Perpus::markSingleNotificationAsRead/$1');
    $routes->post('notifications/delete/(:num)', 'Perpus::deleteNotification/$1');
    $routes->post('notifications/delete-all', 'Perpus::deleteAllNotifications');
    
    // Admin - Buku
    $routes->get('kelola-buku', 'Admin::kelolaBuku');
    $routes->get('tambah-buku', 'Admin::tambahBuku');
    $routes->post('simpan-buku', 'Admin::simpanBuku');
    $routes->get('edit-buku/(:num)', 'Admin::editBuku/$1');
    $routes->post('update-buku/(:num)', 'Admin::updateBuku/$1');
    $routes->get('hapus-buku/(:num)', 'Admin::hapusBuku/$1');
    
    // Admin - Peminjaman
    $routes->get('kelola-peminjaman', 'Admin::kelolaPeminjaman');
    $routes->post('proses-pengembalian/(:num)', 'Admin::prosesPengembalian/$1');
    $routes->post('proses-pembayaran-denda/(:num)', 'Admin::prosesPembayaranDenda/$1');
    $routes->get('kelola-laporan', 'Admin::kelolaLaporan');
    
    // Admin - User
    $routes->get('kelola-user', 'Admin::kelolaUser');
    $routes->get('tambah-user', 'Admin::tambahUser');
    $routes->post('simpan-user', 'Admin::simpanUser');
    $routes->get('edit-user/(:num)', 'Admin::editUser/$1');
    $routes->post('update-user/(:num)', 'Admin::updateUser/$1');
    $routes->get('hapus-user/(:num)', 'Admin::hapusUser/$1');
    
    // Admin - Kartu Perpustakaan & Scan
    $routes->get('cetak-kartu/(:num)', 'Admin::cetakKartu/$1');
    $routes->get('scan-kartu', 'Admin::scanKartu');
    $routes->post('proses-scan-kartu', 'Admin::prosesScanKartu');
    
    // Siswa
    $routes->get('katalog', 'Siswa::katalog');
    $routes->get('pinjam-buku/(:num)', 'Siswa::pinjamBuku/$1');
    $routes->post('proses-pinjam', 'Siswa::prosesPinjam');
    $routes->get('peminjaman-saya', 'Siswa::peminjamanSaya');
    $routes->get('ubah-password', 'Siswa::ubahPassword');
    $routes->post('update-password', 'Siswa::updatePassword');
});
