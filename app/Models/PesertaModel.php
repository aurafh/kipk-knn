<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaModel extends Model
{
    protected $table            = 'data_peserta';
    protected $primaryKey       = 'id_peserta';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'no_pendaftaran', 'nama_siswa', 'jenis_kel', 'nisn', 'no_wa', 'id_prodi', 'id_sekolah',
        'nama_sekolah', 'bukti', 'status', 'label', 'id_periode', 'ranking', 'akumulasi', 'keterangan'
    ];
    public function getAll($num, $periode)
    {
        $builder = $this->builder();
        $builder->join('prodi', 'prodi.id_prodi=data_peserta.id_prodi');
        $builder->where('id_periode', $periode);
        $peserta = $this->paginate($num);
        $pager = $this->pager;
        return [
            'cekData' => !empty($peserta),
            'peserta' => $peserta,
            'pager' => $pager,
        ];
    }
    public function getPesertaStatus($periode)
    {
        return $this->join('prodi', 'prodi.id_prodi=data_peserta.id_prodi')
            ->join('periode', 'periode.id_periode=data_peserta.id_periode')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_peserta.id_sekolah')
            ->where('data_peserta.id_periode =', $periode)
            ->where('status', 'VALIDATE')->findAll();
    }
    public function getPDF($periode)
    {
        return $this->join('prodi', 'prodi.id_prodi=data_peserta.id_prodi')
            ->join('periode', 'periode.id_periode=data_peserta.id_periode')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_peserta.id_sekolah')
            ->where('data_peserta.id_periode =', $periode)
            ->where('status', 'VALIDATE')
            ->where('label =', 'Layak')
            ->where('ranking !=', null)
            ->findAll();
    }
    public function getHasil($periode, $search, $num)
    {
        $builder = $this->builder();
        $builder->join('prodi', 'prodi.id_prodi=data_peserta.id_prodi');
        $builder->where('id_periode =', $periode);
        $builder->where('ranking !=', null);
        $builder->orderBy('data_peserta.id_prodi', 'desc');

        if ($search != '') {
            $builder->like('data_peserta.no_pendaftaran', $search);
            $builder->orLike('data_peserta.nama_siswa', $search);
            $builder->orLike('prodi.nama_prodi', $search);
            $builder->orLike('data.peserta.nama_sekolah', $search);
            $builder->orLike('data_peserta.label', $search);
            $builder->where('id_periode =', $periode);
        }

        $paginate = $this->paginate($num);
        $pager = $this->pager;
        return [
            'searched' => !empty($search),
            'seleksi' => $paginate,
            'pager' => $pager,
            'cekData' => !empty($paginate),
        ];
    }
    public function getData($periode, $search, $num)
    {
        $builder = $this->builder();
        $builder->join('prodi', 'prodi.id_prodi=data_peserta.id_prodi');

        if (!empty($periode)) {
            $builder->where('id_periode =', $periode);
        }

        if ($search != '') {
            $builder->like('data_peserta.no_pendaftaran', $search);
            $builder->orLike('data_peserta.nama_siswa', $search);
            $builder->orLike('prodi.nama_prodi', $search);
            $builder->orLike('data.peserta.nama_sekolah', $search);
            $builder->orLike('data_peserta.label', $search);
            if (!empty($periode)) {
                $builder->where('id_periode =', $periode);
            }
        }

        $paginate = $this->paginate($num);
        $pager = $this->pager;
        $tahun = $this->db->table('periode')->get()->getResultArray();
        return [
            'searched' => !empty($search),
            'tahun' => $tahun,
            'pendaftar' => $paginate,
            'pager' => $pager,
            'cekData' => !empty($paginate),
        ];
    }
    public function getNilai($no)
    {
        return $this->where('no_pendaftaran =', $no)->find();
    }
}
