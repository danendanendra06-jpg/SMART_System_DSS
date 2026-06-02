<?php

namespace App\Controllers;

use App\Models\AlternatifModel;

class Alternatif extends BaseController
{
    protected $alternatifModel;

    public function __construct()
    {
        $this->alternatifModel = new AlternatifModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->table('alternatif')
                    ->select('alternatif.*, users.nama as nama_pembuat')
                    ->join('users', 'users.id_user = alternatif.created_by', 'left')
                    ->orderBy('alternatif.id_alternatif', 'DESC')
                    ->get();

        $data = [
            'title'      => 'Katalog Tempat Makan (Alternatif) | SPK SMART',
            'alternatif' => $query->getResultArray()
        ];
        return view('alternatif/index', $data);
    }

    public function search()
    {
        $query = $this->request->getGet('q');
        if (empty($query)) {
            return $this->response->setJSON([]);
        }

        $results = $this->alternatifModel
                        ->like('nama_alternatif', $query)
                        ->findAll(5);

        return $this->response->setJSON($results);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Tempat Makan Baru | SPK SMART',
            'validation' => \Config\Services::validation()
        ];
        return view('alternatif/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama_alternatif' => 'required',
            'lokasi'          => 'required'
        ])) {
            return redirect()->to(base_url('alternatif/create'))->withInput();
        }

        $nama = $this->request->getPost('nama_alternatif');
        
        // Cek duplikasi persis
        $exist = $this->alternatifModel->where('nama_alternatif', $nama)->first();
        if ($exist) {
            session()->setFlashdata('error', 'Tempat makan dengan nama tersebut sudah ada di katalog. Silakan gunakan yang sudah ada.');
            return redirect()->to(base_url('alternatif/create'))->withInput();
        }

        $this->alternatifModel->insert([
            'nama_alternatif' => $nama,
            'lokasi'          => $this->request->getPost('lokasi'),
            'created_by'      => session()->get('id_user')
        ]);

        session()->setFlashdata('success', 'Tempat Makan berhasil ditambahkan ke katalog!');
        return redirect()->to(base_url('alternatif'));
    }

    public function edit($id)
    {
        $alternatif = $this->alternatifModel->find($id);
        
        // Hak akses edit: Hanya pembuat
        if (session()->get('role') != 'admin' && $alternatif['created_by'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak berhak mengedit tempat makan yang dibuat oleh orang lain.');
            return redirect()->to(base_url('alternatif'));
        }

        $data = [
            'title'      => 'Edit Tempat Makan | SPK SMART',
            'validation' => \Config\Services::validation(),
            'alternatif' => $alternatif
        ];
        return view('alternatif/edit', $data);
    }

    public function update($id)
    {
        $alternatif = $this->alternatifModel->find($id);
        if (session()->get('role') != 'admin' && $alternatif['created_by'] != session()->get('id_user')) {
            return redirect()->to(base_url('alternatif'));
        }

        if (!$this->validate([
            'nama_alternatif' => 'required',
            'lokasi'          => 'required'
        ])) {
            return redirect()->to(base_url('alternatif/edit/' . $id))->withInput();
        }

        $this->alternatifModel->update($id, [
            'nama_alternatif' => $this->request->getPost('nama_alternatif'),
            'lokasi'          => $this->request->getPost('lokasi')
        ]);

        session()->setFlashdata('success', 'Data Tempat Makan berhasil diubah.');
        return redirect()->to(base_url('alternatif'));
    }

    public function delete($id)
    {
        $alternatif = $this->alternatifModel->find($id);
        // Hak akses delete: Pembuat atau Admin
        if (session()->get('role') != 'admin' && $alternatif['created_by'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            return redirect()->to(base_url('alternatif'));
        }

        $this->alternatifModel->delete($id);
        session()->setFlashdata('success', 'Tempat Makan berhasil dihapus dari katalog.');
        return redirect()->to(base_url('alternatif'));
    }
}
