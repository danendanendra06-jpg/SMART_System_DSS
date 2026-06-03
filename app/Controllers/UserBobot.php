<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\UserBobotKriteriaModel;

class UserBobot extends BaseController
{
    protected $kriteriaModel;
    protected $userBobotModel;

    public function __construct()
    {
        $this->kriteriaModel = new KriteriaModel();
        $this->userBobotModel = new UserBobotKriteriaModel();
    }

    public function index()
    {
        $id_user = session()->get('id_user');
        if (session()->get('role') == 'admin') {
            return redirect()->to(base_url('home'))->with('error', 'Fitur atur bobot hanya untuk User Decision Maker.');
        }

        $kriteria = $this->kriteriaModel->findAll();
        
        // Cek bobot user saat ini
        $userBobot = $this->userBobotModel->where('id_user', $id_user)->findAll();
        $bobotMap = [];
        foreach($userBobot as $ub) {
            $bobotMap[$ub['id_kriteria']] = $ub['nilai_kepentingan'];
        }

        $data = [
            'title'    => 'Atur Bobot Kriteria | SPK SMART',
            'kriteria' => $kriteria,
            'bobotMap' => $bobotMap
        ];

        return view('user_bobot/index', $data);
    }

    public function store()
    {
        $id_user = session()->get('id_user');
        $bobot = $this->request->getPost('bobot'); // array id_kriteria => nilai bobot

        $this->userBobotModel->where('id_user', $id_user)->delete();

        $total = 0;
        foreach($bobot as $id_kriteria => $nilai) {
            $this->userBobotModel->insert([
                'id_user' => $id_user,
                'id_kriteria' => $id_kriteria,
                'nilai_kepentingan' => $nilai
            ]);
            $total += $nilai;
        }

        // if($total != 100) {
        //   Warning bisa ditambahkan disini
        // }

        session()->setFlashdata('success', 'Preferensi bobot Anda berhasil disimpan. Anda dapat melanjutkan ke perhitungan SMART.');
        return redirect()->to(base_url('userbobot'));
    }
}
