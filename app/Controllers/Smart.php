<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\AlternatifModel;
use App\Models\PenilaianModel;
use App\Models\DetailPenilaianModel;
use App\Models\HasilModel;

class Smart extends BaseController
{
    protected $kriteriaModel;
    protected $alternatifModel;
    protected $penilaianModel;
    protected $detailPenilaianModel;
    protected $hasilModel;

    public function __construct()
    {
        $this->kriteriaModel = new KriteriaModel();
        $this->alternatifModel = new AlternatifModel();
        $this->penilaianModel = new PenilaianModel();
        $this->detailPenilaianModel = new DetailPenilaianModel();
        $this->hasilModel = new HasilModel();
    }

    public function kriteria()
    {
        $data = [
            'title'    => 'Kriteria & Bobot | SPK SMART',
            'kriteria' => $this->kriteriaModel->findAll()
        ];
        return view('smart/kriteria', $data);
    }

    public function penilaian()
    {
        $db = \Config\Database::connect();
        
        $penilaian = $db->table('penilaian')
                        ->select('penilaian.*, alternatif.nama_alternatif')
                        ->join('alternatif', 'alternatif.id_alternatif = penilaian.id_alternatif')
                        ->orderBy('penilaian.nama_responden', 'ASC')
                        ->orderBy('alternatif.id_alternatif', 'ASC')
                        ->get()->getResultArray();

        $kriteria = $this->kriteriaModel->findAll();

        $nilaiMatrix = [];
        $details = $this->detailPenilaianModel->findAll();
        foreach($details as $d) {
            $nilaiMatrix[$d['id_penilaian']][$d['id_kriteria']] = $d['nilai'];
        }

        $data = [
            'title'     => 'Penilaian Responden | SPK SMART',
            'penilaian' => $penilaian,
            'kriteria'  => $kriteria,
            'nilaiMatrix'=> $nilaiMatrix
        ];
        return view('smart/penilaian', $data);
    }

    public function rata_rata()
    {
        $db = \Config\Database::connect();
        
        // Dapatkan rata-rata nilai per alternatif dan per kriteria
        // menggunakan query AVG pada tabel detail_penilaian yang di-join dengan penilaian
        $rataQuery = $db->table('detail_penilaian')
                        ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, AVG(detail_penilaian.nilai) as rata_nilai')
                        ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                        ->groupBy('penilaian.id_alternatif, detail_penilaian.id_kriteria')
                        ->get()->getResultArray();

        $matrix = [];
        foreach ($rataQuery as $r) {
            $matrix[$r['id_alternatif']][$r['id_kriteria']] = (float) $r['rata_nilai'];
        }

        $alternatif = $this->alternatifModel->findAll();
        $kriteria = $this->kriteriaModel->findAll();

        $data = [
            'title'      => 'Rata-rata Penilaian | SPK SMART',
            'alternatif' => $alternatif,
            'kriteria'   => $kriteria,
            'matrix'     => $matrix
        ];
        return view('smart/rata_rata', $data);
    }

    public function normalisasi()
    {
        $kriteria = $this->kriteriaModel->findAll();
        $totalBobot = 0;
        foreach ($kriteria as $k) {
            $totalBobot += $k['bobot'];
        }

        $normalisasi = [];
        foreach ($kriteria as $k) {
            $norm = $totalBobot > 0 ? $k['bobot'] / $totalBobot : 0;
            $normalisasi[] = [
                'id_kriteria'   => $k['id_kriteria'],
                'nama_kriteria' => $k['nama_kriteria'],
                'bobot'         => $k['bobot'],
                'normalisasi'   => $norm
            ];
        }

        $data = [
            'title'       => 'Normalisasi Bobot | SPK SMART',
            'totalBobot'  => $totalBobot,
            'normalisasi' => $normalisasi
        ];
        return view('smart/normalisasi', $data);
    }

    public function utility()
    {
        $db = \Config\Database::connect();
        $rataQuery = $db->table('detail_penilaian')
                        ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, AVG(detail_penilaian.nilai) as rata_nilai')
                        ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                        ->groupBy('penilaian.id_alternatif, detail_penilaian.id_kriteria')
                        ->get()->getResultArray();

        $matrix = [];
        foreach ($rataQuery as $r) {
            $matrix[$r['id_alternatif']][$r['id_kriteria']] = (float) $r['rata_nilai'];
        }

        $alternatif = $this->alternatifModel->findAll();
        $kriteria = $this->kriteriaModel->findAll();

        // Cari nilai Max dan Min untuk setiap kriteria
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

        // Hitung Utility
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
                    if ($jenis == 'Benefit') {
                        $u = ($val - $min) / ($max - $min);
                    } else { // Cost
                        $u = ($max - $val) / ($max - $min);
                    }
                }
                $utility[$id_a][$id_k] = $u;
            }
        }

        $data = [
            'title'      => 'Nilai Utility | SPK SMART',
            'alternatif' => $alternatif,
            'kriteria'   => $kriteria,
            'cMax'       => $cMax,
            'cMin'       => $cMin,
            'utility'    => $utility
        ];
        return view('smart/utility', $data);
    }

    public function nilai_akhir()
    {
        $utilityData = $this->getUtilityData();
        $utility = $utilityData['utility'];
        $alternatif = $utilityData['alternatif'];
        $kriteria = $utilityData['kriteria'];
        
        $totalBobot = 0;
        foreach ($kriteria as $k) {
            $totalBobot += $k['bobot'];
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

        $this->hasilModel->truncate();

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
                'id_alternatif' => $row['id_alternatif'],
                'nilai_akhir'   => $row['nilai_akhir'],
                'ranking'       => $rank
            ];
            $rank++;
        }
        if(!empty($insertData)){
            $this->hasilModel->insertBatch($insertData);
        }

        $data = [
            'title'      => 'Nilai Akhir | SPK SMART',
            'alternatif' => $alternatif,
            'kriteria'   => $kriteria,
            'utility'    => $utility,
            'normBobot'  => $normBobot,
            'nilaiAkhir' => $nilaiAkhir
        ];
        return view('smart/nilai_akhir', $data);
    }

    public function ranking()
    {
        $db = \Config\Database::connect();
        $query = $db->table('hasil')
                    ->select('hasil.*, alternatif.nama_alternatif, alternatif.lokasi')
                    ->join('alternatif', 'alternatif.id_alternatif = hasil.id_alternatif')
                    ->orderBy('ranking', 'ASC')
                    ->get();

        $data = [
            'title'   => 'Ranking Tempat Makan | SPK SMART',
            'ranking' => $query->getResultArray()
        ];
        return view('smart/ranking', $data);
    }

    private function getUtilityData()
    {
        $db = \Config\Database::connect();
        $rataQuery = $db->table('detail_penilaian')
                        ->select('penilaian.id_alternatif, detail_penilaian.id_kriteria, AVG(detail_penilaian.nilai) as rata_nilai')
                        ->join('penilaian', 'penilaian.id_penilaian = detail_penilaian.id_penilaian')
                        ->groupBy('penilaian.id_alternatif, detail_penilaian.id_kriteria')
                        ->get()->getResultArray();

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
            'kriteria'   => $kriteria
        ];
    }
}
