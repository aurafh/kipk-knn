<?php

namespace App\Models;

use CodeIgniter\Model;

class DataUjiModel extends Model
{
    protected $table            = 'data_uji';
    protected $primaryKey       = 'id';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'id_peserta', 'id_prodi', 'id_sekolah', 'skor_nilai_seleksi', 'skor_nilai_wawancara', 'skor_nilai_kondisi_ekonomi',
        'skor_nilai_hasil_survey', 'skor_prestasi_akademik', 'skor_nilai_prestasi_non_akademik', 'label', 'id_periode'
    ];

    public function getSeleksi($num, $periode)
    {
        $builder = $this->builder();
        $builder->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
            ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')
            ->where('data_uji.id_periode =', $periode);
        $seleksi = $this->paginate($num);
        $pager = $this->pager;
        return [
            'seleksi' => $seleksi,
            'pager' => $pager,
            'cekData' => !empty($seleksi)
        ];
    }
    public function getID($id)
    {
        return $this->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
            ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')->where('id', $id)->first();
    }
    public function getID_Periode($id, $periode)
    {
        return $this->select('prodi.*,data_uji.*,data_peserta.no_pendaftaran,data_peserta.nama_siswa, 
        data_peserta.ranking, data_peserta.akumulasi, data_peserta.keterangan')
            ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
            ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->where('data_uji.id_periode =', $periode)
            ->where('data_peserta.id_peserta', $id)->first();
    }

    public function getPeriode($periode)
    {
        $builder = $this->db->table('data_uji');
        $builder->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')
            ->where('data_uji.id_periode =', $periode)
            ->where('data_uji.label', null);
        $query = $builder->get();
        return $query->getResult();
    }
    public function getAkum($periode)
    {
        $builder = $this->db->table('data_uji');
        $builder->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')
            ->where('data_uji.id_periode', $periode)
            ->where('data_uji.label !=', null);
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getDataPeriode($periode)
    {
        return $this->select('data_uji.*,prodi.*, asal_sekolah.*, data_peserta.no_pendaftaran, data_peserta.nama_siswa')
            ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')
            ->where('data_uji.id_periode =', $periode)->findAll();
    }

    public function getOrder($periode, $search, $num)
    {

        $builder = $this->builder();
        $builder->select('data_uji.*,prodi.*, asal_sekolah.*, data_peserta.no_pendaftaran, 
        data_peserta.nama_siswa, data_peserta.ranking, data_peserta.akumulasi, data_peserta.keterangan')
            ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
            ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')
            ->where('data_uji.id_periode', $periode);

        if ($search != '') {
            $builder->like('data_peserta.no_pendaftaran', $search);
            $builder->orLike('data_peserta.nama_siswa', $search);
            $builder->orLike('prodi.nama_prodi', $search);
            $builder->orLike('asal_sekolah.jenis_sekolah', $search);
            $builder->orLike('data_uji.label', $search);
            $builder->where('data_uji.id_periode', $periode);
        }
        // 
        // if (!empty($informatika)) {
        //     $data_sorted_layak = $builder->where('data_uji.label', 'Layak')
        //         ->where('prodi.nama_prodi', 'Teknik Informatika')
        //         ->where('data_peserta.keterangan =', null)
        //         ->orderBy('data_peserta.akumulasi', 'desc')->get()->getResultArray();
        //     if ($informatika <= count($data_sorted_layak)) {
        //         rsort($data_sorted_layak);
        //         $data_hasil = array_slice($data_sorted_layak, 0, $informatika);
        //     } else {
        //         $data_sorted_tidak = $builder->select('data_uji.*,prodi.*, asal_sekolah.*, data_peserta.no_pendaftaran, data_peserta.nama_siswa,
        //         data_peserta.ranking, data_peserta.akumulasi, data_peserta.keterangan')
        //             ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
        //             ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
        //             ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')
        //             ->where('data_uji.id_periode =', $periode)
        //             ->where('data_uji.label =', 'Tidak Layak')
        //             ->where('prodi.nama_prodi =', 'Teknik Informatika')
        //             ->orderBy('data_peserta.akumulasi', 'desc')->get()->getResultArray();
        //         $data_hasil = $data_sorted_layak;
        //         $kurang = $informatika - count($data_sorted_layak);
        //         rsort($data_sorted_tidak);
        //         $data_hasil = array_merge($data_hasil, array_slice($data_sorted_tidak, 0, $kurang));
        //     }
        // }

        $paginate = $this->paginate($num);
        $pager = $this->pager;
        return [
            // 'prodi' => $prodi,
            'periode' => $periode,
            'searched' => !empty($search),
            'seleksi' => $paginate,
            'pager' => $pager,
            'cekData' => !empty($paginate),
        ];
    }

    public function getFilter($periode, $num, $kuota, $prodi)
    {
        $filterData = [];
        if (!empty($kuota)) {
            // $prodi = $this->db->table('prodi');
            foreach ($prodi as $prodiItem) {
                // dd($kuotaProdi);
                if (isset($kuota[$prodiItem])) {
                    $kuotaProdi = ($kuota[$prodiItem] == null) ? 0 : $kuota[$prodiItem];
                    $query = $this->builder();
                    $data = $query->select('data_uji.*,prodi.*, asal_sekolah.*, data_peserta.no_pendaftaran, data_peserta.nama_siswa,data_peserta.nama_sekolah,
                            data_peserta.ranking, data_peserta.akumulasi, data_peserta.keterangan')
                        ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
                        ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta')
                        ->join('asal_sekolah', 'asal_sekolah.id_sekolah=data_uji.id_sekolah')
                        ->where('data_uji.id_periode', $periode)
                        ->where('data_uji.label', 'Layak')
                        ->where('data_peserta.keterangan', null)
                        ->where('prodi.nama_prodi', $prodiItem)
                        ->orderBy('data_peserta.akumulasi', 'desc')->get()->getResultArray();
                    $temptRata = [];
                    foreach ($data as $akum) {
                        $temptRata[] = [
                            'id_peserta' => $akum['id_peserta'],
                            'rata-rata' => $akum['akumulasi'],
                            'no_pendaftaran' => $akum['no_pendaftaran'],
                            'nama_siswa' => $akum['nama_siswa'],
                            'nama_prodi' => $akum['nama_prodi'],
                            'skor_nilai_seleksi' => $akum['skor_nilai_seleksi'],
                            'skor_nilai_wawancara' => $akum['skor_nilai_wawancara'],
                            'skor_nilai_kondisi_ekonomi' => $akum['skor_nilai_kondisi_ekonomi'],
                            'skor_prestasi_akademik' => $akum['skor_prestasi_akademik'],
                            'skor_nilai_prestasi_non_akademik' => $akum['skor_nilai_prestasi_non_akademik'],
                            'skor_nilai_hasil_survey' => $akum['skor_nilai_hasil_survey'],
                            'label' => $akum['label'],
                            'akumulasi' => $akum['akumulasi'],
                            'ranking' => $akum['ranking'],
                            'keterangan' => $akum['keterangan'],
                        ];
                    }
                    usort($temptRata, function ($a, $b) {
                        return $b['rata-rata'] <=> $a['rata-rata'];
                    });
                    $filterData = array_merge($filterData, array_slice($temptRata, 0, $kuotaProdi));
                }
            }
            usort($filterData, function ($a, $b) {
                return $b['rata-rata'] <=> $a['rata-rata'];
            });
        }
        $page = $this->paginate($num);
        $pager = $this->pager;
        return [
            'periode' => $periode,
            'data' => !empty($filterData),
            'seleksi' => $filterData,
            'pager' => $pager,
            'cekData' => !empty($filterData),

        ];
    }
    public function getData($periode, $search, $num)
    {
        $builder = $this->builder();
        $builder->select('prodi.*,data_peserta.*,data_uji.id,data_uji.skor_nilai_seleksi,data_uji.skor_nilai_prestasi_non_akademik,
        data_uji.skor_nilai_wawancara,data_uji.skor_nilai_kondisi_ekonomi,data_uji.skor_nilai_hasil_survey,data_uji.skor_prestasi_akademik')
            ->join('prodi', 'prodi.id_prodi=data_uji.id_prodi')
            ->join('data_peserta', 'data_peserta.id_peserta=data_uji.id_peserta');

        if (!empty($periode)) {
            $builder->where('data_peserta.id_periode =', $periode);
        }
        if ($search != '') {
            $builder->like('data_peserta.no_pendaftaran', $search);
            $builder->orLike('data_peserta.nama_siswa', $search);
            $builder->orLike('prodi.nama_prodi', $search);
            $builder->orLike('data.peserta.nama_sekolah', $search);
            $builder->orLike('data_peserta.label', $search);
            if (!empty($periode)) {
                $builder->where('data_peserta.id_periode =', $periode);
            }
        }

        $paginate = $this->paginate($num);
        $pager = $this->pager;
        $tahun = $this->db->table('periode')->get()->getResultArray();
        return [
            'searched' => !empty($search),
            'tahun' => $tahun,
            'seleksi' => $paginate,
            'pager' => $pager,
            'cekData' => !empty($paginate),
        ];
    }
}
