<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode_buku' => 'BK001',
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun_terbit' => 2005,
                'kategori' => 'Fiksi',
                'stok' => 10,
                'tersedia' => 10,
                'gambar' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_buku' => 'BK002',
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'tahun_terbit' => 1980,
                'kategori' => 'Sejarah',
                'stok' => 8,
                'tersedia' => 8,
                'gambar' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_buku' => 'BK003',
                'judul' => 'Negeri 5 Menara',
                'pengarang' => 'Ahmad Fuadi',
                'penerbit' => 'Gramedia Pustaka Utama',
                'tahun_terbit' => 2009,
                'kategori' => 'Fiksi',
                'stok' => 12,
                'tersedia' => 12,
                'gambar' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_buku' => 'BK004',
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'tahun_terbit' => 2018,
                'kategori' => 'Non-Fiksi',
                'stok' => 15,
                'tersedia' => 15,
                'gambar' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kode_buku' => 'BK005',
                'judul' => 'Sapiens',
                'pengarang' => 'Yuval Noah Harari',
                'penerbit' => 'Pustaka Alvabet',
                'tahun_terbit' => 2014,
                'kategori' => 'Sains',
                'stok' => 7,
                'tersedia' => 7,
                'gambar' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('buku')->insertBatch($data);
    }
}
