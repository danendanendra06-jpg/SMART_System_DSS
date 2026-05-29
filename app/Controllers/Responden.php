<?php

namespace App\Controllers;

use App\Models\RespondenModel;

class Responden extends BaseController
{
    protected $respondenModel;

    public function __construct()
    {
        $this->respondenModel = new RespondenModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Responden | SPK SMART',
            'responden' => $this->respondenModel->findAll()
        ];
        return view('responden/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Responden | SPK SMART',
            'validation' => \Config\Services::validation()
        ];
        return view('responden/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nama_responden' => 'required'
        ])) {
            return redirect()->to(base_url('responden/create'))->withInput();
        }

        $this->respondenModel->save([
            'nama_responden' => $this->request->getPost('nama_responden'),
            'tanggal_input'  => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Data Responden berhasil ditambahkan.');
        return redirect()->to(base_url('responden'));
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Responden | SPK SMART',
            'validation' => \Config\Services::validation(),
            'responden'  => $this->respondenModel->find($id)
        ];
        return view('responden/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_responden' => 'required'
        ])) {
            return redirect()->to(base_url('responden/edit/' . $id))->withInput();
        }

        $this->respondenModel->save([
            'id_responden'   => $id,
            'nama_responden' => $this->request->getPost('nama_responden')
            // tanggal_input biarkan sama
        ]);

        session()->setFlashdata('success', 'Data Responden berhasil diubah.');
        return redirect()->to(base_url('responden'));
    }

    public function delete($id)
    {
        $this->respondenModel->delete($id);
        session()->setFlashdata('success', 'Data Responden berhasil dihapus.');
        return redirect()->to(base_url('responden'));
    }
}
