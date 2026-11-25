<?php

namespace App\Controllers;

use App\Models\CrudModel;
use App\Models\DepartemenModel;
use App\Models\PenilaianModel;

class Home extends BaseController
{
    public function index()
    {
        $crudModel       = new CrudModel();
        $departemenModel = new DepartemenModel();
        $penilaianModel  = new PenilaianModel();

        $data = [
            'title'             => 'Home - Sistem Penilaian Kepegawaian',
            'jumlahPegawai'     => $crudModel->countAllResults(),
            'jumlahDepartemen'  => $departemenModel->countAllResults(),
            'jumlahPenilaian'   => $penilaianModel->countAllResults(),
        ];

        return view('home/index', $data);
    }
}
