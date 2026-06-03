<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\AlternatifModel;
use App\Models\PenilaianModel;
use App\Models\DetailPenilaianModel;
use App\Models\HasilModel;
use App\Models\UserBobotKriteriaModel;
use App\Models\UserModel;

class Smart extends BaseController
{
    protected $kriteriaModel;
    protected $alternatifModel;
    protected $penilaianModel;
    protected $detailPenilaianModel;
    protected $hasilModel;
    protected $userBobotModel;
    protected $userModel;

    public function __construct()
    {
        $this->kriteriaModel = new KriteriaModel();
        $this->alternatifModel = new AlternatifModel();
        $this->penilaianModel = new PenilaianModel();
        $this->detailPenilaianModel = new DetailPenilaianModel();
        $this->hasilModel = new HasilModel();
        $this->userBobotModel = new UserBobotKriteriaModel();
        $this->userModel = new UserModel();
    }

    private function getActiveUserId()
    {
        if (session()->get('role') == 'admin') {
            $u = $this->request->getGet('u');
            if ($u) return $u;
            return 'global'; // Admin defaults to global
        }
        return session()->get('id_user');
    }

    private function getAllUsersForFilter()
    {
        if (session()->get('role') == 'admin') {
            return $this->userModel->where('role', 'user')->findAll();
        }
        return [];
    }

    private function getUserBobot($id_user)
    {
        $kriteria = $this->kriteriaModel->findAll();
        
        // If global, we get average bobot, otherwise specific user
        $bobotMap = [];
        if ($id_user === 'global') {
            $db = \Config\Database::connect();
            $bobotQuery = $db->table('user_bobot_kriteria')
                             ->select('id_kriteria, AVG(nilai_kepentingan) as avg_bobot')
                             ->groupBy('id_kriteria')
                             ->get()->getResultArray();
            foreach ($bobotQuery as $bq) {
                $bobotMap[$bq['id_kriteria']] = (float) $bq['avg_bobot'];
            }
        } else if ($id_user) {
            $userBobot = $this->userBobotModel->where('id_user', $id_user)->findAll();
            foreach($userBobot as $ub) {
                $bobotMap[$ub['id_kriteria']] = $ub['nilai_kepentingan'];
            }
        }

        foreach ($kriteria as &$k) {
            $k['bobot'] = $bobotMap[$k['id_kriteria']] ?? 0;
        }

        return $kriteria;
    }

    public function kriteria()
    {
        if (session()->get('role') != 'admin') return redirect()->to(base_url('home'));

        $data = [
            'title'    => 'Kriteria Master | SPK SMART',
            'kriteria' => $this->kriteriaModel->findAll()
        ];
        return view('smart/kriteria', $data);
    }

    public function penilaian()
    {
        if (session()->get('role') != 'admin') return redirect()->to(base_url('home'));
        $id_user = $this->getActiveUserId();
        $db = \Config\Database::connect();
        $kriteria = $this->kriteriaModel->findAll();

        if ($id_user === 'global') {
            // Rata-rata Penilaian Global
            $rataQuery = $db->table('detail_penilaian')
                            ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, AVG(detail_penilaian.nilai) as rata_nilai')
                            ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                            ->groupBy('penilaian.id_alternatif, detail_penilaian.id_kriteria')
                            ->get()->getResultArray();

            $matrixAvg = [];
            foreach ($rataQuery as $r) {
                $matrixAvg[$r['id_alternatif']][$r['id_kriteria']] = (float) $r['rata_nilai'];
            }

            // Fake data structure for the view
            $alternatifDb = $this->alternatifModel->findAll();
            $penilaian = [];
            $nilaiMatrix = [];
            
            foreach ($alternatifDb as $a) {
                if (isset($matrixAvg[$a['id_alternatif']])) {
                    $pid = 'global_'.$a['id_alternatif'];
                    $penilaian[] = [
                        'id_penilaian' => $pid,
                        'id_alternatif'=> $a['id_alternatif'],
                        'nama_alternatif'=> $a['nama_alternatif']
                    ];
                    foreach ($kriteria as $k) {
                        $nilaiMatrix[$pid][$k['id_kriteria']] = isset($matrixAvg[$a['id_alternatif']][$k['id_kriteria']]) ? number_format($matrixAvg[$a['id_alternatif']][$k['id_kriteria']], 2) : '-';
                    }
                }
            }

            $targetUser = ['nama' => 'Seluruh User (Agregasi Global)'];
        } else {
            $builder = $db->table('penilaian')
                          ->select('penilaian.*, alternatif.nama_alternatif')
                          ->join('alternatif', 'alternatif.id_alternatif = penilaian.id_alternatif')
                          ->where('penilaian.id_user', $id_user)
                          ->orderBy('alternatif.id_alternatif', 'ASC');

            $penilaian = $builder->get()->getResultArray();
            $nilaiMatrix = [];
            $details = $this->detailPenilaianModel->findAll();
            foreach($details as $d) {
                $nilaiMatrix[$d['id_penilaian']][$d['id_kriteria']] = $d['nilai'];
            }
            $targetUser = $this->userModel->find($id_user);
        }

        $data = [
            'title'      => 'Data Penilaian Tersimpan | SPK SMART',
            'penilaian'  => $penilaian,
            'kriteria'   => $kriteria,
            'nilaiMatrix'=> $nilaiMatrix,
            'targetUser' => $targetUser,
            'activeUser' => $id_user,
            'allUsers'   => $this->getAllUsersForFilter()
        ];
        return view('smart/penilaian_smart', $data);
    }

