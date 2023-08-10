<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdiModel;

class Prodi extends BaseController
{
    protected $prodiModel;
    public function __construct()
    {
        $this->prodiModel = new ProdiModel();
    }
    public function index()
    {
        $searching = $this->request->getVar('searching');
        if ($searching) {
            $this->prodiModel->search($searching);
        } else {
            $prodi = $this->prodiModel;
        }
        $prodi = $this->prodiModel->paginate(5);
        $data = [
            'prodi' => $prodi,
            'pager' => $this->prodiModel->pager
        ];
        return view('Admin/Prodi/index', $data);
    }

    public function orderBy()
    {
        $column = $this->request->getVar('column');
        $type = $this->request->getVar('type');
        $orderProdi = $this->prodiModel->orderBy($column, $type)->findAll();
        $data = [
            'prodi' => $orderProdi
        ];
        return view('Admin/Prodi/index', $data);
    }

    public function create()
    {

        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('Admin/Prodi/create', $data);
    }
    public function save()
    {
        if (!$this->validate([
            'nama_prodi' => 'required',
            'nilai_atribut_prodi' => 'required',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('data-prodi-tambah')->withInput()->with('validation', $validation);
        }


        $this->prodiModel->save([
            'nama_prodi' => $this->request->getVar('nama_prodi'),
            'nilai_atribut_prodi' => $this->request->getVar('nilai_atribut_prodi'),

        ]);
        session()->setFlashdata('pesan', 'Data prodi atribut ' . $this->request->getVar('nama_prodi') . ' berhasil ditambahkan!');
        return redirect()->to('data-prodi');
    }
    public function edit($id_prodi)
    {

        $data = [
            'validation' => \Config\Services::validation(),
            'prodi' => $this->prodiModel->getProdi($id_prodi)
        ];
        return view('Admin/Prodi/edit', $data);
    }

    public function update($id_prodi)
    {
        if (!$this->validate([
            'nama_prodi' => 'required',
            'nilai_atribut_prodi' => 'required',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('data-prodi-edit-' . $this->request->getVar('id_prodi'))->withInput()->with('validation', $validation);
        }

        $this->prodiModel->save([
            'id_prodi' => $id_prodi,
            'nama_prodi' => $this->request->getVar('nama_prodi'),
            'nilai_atribut_prodi' => $this->request->getVar('nilai_atribut_prodi'),
        ]);
        session()->setFlashdata('pesan', 'Data prodi atribut ' . $this->request->getVar('nama_prodi') . ' berhasil diubah!');
        return redirect()->to('data-prodi');
    }

    public function delete($id_prodi)
    {
        $this->prodiModel->delete($id_prodi);
        session()->setFlashdata('pesan', 'Data prodi atribut berhasil dihapus!');
        return redirect()->to('data-prodi');
    }
    public function delete_multiple()
    {
        $item_ids = $this->request->getPost('item_ids');
        if (!empty($item_ids)) {
            foreach ($item_ids as $item) {
                $this->prodiModel->delete($item);
            }
            session()->setFlashdata('pesan', 'Data program studi berhasil dihapus!');
            return redirect()->to('data-prodi');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih');
        }
    }
}
