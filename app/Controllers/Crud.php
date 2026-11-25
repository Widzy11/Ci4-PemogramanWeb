<?php

namespace App\Controllers;

use App\Models\CrudModel;
use App\Models\DepartemenModel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;

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
        $selectedId = $this->request->getGet('pegawai_id');
        if (!empty($selectedId)) {
            $single = $this->crudModel->getPegawai($selectedId);
            $pegawai = $single ? [$single] : [];
        } else {
            $pegawai = $this->crudModel->getPegawai();
        }

        $data = [
            'title'      => 'Daftar Pegawai',
            'pegawai'    => $pegawai,
            'selectedId' => $selectedId
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
            return redirect()->to('/crud/create')->withInput();
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
            return redirect()->to('/crud/edit/' . $id)->withInput();
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

    // AJAX: Cek ketersediaan nomor pegawai secara realtime
    public function cekNomorPegawai()
    {
        $nomorPegawai = trim($this->request->getVar('nomor_pegawai') ?? '');
        $id = $this->request->getVar('id');

        if (empty($nomorPegawai)) {
            return $this->response->setJSON([
                'status'  => 'empty',
                'message' => ''
            ]);
        }

        $builder = $this->crudModel->where('nomor_pegawai', $nomorPegawai);
        if (!empty($id)) {
            $builder->where('id !=', $id);
        }
        $pegawai = $builder->first();

        if ($pegawai) {
            return $this->response->setJSON([
                'status'  => 'exists',
                'message' => 'Nomor pegawai sudah terdaftar, silakan gunakan nomor lain.'
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'available',
                'message' => 'Nomor pegawai tersedia.'
            ]);
        }
    }

    // AJAX Select2 Autocomplete (#7): Cari pegawai dari database MySQL
    public function searchPegawai()
    {
        $keyword = trim($this->request->getGet('q') ?? $this->request->getGet('searchTerm') ?? '');

        $builder = $this->crudModel
            ->select('pegawai.id, pegawai.nomor_pegawai, pegawai.nama_pegawai, departemen.nama_departemen')
            ->join('departemen', 'departemen.id_departemen = pegawai.id_departemen');

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('pegawai.nomor_pegawai', $keyword)
                ->orLike('pegawai.nama_pegawai', $keyword)
                ->orLike('departemen.nama_departemen', $keyword)
                ->groupEnd();
        }

        $rows = $builder->orderBy('pegawai.nama_pegawai', 'ASC')->findAll(20);
        $results = [];
        foreach ($rows as $row) {
            $results[] = [
                'id'   => $row['id'],
                'text' => $row['nomor_pegawai'] . ' - ' . $row['nama_pegawai'] . ' (' . $row['nama_departemen'] . ')',
            ];
        }

        return $this->response->setJSON(['results' => $results]);
    }

    // Export to Word (#9): Export data pegawai ke file .docx menggunakan PhpWord
    public function exportWord($id = null)
    {
        if ($id !== null) {
            $single = $this->crudModel->getPegawai($id);
            $pegawaiList = $single ? [$single] : [];
        } else {
            $pegawaiList = $this->crudModel->getPegawai();
        }

        Settings::setOutputEscapingEnabled(true);
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Calibri');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop'    => 800,
            'marginBottom' => 800,
            'marginLeft'   => 800,
            'marginRight'  => 800,
        ]);

        // Judul Dokumen
        $section->addText(
            'LAPORAN DATA PEGAWAI',
            ['bold' => true, 'size' => 16, 'color' => '0D6EFD'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 100]
        );
        $section->addText(
            'Tanggal Export: ' . date('d-m-Y H:i:s'),
            ['italic' => true, 'size' => 10, 'color' => '666666'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 300]
        );

        // Gaya Tabel
        $tableStyle = [
            'borderSize'  => 6,
            'borderColor' => '999999',
            'cellMargin'  => 80,
            'alignment'   => JcTable::CENTER,
        ];
        $phpWord->addTableStyle('PegawaiTable', $tableStyle);
        $table = $section->addTable('PegawaiTable');

        // Header Tabel
        $headerCellStyle = ['bgColor' => '0D6EFD', 'valign' => 'center'];
        $headerFontStyle = ['bold' => true, 'color' => 'FFFFFF', 'size' => 10];
        $headerParaStyle = ['alignment' => Jc::CENTER];

        $table->addRow(400, ['tblHeader' => true]);
        $table->addCell(600, $headerCellStyle)->addText('No', $headerFontStyle, $headerParaStyle);
        $table->addCell(1400, $headerCellStyle)->addText('Foto', $headerFontStyle, $headerParaStyle);
        $table->addCell(1800, $headerCellStyle)->addText('Nomor Pegawai', $headerFontStyle, $headerParaStyle);
        $table->addCell(2600, $headerCellStyle)->addText('Nama Pegawai', $headerFontStyle, $headerParaStyle);
        $table->addCell(2200, $headerCellStyle)->addText('Departemen', $headerFontStyle, $headerParaStyle);
        $table->addCell(2200, $headerCellStyle)->addText('Bagian', $headerFontStyle, $headerParaStyle);

        // Isi Tabel
        $cellStyle = ['valign' => 'center'];
        $no = 1;
        foreach ($pegawaiList as $p) {
            $table->addRow();
            $table->addCell(600, $cellStyle)->addText((string) $no++, ['size' => 10], ['alignment' => Jc::CENTER]);

            $fotoCell = $table->addCell(1400, $cellStyle);
            $fotoPath = FCPATH . 'img/' . ($p['foto'] ?: 'default.jpg');
            if (is_file($fotoPath) && @getimagesize($fotoPath)) {
                $fotoCell->addImage($fotoPath, [
                    'width'     => 40,
                    'height'    => 40,
                    'alignment' => Jc::CENTER,
                ]);
            } else {
                $fotoCell->addText('-', ['size' => 10], ['alignment' => Jc::CENTER]);
            }

            $table->addCell(1800, $cellStyle)->addText($p['nomor_pegawai'], ['size' => 10]);
            $table->addCell(2600, $cellStyle)->addText($p['nama_pegawai'], ['size' => 10]);
            $table->addCell(2200, $cellStyle)->addText($p['nama_departemen'], ['size' => 10]);
            $table->addCell(2200, $cellStyle)->addText($p['nama_bagian'], ['size' => 10]);
        }

        $filename = 'Data_Pegawai_' . date('Ymd_His') . '.docx';
        $tempFile = WRITEPATH . 'uploads/' . $filename;
        if (!is_dir(WRITEPATH . 'uploads')) {
            mkdir(WRITEPATH . 'uploads', 0755, true);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        $fileContents = file_get_contents($tempFile);
        @unlink($tempFile);

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($fileContents);
    }
}
