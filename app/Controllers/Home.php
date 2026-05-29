<?php

namespace App\Controllers;

use App\Models\AlternatifModel;
use App\Models\KriteriaModel;
use App\Models\RespondenModel;

class Home extends BaseController
{
    public function index()
    {
        $alternatifModel = new AlternatifModel();
        $penilaianModel = new \App\Models\PenilaianModel();
        
        $db = \Config\Database::connect();
        $query = $db->table('hasil')
                    ->select('hasil.*, alternatif.nama_alternatif')
                    ->join('alternatif', 'alternatif.id_alternatif = hasil.id_alternatif')
                    ->where('ranking', 1)
                    ->get();
        $terbaik = $query->getRowArray();

        // Get unique respondents count
        $db = \Config\Database::connect();
        $resQuery = $db->query("SELECT COUNT(DISTINCT nama_responden) as total FROM penilaian");
        $resCount = $resQuery->getRow()->total;

        $data = [
            'title'           => 'Beranda | SPK SMART',
            'countAlternatif' => $alternatifModel->countAllResults(),
            'countResponden'  => $resCount,
            'terbaik'         => $terbaik ? $terbaik['nama_alternatif'] : '-',
        ];

        return view('home/index', $data);
    }
}
