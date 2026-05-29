<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SmartSeeder extends Seeder
{
    public function run()
    {
        // 1. Kriteria
        // Pastikan id_kriteria berurutan dari 1 sampai 6 untuk kemudahan pemetaan array
        $kriteriaData = [
            ['nama_kriteria' => 'Harga (Cost)', 'bobot' => 30, 'jenis' => 'Cost'],
            ['nama_kriteria' => 'Porsi (Benefit)', 'bobot' => 20, 'jenis' => 'Benefit'],
            ['nama_kriteria' => 'Rasa Makanan (Benefit)', 'bobot' => 20, 'jenis' => 'Benefit'],
            ['nama_kriteria' => 'Kebersihan (Benefit)', 'bobot' => 10, 'jenis' => 'Benefit'],
            ['nama_kriteria' => 'Variasi Menu (Benefit)', 'bobot' => 10, 'jenis' => 'Benefit'],
            ['nama_kriteria' => 'Waktu Pelayanan (Benefit)', 'bobot' => 10, 'jenis' => 'Benefit'],
        ];
        $this->db->table('kriteria')->insertBatch($kriteriaData);
    }
}
