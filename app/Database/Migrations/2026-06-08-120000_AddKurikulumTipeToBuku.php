<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKurikulumTipeToBuku extends Migration
{
    public function up()
    {
        $this->forge->addColumn('buku', [
            'kurikulum_tipe' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'kategori',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('buku', 'kurikulum_tipe');
    }
}
