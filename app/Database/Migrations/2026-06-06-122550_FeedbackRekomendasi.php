<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FeedbackRekomendasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_feedback' => [
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
            'nama_alternatif_rekomendasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'status_feedback' => [
                'type'       => 'ENUM',
                'constraint' => ['Setuju', 'Tidak Setuju'],
            ],
            'alasan' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_feedback', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('feedback_rekomendasi');
    }

    public function down()
    {
        $this->forge->dropTable('feedback_rekomendasi');
    }
}
