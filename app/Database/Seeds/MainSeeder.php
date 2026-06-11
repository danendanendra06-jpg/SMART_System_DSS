<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        echo "Menjalankan UserSeeder...\n";
        $this->seedUsers($db);
        
        echo "Menjalankan AlternatifSeeder...\n";
        $this->seedAlternatif($db);
        
        echo "Menjalankan BobotSeeder...\n";
        $this->seedBobot($db);
        
        echo "Menjalankan PenilaianSeeder...\n";
        $this->seedPenilaian($db);
        
        echo "Selesai!\n";
    }

    private function seedUsers($db)
    {
        $users = [
            'Anil', 'Falah Zahran', 'Bintang', 'Laura', 'Aurel', 
            'Vara', 'Aini Tri Apriyani', 'Muhamad Rifqi Alfareza', 
            'Muhammad Adib Arkan', 'Callysta', 'Pompom', // Termasuk Pompom
            'Hamza Deleon Wiradarma', 'Bestar', 'Fajar Fathurrachman', 
            'Kanaka', 'Ridhwan', 'Akhtar', 'Namira Assalwa', 
            'Langit', 'Hasan', 'Jull'
        ];

        $password = password_hash('user123', PASSWORD_DEFAULT);
        $builder = $db->table('users');

        foreach ($users as $u) {
            $email = strtolower(str_replace(' ', '', $u)) . '@spksmart.local';
            
            $cek = $builder->where('email', $email)->get()->getRow();
            if (!$cek) {
                $builder->insert([
                    'nama'     => $u,
                    'email'    => $email,
                    'password' => $password,
                    'role'     => 'user'
                ]);
            }
        }
    }

    private function seedAlternatif($db)
    {
        $alternatif = [
            'Ayam Katsu (Kantek)', 'Nasi Goreng (Bang Roni)', 'Sate (Kantek)', 
            'Soto Mie Rempah (Kantek)', 'Bakso Malang (Kantek)', 'Pawon Bu Ina (Kantek)', 
            'Nasi Kebuli (Kantek)', 'Ayam Katsu FC', 'Penyetan HK (Kawah)', 
            'Nasgor 962 (Kantek)', 'Nasi Bakarin (Kantek)', 'Mie Ayam FC Beji', 
            'Chicken Katsu (Kawah)', 'FC'
        ];

        $builder = $db->table('alternatif');
        
        // Asumsi admin user id = 1 untuk field created_by jika diperlukan
        $admin = $db->table('users')->where('role', 'admin')->get()->getRow();
        $id_admin = $admin ? $admin->id_user : 1;

        foreach ($alternatif as $a) {
            $cek = $builder->where('nama_alternatif', $a)->get()->getRow();
            if (!$cek) {
                $builder->insert([
                    'nama_alternatif' => $a,
                    'lokasi'          => '-',
                    'created_by'      => $id_admin
                ]);
            }
        }
    }

    private function seedBobot($db)
    {
        $kriteriaData = [
            ['id_kriteria' => 1, 'nama_kriteria' => 'Harga', 'jenis' => 'Cost'],
            ['id_kriteria' => 2, 'nama_kriteria' => 'Porsi', 'jenis' => 'Benefit'],
            ['id_kriteria' => 3, 'nama_kriteria' => 'Rasa', 'jenis' => 'Benefit'],
            ['id_kriteria' => 4, 'nama_kriteria' => 'Kebersihan', 'jenis' => 'Benefit'],
            ['id_kriteria' => 5, 'nama_kriteria' => 'Variasi Menu', 'jenis' => 'Benefit'],
            ['id_kriteria' => 6, 'nama_kriteria' => 'Kecepatan Pelayanan', 'jenis' => 'Benefit'],
        ];

        $builder = $db->table('kriteria');
        foreach ($kriteriaData as $kd) {
            $cek = $builder->where('id_kriteria', $kd['id_kriteria'])->get()->getRow();
            if ($cek) {
                $builder->where('id_kriteria', $kd['id_kriteria'])->update([
                    'nama_kriteria' => $kd['nama_kriteria'],
                    'jenis'         => $kd['jenis']
                ]);
            } else {
                $builder->insert([
                    'id_kriteria'   => $kd['id_kriteria'],
                    'nama_kriteria' => $kd['nama_kriteria'],
                    'jenis'         => $kd['jenis']
                ]);
            }
        }

        // Insert bobot into user_bobot_kriteria for all users
        $bobotData = [
            1 => 4, // Harga
            2 => 2, // Porsi
            3 => 1, // Rasa
            4 => 1, // Kebersihan
            5 => 1, // Variasi Menu
            6 => 1  // Kecepatan Pelayanan
        ];

        $users = $db->table('users')->get()->getResult();
        $ubBuilder = $db->table('user_bobot_kriteria');

        foreach ($users as $user) {
            foreach ($bobotData as $id_kriteria => $nilai) {
                $cek_ub = $ubBuilder->where('id_user', $user->id_user)
                                    ->where('id_kriteria', $id_kriteria)
                                    ->get()->getRow();
                if (!$cek_ub) {
                    $ubBuilder->insert([
                        'id_user' => $user->id_user,
                        'id_kriteria' => $id_kriteria,
                        'nilai_kepentingan' => $nilai
                    ]);
                }
            }
        }
    }

    private function seedPenilaian($db)
    {
        $penilaian = [
            ['Anil', 'Ayam Katsu (Kantek)', [1,3,3,2,4,4]],
            ['Falah Zahran', 'Nasi Goreng (Bang Roni)', [3,4,5,3,4,4]],
            ['Bintang', 'Sate (Kantek)', [3,3,4,3,3,3]],
            ['Laura', 'Soto Mie Rempah (Kantek)', [3,4,4,3,2,4]],
            ['Aurel', 'Bakso Malang (Kantek)', [3,3,4,4,2,5]],
            ['Vara', 'Ayam Katsu (Kantek)', [3,4,4,4,3,3]],
            ['Aini Tri Apriyani', 'Pawon Bu Ina (Kantek)', [2,2,4,3,3,3]],
            ['Muhamad Rifqi Alfareza', 'Nasi Kebuli (Kantek)', [3,3,3,3,3,3]],
            ['Muhammad Adib Arkan', 'Ayam Katsu FC', [4,4,3,3,4,4]],
            ['Callysta', 'Penyetan HK (Kawah)', [3,4,5,5,5,3]],
            ['Pompom', 'Nasgor 962 (Kantek)', [3,3,3,3,3,3]],
            ['Hamza Deleon Wiradarma', 'Nasi Bakarin (Kantek)', [3,4,4,3,3,3]],
            ['Bestar', 'Mie Ayam FC Beji', [3,3,3,2,2,3]],
            ['Fajar Fathurrachman', 'Nasgor 962 (Kantek)', [5,3,4,2,4,2]],
            ['Kanaka', 'Chicken Katsu (Kawah)', [3,3,4,3,3,4]],
            ['Ridhwan', 'Nasgor 962 (Kantek)', [2,3,3,2,4,2]],
            ['Akhtar', 'Nasi Kebuli (Kantek)', [3,3,3,4,2,3]],
            ['Namira Assalwa', 'Nasi Bakarin (Kantek)', [4,3,4,4,4,4]],
            ['Langit', 'FC', [3,3,4,2,4,2]],
            ['Hasan', 'Ayam Katsu (Kantek)', [3,3,3,3,4,4]],
            ['Jull', 'Nasgor 962 (Kantek)', [3,4,5,4,4,5]]
        ];

        $mapKriteria = [1, 2, 3, 4, 5, 6]; 
        
        $pBuilder = $db->table('penilaian');
        $dpBuilder = $db->table('detail_penilaian');

        // Fungsi konversi manual di Seeder agar konsisten dengan `mapSkalaToSmart` (1=20.. dst)
        // Note: berdasarkan perbaikan sebelumnya, 1 = 20
        $konversi = function($skala) {
            $map = [
                1 => 10, // Disesuaikan dengan controller Penilaian.php (1 = 10)
                2 => 20,
                3 => 60,
                4 => 80,
                5 => 100
            ];
            return $map[$skala] ?? 0;
        };

        foreach ($penilaian as $p) {
            $user = $db->table('users')->where('nama', $p[0])->get()->getRow();
            $alternatif = $db->table('alternatif')->where('nama_alternatif', $p[1])->get()->getRow();

            if ($user && $alternatif) {
                $cek_penilaian = $pBuilder->where('id_user', $user->id_user)
                                          ->where('id_alternatif', $alternatif->id_alternatif)
                                          ->get()->getRow();

                if (!$cek_penilaian) {
                    $pBuilder->insert([
                        'id_user' => $user->id_user,
                        'id_alternatif' => $alternatif->id_alternatif
                    ]);
                    
                    $id_penilaian = $db->insertID();

                    $detailData = [];
                    foreach ($p[2] as $index => $nilai_skala) {
                        $id_kriteria = $mapKriteria[$index];
                        
                        // JIKA COST (Harga = index 0 atau id_kriteria 1), BALIKKAN SKALANYA
                        if ($id_kriteria == 1) {
                            $nilai_skala = 6 - $nilai_skala;
                        }

                        // Convert nilai asli 1-5 menjadi 10-100 sebelum di-insert
                        $nilai_smart = $konversi($nilai_skala);
                        
                        $detailData[] = [
                            'id_penilaian' => $id_penilaian,
                            'id_kriteria'  => $id_kriteria,
                            'nilai'        => $nilai_smart
                        ];
                    }
                    $dpBuilder->insertBatch($detailData);
                }
            }
        }
    }
}
