<?php

namespace App\Models;

use CodeIgniter\Model;

class CardScanModel extends Model
{
    protected $table = 'card_scans';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'scan_time', 'status'];
    protected $useTimestamps = false;

    /**
     * Catat scan kartu baru
     */
    public function recordScan($userId)
    {
        return $this->insert([
            'user_id'   => $userId,
            'scan_time' => date('Y-m-d H:i:s'),
            'status'    => 'aktif'
        ]);
    }

    /**
     * Ambil aktivitas scan dengan detail user (nama, kelas)
     * @param int $limit Jumlah data yang ditampilkan
     * @return array
     */
    public function getScanActivity($limit = 20)
    {
        return $this->select('card_scans.*, users.nama_lengkap, users.kelas')
                    ->join('users', 'users.id = card_scans.user_id')
                    ->orderBy('card_scans.scan_time', 'DESC')
                    ->findAll($limit);
    }

    /**
     * Ambil aktivitas scan hari ini
     * @return array
     */
    public function getTodayScanActivity()
    {
        $today = date('Y-m-d');
        return $this->select('card_scans.*, users.nama_lengkap, users.kelas')
                    ->join('users', 'users.id = card_scans.user_id')
                    ->where('DATE(card_scans.scan_time)', $today)
                    ->orderBy('card_scans.scan_time', 'DESC')
                    ->findAll();
    }
}