    public function rata_rata()
    {
        if (session()->get('role') != 'admin') return redirect()->to(base_url('home'));
        $id_user = $this->getActiveUserId();
        $db = \Config\Database::connect();
        
        if ($id_user === 'global') {
            $rataQuery = $db->table('detail_penilaian')
                            ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, AVG(detail_penilaian.nilai) as rata_nilai')
                            ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                            ->groupBy('penilaian.id_alternatif, detail_penilaian.id_kriteria')
                            ->get()->getResultArray();
            $targetUser = ['nama' => 'Seluruh User (Agregasi Global)'];
        } else {
            $rataQuery = $db->table('detail_penilaian')
                            ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, detail_penilaian.nilai as rata_nilai')
                            ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                            ->where('penilaian.id_user', $id_user)
                            ->get()->getResultArray();
            $targetUser = $this->userModel->find($id_user);
        }

        $matrix = [];
        foreach ($rataQuery as $r) {
            $matrix[$r['id_alternatif']][$r['id_kriteria']] = (float) $r['rata_nilai'];
        }

        $alternatif = $this->alternatifModel->findAll();
        $kriteria = $this->kriteriaModel->findAll();
        
        $data = [
            'title'      => 'Nilai Rata-rata/Konversi | SPK SMART',
            'alternatif' => $alternatif,
            'kriteria'   => $kriteria,
            'matrix'     => $matrix,
            'targetUser' => $targetUser,
            'activeUser' => $id_user,
            'allUsers'   => $this->getAllUsersForFilter()
        ];
        return view('smart/rata_rata', $data);
    }

    public function normalisasi()
    {
        if (session()->get('role') != 'admin') return redirect()->to(base_url('home'));
        $id_user = $this->getActiveUserId();
        $kriteria = $this->getUserBobot($id_user);

        $totalBobot = 0;
        foreach ($kriteria as $k) {
            $totalBobot += $k['bobot'];
        }

        if ($totalBobot == 0 && session()->get('role') == 'user') {
            session()->setFlashdata('error', 'Anda belum mengatur bobot preferensi kriteria. Silakan atur bobot terlebih dahulu.');
            return redirect()->to(base_url('userbobot'));
        }

        $normalisasi = [];
        foreach ($kriteria as $k) {
            $norm = $totalBobot > 0 ? $k['bobot'] / $totalBobot : 0;
            $normalisasi[] = [
                'id_kriteria'   => $k['id_kriteria'],
                'nama_kriteria' => $k['nama_kriteria'],
                'bobot'         => $id_user === 'global' ? number_format($k['bobot'], 2) : $k['bobot'],
                'normalisasi'   => $norm
            ];
        }

        $targetUser = $id_user === 'global' ? ['nama' => 'Seluruh User (Agregasi Global)'] : $this->userModel->find($id_user);

        $data = [
            'title'       => 'Normalisasi Bobot Preference | SPK SMART',
            'totalBobot'  => $id_user === 'global' ? number_format($totalBobot, 2) : $totalBobot,
            'normalisasi' => $normalisasi,
            'targetUser'  => $targetUser,
            'activeUser'  => $id_user,
            'allUsers'    => $this->getAllUsersForFilter()
        ];
        return view('smart/normalisasi', $data);
    }

