<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kriteria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kriteria' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'bobot' => [
                'type'       => 'FLOAT',
            ],
            'jenis' => [
                'type'       => 'ENUM',
                'constraint' => ['Benefit', 'Cost'],
                'default'    => 'Benefit',
            ],
        ]);
        $this->forge->addKey('id_kriteria', true);
        $this->forge->createTable('kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('kriteria');
    }
}
