<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserBobotKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bobot' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_kriteria' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai_kepentingan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 1,
            ],
        ]);
        $this->forge->addKey('id_bobot', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria', 'kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('user_bobot_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('user_bobot_kriteria');
    }
}
