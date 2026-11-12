<?php

namespace App\Models;

use CodeIgniter\Model;

class CrudModel extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor_pegawai', 'nama_pegawai', 'id_departemen', 'foto'];

    public function getPegawai($id = false)
    {
        if ($id === false) {
            return $this->select('pegawai.*, departemen.nama_departemen, departemen.nama_bagian')
                        ->join('departemen', 'departemen.id_departemen = pegawai.id_departemen')
                        ->findAll();
        }

        return $this->select('pegawai.*, departemen.nama_departemen, departemen.nama_bagian')
                    ->join('departemen', 'departemen.id_departemen = pegawai.id_departemen')
                    ->where(['pegawai.id' => $id])
                    ->first();
    }
}
