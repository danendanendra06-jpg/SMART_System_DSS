<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\DetailPenilaianModel;
use App\Models\AlternatifModel;
use App\Models\KriteriaModel;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $detailPenilaianModel;
    protected $alternatifModel;
    protected $kriteriaModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->detailPenilaianModel = new DetailPenilaianModel();
        $this->alternatifModel = new AlternatifModel();
        $this->kriteriaModel = new KriteriaModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penilaian')
                      ->select('penilaian.*, alternatif.nama_alternatif, users.nama as nama_user')
                      ->join('alternatif', 'alternatif.id_alternatif = penilaian.id_alternatif')
                      ->join('users', 'users.id_user = penilaian.id_user')
                      ->orderBy('penilaian.id_penilaian', 'DESC');

        if (session()->get('role') != 'admin') {
            $builder->where('penilaian.id_user', session()->get('id_user'));
        }

        $penilaian = $builder->get()->getResultArray();
        $kriteria = $this->kriteriaModel->findAll();

        $nilaiMatrix = [];
        $details = $this->detailPenilaianModel->findAll();
        foreach($details as $d) {
            $nilaiMatrix[$d['id_penilaian']][$d['id_kriteria']] = $d['nilai'];
        }

        $data = [
            'title'      => session()->get('role') == 'admin' ? 'Data Penilaian Global | SPK SMART' : 'Data Penilaian Saya | SPK SMART',
            'penilaian'  => $penilaian,
            'kriteria'   => $kriteria,
            'nilaiMatrix'=> $nilaiMatrix
        ];
        return view('penilaian/index', $data);
    }

    public function create()
    {
        if (session()->get('role') == 'admin') {
            return redirect()->to(base_url('penilaian'))->with('error', 'Admin tidak dapat menginput penilaian.');
        }

        // Cari alternatif yang belum dinilai oleh user ini
        $db = \Config\Database::connect();
        $id_user = session()->get('id_user');
        $dinilaiQuery = $db->table('penilaian')->select('id_alternatif')->where('id_user', $id_user)->get()->getResultArray();
        $dinilaiIds = array_column($dinilaiQuery, 'id_alternatif');

        if (empty($dinilaiIds)) {
            $alternatif = $this->alternatifModel->findAll();
        } else {
            $alternatif = $this->alternatifModel->whereNotIn('id_alternatif', $dinilaiIds)->findAll();
        }

        $data = [
            'title'      => 'Beri Penilaian Tempat Makan | SPK SMART',
            'validation' => \Config\Services::validation(),
            'alternatif' => $alternatif,
            'kriteria'   => $this->kriteriaModel->findAll()
        ];
        return view('penilaian/create', $data);
    }

    public function store()
    {
        if (session()->get('role') == 'admin') {
            return redirect()->to(base_url('penilaian'))->with('error', 'Akses ditolak.');
        }

        $id_alternatif = $this->request->getPost('id_alternatif');
        $nilai = $this->request->getPost('nilai'); // array [id_kriteria => nilai]
        $id_user = session()->get('id_user');

        if(empty($id_alternatif)) {
            session()->setFlashdata('error', 'Alternatif harus dipilih.');
            return redirect()->to(base_url('penilaian/create'))->withInput();
        }

        // Cek duplikasi penilaian oleh user untuk alternatif ini
        $cek = $this->penilaianModel->where('id_user', $id_user)
                                    ->where('id_alternatif', $id_alternatif)
                                    ->first();
        if ($cek) {
            session()->setFlashdata('error', "Anda sudah memberikan penilaian untuk tempat makan ini.");
            return redirect()->to(base_url('penilaian/create'))->withInput();
        }

        $this->penilaianModel->insert([
            'id_user'        => $id_user,
            'id_alternatif'  => $id_alternatif
        ]);
        
        $id_penilaian = $this->penilaianModel->getInsertID();

        $detailData = [];
        if($nilai && is_array($nilai)) {
            foreach($nilai as $id_kriteria => $val) {
                if($val !== "") {
                    $detailData[] = [
                        'id_penilaian' => $id_penilaian,
                        'id_kriteria'  => $id_kriteria,
                        'nilai'        => $this->mapSkalaToSmart($val)
                    ];
                }
            }
        }

        if (!empty($detailData)) {
            $this->detailPenilaianModel->insertBatch($detailData);
        }

        session()->setFlashdata('success', 'Penilaian berhasil disimpan.');
        return redirect()->to(base_url('penilaian'));
    }

    public function edit($id)
    {
        $penilaian = $this->penilaianModel->find($id);
        if(!$penilaian) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if (session()->get('role') != 'admin' && $penilaian['id_user'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak berhak mengedit penilaian ini.');
            return redirect()->to(base_url('penilaian'));
        }

        $details = $this->detailPenilaianModel->where('id_penilaian', $id)->findAll();
        $nilaiSelesai = [];
        foreach($details as $d) {
            $nilaiSelesai[$d['id_kriteria']] = $this->mapSmartToSkala($d['nilai']);
        }

        $data = [
            'title'      => 'Edit Penilaian | SPK SMART',
            'validation' => \Config\Services::validation(),
            'penilaian'  => $penilaian,
            'alternatif' => $this->alternatifModel->findAll(),
            'kriteria'   => $this->kriteriaModel->findAll(),
            'nilaiSelesai'=> $nilaiSelesai
        ];
        return view('penilaian/edit', $data);
    }

    public function update($id)
    {
        $penilaian = $this->penilaianModel->find($id);
        if (session()->get('role') != 'admin' && $penilaian['id_user'] != session()->get('id_user')) {
            return redirect()->to(base_url('penilaian'));
        }

        $id_alternatif = $this->request->getPost('id_alternatif');
        $nilai = $this->request->getPost('nilai');

        if(empty($id_alternatif)) {
            session()->setFlashdata('error', 'Alternatif harus diisi.');
            return redirect()->to(base_url('penilaian/edit/'.$id))->withInput();
        }

        // Cek duplikasi jika user mengubah alternatif ke alternatif yang sudah dinilainya
        $cek = $this->penilaianModel->where('id_user', $penilaian['id_user'])
                                    ->where('id_alternatif', $id_alternatif)
                                    ->where('id_penilaian !=', $id)
                                    ->first();
        if ($cek) {
            session()->setFlashdata('error', 'Anda sudah memberikan penilaian untuk alternatif tersebut.');
            return redirect()->to(base_url('penilaian/edit/' . $id))->withInput();
        }

        $this->penilaianModel->update($id, [
            'id_alternatif'  => $id_alternatif
        ]);

        $this->detailPenilaianModel->where('id_penilaian', $id)->delete();

        $detailData = [];
        if($nilai && is_array($nilai)) {
            foreach($nilai as $id_kriteria => $val) {
                if($val !== "") {
                    $detailData[] = [
                        'id_penilaian' => $id,
                        'id_kriteria'  => $id_kriteria,
                        'nilai'        => $this->mapSkalaToSmart($val)
                    ];
                }
            }
        }

        if (!empty($detailData)) {
            $this->detailPenilaianModel->insertBatch($detailData);
        }

        session()->setFlashdata('success', 'Penilaian berhasil diubah.');
        return redirect()->to(base_url('penilaian'));
    }

    public function delete($id)
    {
        $penilaian = $this->penilaianModel->find($id);
        if (session()->get('role') != 'admin' && $penilaian['id_user'] != session()->get('id_user')) {
            return redirect()->to(base_url('penilaian'));
        }

        $this->penilaianModel->delete($id);
        session()->setFlashdata('success', 'Data Penilaian berhasil dihapus.');
        return redirect()->to(base_url('penilaian'));
    }

    private function mapSkalaToSmart($skala)
    {
        $map = [
            1 => 10,
            2 => 20,
            3 => 60,
            4 => 80,
            5 => 100
        ];
        return $map[$skala] ?? 0;
    }

    private function mapSmartToSkala($smartValue)
    {
        $map = [
            10 => 1,
            20 => 2,
            60 => 3,
            80 => 4,
            100 => 5
        ];
        return $map[$smartValue] ?? '';
    }
}
