<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\NotificationModel;

class Perpus extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        return view('perpus/beranda');
    }

    private function renderView($view, $data = [])
    {
        $data = array_merge($data, $this->getNotificationData());
        return view($view, $data);
    }

    public function login()
    {
        return view('perpus/login');
    }

    public function loginAdmin()
    {
        return view('perpus/login_admin');
    }

    public function authSiswa()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->to('/')->with('error_siswa', 'Username dan password harus diisi!');
        }

        // Cari user di database
        $user = $this->userModel->getUserByUsername($username);

        if ($user && $user['user_type'] === 'siswa') {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session
                session()->set([
                    'logged_in' => true,
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'user_type' => $user['user_type']
                ]);

                // Update last login
                $this->userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

                return redirect()->to(base_url('perpus/dashboard'));
            }
        }

        return redirect()->to('/')->with('error_siswa', 'Username atau password salah!');
    }

    public function authAdmin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->to(base_url('perpus/login-admin'))->with('error', 'Username dan password harus diisi!');
        }

        // Cari user di database
        $user = $this->userModel->getUserByUsername($username);

        if ($user && $user['user_type'] === 'admin') {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session
                session()->set([
                    'logged_in' => true,
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'user_type' => $user['user_type']
                ]);

                // Update last login
                $this->userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);

                return redirect()->to(base_url('perpus/dashboard-admin'));
            }
        }

        return redirect()->to(base_url('perpus/login-admin'))->with('error', 'Username atau password salah atau Anda bukan admin!');
    }

        public function dashboard()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        // Redirect admin ke dashboard admin
        if (session()->get('user_type') === 'admin') {
            return redirect()->to(base_url('perpus/dashboard-admin'));
        }

        $userId = session()->get('user_id');
        $peminjamanModel = new \App\Models\PeminjamanModel();
        
        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        
        // Statistika
        $today = date('Y-m-d');
        $data['total_dipinjam'] = $peminjamanModel->where('user_id', $userId)
                                                 ->where('status', 'dipinjam')
                                                 ->countAllResults();
                                                 
        $data['total_riwayat'] = $peminjamanModel->where('user_id', $userId)
                                                ->countAllResults();
                                                
        $data['total_jatuh_tempo'] = $peminjamanModel->where('user_id', $userId)
                                                    ->where('status', 'dipinjam')
                                                    ->where('tanggal_kembali <', $today)
                                                    ->countAllResults();

        // Calculate total fines for the student (unpaid only)
        $data['total_denda_saya'] = $peminjamanModel->where('user_id', $userId)
                                                   ->where('is_denda_lunas', 0)
                                                   ->selectSum('denda')
                                                   ->get()->getRow()->denda ?? 0;

        return $this->renderView('perpus/dashboard', $data);
    }

        public function dashboardAdmin()
    {
        // Cek apakah user sudah login dan adalah admin
        if (!session()->get('logged_in') || session()->get('user_type') !== 'admin') {
            return redirect()->to(base_url('perpus/login-admin'));
        }

        $bukuModel = new \App\Models\BukuModel();
        $userModel = new \App\Models\UserModel();
        $peminjamanModel = new \App\Models\PeminjamanModel();

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');

        // Statistika Admin
        $today = date('Y-m-d');
        $data['total_buku'] = $bukuModel->countAllResults();
        $data['total_siswa'] = $userModel->where('user_type', 'siswa')->countAllResults();
        $data['sedang_dipinjam'] = $peminjamanModel->where('status', 'dipinjam')->countAllResults();
        $data['total_terlambat'] = $peminjamanModel->where('status', 'dipinjam')
                                                  ->where('tanggal_kembali <', $today)
                                                  ->countAllResults();
        
        // Fines summary
        $data['total_denda_diterima'] = $peminjamanModel->where('is_denda_lunas', 1)->selectSum('denda')->get()->getRow()->denda ?? 0;
        $data['total_denda_pending'] = $peminjamanModel->where('is_denda_lunas', 0)->selectSum('denda')->get()->getRow()->denda ?? 0;
        $data['total_denda'] = $data['total_denda_pending']; // For backward compatibility with existing views if any

        return $this->renderView('perpus/dashboard_admin', $data);
    }

    public function logout()
    {
        // Simpan user type sebelum destroy session
        $userType = session()->get('user_type');
        
        // Destroy session
        session()->destroy();
        
        // Redirect berdasarkan user type
        if ($userType === 'admin') {
            return redirect()->to('/perpus/login-admin')->with('success', 'Anda telah logout.');
        }
        
        // Default redirect ke beranda untuk siswa
        return redirect()->to('/')->with('success', 'Anda telah logout.');
    }

    public function forgotPassword()
    {
        return view('perpus/forgot_password');
    }

    public function resetPassword()
    {
        $email = $this->request->getPost('email');
        
        $user = $this->userModel->where('email', $email)
                                ->where('user_type', 'siswa')
                                ->first();
                                
        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar atau bukan akun siswa.');
        }
        
        // Generate password baru
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $newPassword = implode($pass);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update database
        $this->userModel->update($user['id'], ['password' => $hashedPassword]);
        
        // Kirim Email
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Password Baru Perpustakaan');
        $emailService->setMessage("Halo {$user['nama_lengkap']},\n\nPassword Anda telah direset. Berikut adalah password baru Anda:\n\nPassword: {$newPassword}\n\nSilakan gunakan password ini untuk login.\n\nTerima kasih.");
        
        if ($emailService->send()) {
            return redirect()->back()->with('success', 'Password baru telah dikirim ke email Anda. Silakan cek inbox/spam.');
        } else {
            // Untuk keperluan demo jika SMTP belum diset
            return redirect()->back()->with('success', "Password baru berhasil dibuat: <strong style='font-size: 1.2rem;'>{$newPassword}</strong><br><small>(Catat password ini! Email gagal terkirim karena SMTP belum dikonfigurasi di server ini)</small>");
        }
    }

    public function notifications()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/');
        }

        $userId = session()->get('user_id');
        $notificationModel = new NotificationModel();
        
        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        $data['all_notifications'] = $notificationModel->where('user_id', $userId)
                                                       ->orderBy('created_at', 'DESC')
                                                       ->findAll();
                                                       
        // Determine which view to use based on user type
        $userType = session()->get('user_type');
        $view = ($userType === 'admin') ? 'perpus/admin/notifications' : 'perpus/siswa/notifications';
        
        return $this->renderView($view, $data);
    }

    public function markNotificationsAsRead()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $notificationModel = new NotificationModel();
        
        $notificationModel->where('user_id', $userId)
                          ->where('is_read', 0)
                          ->set(['is_read' => 1])
                          ->update();
                          
        return $this->response->setJSON(['status' => 'success']);
    }

    public function markSingleNotificationAsRead($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $notificationModel = new NotificationModel();
        
        $notificationModel->where('user_id', $userId)
                          ->where('id', $id)
                          ->set(['is_read' => 1])
                          ->update();
                          
        return $this->response->setJSON(['status' => 'success']);
    }

    public function deleteNotification($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $notificationModel = new NotificationModel();
        
        $notificationModel->where('user_id', $userId)
                          ->where('id', $id)
                          ->delete();
                          
        return $this->response->setJSON(['status' => 'success']);
    }

    public function deleteAllNotifications()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $userId = session()->get('user_id');
        $notificationModel = new NotificationModel();
        
        $notificationModel->where('user_id', $userId)
                          ->delete();
                          
        return $this->response->setJSON(['status' => 'success']);
    }
}
