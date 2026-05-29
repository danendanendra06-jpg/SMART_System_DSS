<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPenilaian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penilaian' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_kriteria' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai' => [
                'type'       => 'FLOAT',
            ],
        ]);
        $this->forge->addKey('id_detail', true);
        
        $this->forge->addForeignKey('id_penilaian', 'penilaian', 'id_penilaian', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria', 'kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('detail_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('detail_penilaian');
    }
}
