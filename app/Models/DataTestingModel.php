<?php

namespace App\Models;

use CodeIgniter\Model;

class DataTestingModel extends Model
{
    protected $table            = 'data_testing';
    protected $primaryKey       = 'id';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'no_pendaftaran', 'nama_siswa', 'id_prodi',
        'id_sekolah', 'skor_nilai_seleksi', 'skor_nilai_wawancara', 'skor_nilai_kondisi_ekonomi', 'skor_nilai_hasil_survey',
        'skor_prestasi_akademik', 'skor_nilai_prestasi_non_akademik', 'label', 'prediksi'
    ];

    public function getTesting($id)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }

    public function getAll()
    {
        $builder = $this->db->table('data_testing');
        $builder->join('prodi', 'prodi.id_prodi=data_testing.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_testing.id_sekolah');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getOrders($sortColumns)
    {
        $builder = $this->db->table('data_testing');
        $builder->join('prodi', 'prodi.id_prodi=data_testing.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_testing.id_sekolah');
        if (count($sortColumns) > 0) {
            foreach ($sortColumns as $column) {
                $builder->orderBy($column['column'], $column['type']);
            }
        }
        return $builder->get()->getResult();
    }
    public function deleteMultiple($item_ids)
    {
        $this->db->table('data_testing')->where('id', $item_ids)->delete($item_ids);
    }

    public function getPage($num, $search, $column, $type, $column2 = null, $type2 = null)
    {
        $builder = $this->builder();
        $builder->join('prodi', 'prodi.id_prodi=data_testing.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_testing.id_sekolah');
        if ($search != '') {
            $builder->like('no_pendaftaran', $search);
            $builder->orLike('nama_siswa', $search);
            $builder->orLike('nama_prodi', $search);
            $builder->orLike('jenis_sekolah', $search);
            $builder->orLike('prediksi', $search);
            $builder->orLike('label', $search);
        }
        if (!empty($column) && !empty($type)) {
            $builder->orderBy($column, $type);
        }
        if (!empty($column2) && !empty($type2)) {
            $builder->orderBy($column, $type);
            $builder->orderBy($column2, $type2);
        }
        $testing = $this->paginate($num);
        $pager = $this->pager;
        $query = $this->select('label,prediksi')->findAll();
        $true = 0;
        $false = 0;
        foreach ($query as $uji) {
            $asli = $uji['label'];
            $prediksi = $uji['prediksi'];
            if ($prediksi == $asli) {
                $true++;
            } else {
                $false++;
            }
        }
        // dd($true);
        $jumlah_data = count($query);
        if ($true != 0) {
            $presentaseTrue = round(($true / $jumlah_data) * 100, 2);
        } else {
            $presentaseFalse = 0;
        }
        return [
            'searched' => !empty($search),
            'testing' => $testing,
            'akurasi' => ($true != 0) ? $presentaseTrue : $presentaseFalse,
            'pager' => $pager,
        ];
    }
}
