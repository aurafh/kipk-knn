<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\PesertaModel;

/**
 * @property string $password
 */
class Login extends BaseController
{
    protected $user;
    protected $peserta;
    protected $session;
    public function __construct()
    {
        $this->user = new LoginModel();
        $this->peserta = new PesertaModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {

        return view('index');
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->user->where('username', $username)->first();
        if ($user && password_verify($password, $user['password'])) {
            $isi = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];
            $session = session();
            $session->set($isi);

            if ($user['role'] === 'Admin') {
                return redirect()->to('dashboard');
            } elseif ($user['role'] === 'Operator') {
                return redirect()->to('periode');
            } elseif ($user['role'] === 'Peserta') {
                return redirect()->to('home');
            }
        } else {
            return redirect()->back()->with('error', 'Username atau Password salah!');
        }
    }

    public function logout()
    {
        session()->remove('id');
        session()->remove('username');
        session()->remove('role');
        session()->remove('selectedPeriode');
        // session()->destroy();
        return redirect()->to('/');
    }
    public function edit($id)
    {
        $user = $this->user->getUserByID($id);
        return view('editProfile', ['user' => $user]);
    }
    public function update()
    {
        $id = $this->request->getPost('id');
        $username = $this->request->getVar('username');
        $password_lama = $this->request->getVar('password_lama');
        $newPassword = $this->request->getVar('password_baru');
        $userData = ['username' => $username];
        $this->user->updateUser($id, $userData);

        if (!empty($newPassword)) {
            $user = $this->user->getUserByID($id);
            if (password_verify($password_lama, $user['password'])) {
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->user->updatePassword($id, $newPasswordHash);
            } else {
                return redirect()->back()->withInput()->with('error', 'Password lama salah!');
            }
        }
        return redirect()->to('/')->withInput()->with('pesan', "Data user berhasil diubah! Silahkan Sign In kembali!");
    }
}