    public function utility()
    {
        if (session()->get('role') != 'admin') return redirect()->to(base_url('home'));
        $id_user = $this->getActiveUserId();
        $utilityData = $this->getUtilityData($id_user);

        $targetUser = $id_user === 'global' ? ['nama' => 'Seluruh User (Agregasi Global)'] : $this->userModel->find($id_user);

        $data = [
            'title'      => 'Nilai Utility | SPK SMART',
            'alternatif' => $utilityData['alternatif'],
            'kriteria'   => $utilityData['kriteria'],
            'cMax'       => $utilityData['cMax'],
            'cMin'       => $utilityData['cMin'],
            'utility'    => $utilityData['utility'],
            'targetUser' => $targetUser,
            'activeUser' => $id_user,
            'allUsers'   => $this->getAllUsersForFilter()
        ];
        return view('smart/utility', $data);
    }

    public function nilai_akhir()
    {
        if (session()->get('role') != 'admin') return redirect()->to(base_url('home'));
        $id_user = $this->getActiveUserId();
        $utilityData = $this->getUtilityData($id_user);
        $utility = $utilityData['utility'];
        $alternatif = $utilityData['alternatif'];
        
        $kriteria = $this->getUserBobot($id_user);
        
        $totalBobot = 0;
        foreach ($kriteria as $k) {
            $totalBobot += $k['bobot'];
        }
        
        if ($totalBobot == 0 && session()->get('role') == 'user') {
            return redirect()->to(base_url('userbobot'))->with('error', 'Silakan atur bobot Anda terlebih dahulu.');
        }

        $normBobot = [];
        foreach ($kriteria as $k) {
            $normBobot[$k['id_kriteria']] = $totalBobot > 0 ? $k['bobot'] / $totalBobot : 0;
        }

        $nilaiAkhir = [];
        foreach ($alternatif as $a) {
            $id_a = $a['id_alternatif'];
            $total = 0;
            foreach ($kriteria as $k) {
                $id_k = $k['id_kriteria'];
                $u = $utility[$id_a][$id_k] ?? 0;
                $w = $normBobot[$id_k];
                $total += ($u * $w);
            }
            $nilaiAkhir[$id_a] = $total;
        }

        // Only save to DB if it's a specific user (don't save global to hasil table to avoid breaking ranking)
        if ($id_user !== 'global') {
            $this->hasilModel->where('id_user', $id_user)->delete();

            $rankingData = [];
            foreach ($alternatif as $a) {
                if(isset($nilaiAkhir[$a['id_alternatif']])) {
                    $rankingData[] = [
                        'id_alternatif' => $a['id_alternatif'],
                        'nilai_akhir'   => $nilaiAkhir[$a['id_alternatif']],
                        'nama_alternatif' => $a['nama_alternatif']
                    ];
                }
            }

            usort($rankingData, function($a, $b) {
                return $b['nilai_akhir'] <=> $a['nilai_akhir'];
            });

            $rank = 1;
            $insertData = [];
            foreach ($rankingData as $row) {
                $insertData[] = [
                    'id_user'       => $id_user,
                    'id_alternatif' => $row['id_alternatif'],
                    'nilai_akhir'   => $row['nilai_akhir'],
                    'ranking'       => $rank
                ];
                $rank++;
            }
            if(!empty($insertData)){
                $this->hasilModel->insertBatch($insertData);
            }
        }

        $targetUser = $id_user === 'global' ? ['nama' => 'Seluruh User (Agregasi Global)'] : $this->userModel->find($id_user);

        $data = [
            'title'      => 'Nilai Akhir SMART | SPK SMART',
            'alternatif' => $alternatif,
            'kriteria'   => $kriteria,
            'utility'    => $utility,
            'normBobot'  => $normBobot,
            'nilaiAkhir' => $nilaiAkhir,
            'targetUser' => $targetUser,
            'activeUser' => $id_user,
            'allUsers'   => $this->getAllUsersForFilter()
        ];
        return view('smart/nilai_akhir', $data);
    }

