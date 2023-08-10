<?php

namespace App\Models;

use CodeIgniter\Model;

class TestingNormalized extends Model
{
    protected $useTimestamps = true;
    protected $table            = 'data_testing_normalization';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'no_pendaftaran', 'nama_siswa', 'pilihan_program_studi',
        'asal_sekolah', 'skor_nilai_seleksi', 'skor_nilai_wawancara', 'skor_nilai_kondisi_ekonomi', 'skor_nilai_hasil_survey',
        'skor_prestasi_akademik', 'skor_nilai_prestasi_non_akademik', 'label'
    ];
    public function getPage($num, $search = null)
    {
        $builder = $this->table('data_testing_normalization');
        if ($search != '') {
            $builder->like('no_pendaftaran', $search);
            $builder->orLike('nama_siswa', $search);
            $builder->orLike('label', $search);
        }
        $testing = $this->paginate($num);
        $pager = $this->pager;
        return [
            'norm' => $testing,
            'pager' => $pager,
        ];
    }
    public function saveNorm($data)
    {
        return $this->db->table($this->table)->insertBatch($data);
    }
}
