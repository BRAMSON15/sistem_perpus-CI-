<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCardScansTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'scan_time' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif'],
                'default'    => 'aktif',
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('card_scans', true); // parameter true = IF NOT EXISTS
        
        // Mengatur default timestamp CURRENT_TIMESTAMP secara manual karena Forge CI4 
        // memerlukan query manual untuk default CURRENT_TIMESTAMP pada DATETIME
        $this->db->query('ALTER TABLE card_scans MODIFY scan_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down()
    {
        $this->forge->dropTable('card_scans', true);
    }
}
