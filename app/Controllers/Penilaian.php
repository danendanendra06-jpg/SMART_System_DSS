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
        
        // Ambil data penilaian beserta alternatifnya
        $penilaian = $db->table('penilaian')
                        ->select('penilaian.*, alternatif.nama_alternatif')
                        ->join('alternatif', 'alternatif.id_alternatif = penilaian.id_alternatif')
                        ->orderBy('penilaian.id_penilaian', 'DESC')
                        ->get()->getResultArray();

        // Karena data nilai dinamis, kita kirimkan data mentah kriteria untuk membuat header tabel
        $kriteria = $this->kriteriaModel->findAll();

        // Kita perlu menyusun matriks nilai untuk ditampilkan di tabel index
        $nilaiMatrix = [];
        $details = $this->detailPenilaianModel->findAll();
        foreach($details as $d) {
            $nilaiMatrix[$d['id_penilaian']][$d['id_kriteria']] = $d['nilai'];
        }

        $data = [
            'title'      => 'Data Penilaian | SPK SMART',
            'penilaian'  => $penilaian,
            'kriteria'   => $kriteria,
            'nilaiMatrix'=> $nilaiMatrix
        ];
        return view('penilaian/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Input Penilaian Baru | SPK SMART',
            'validation' => \Config\Services::validation(),
            'alternatif' => $this->alternatifModel->findAll(),
            'kriteria'   => $this->kriteriaModel->findAll()
        ];
        return view('penilaian/create', $data);
    }

    public function store()
    {
        $nama_responden = $this->request->getPost('nama_responden');
        $id_alternatif = $this->request->getPost('id_alternatif');
        $nilai = $this->request->getPost('nilai'); // Ini berupa array [id_kriteria => nilai]

        // Validasi dasar
        if(empty($nama_responden) || empty($id_alternatif)) {
            session()->setFlashdata('error', 'Nama Responden dan Alternatif harus diisi.');
            return redirect()->to(base_url('penilaian/create'))->withInput();
        }

        // Cek duplikasi
        $cek = $this->penilaianModel->where('nama_responden', $nama_responden)
                                    ->where('id_alternatif', $id_alternatif)
                                    ->first();
        if ($cek) {
            session()->setFlashdata('error', "Responden {$nama_responden} sudah memberikan penilaian untuk tempat makan tersebut.");
            return redirect()->to(base_url('penilaian/create'))->withInput();
        }

        // Insert ke tabel penilaian
        $this->penilaianModel->insert([
            'nama_responden' => $nama_responden,
            'id_alternatif'  => $id_alternatif
        ]);
        
        $id_penilaian = $this->penilaianModel->getInsertID();

        // Insert ke tabel detail_penilaian
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

        session()->setFlashdata('success', 'Data Penilaian berhasil disimpan.');
        return redirect()->to(base_url('penilaian'));
    }

    public function edit($id)
    {
        $penilaian = $this->penilaianModel->find($id);
        if(!$penilaian) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Ambil detail nilai
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
        $nama_responden = $this->request->getPost('nama_responden');
        $id_alternatif = $this->request->getPost('id_alternatif');
        $nilai = $this->request->getPost('nilai');

        // Validasi dasar
        if(empty($nama_responden) || empty($id_alternatif)) {
            session()->setFlashdata('error', 'Nama Responden dan Alternatif harus diisi.');
            return redirect()->to(base_url('penilaian/edit/'.$id))->withInput();
        }

        // Cek duplikasi jika mengubah responden atau alternatif
        $cek = $this->penilaianModel->where('nama_responden', $nama_responden)
                                    ->where('id_alternatif', $id_alternatif)
                                    ->where('id_penilaian !=', $id)
                                    ->first();
        if ($cek) {
            session()->setFlashdata('error', 'Responden ini sudah memberikan penilaian untuk alternatif tersebut.');
            return redirect()->to(base_url('penilaian/edit/' . $id))->withInput();
        }

        // Update penilaian utama
        $this->penilaianModel->update($id, [
            'nama_responden' => $nama_responden,
            'id_alternatif'  => $id_alternatif
        ]);

        // Karena dinamis, cara termudah update adalah hapus semua detail lama lalu insert baru
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

        session()->setFlashdata('success', 'Data Penilaian berhasil diubah.');
        return redirect()->to(base_url('penilaian'));
    }

    public function delete($id)
    {
        // Karena ada CASCADE di DB, menghapus tabel penilaian otomatis hapus detail_penilaian
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
