<?php
namespace App\Controllers;
use App\Models\BukuModel;
use App\Models\PeminjamanModel;
use App\Models\UserModel;
use App\Models\NotificationModel;

class Admin extends BaseController
{
    protected $bukuModel;
    protected $peminjamanModel;
    protected $userModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->peminjamanModel = new PeminjamanModel();
        $this->userModel = new UserModel();
        $this->notificationModel = new NotificationModel();
    }

    private function renderAdminView($view, $data = [])
    {
        $data = array_merge($data, $this->getNotificationData());
        return view($view, $data);
    }

    private function checkAdmin()
    {
        if (!session()->get('logged_in') || session()->get('user_type') !== 'admin') {
            return redirect()->to(base_url('perpus/login-admin'));
        }
        return null;
    }

    public function kelolaBuku()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        $data['buku'] = $this->bukuModel->findAll();
        return $this->renderAdminView('perpus/admin/kelola_buku', $data);
    }

    public function tambahBuku()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        return $this->renderAdminView('perpus/admin/tambah_buku', $data);
    }

    public function simpanBuku()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data = [
            'kode_buku' => $this->request->getPost('kode_buku'),
            'judul' => $this->request->getPost('judul'),
            'pengarang' => $this->request->getPost('pengarang'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'kategori' => $this->request->getPost('kategori'),
            'stok' => $this->request->getPost('stok'),
            'tersedia' => $this->request->getPost('stok'),
        ];

        // Handle upload gambar
        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $namaGambar = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/buku', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $this->bukuModel->save($data);

        // Notify all students about the new book
        $students = $this->userModel->where('user_type', 'siswa')->findAll();
        foreach ($students as $student) {
            $this->notificationModel->save([
                'user_id' => $student['id'],
                'title'   => 'Buku Baru Tersedia!',
                'message' => 'Buku "' . $data['judul'] . '" baru saja ditambahkan ke koleksi. Yuk, buruan pinjam!',
                'type'    => 'info'
            ]);
        }

        return redirect()->to(base_url('perpus/kelola-buku'))->with('success', 'Buku berhasil ditambahkan!');
    }

    public function editBuku($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        $data['buku'] = $this->bukuModel->find($id);
        return $this->renderAdminView('perpus/admin/edit_buku', $data);
    }

    public function updateBuku($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data = [
            'kode_buku' => $this->request->getPost('kode_buku'),
            'judul' => $this->request->getPost('judul'),
            'pengarang' => $this->request->getPost('pengarang'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'kategori' => $this->request->getPost('kategori'),
            'stok' => $this->request->getPost('stok'),
        ];

        // Handle upload gambar
        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama jika ada
            $bukuLama = $this->bukuModel->find($id);
            if ($bukuLama['gambar'] && file_exists(FCPATH . 'uploads/buku/' . $bukuLama['gambar'])) {
                unlink(FCPATH . 'uploads/buku/' . $bukuLama['gambar']);
            }

            $namaGambar = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/buku', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $this->bukuModel->update($id, $data);
        return redirect()->to(base_url('perpus/kelola-buku'))->with('success', 'Buku berhasil diupdate!');
    }

    public function hapusBuku($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        // Hapus gambar jika ada
        $buku = $this->bukuModel->find($id);
        if ($buku['gambar'] && file_exists(FCPATH . 'uploads/buku/' . $buku['gambar'])) {
            unlink(FCPATH . 'uploads/buku/' . $buku['gambar']);
        }

        $this->bukuModel->delete($id);
        return redirect()->to(base_url('perpus/kelola-buku'))->with('success', 'Buku berhasil dihapus!');
    }

    public function kelolaPeminjaman()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $keyword = $this->request->getGet('keyword');
        $peminjaman_raw = $this->peminjamanModel->getPeminjamanWithDetails(null, $keyword);
        $sekarang = date('Y-m-d');

        $denda_per_hari = 1000;

        // Dynamically update status and calculate pending fines
        $peminjaman = array_map(function($p) use ($sekarang, $denda_per_hari) {
            if ($p['status'] == 'dipinjam' && $sekarang > $p['tanggal_kembali']) {
                $p['status'] = 'terlambat';
                
                // Calculate pending fine for display
                $tanggal_kembali = new \DateTime($p['tanggal_kembali']);
                $tanggal_sekarang = new \DateTime($sekarang);
                $diff = $tanggal_sekarang->diff($tanggal_kembali);
                $p['denda'] = $diff->days * $denda_per_hari;
            }
            return $p;
        }, $peminjaman_raw);

        $data = [
            'username' => session()->get('nama_lengkap') ?: session()->get('username'),
            'peminjaman' => $peminjaman,
            'keyword' => $keyword
        ];

        return $this->renderAdminView('perpus/admin/kelola_peminjaman', $data);
    }

    public function prosesPengembalian($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $peminjaman = $this->peminjamanModel->find($id);
        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan!');
        }

        $buku = $this->bukuModel->find($peminjaman['buku_id']);
        
        $tanggal_kembali = new \DateTime($peminjaman['tanggal_kembali']);
        $tanggal_sekarang = new \DateTime(date('Y-m-d'));
        $denda = 0;
        $denda_per_hari = 1000; // Harga denda per hari keterlambatan

        if ($tanggal_sekarang > $tanggal_kembali) {
            $diff = $tanggal_sekarang->diff($tanggal_kembali);
            $hari_terlambat = $diff->days;
            $denda = $hari_terlambat * $denda_per_hari;
        }

        // Update peminjaman
        $this->peminjamanModel->update($id, [
            'tanggal_dikembalikan' => date('Y-m-d'),
            'status' => 'dikembalikan',
            'denda' => $denda
        ]);

        // Notify student about return and fine
        $title = $denda > 0 ? 'Pengembalian & Denda' : 'Buku Dikembalikan';
        $message = 'Buku "' . $buku['judul'] . '" telah dikembalikan.';
        if ($denda > 0) {
            $message .= ' Anda dikenakan denda keterlambatan sebesar Rp ' . number_format($denda, 0, ',', '.') . '.';
        } else {
            $message .= ' Terima kasih telah mengembalikan tepat waktu!';
        }

        $this->notificationModel->save([
            'user_id' => $peminjaman['user_id'],
            'title'   => $title,
            'message' => $message,
            'type'    => $denda > 0 ? 'warning' : 'success'
        ]);

        // Notify Admins about return
        $admins = $this->userModel->where('user_type', 'admin')->findAll();
        foreach ($admins as $admin) {
            $this->notificationModel->save([
                'user_id' => $admin['id'],
                'title'   => 'Buku Dikembalikan',
                'message' => 'Siswa ' . ($peminjaman['nama_lengkap'] ?? 'User ID:'.$peminjaman['user_id']) . ' telah mengembalikan buku "' . $buku['judul'] . '".' . ($denda > 0 ? ' Denda dibayar: Rp ' . number_format($denda, 0, ',', '.') : ''),
                'type'    => 'success'
            ]);
        }

        // Update stok buku
        $this->bukuModel->update($peminjaman['buku_id'], [
            'tersedia' => $buku['tersedia'] + 1
        ]);

        $pesan = ($denda > 0) 
            ? "Buku berhasil dikembalikan! Denda keterlambatan: Rp " . number_format($denda, 0, ',', '.')
            : "Buku berhasil dikembalikan tepat waktu!";

        return redirect()->to(base_url('perpus/kelola-peminjaman'))->with('success', $pesan);
    }

    public function kelolaUser()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $keyword = $this->request->getGet('keyword');
        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        
        if ($keyword) {
            $data['users'] = $this->userModel->where('user_type', 'siswa')
                ->groupStart()
                    ->like('username', $keyword)
                    ->orLike('nama_lengkap', $keyword)
                    ->orLike('kelas', $keyword)
                    ->orLike('email', $keyword)
                ->groupEnd()
                ->findAll();
        } else {
            $data['users'] = $this->userModel->where('user_type', 'siswa')->findAll();
        }

        $data['keyword'] = $keyword;
        return $this->renderAdminView('perpus/admin/kelola_user', $data);
    }

    public function tambahUser()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        return $this->renderAdminView('perpus/admin/tambah_user', $data);
    }

    public function simpanUser()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'kelas' => $this->request->getPost('kelas'),
            'email' => $this->request->getPost('email'),
            'user_type' => 'siswa'
        ];

        $this->userModel->save($data);
        return redirect()->to(base_url('perpus/kelola-user'))->with('success', 'User berhasil ditambahkan!');
    }

    public function hapusUser($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $this->userModel->delete($id);
        return redirect()->to(base_url('perpus/kelola-user'))->with('success', 'User berhasil dihapus!');
    }

    public function editUser($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        $data['user'] = $this->userModel->find($id);
        return $this->renderAdminView('perpus/admin/edit_user', $data);
    }

    public function updateUser($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $data = [
            'username' => $this->request->getPost('username'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'kelas' => $this->request->getPost('kelas'),
            'email' => $this->request->getPost('email'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        return redirect()->to(base_url('perpus/kelola-user'))->with('success', 'User berhasil diupdate!');
    }

    public function prosesPembayaranDenda($id)
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $peminjaman = $this->peminjamanModel->find($id);
        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $this->peminjamanModel->update($id, ['is_denda_lunas' => 1]);

        // Notify student
        $buku = $this->bukuModel->find($peminjaman['buku_id']);
        $notificationModel = new \App\Models\NotificationModel();
        $notificationModel->save([
            'user_id' => $peminjaman['user_id'],
            'title' => 'Denda Dibayar',
            'message' => 'Denda sebesar Rp ' . number_format($peminjaman['denda'], 0, ',', '.') . ' untuk buku "' . ($buku['judul'] ?? 'Buku') . '" telah dinyatakan LUNAS. Terima kasih!',
            'type' => 'success',
            'is_read' => 0
        ]);

        return redirect()->to(base_url('perpus/kelola-peminjaman'))->with('success', 'Denda berhasil ditandai Lunas!');
    }

    public function kelolaLaporan()
    {
        if ($redirect = $this->checkAdmin()) return $redirect;

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // default to this month if not set
        if (!$startDate) $startDate = date('Y-m-01');
        if (!$endDate) $endDate = date('Y-m-t');

        $data['username'] = session()->get('nama_lengkap') ?: session()->get('username');
        
        // 1. Statistik Pengguna Aktif (Login dalam 30 hari terakhir)
        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        $data['user_aktif'] = $this->userModel->where('last_login >=', $thirtyDaysAgo)
                                             ->where('user_type', 'siswa')
                                             ->countAllResults();
        $data['total_siswa'] = $this->userModel->where('user_type', 'siswa')->countAllResults();

        // 2. Laporan Aktivitas Peminjaman
        $laporan_raw = $this->peminjamanModel->getLaporanPeminjaman($startDate, $endDate);
        $sekarang = date('Y-m-d');
        $denda_per_hari = 1000;

        $data['laporan_peminjaman'] = array_map(function($p) use ($sekarang, $denda_per_hari) {
            if ($p['status'] == 'dipinjam' && $sekarang > $p['tanggal_kembali']) {
                $p['status'] = 'terlambat';
                $tanggal_kembali = new \DateTime($p['tanggal_kembali']);
                $tanggal_sekarang = new \DateTime($sekarang);
                $diff = $tanggal_sekarang->diff($tanggal_kembali);
                $p['denda'] = $diff->days * $denda_per_hari;
            }
            return $p;
        }, $laporan_raw);

        // 3. Statistik Denda
        $data['denda_lunas'] = $this->peminjamanModel->where('is_denda_lunas', 1)
                                                     ->where('tanggal_pinjam >=', $startDate)
                                                     ->where('tanggal_pinjam <=', $endDate)
                                                     ->selectSum('denda')
                                                     ->get()->getRow()->denda ?? 0;
        
        $data['denda_pending'] = $this->peminjamanModel->where('is_denda_lunas', 0)
                                                       ->where('tanggal_pinjam >=', $startDate)
                                                       ->where('tanggal_pinjam <=', $endDate)
                                                       ->selectSum('denda')
                                                       ->get()->getRow()->denda ?? 0;

        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        return $this->renderAdminView('perpus/admin/kelola_laporan', $data);
    }
}
