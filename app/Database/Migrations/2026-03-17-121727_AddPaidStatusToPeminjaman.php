<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaidStatusToPeminjaman extends Migration
{
    public function up()
    {
        $this->forge->addColumn('peminjaman', [
            'is_denda_lunas' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'denda'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('peminjaman', 'is_denda_lunas');
    }
}
