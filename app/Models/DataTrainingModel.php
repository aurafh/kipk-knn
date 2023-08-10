<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\ErrorHandler\Collecting;

class DataTrainingModel extends Model
{
    protected $table = 'data_training';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'no_pendaftaran', 'nama_siswa', 'id_prodi',
        'id_sekolah', 'skor_nilai_seleksi', 'skor_nilai_wawancara', 'skor_nilai_kondisi_ekonomi', 'skor_nilai_hasil_survey',
        'skor_prestasi_akademik', 'skor_nilai_prestasi_non_akademik', 'label'
    ];

    public function getTraining($id)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
    public function getAll()
    {
        $builder = $this->db->table('data_training');
        $builder->join('prodi', 'prodi.id_prodi=data_training.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_training.id_sekolah');
        $query = $builder->get();
        return $query->getResult();
    }


    public function deleteMultiple($item_ids)
    {
        $this->db->table('data_training')->where('id', $item_ids)->delete($item_ids);
    }

    public function getPage($num, $search, $column, $type, $column2 = null, $type2 = null)
    {
        $builder = $this->builder();
        $builder->join('prodi', 'prodi.id_prodi=data_training.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_training.id_sekolah');
        if ($search != '') {
            $builder->like('no_pendaftaran', $search);
            $builder->orLike('nama_siswa', $search);
            $builder->orLike('nama_prodi', $search);
            $builder->orLike('jenis_sekolah', $search);
            $builder->orLike('label', $search);
        }
        if (!empty($column) && !empty($type)) {
            $builder->orderBy($column, $type);
        }
        if (!empty($column2) && !empty($type2)) {
            $builder->orderBy($column, $type);
            $builder->orderBy($column2, $type2);
        }
        $training = $this->paginate($num);
        $pager = $this->pager;
        return [
            'searched' => !empty($search),
            'training' => $training,
            'pager' => $pager,
        ];
    }
    public function Distance($testData, $k)
    {
        $builder = $this->db->table('data_training')->join('prodi', 'prodi.id_prodi=data_training.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_training.id_sekolah');
        $query = $builder->get()->getResultArray();
        $distances = [];
        foreach ($query as $train) {
            $distance = sqrt(
                pow($testData['pilihan_program_studi'] - $train['nilai_atribut_prodi'], 2) +
                    pow($testData['asal_sekolah'] - $train['nilai_atribut'], 2) +
                    pow($testData['skor_nilai_seleksi'] - $train['skor_nilai_seleksi'], 2) +
                    pow($testData['skor_nilai_wawancara'] - $train['skor_nilai_wawancara'], 2) +
                    pow($testData['skor_nilai_kondisi_ekonomi'] - $train['skor_nilai_kondisi_ekonomi'], 2) +
                    pow($testData['skor_nilai_hasil_survey'] - $train['skor_nilai_hasil_survey'], 2) +
                    pow($testData['skor_prestasi_akademik'] - $train['skor_prestasi_akademik'], 2) +
                    pow($testData['skor_nilai_prestasi_non_akademik'] - $train['skor_nilai_prestasi_non_akademik'], 2)
            );
            $distances[] = [
                'id' => $train['no_pendaftaran'],
                'distance' => $distance,
                'label' => $train['label']
            ];
        }
        // dd($distances);
        usort($distances, function ($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });
        $neighbors = array_slice($distances, 0, $k, true);
        // dd($neighbors);
        return $neighbors;
    }
}
