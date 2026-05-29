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
        $data = [
            'title'      => 'Data Alternatif | SPK SMART',
            'alternatif' => $this->alternatifModel->findAll()
        ];
        return view('alternatif/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Alternatif | SPK SMART',
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

        $this->alternatifModel->save([
            'nama_alternatif' => $this->request->getPost('nama_alternatif'),
            'lokasi'          => $this->request->getPost('lokasi')
        ]);

        session()->setFlashdata('success', 'Data Alternatif berhasil ditambahkan.');
        return redirect()->to(base_url('alternatif'));
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Alternatif | SPK SMART',
            'validation' => \Config\Services::validation(),
            'alternatif' => $this->alternatifModel->find($id)
        ];
        return view('alternatif/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_alternatif' => 'required',
            'lokasi'          => 'required'
        ])) {
            return redirect()->to(base_url('alternatif/edit/' . $id))->withInput();
        }

        $this->alternatifModel->save([
            'id_alternatif'   => $id,
            'nama_alternatif' => $this->request->getPost('nama_alternatif'),
            'lokasi'          => $this->request->getPost('lokasi')
        ]);

        session()->setFlashdata('success', 'Data Alternatif berhasil diubah.');
        return redirect()->to(base_url('alternatif'));
    }

    public function delete($id)
    {
        $this->alternatifModel->delete($id);
        session()->setFlashdata('success', 'Data Alternatif berhasil dihapus.');
        return redirect()->to(base_url('alternatif'));
    }
}
