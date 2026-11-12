<?php

namespace App\Controllers;

use App\Models\DepartemenModel;

class Departemen extends BaseController
{
    protected $departemenModel;

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Daftar Departemen',
            'departemen' => $this->departemenModel->findAll()
        ];

        return view('departemen/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Data Departemen',
            'validation' => \Config\Services::validation()
        ];

        return view('departemen/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_departemen' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'nama_bagian' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to('/departemen/create')->withInput()->with('validation', \Config\Services::validation());
        }

        $this->departemenModel->save([
            'nama_departemen' => $this->request->getPost('nama_departemen'),
            'nama_bagian'     => $this->request->getPost('nama_bagian')
        ]);

        session()->setFlashdata('pesan', 'Data Departemen berhasil ditambahkan.');
        return redirect()->to('/departemen');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Data Departemen',
            'departemen' => $this->departemenModel->find($id),
            'validation' => \Config\Services::validation()
        ];

        return view('departemen/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_departemen' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ],
            'nama_bagian' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ]
        ])) {
            return redirect()->to('/departemen/edit/' . $id)->withInput()->with('validation', \Config\Services::validation());
        }

        $this->departemenModel->update($id, [
            'nama_departemen' => $this->request->getPost('nama_departemen'),
            'nama_bagian'     => $this->request->getPost('nama_bagian')
        ]);

        session()->setFlashdata('pesan', 'Data Departemen berhasil diubah.');
        return redirect()->to('/departemen');
    }

    public function delete($id)
    {
        $this->departemenModel->delete($id);
        session()->setFlashdata('pesan', 'Data Departemen berhasil dihapus.');
        return redirect()->to('/departemen');
    }
}
