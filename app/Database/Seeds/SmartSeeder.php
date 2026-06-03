<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SmartSeeder extends Seeder
{
    public function run()
    {
        // 1. Users
        $usersData = [
            [
                'nama'       => 'Administrator',
                'email'      => 'admin@gmail.com',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Mahasiswa Budi',
                'email'      => 'user@gmail.com',
                'password'   => password_hash('user123', PASSWORD_BCRYPT),
                'role'       => 'user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($usersData);

        // 2. Kriteria
        $kriteriaData = [
            ['nama_kriteria' => 'Harga (Cost)', 'jenis' => 'Cost', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kriteria' => 'Porsi (Benefit)', 'jenis' => 'Benefit', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kriteria' => 'Rasa Makanan (Benefit)', 'jenis' => 'Benefit', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kriteria' => 'Kebersihan (Benefit)', 'jenis' => 'Benefit', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kriteria' => 'Variasi Menu (Benefit)', 'jenis' => 'Benefit', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_kriteria' => 'Waktu Pelayanan (Benefit)', 'jenis' => 'Benefit', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('kriteria')->insertBatch($kriteriaData);

        // 3. User Bobot Kriteria (Default untuk User 2, skala 1-5)
        $bobotData = [
            ['id_user' => 2, 'id_kriteria' => 1, 'nilai_kepentingan' => 5], // Harga -> Sangat Penting
            ['id_user' => 2, 'id_kriteria' => 2, 'nilai_kepentingan' => 4], // Porsi -> Penting
            ['id_user' => 2, 'id_kriteria' => 3, 'nilai_kepentingan' => 5], // Rasa -> Sangat Penting
            ['id_user' => 2, 'id_kriteria' => 4, 'nilai_kepentingan' => 4], // Kebersihan -> Penting
            ['id_user' => 2, 'id_kriteria' => 5, 'nilai_kepentingan' => 3], // Jarak -> Cukup
            ['id_user' => 2, 'id_kriteria' => 6, 'nilai_kepentingan' => 3], // Fasilitas -> Cukup(Pelayanan)
        ];
        $this->db->table('user_bobot_kriteria')->insertBatch($bobotData);

        // 4. Alternatif Awal
        $alternatifData = [
            ['nama_alternatif' => 'Nasgor 962', 'lokasi' => 'Pondok Cina', 'created_by' => 2, 'created_at' => date('Y-m-d H:i:s')],
            ['nama_alternatif' => 'Warteg Bahari', 'lokasi' => 'Kukusan', 'created_by' => 2, 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('alternatif')->insertBatch($alternatifData);

        // 5. Penilaian Awal oleh User 2
        $penilaianData = [
            ['id_user' => 2, 'id_alternatif' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['id_user' => 2, 'id_alternatif' => 2, 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('penilaian')->insertBatch($penilaianData);

        // 6. Detail Penilaian (konversi SMART 10-100)
        // Nasgor 962 (id_penilaian 1)
        $detailData = [
            ['id_penilaian' => 1, 'id_kriteria' => 1, 'nilai' => 80], // 4 = Murah
            ['id_penilaian' => 1, 'id_kriteria' => 2, 'nilai' => 80], // 4 = Banyak
            ['id_penilaian' => 1, 'id_kriteria' => 3, 'nilai' => 100], // 5 = Sangat Enak
            ['id_penilaian' => 1, 'id_kriteria' => 4, 'nilai' => 60], // 3 = Standar
            ['id_penilaian' => 1, 'id_kriteria' => 5, 'nilai' => 80], // 4 = Banyak
            ['id_penilaian' => 1, 'id_kriteria' => 6, 'nilai' => 80], // 4 = Cepat
            
            // Warteg Bahari (id_penilaian 2)
            ['id_penilaian' => 2, 'id_kriteria' => 1, 'nilai' => 100], // 5 = Sangat Murah
            ['id_penilaian' => 2, 'id_kriteria' => 2, 'nilai' => 100], // 5 = Melimpah
            ['id_penilaian' => 2, 'id_kriteria' => 3, 'nilai' => 60], // 3 = Cukup
            ['id_penilaian' => 2, 'id_kriteria' => 4, 'nilai' => 60], // 3 = Standar
            ['id_penilaian' => 2, 'id_kriteria' => 5, 'nilai' => 100], // 5 = Sangat Banyak
            ['id_penilaian' => 2, 'id_kriteria' => 6, 'nilai' => 100], // 5 = Sangat Cepat
        ];
        $this->db->table('detail_penilaian')->insertBatch($detailData);
    }
}
