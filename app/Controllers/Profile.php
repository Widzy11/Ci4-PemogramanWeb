<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Myth\Auth\Password;

class Profile extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $currentUser = $this->usersModel->find(user_id());

        $data = [
            'title'      => 'Edit Profil',
            'user'       => $currentUser,
            'validation' => session('validation') ?? \Config\Services::validation(),
        ];

        return view('profile/edit', $data);
    }

    public function updateProfil()
    {
        $id = user_id();

        if (!$this->validate([
            'username' => [
                'rules'  => "required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,{$id}]",
                'errors' => [
                    'required'  => 'Username harus diisi.',
                    'is_unique' => 'Username sudah digunakan.',
                ],
            ],
            'email' => [
                'rules'  => "required|valid_email|is_unique[users.email,id,{$id}]",
                'errors' => [
                    'required'    => 'Email harus diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah digunakan.',
                ],
            ],
        ])) {
            return redirect()->to('/profile')->withInput();
        }

        $this->usersModel->update($id, [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ]);

        session()->setFlashdata('pesan', 'Profil berhasil diperbarui.');
        return redirect()->to('/profile');
    }

    public function ubahPassword()
    {
        $data = [
            'title'      => 'Ubah Password',
            'validation' => session('validation') ?? \Config\Services::validation(),
        ];

        return view('profile/ubah_password', $data);
    }

    public function updatePassword()
    {
        if (!$this->validate([
            'password_lama' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Password lama harus diisi.'],
            ],
            'password_baru' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password baru harus diisi.',
                    'min_length' => 'Password baru minimal 6 karakter.',
                ],
            ],
            'konfirmasi_password' => [
                'rules'  => 'required|matches[password_baru]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi.',
                    'matches'  => 'Konfirmasi password tidak cocok dengan password baru.',
                ],
            ],
        ])) {
            return redirect()->to('/profile/ubah-password')->withInput();
        }

        $id          = user_id();
        $currentUser = $this->usersModel->find($id);
        $oldPassword = $this->request->getPost('password_lama');
        $newPassword = $this->request->getPost('password_baru');

        if (!Password::verify($oldPassword, $currentUser['password_hash'])) {
            session()->setFlashdata('error', 'Password lama tidak sesuai.');
            return redirect()->to('/profile/ubah-password');
        }

        $this->usersModel->update($id, [
            'password_hash' => Password::hash($newPassword),
        ]);

        session()->setFlashdata('pesan', 'Password berhasil diubah.');
        return redirect()->to('/profile/ubah-password');
    }
}
