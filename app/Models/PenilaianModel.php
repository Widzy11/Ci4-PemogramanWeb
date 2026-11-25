<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table = 'penilaian';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor_pegawai', 'penilaian_kerja', 'keterangan', 'tanggal_penilaian'];

    public function getPenilaian($id = false)
    {
        $builder = $this->select('penilaian.*, pegawai.nama_pegawai')
            ->join('pegawai', 'pegawai.nomor_pegawai = penilaian.nomor_pegawai', 'left');

        if ($id === false) {
            return $builder->orderBy('penilaian.id', 'ASC')->findAll();
        }

        return $builder->where(['penilaian.id' => $id])->first();
    }
}
