<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingNormalized extends Model
{
    protected $useTimestamps = true;
    protected $table            = 'data_training_normalization';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'no_pendaftaran', 'nama_siswa', 'pilihan_program_studi',
        'asal_sekolah', 'skor_nilai_seleksi', 'skor_nilai_wawancara', 'skor_nilai_kondisi_ekonomi', 'skor_nilai_hasil_survey',
        'skor_prestasi_akademik', 'skor_nilai_prestasi_non_akademik', 'label'
    ];
    public function getPage($num, $search = null)
    {
        $builder = $this->table('data_training_normalization');
        if ($search != '') {
            $builder->like('no_pendaftaran', $search);
            $builder->orLike('nama_siswa', $search);
            $builder->orLike('label', $search);
        }
        $training = $this->paginate($num);
        $pager = $this->pager;
        return [
            'norm' => $training,
            'pager' => $pager,
        ];
    }
    public function Distance($testData, $k)
    {
        $query = $this->select('id,no_pendaftaran, nama_siswa, pilihan_program_studi,
        asal_sekolah, skor_nilai_seleksi, skor_nilai_wawancara, skor_nilai_kondisi_ekonomi, skor_nilai_hasil_survey,
        skor_prestasi_akademik, skor_nilai_prestasi_non_akademik, label')->findAll();
        $distances = [];
        foreach ($query as $train) {
            $distance = sqrt(
                pow($testData['pilihan_program_studi'] - $train['pilihan_program_studi'], 2) +
                    pow($testData['asal_sekolah'] - $train['asal_sekolah'], 2) +
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

    public function getDataCriteria($data)
    {
        $query = $this->db->table('data_training_normalization')->where($data)->get();
        return ($query->getRow());
    }
}
