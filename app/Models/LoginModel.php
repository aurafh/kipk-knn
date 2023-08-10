<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'users';
    protected $primaryKey       = 'id';
    protected $useTimestamps = true;
    protected $allowedFields    = ['username', 'password', 'role'];
    public function getUserByID($id)
    {
        return $this->where('id', $id)->first();
    }
    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }
    public function updatePassword($id, $newPassword)
    {
        return $this->update($id, ['password' => $newPassword]);
    }
    public function login($username, $password)
    {
        return $this->db->table('users')->where([
            'username' => $username,
            'password' => $password,
        ])->get()->getRowArray();
    }
}
