<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AtributModel;
use App\Models\SekolahModel;

class Sekolah extends BaseController
{
    protected $sekolah;
    public function __construct()
    {
        $this->sekolah = new SekolahModel();
    }

    public function index()
    {
        $sekolah = $this->sekolah->paginate(5);

        $data = [
            'sekolah' => $sekolah,
            'pager' => $this->sekolah->pager
        ];
        return view('Admin/Sekolah/index', $data);
    }
    public function orderBy()
    {
        $column = $this->request->getVar('column');
        $type = $this->request->getVar('type');
        $orderSekolah = $this->sekolah->orderBy($column, $type)->findAll();
        $data = [
            'sekolah' => $orderSekolah
        ];
        return view('Admin/Sekolah/index', $data);
    }
    public function create()
    {

        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('Admin/Sekolah/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'jenis_sekolah' => 'required',
            'nilai_atribut' => 'required',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('data-sekolah-tambah')->withInput()->with('validation', $validation);
        }


        $this->sekolah->save([
            'jenis_sekolah' => $this->request->getVar('jenis_sekolah'),
            'nilai_atribut' => $this->request->getVar('nilai_atribut'),

        ]);
        session()->setFlashdata('pesan', 'Data sekolah atribut ' . $this->request->getVar('jenis_sekolah') . ' berhasil ditambahkan!');
        return redirect()->to('data-sekolah');
    }

    public function edit($id_sekolah)
    {

        $data = [
            'validation' => \Config\Services::validation(),
            'sekolah' => $this->sekolah->getSekolah($id_sekolah)
        ];
        return view('Admin/Sekolah/edit', $data);
    }

    public function update($id_sekolah)
    {
        if (!$this->validate([
            'jenis_sekolah' => 'required',
            'nilai_atribut' => 'required',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('data-sekolah-edit-' . $this->request->getVar('id_sekolah'))->withInput()->with('validation', $validation);
        }

        $this->sekolah->save([
            'id_sekolah' => $id_sekolah,
            'jenis_sekolah' => $this->request->getVar('jenis_sekolah'),
            'nilai_atribut' => $this->request->getVar('nilai_atribut'),
        ]);
        session()->setFlashdata('pesan', 'Data sekolah atribut ' . $this->request->getVar('jenis_sekolah') . ' berhasil diubah!');
        return redirect()->to('data-sekolah');
    }

    public function delete($id_sekolah)
    {
        $this->sekolah->delete($id_sekolah);
        session()->setFlashdata('pesan', 'Data sekolah atribut berhasil dihapus!');
        return redirect()->to('data-sekolah');
    }
    public function delete_multiple()
    {
        $item_ids = $this->request->getPost('item_ids');
        if (!empty($item_ids)) {
            foreach ($item_ids as $item) {
                $this->sekolah->delete($item);
            }
            session()->setFlashdata('pesan', 'Data asal sekolah berhasil dihapus!');
            return redirect()->to('data-sekolah');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih');
        }
    }
}
