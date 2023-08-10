<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataUjiModel;
use App\Models\LoginModel;
use App\Models\PeriodeModel;
use App\Models\PesertaModel;
use App\Models\ProdiModel;
use App\Models\SekolahModel;

class Peserta extends BaseController
{
    protected $periodeModel;
    protected $prodiModel;
    protected $sekolahModel;
    protected $pesertaModel;
    protected $userModel;
    protected $seleksiModel;

    public function __construct()
    {
        $this->prodiModel = new ProdiModel();
        $this->sekolahModel = new SekolahModel();
        $this->periodeModel = new PeriodeModel();
        $this->pesertaModel = new PesertaModel();
        $this->userModel = new LoginModel();
        $this->seleksiModel = new DataUjiModel();
    }
    public function index()
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'prodi' => $this->prodiModel->findAll(),
            'sekolah' => $this->sekolahModel->findAll(),
            'periode' => $this->periodeModel->findAll()
        ];
        return view('register', $data);
    }
    public function save()
    {
        if (!$this->validate([
            'bukti' => [
                'rules' => 'uploaded[bukti]',
                'errors' => ['uploaded' => 'Silahkan masukan kartu peserta']
            ]
        ])) {
            return redirect()->to('register')->withInput();
        }
        $fileBukti = $this->request->getFile('bukti');
        $fileBukti->move('files');
        $namaBukti = $fileBukti->getName();
        $peserta = [
            'no_pendaftaran' => $this->request->getVar('no_pendaftaran'),
            'nama_siswa' => $this->request->getVar('nama_siswa'),
            'id_prodi' => $this->request->getVar('id_prodi'),
            'id_sekolah' => $this->request->getVar('id_sekolah'),
            'jenis_kel' => $this->request->getVar('jenis_kel'),
            'nisn' => $this->request->getVar('nisn'),
            'nama_sekolah' => $this->request->getVar('nama_sekolah'),
            'no_wa' => $this->request->getVar('no_wa'),
            'id_periode' => $this->request->getVar('id_periode'),
            'bukti' => $namaBukti,
            'status' => 'WAITING'
        ];
        $password = $this->request->getVar('password');
        $hashPass = password_hash($password, PASSWORD_DEFAULT);
        $akun = [
            'username' => $this->request->getVar('no_pendaftaran'),
            'password' => $hashPass,
            'role' => 'Peserta'
        ];
        //cek data pada database
        $cek = $this->pesertaModel->where($peserta)->first();
        if ($cek) {
            session()->setFlashdata('error', 'Data sudah ada!');
            return redirect()->to('register');
        } else {
            $this->pesertaModel->insert($peserta);
            $this->userModel->insert($akun);
        }

        session()->setFlashdata('pesan', 'Telah berhasil terdaftar. Silahkan coba untuk Login!');
        return redirect()->to('/');
    }
    public function home()
    {
        $session = session();
        $username = $session->get('username');
        $user = $this->pesertaModel->where('no_pendaftaran', $username)->first();
        $data = [
            'user' => $user,
        ];
        return view('Peserta/home', $data);
    }
    public function hasil()
    {
        $session = session();
        $username = $session->get('username');
        $user = $this->pesertaModel->where('no_pendaftaran', $username)->first();
        $label = $user['label'];
        $data = [
            'user' => $user,
            'cekLabel' => !empty($label)
        ];
        return view('Peserta/hasil', $data);
    }
    public function data_pendaftar()
    {
        $periode = $this->request->getVar('periode');
        $search = $this->request->getVar('searching');
        $data = $this->pesertaModel->getData($periode, $search, 5);
        return view('Admin/DataPendaftar/index', $data);
    }
    public function data_seleksi()
    {
        $periode = $this->request->getVar('periode');
        $search = $this->request->getVar('searching');
        $data = $this->seleksiModel->getData($periode, $search, 5);
        return view('Admin/DataSeleksi/index', $data);
    }
}
