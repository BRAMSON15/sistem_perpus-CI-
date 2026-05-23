<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\PeminjamanModel;
use App\Models\NotificationModel;

class Siswa extends BaseController
{
    protected $bukuModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    private function renderSiswaView($view, $data = [])
    {
        $data = array_merge($data, $this->getNotificationData());
        return view($view, $data);
    }

    private function checkSiswa()
    {
        if (!session()->get('logged_in') || session()->get('user_type') !== 'siswa') {
            return redirect()->to('/');
        }
        return null;
    }

    public function katalog()
    {
        if ($redirect = $this->checkSiswa()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        $data['buku'] = $this->bukuModel->where('tersedia >', 0)->findAll();
        return $this->renderSiswaView('perpus/siswa/katalog', $data);
    }

    public function pinjamBuku($id)
    {
        if ($redirect = $this->checkSiswa()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        $data['buku'] = $this->bukuModel->find($id);
        return $this->renderSiswaView('perpus/siswa/pinjam_buku', $data);
    }

    public function prosesPinjam()
    {
        if ($redirect = $this->checkSiswa()) return $redirect;

        $bukuId = $this->request->getPost('buku_id');
        $buku = $this->bukuModel->find($bukuId);

        if ($buku['tersedia'] <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia!');
        }

        // Simpan peminjaman
        $data = [
            'user_id' => session()->get('user_id'),
            'buku_id' => $bukuId,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status' => 'dipinjam'
        ];

        $this->peminjamanModel->save($data);

        // Update stok buku
        $this->bukuModel->update($bukuId, [
            'tersedia' => $buku['tersedia'] - 1
        ]);

        // Notify student
        $notificationModel = new NotificationModel();
        $notificationModel->save([
            'user_id' => session()->get('user_id'),
            'title'   => 'Peminjaman Berhasil',
            'message' => 'Anda telah berhasil meminjam buku "' . $buku['judul'] . '". Harap kembalikan sebelum ' . date('d M Y', strtotime('+7 days')) . '.',
            'type'    => 'success'
        ]);

        // Notify Admins
        $userModel = new \App\Models\UserModel();
        $admins = $userModel->where('user_type', 'admin')->findAll();
        foreach ($admins as $admin) {
            $notificationModel->save([
                'user_id' => $admin['id'],
                'title'   => 'Peminjaman Baru',
                'message' => 'Siswa ' . session()->get('nama_lengkap') . ' telah meminjam buku "' . $buku['judul'] . '".',
                'type'    => 'info'
            ]);
        }

        return redirect()->to(base_url('perpus/peminjaman-saya'))->with('success', 'Buku berhasil dipinjam!');
    }

    public function peminjamanSaya()
    {
        if ($redirect = $this->checkSiswa()) return $redirect;

        $userId = session()->get('user_id');
        $peminjaman_raw = $this->peminjamanModel->getPeminjamanWithDetails($userId);
        $sekarang = date('Y-m-d');
        $denda_flat = 2000; // Denda flat rate untuk keterlambatan

        // Dynamically update status and pending fines
        $peminjaman = array_map(function($p) use ($sekarang, $denda_flat) {
            if ($p['status'] == 'dipinjam' && $sekarang > $p['tanggal_kembali']) {
                $p['status'] = 'terlambat';
                
                // Calculate pending fine (flat rate: Rp 2000 untuk terlambat 1-3 hari atau lebih)
                $tanggal_kembali = new \DateTime($p['tanggal_kembali']);
                $tanggal_sekarang = new \DateTime($sekarang);
                $diff = $tanggal_sekarang->diff($tanggal_kembali);
                
                // Jika terlambat, denda flat Rp 2000 (tidak peduli berapa hari terlambat)
                if ($diff->days > 0) {
                    $p['denda'] = $denda_flat;
                }
            }
            return $p;
        }, $peminjaman_raw);

        $data = [
            'username' => session()->get('nama_lengkap') ?: session()->get('username'),
            'peminjaman' => $peminjaman
        ];

        return $this->renderSiswaView('perpus/siswa/peminjaman_saya', $data);
    }

    public function ubahPassword()
    {
        if ($redirect = $this->checkSiswa()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        return $this->renderSiswaView('perpus/siswa/ubah_password', $data);
    }

    public function updatePassword()
    {
        if ($redirect = $this->checkSiswa()) return $redirect;

        $userModel = new \App\Models\UserModel();
        $userId = session()->get('user_id');
        $user = $userModel->find($userId);

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini salah!');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password baru tidak cocok!');
        }

        if (strlen($newPassword) < 5) {
            return redirect()->back()->with('error', 'Password baru minimal 5 karakter!');
        }

        $userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }
}
