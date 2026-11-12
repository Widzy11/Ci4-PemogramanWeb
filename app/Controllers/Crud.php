<?php

namespace App\Controllers;

use App\Models\CrudModel;
use App\Models\DepartemenModel;

class Crud extends BaseController
{
    protected $crudModel;
    protected $departemenModel;

    public function __construct()
    {
        $this->crudModel = new CrudModel();
        $this->departemenModel = new DepartemenModel();
    }

    // Read: Menampilkan daftar data pegawai dengan relasi departemen
    public function index()
    {
        $data = [
            'title'   => 'Daftar Pegawai',
            'pegawai' => $this->crudModel->getPegawai()
        ];

        return view('crud/index', $data);
    }

    // Create: Menampilkan formulir tambah data
    public function create()
    {
        $data = [
            'title'      => 'Form Tambah Data Pegawai',
            'departemen' => $this->departemenModel->findAll(),
            'validation' => session('validation') ?? \Config\Services::validation()
        ];

        return view('crud/create', $data);
    }

    // Create Action: Validasi, Upload Foto, dan Simpan Data
    public function save()
    {
        if (!$this->validate([
            'nomor_pegawai' => [
                'rules'  => 'required|is_unique[pegawai.nomor_pegawai]',
                'errors' => [
                    'required'  => 'Nomor pegawai harus diisi.',
                    'is_unique' => 'Nomor pegawai sudah terdaftar, gunakan nomor lain.'
                ]
            ],
            'nama_pegawai' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama pegawai harus diisi.'
                ]
            ],
            'id_departemen' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Departemen harus dipilih.'
                ]
            ],
            'foto' => [
                'rules'  => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 1MB.',
                    'is_image' => 'File yang dipilih bukan format gambar yang valid.',
                    'mime_in'  => 'Format gambar harus berupa JPG, JPEG, atau PNG.'
                ]
            ]
        ])) {
            return redirect()->to('/crud/create')->withInput()->with('validation', \Config\Services::validation());
        }

        // Kelola file foto
        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto->getError() == 4) {
            $namaFoto = 'default.jpg';
        } else {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('img', $namaFoto);
        }

        $this->crudModel->save([
            'nomor_pegawai' => $this->request->getPost('nomor_pegawai'),
            'nama_pegawai'  => $this->request->getPost('nama_pegawai'),
            'id_departemen' => $this->request->getPost('id_departemen'),
            'foto'          => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan');
        return redirect()->to('/crud');
    }

    // Update: Menampilkan formulir edit data berdasarkan ID
    public function edit($id)
    {
        $data = [
            'title'      => 'Form Edit Data Pegawai',
            'pegawai'    => $this->crudModel->find($id),
            'departemen' => $this->departemenModel->findAll(),
            'validation' => session('validation') ?? \Config\Services::validation()
        ];

        return view('crud/edit', $data);
    }

    // Update Action: Validasi (pengecualian ID), Upload Foto Baru, dan Update Data
    public function update($id)
    {
        $pegawaiLama = $this->crudModel->find($id);
        if ($pegawaiLama['nomor_pegawai'] == $this->request->getPost('nomor_pegawai')) {
            $ruleNomorPegawai = 'required';
        } else {
            $ruleNomorPegawai = 'required|is_unique[pegawai.nomor_pegawai]';
        }

        if (!$this->validate([
            'nomor_pegawai' => [
                'rules'  => $ruleNomorPegawai,
                'errors' => [
                    'required'  => 'Nomor pegawai harus diisi.',
                    'is_unique' => 'Nomor pegawai sudah terdaftar, gunakan nomor lain.'
                ]
            ],
            'nama_pegawai' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama pegawai harus diisi.'
                ]
            ],
            'id_departemen' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Departemen harus dipilih.'
                ]
            ],
            'foto' => [
                'rules'  => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar tidak boleh melebihi 1MB.',
                    'is_image' => 'File yang dipilih bukan format gambar yang valid.',
                    'mime_in'  => 'Format gambar harus berupa JPG, JPEG, atau PNG.'
                ]
            ]
        ])) {
            return redirect()->to('/crud/edit/' . $id)->withInput()->with('validation', \Config\Services::validation());
        }

        $fileFoto = $this->request->getFile('foto');
        $fotoLama = $this->request->getPost('fotoLama');

        // Cek apakah user mengupload foto baru
        if ($fileFoto->getError() == 4) {
            $namaFoto = $fotoLama;
        } else {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('img', $namaFoto);

            // Hapus file lama jika bukan default.jpg
            if ($fotoLama != 'default.jpg' && file_exists('img/' . $fotoLama)) {
                unlink('img/' . $fotoLama);
            }
        }

        $this->crudModel->update($id, [
            'nomor_pegawai' => $this->request->getPost('nomor_pegawai'),
            'nama_pegawai'  => $this->request->getPost('nama_pegawai'),
            'id_departemen' => $this->request->getPost('id_departemen'),
            'foto'          => $namaFoto
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/crud');
    }

    // Delete Action: Hapus foto dan data pegawai
    public function delete($id)
    {
        $pegawai = $this->crudModel->find($id);

        // Hapus file foto fisik jika bukan default.jpg
        if ($pegawai['foto'] != 'default.jpg' && file_exists('img/' . $pegawai['foto'])) {
            unlink('img/' . $pegawai['foto']);
        }

        $this->crudModel->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/crud');
    }
}
