<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'kategori', 'stok', 'tersedia', 'gambar'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
