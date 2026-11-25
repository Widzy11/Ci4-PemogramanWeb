<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Myth\Auth\Password;

class Users extends BaseController
{
    protected $usersModel;
    protected $db;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
        $this->db         = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Data User',
            'users' => $this->usersModel->getUsers(),
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        $groups = $this->db->table('auth_groups')->orderBy('id', 'ASC')->get()->getResultArray();

        $data = [
            'title'      => 'Tambah Data User',
            'groups'     => $groups,
            'validation' => session('validation') ?? \Config\Services::validation(),
        ];

        return view('users/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'username' => [
                'rules'  => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
                'errors' => [
                    'required'  => 'Username harus diisi.',
                    'is_unique' => 'Username sudah digunakan.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email harus diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah terdaftar.',
                ],
            ],
            'group_id' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Role akses harus dipilih.',
                ],
            ],
        ])) {
            return redirect()->to('/users/create')->withInput();
        }

        $this->usersModel->insert([
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => Password::hash('123456'),
            'active'        => 1,
        ]);

        $newUserId = $this->usersModel->getInsertID();
        $this->db->table('auth_groups_users')->insert([
            'group_id' => (int) $this->request->getPost('group_id'),
            'user_id'  => (int) $newUserId,
        ]);

        session()->setFlashdata('pesan', 'User berhasil ditambahkan dengan password default: 123456');
        return redirect()->to('/users');
    }

    public function resetPassword($id)
    {
        $this->usersModel->update($id, [
            'password_hash' => Password::hash('123456'),
        ]);

        session()->setFlashdata('pesan', 'Password user berhasil direset menjadi: 123456');
        return redirect()->to('/users');
    }

    public function delete($id)
    {
        if ((int) $id === (int) user_id()) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return redirect()->to('/users');
        }

        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
        $this->usersModel->delete($id);

        session()->setFlashdata('pesan', 'Data user berhasil dihapus.');
        return redirect()->to('/users');
    }
}
