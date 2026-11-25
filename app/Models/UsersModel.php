<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'username', 'password_hash', 'active'];

    public function getUsers($id = false)
    {
        $builder = $this->select('users.id, users.username, users.email, users.active, auth_groups.id AS group_id, auth_groups.name AS role')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');

        if ($id === false) {
            return $builder->orderBy('users.id', 'ASC')->findAll();
        }

        return $builder->where(['users.id' => $id])->first();
    }
}
