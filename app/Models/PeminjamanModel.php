<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'buku_id', 'tanggal_pinjam', 'tanggal_kembali', 'tanggal_dikembalikan', 'status', 'denda', 'is_denda_lunas'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPeminjamanWithDetails($userId = null, $keyword = null)
    {
        $builder = $this->db->table('peminjaman')
            ->select('peminjaman.*, buku.judul, buku.pengarang, users.nama_lengkap, users.username')
            ->join('buku', 'buku.id = peminjaman.buku_id')
            ->join('users', 'users.id = peminjaman.user_id');
        
        if ($userId) {
            $builder->where('peminjaman.user_id', $userId);
        }

        if ($keyword) {
            $builder->groupStart()
                ->like('users.nama_lengkap', $keyword)
                ->orLike('users.username', $keyword)
                ->orLike('buku.judul', $keyword)
                ->orLike('peminjaman.status', $keyword)
            ->groupEnd();
        }
        
        return $builder->orderBy('peminjaman.created_at', 'DESC')->get()->getResultArray();
    }

    public function getLaporanPeminjaman($startDate = null, $endDate = null)
    {
        $builder = $this->db->table('peminjaman')
            ->select('peminjaman.*, buku.judul, users.nama_lengkap, users.kelas')
            ->join('buku', 'buku.id = peminjaman.buku_id')
            ->join('users', 'users.id = peminjaman.user_id');

        if ($startDate && $endDate) {
            $builder->where('peminjaman.tanggal_pinjam >=', $startDate)
                    ->where('peminjaman.tanggal_pinjam <=', $endDate);
        }

        return $builder->orderBy('peminjaman.tanggal_pinjam', 'DESC')->get()->getResultArray();
    }
}
