<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\CrudModel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\JcTable;

class Penilaian extends BaseController
{
    protected $penilaianModel;
    protected $crudModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->crudModel      = new CrudModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Penilaian',
            'penilaian' => $this->penilaianModel->getPenilaian(),
        ];

        return view('penilaian/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Data Penilaian',
            'pegawai'    => $this->crudModel->orderBy('nomor_pegawai', 'ASC')->findAll(),
            'validation' => session('validation') ?? \Config\Services::validation(),
        ];

        return view('penilaian/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nomor_pegawai' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nomor pegawai harus dipilih.'],
            ],
            'penilaian_kerja' => [
                'rules'  => 'required|in_list[1,2,3]',
                'errors' => ['required' => 'Penilaian kerja harus dipilih.'],
            ],
            'keterangan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Keterangan harus diisi.'],
            ],
            'tanggal_penilaian' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal penilaian harus diisi.'],
            ],
        ])) {
            return redirect()->to('/penilaian/create')->withInput();
        }

        $this->penilaianModel->save([
            'nomor_pegawai'     => $this->request->getPost('nomor_pegawai'),
            'penilaian_kerja'   => $this->request->getPost('penilaian_kerja'),
            'keterangan'        => $this->request->getPost('keterangan'),
            'tanggal_penilaian' => $this->request->getPost('tanggal_penilaian'),
        ]);

        session()->setFlashdata('pesan', 'Data penilaian berhasil ditambahkan.');
        return redirect()->to('/penilaian');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Ubah Data Penilaian',
            'penilaian'  => $this->penilaianModel->find($id),
            'pegawai'    => $this->crudModel->orderBy('nomor_pegawai', 'ASC')->findAll(),
            'validation' => session('validation') ?? \Config\Services::validation(),
        ];

        return view('penilaian/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nomor_pegawai' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nomor pegawai harus dipilih.'],
            ],
            'penilaian_kerja' => [
                'rules'  => 'required|in_list[1,2,3]',
                'errors' => ['required' => 'Penilaian kerja harus dipilih.'],
            ],
            'keterangan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Keterangan harus diisi.'],
            ],
            'tanggal_penilaian' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tanggal penilaian harus diisi.'],
            ],
        ])) {
            return redirect()->to('/penilaian/edit/' . $id)->withInput();
        }

        $this->penilaianModel->update($id, [
            'nomor_pegawai'     => $this->request->getPost('nomor_pegawai'),
            'penilaian_kerja'   => $this->request->getPost('penilaian_kerja'),
            'keterangan'        => $this->request->getPost('keterangan'),
            'tanggal_penilaian' => $this->request->getPost('tanggal_penilaian'),
        ]);

        session()->setFlashdata('pesan', 'Data penilaian berhasil diubah.');
        return redirect()->to('/penilaian');
    }

    public function delete($id)
    {
        $this->penilaianModel->delete($id);
        session()->setFlashdata('pesan', 'Data penilaian berhasil dihapus.');
        return redirect()->to('/penilaian');
    }

    // Video #9: Export Data Penilaian ke Word (.docx) menggunakan PhpWord
    public function exportWord()
    {
        $list = $this->penilaianModel->getPenilaian();

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

        $section->addText(
            'LAPORAN DATA PENILAIAN KINERJA PEGAWAI',
            ['bold' => true, 'size' => 15, 'color' => '0D6EFD'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 100]
        );
        $section->addText(
            'Dicetak pada: ' . date('d-m-Y H:i:s'),
            ['italic' => true, 'size' => 10, 'color' => '666666'],
            ['alignment' => Jc::CENTER, 'spaceAfter' => 300]
        );

        $tableStyle = [
            'borderSize'  => 6,
            'borderColor' => '999999',
            'cellMargin'  => 80,
            'alignment'   => JcTable::CENTER,
        ];
        $phpWord->addTableStyle('PenilaianTable', $tableStyle);
        $table = $section->addTable('PenilaianTable');

        $headerCellStyle = ['bgColor' => '0D6EFD', 'valign' => 'center'];
        $headerFontStyle = ['bold' => true, 'color' => 'FFFFFF', 'size' => 10];
        $headerParaStyle = ['alignment' => Jc::CENTER];

        $table->addRow(400, ['tblHeader' => true]);
        $table->addCell(700, $headerCellStyle)->addText('No', $headerFontStyle, $headerParaStyle);
        $table->addCell(1700, $headerCellStyle)->addText('No Pegawai', $headerFontStyle, $headerParaStyle);
        $table->addCell(2400, $headerCellStyle)->addText('Nama Pegawai', $headerFontStyle, $headerParaStyle);
        $table->addCell(1800, $headerCellStyle)->addText('Penilaian Kerja', $headerFontStyle, $headerParaStyle);
        $table->addCell(2400, $headerCellStyle)->addText('Keterangan', $headerFontStyle, $headerParaStyle);
        $table->addCell(1800, $headerCellStyle)->addText('Tanggal Penilaian', $headerFontStyle, $headerParaStyle);

        $cellStyle = ['valign' => 'center'];
        $no = 1;
        foreach ($list as $row) {
            if ((int) $row['penilaian_kerja'] === 1) {
                $nilaiText = 'Sangat Baik';
            } elseif ((int) $row['penilaian_kerja'] === 2) {
                $nilaiText = 'Cukup';
            } else {
                $nilaiText = 'Buruk';
            }

            $table->addRow();
            $table->addCell(700, $cellStyle)->addText((string) $no++, ['size' => 10], ['alignment' => Jc::CENTER]);
            $table->addCell(1700, $cellStyle)->addText($row['nomor_pegawai'], ['size' => 10]);
            $table->addCell(2400, $cellStyle)->addText($row['nama_pegawai'] ?? '-', ['size' => 10]);
            $table->addCell(1800, $cellStyle)->addText($nilaiText, ['size' => 10], ['alignment' => Jc::CENTER]);
            $table->addCell(2400, $cellStyle)->addText($row['keterangan'], ['size' => 10]);
            $table->addCell(1800, $cellStyle)->addText($row['tanggal_penilaian'], ['size' => 10], ['alignment' => Jc::CENTER]);
        }

        $filename = 'Laporan_Penilaian_' . date('Ymd_His') . '.docx';
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