    public function ranking()
    {
        $id_user = $this->getActiveUserId();
        
        $utilityData = $this->getUtilityData($id_user);
        $utility = $utilityData['utility'];
        $alternatif = $utilityData['alternatif'];
        
        $kriteria = $this->getUserBobot($id_user);
        $totalBobot = 0;
        foreach ($kriteria as $k) { $totalBobot += $k['bobot']; }
        
        if ($totalBobot == 0 && session()->get('role') == 'user') {
            return redirect()->to(base_url('userbobot'))->with('error', 'Silakan atur bobot Anda terlebih dahulu sebelum melihat hasil ranking.');
        }

        $normBobot = [];
        foreach ($kriteria as $k) {
            $normBobot[$k['id_kriteria']] = $totalBobot > 0 ? $k['bobot'] / $totalBobot : 0;
        }

        $nilaiAkhir = [];
        foreach ($alternatif as $a) {
            $id_a = $a['id_alternatif'];
            $total = 0;
            foreach ($kriteria as $k) {
                $id_k = $k['id_kriteria'];
                $u = $utility[$id_a][$id_k] ?? 0;
                $w = $normBobot[$id_k];
                $total += ($u * $w);
            }
            $nilaiAkhir[$id_a] = $total;
        }

        $rankingArray = [];
        foreach ($alternatif as $a) {
            if(isset($nilaiAkhir[$a['id_alternatif']])) {
                $rankingArray[] = [
                    'id_alternatif'   => $a['id_alternatif'],
                    'nama_alternatif' => $a['nama_alternatif'],
                    'lokasi'          => $a['lokasi'],
                    'nilai_akhir'     => $nilaiAkhir[$a['id_alternatif']]
                ];
            }
        }

        usort($rankingArray, function($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        $rank = 1;
        foreach ($rankingArray as &$r) {
            $r['ranking'] = $rank++;
        }

        $targetUser = $id_user === 'global' ? ['nama' => 'Seluruh User (Agregasi Global)'] : $this->userModel->find($id_user);

        $data = [
            'title'      => 'Ranking Tempat Makan | SPK SMART',
            'ranking'    => $rankingArray,
            'targetUser' => $targetUser,
            'activeUser' => $id_user,
            'allUsers'   => $this->getAllUsersForFilter()
        ];
        return view('smart/ranking', $data);
    }

    private function getUtilityData($id_user)
    {
        $db = \Config\Database::connect();
        if ($id_user === 'global') {
            $rataQuery = $db->table('detail_penilaian')
                            ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, AVG(detail_penilaian.nilai) as rata_nilai')
                            ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                            ->groupBy('penilaian.id_alternatif, detail_penilaian.id_kriteria')
                            ->get()->getResultArray();
        } else {
            $rataQuery = $db->table('detail_penilaian')
                            ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, detail_penilaian.nilai as rata_nilai')
                            ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                            ->where('penilaian.id_user', $id_user)
                            ->get()->getResultArray();
        }

        $matrix = [];
        foreach ($rataQuery as $r) {
            $matrix[$r['id_alternatif']][$r['id_kriteria']] = (float) $r['rata_nilai'];
        }

        $alternatif = $this->alternatifModel->findAll();
        $kriteria = $this->kriteriaModel->findAll();

        $cMax = [];
        $cMin = [];
        foreach ($kriteria as $k) {
            $id_k = $k['id_kriteria'];
            $cMax[$id_k] = 0;
            $cMin[$id_k] = 0;
            $hasValues = false;
            
            foreach ($alternatif as $a) {
                $id_a = $a['id_alternatif'];
                if (isset($matrix[$id_a][$id_k])) {
                    $val = $matrix[$id_a][$id_k];
                    if (!$hasValues) {
                        $cMax[$id_k] = $val;
                        $cMin[$id_k] = $val;
                        $hasValues = true;
                    } else {
                        if ($val > $cMax[$id_k]) $cMax[$id_k] = $val;
                        if ($val < $cMin[$id_k]) $cMin[$id_k] = $val;
                    }
                }
            }
        }

        $utility = [];
        foreach ($alternatif as $a) {
            $id_a = $a['id_alternatif'];
            foreach ($kriteria as $k) {
                $id_k = $k['id_kriteria'];
                $val = $matrix[$id_a][$id_k] ?? 0;
                $max = $cMax[$id_k];
                $min = $cMin[$id_k];
                $jenis = $k['jenis'];
                $u = 0;
                if ($max - $min != 0) {
                    if ($jenis == 'Benefit') $u = ($val - $min) / ($max - $min);
                    else $u = ($max - $val) / ($max - $min);
                }
                $utility[$id_a][$id_k] = $u;
            }
        }

        return [
            'utility'    => $utility,
            'alternatif' => $alternatif,
            'kriteria'   => $kriteria,
            'cMax'       => $cMax,
            'cMin'       => $cMin
        ];
    }
}
