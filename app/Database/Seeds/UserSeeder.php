<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'siswa',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Siswa Demo',
                'kelas' => 'XII IPA 1',
                'email' => 'siswa@email.com',
                'user_type' => 'siswa',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Administrator',
                'kelas' => null,
                'email' => 'admin@email.com',
                'user_type' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
