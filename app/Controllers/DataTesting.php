<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataTestingModel;
use App\Models\DataTrainingModel;
use App\Models\PeriodeModel;
use App\Models\ProdiModel;
use App\Models\SekolahModel;
use App\Models\TestingNormalized;
use App\Models\TrainingNormalized;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Averages;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataTesting extends BaseController
{
    protected $trainingModel;
    protected $testingModel;
    protected $prodiModel;
    protected $sekolahModel;
    protected $testNorm;
    protected $periode;
    protected $normalized;
    public function __construct()
    {
        $this->trainingModel = new DataTrainingModel();
        $this->testingModel = new DataTestingModel();
        $this->prodiModel = new ProdiModel();
        $this->sekolahModel = new SekolahModel();
        $this->testNorm = new TestingNormalized();
        $this->normalized = new TrainingNormalized();
        $this->periode = new PeriodeModel();
    }

    public function index()
    {

        $search = $this->request->getVar('searching');
        $column = $this->request->getVar('column');
        $type = $this->request->getVar('type');
        $column2 = $this->request->getVar('column2');
        $type2 = $this->request->getVar('type2');
        $data =  $this->testingModel->getPage(5, $search, $column, $type, $column2, $type2);
        return view('Admin/DataTesting/index', $data);
    }

    public function create()
    {

        $data = [
            'validation' => \Config\Services::validation(),
            'prodi' => $this->prodiModel->findAll(),
            'sekolah' => $this->sekolahModel->findAll()
        ];
        return view('Admin/DataTesting/create', $data);
    }

    public function prediksi()
    {
        $test = [
            'no_pendaftaran' => $this->request->getVar('no_pendaftaran'),
            'nama_siswa' => $this->request->getVar('nama_siswa'),
            'id_prodi' => $this->request->getVar('id_prodi'),
            'id_sekolah' => $this->request->getVar('id_sekolah'),
            'skor_nilai_seleksi' => $this->request->getVar('skor_nilai_seleksi'),
            'skor_nilai_wawancara' => $this->request->getVar('skor_nilai_wawancara'),
            'skor_nilai_kondisi_ekonomi' => $this->request->getVar('skor_nilai_kondisi_ekonomi'),
            'skor_nilai_hasil_survey' => $this->request->getVar('skor_nilai_hasil_survey'),
            'skor_prestasi_akademik' => $this->request->getVar('skor_prestasi_akademik'),
            'skor_nilai_prestasi_non_akademik' => $this->request->getVar('skor_nilai_prestasi_non_akademik'),
        ];
        $k = $this->request->getVar('jumlah_k'); //ambil data jumlah k
        //cek data pada database
        $cek = $this->testingModel->where($test)->first();
        if ($cek) {
            session()->setFlashdata('error', 'Data testing sudah ada!');
            return redirect()->to('data-testing');
        } else {
            $this->testingModel->insert($test);
            $this->trainingModel->insert($test);
        }

        $data = $this->trainingModel->getAll();
        $prodi_min = min(array_column($data, 'nilai_atribut_prodi'));
        $prodi_max = max(array_column($data, 'nilai_atribut_prodi'));
        $sekolah_max = max(array_column($data, 'nilai_atribut'));
        $sekolah_min = min(array_column($data, 'nilai_atribut'));
        $seleksi_min = min(array_column($data, 'skor_nilai_seleksi'));
        $seleksi_max = max(array_column($data, 'skor_nilai_seleksi'));
        $ekonomi_max = max(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        $ekonomi_min = min(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        $wawancara_min = min(array_column($data, 'skor_nilai_wawancara'));
        $wawancara_max = max(array_column($data, 'skor_nilai_wawancara'));
        $survey_max = max(array_column($data, 'skor_nilai_hasil_survey'));
        $survey_min = min(array_column($data, 'skor_nilai_hasil_survey'));
        $akademik_min = min(array_column($data, 'skor_prestasi_akademik'));
        $akademik_max = max(array_column($data, 'skor_prestasi_akademik'));
        $non_max = max(array_column($data, 'skor_nilai_prestasi_non_akademik'));
        $non_min = min(array_column($data, 'skor_nilai_prestasi_non_akademik'));

        $nilai_uji = $this->testingModel->getAll();
        foreach ($nilai_uji as $key => $uji) {
            //min max norm if condition
            $no_pendaftaran = $uji->no_pendaftaran;
            $nama_siswa = $uji->nama_siswa;
            $nilai_atribut_prodi = ($uji->nilai_atribut_prodi - $prodi_min != 0) ? round((($uji->nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3) : 0;
            $nilai_atribut = round((($uji->nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3);
            $skor_nilai_seleksi = round((($uji->skor_nilai_seleksi - $seleksi_min) / ($seleksi_max - $seleksi_min)) * (1 - 0) + 0, 3);
            $skor_nilai_kondisi_ekonomi = round((($uji->skor_nilai_kondisi_ekonomi - $ekonomi_min) / ($ekonomi_max - $ekonomi_min)) * (1 - 0) + 0, 3);
            $skor_nilai_wawancara = round((($uji->skor_nilai_wawancara - $wawancara_min) / ($wawancara_max - $wawancara_min)) * (1 - 0) + 0, 3);
            $skor_nilai_hasil_survey = round((($uji->skor_nilai_hasil_survey - $survey_min) / ($survey_max - $survey_min)) * (1 - 0) + 0, 3);
            $skor_prestasi_akademik = round((($uji->skor_prestasi_akademik - $akademik_min) / ($akademik_max - $akademik_min)) * (1 - 0) + 0, 3);
            $skor_nilai_prestasi_non_akademik = round((($uji->skor_nilai_prestasi_non_akademik - $non_min) / ($non_max - $non_min)) * (1 - 0) + 0, 3);
        }

        $this->testNorm->insert([
            'no_pendaftaran' => $no_pendaftaran,
            'nama_siswa' => $nama_siswa,
            'pilihan_program_studi' => $nilai_atribut_prodi,
            'asal_sekolah' => $nilai_atribut,
            'skor_nilai_seleksi' => $skor_nilai_seleksi,
            'skor_nilai_wawancara' => $skor_nilai_wawancara,
            'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
            'skor_prestasi_akademik' => $skor_prestasi_akademik,
            'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
            'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey
        ]);

        $testData = [
            'pilihan_program_studi' => $nilai_atribut_prodi,
            'asal_sekolah' => $nilai_atribut,
            'skor_nilai_seleksi' => $skor_nilai_seleksi,
            'skor_nilai_wawancara' => $skor_nilai_wawancara,
            'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
            'skor_prestasi_akademik' => $skor_prestasi_akademik,
            'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
            'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey
        ];


        $neighbors = $this->normalized->Distance($testData, $k);
        $labelCounts = array_count_values(array_column($neighbors, 'label'));
        $dominantLabel = array_search(max($labelCounts), $labelCounts);

        //update label di database
        $domLabel = ($dominantLabel == '1') ? 'Layak' : 'Tidak Layak';
        $this->testingModel->where(['no_pendaftaran' => $no_pendaftaran, 'nama_siswa' => $nama_siswa])->set(['label' => ($dominantLabel == '1') ? 'Layak' : 'Tidak Layak'])->update();
        $this->trainingModel->where(['no_pendaftaran' => $no_pendaftaran, 'nama_siswa' => $nama_siswa])->set(['label' => ($dominantLabel == '1') ? 'Layak' : 'Tidak Layak'])->update();
        $this->testNorm->where(['no_pendaftaran' => $no_pendaftaran, 'nama_siswa' => $nama_siswa])->set(['label' => $dominantLabel])->update();
        $this->normalized->insert([
            'no_pendaftaran' => $no_pendaftaran,
            'nama_siswa' => $nama_siswa,
            'pilihan_program_studi' => $nilai_atribut_prodi,
            'asal_sekolah' => $nilai_atribut,
            'skor_nilai_seleksi' => $skor_nilai_seleksi,
            'skor_nilai_wawancara' => $skor_nilai_wawancara,
            'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
            'skor_prestasi_akademik' => $skor_prestasi_akademik,
            'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
            'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey,
            'label' => $dominantLabel
        ]);


        $knn = [
            'validation' => \Config\Services::validation(),
            'sekolah' => $this->sekolahModel->findAll(),
            'prodi' => $this->prodiModel->findAll(),
            'test' => $this->request->getVar(),
            'knn' => $neighbors,
            'dominan' => $domLabel

        ];
        return view('Admin/DataTesting/hasil', $knn);
    }

    public function edit($id)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'sekolah' => $this->sekolahModel->findAll(),
            'prodi' => $this->prodiModel->findAll(),
            'testing' => $this->testingModel->getTesting($id)
        ];
        return view('Admin/DataTesting/edit', $data);
    }

    public function update($id)
    {

        $this->testingModel->save([
            'id' => $id,
            'no_pendaftaran' => $this->request->getVar('no_pendaftaran'),
            'nama_siswa' => $this->request->getVar('nama_siswa'),
            'id_prodi' => $this->request->getVar('id_prodi'),
            'id_sekolah' => $this->request->getVar('id_sekolah'),
            'skor_nilai_seleksi' => $this->request->getVar('skor_nilai_seleksi'),
            'skor_nilai_wawancara' => $this->request->getVar('skor_nilai_wawancara'),
            'skor_nilai_kondisi_ekonomi' => $this->request->getVar('skor_nilai_kondisi_ekonomi'),
            'skor_nilai_hasil_survey' => $this->request->getVar('skor_nilai_hasil_survey'),
            'skor_prestasi_akademik' => $this->request->getVar('skor_prestasi_akademik'),
            'skor_nilai_prestasi_non_akademik' => $this->request->getVar('skor_nilai_prestasi_non_akademik'),
            'label' => $this->request->getVar('label'),
            'prediksi' => $this->request->getVar('prediksi'),
        ]);

        $data = $this->trainingModel->getAll();
        $prodi_min = min(array_column($data, 'nilai_atribut_prodi'));
        $prodi_max = max(array_column($data, 'nilai_atribut_prodi'));
        $sekolah_max = max(array_column($data, 'nilai_atribut'));
        $sekolah_min = min(array_column($data, 'nilai_atribut'));
        $seleksi_min = min(array_column($data, 'skor_nilai_seleksi'));
        $seleksi_max = max(array_column($data, 'skor_nilai_seleksi'));
        $ekonomi_max = max(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        $ekonomi_min = min(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        $wawancara_min = min(array_column($data, 'skor_nilai_wawancara'));
        $wawancara_max = max(array_column($data, 'skor_nilai_wawancara'));
        $survey_max = max(array_column($data, 'skor_nilai_hasil_survey'));
        $survey_min = min(array_column($data, 'skor_nilai_hasil_survey'));
        $akademik_min = min(array_column($data, 'skor_prestasi_akademik'));
        $akademik_max = max(array_column($data, 'skor_prestasi_akademik'));
        $non_max = max(array_column($data, 'skor_nilai_prestasi_non_akademik'));
        $non_min = min(array_column($data, 'skor_nilai_prestasi_non_akademik'));

        $nilai_uji = $this->testingModel->getAll();
        foreach ($nilai_uji as $key => $uji) {
            //min max norm if condition
            $no_pendaftaran = $uji->no_pendaftaran;
            $nama_siswa = $uji->nama_siswa;
            $nilai_atribut_prodi = ($uji->nilai_atribut_prodi - $prodi_min != 0) ? round((($uji->nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3) : 0;
            $nilai_atribut = round((($uji->nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3);
            $skor_nilai_seleksi = round((($uji->skor_nilai_seleksi - $seleksi_min) / ($seleksi_max - $seleksi_min)) * (1 - 0) + 0, 3);
            $skor_nilai_kondisi_ekonomi = round((($uji->skor_nilai_kondisi_ekonomi - $ekonomi_min) / ($ekonomi_max - $ekonomi_min)) * (1 - 0) + 0, 3);
            $skor_nilai_wawancara = round((($uji->skor_nilai_wawancara - $wawancara_min) / ($wawancara_max - $wawancara_min)) * (1 - 0) + 0, 3);
            $skor_nilai_hasil_survey = round((($uji->skor_nilai_hasil_survey - $survey_min) / ($survey_max - $survey_min)) * (1 - 0) + 0, 3);
            $skor_prestasi_akademik = round((($uji->skor_prestasi_akademik - $akademik_min) / ($akademik_max - $akademik_min)) * (1 - 0) + 0, 3);
            $skor_nilai_prestasi_non_akademik = round((($uji->skor_nilai_prestasi_non_akademik - $non_min) / ($non_max - $non_min)) * (1 - 0) + 0, 3);
            $label = ($uji->label == 'Tidak Layak') ? '0' : '1';
        }
        $norm = [
            'id' => $id,
            'no_pendaftaran' => $no_pendaftaran,
            'nama_siswa' => $nama_siswa,
            'pilihan_program_studi' => $nilai_atribut_prodi,
            'asal_sekolah' => $nilai_atribut,
            'skor_nilai_seleksi' => $skor_nilai_seleksi,
            'skor_nilai_wawancara' => $skor_nilai_wawancara,
            'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
            'skor_prestasi_akademik' => $skor_prestasi_akademik,
            'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
            'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey,
            'label' => $label
        ];
        //cek data pada database
        $cek = $this->testNorm->where($norm)->first();
        if ($cek) {
            session()->setFlashdata('error', 'Data training sudah ada!');
            return redirect()->to('data-testing');
        } else {
            $this->testNorm->save($norm);
        }
        session()->setFlashdata('pesan', 'Data testing ' . $this->request->getVar('nama_siswa') . ' berhasil ditambahkan!');
        return redirect()->to('data-testing');
    }

    public function delete($id)
    {
        $this->testingModel->delete($id);
        $this->testNorm->delete($id);
        session()->setFlashdata('pesan', 'Data testing berhasil dihapus!');
        return redirect()->to('data-testing');
    }
    public function delete_multiple()
    {
        $item_ids = $this->request->getPost('item_ids');
        if (!empty($item_ids)) {
            foreach ($item_ids as $item) {
                $this->testingModel->delete($item);
                $this->testNorm->delete($item);
            }
            session()->setFlashdata('pesan', 'Data testing berhasil dihapus!');
            return redirect()->to('data-testing');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih');
        }
    }


    public function import()
    {
        $data = [
            'periode' => $this->periode->findAll()
        ];
        return view('Admin/DataTesting/import', $data);
    }

    public function hasil()
    {
        $testModel = $this->testingModel->getAll();
        if (empty($testModel)) {
            session()->setFlashdata('error', "Data testing kosong!");
            return redirect()->to('data-testing');
        }
        $data = $this->trainingModel->getAll();
        $prodi_min = min(array_column($data, 'nilai_atribut_prodi'));
        $prodi_max = max(array_column($data, 'nilai_atribut_prodi'));
        $sekolah_max = max(array_column($data, 'nilai_atribut'));
        $sekolah_min = min(array_column($data, 'nilai_atribut'));
        $seleksi_min = min(array_column($data, 'skor_nilai_seleksi'));
        $seleksi_max = max(array_column($data, 'skor_nilai_seleksi'));
        $ekonomi_max = max(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        $ekonomi_min = min(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        $wawancara_min = min(array_column($data, 'skor_nilai_wawancara'));
        $wawancara_max = max(array_column($data, 'skor_nilai_wawancara'));
        $survey_max = max(array_column($data, 'skor_nilai_hasil_survey'));
        $survey_min = min(array_column($data, 'skor_nilai_hasil_survey'));
        $akademik_min = min(array_column($data, 'skor_prestasi_akademik'));
        $akademik_max = max(array_column($data, 'skor_prestasi_akademik'));
        $non_max = max(array_column($data, 'skor_nilai_prestasi_non_akademik'));
        $non_min = min(array_column($data, 'skor_nilai_prestasi_non_akademik'));

        $testData = $this->testingModel->getAll();
        foreach ($testData as $row) {
            $no_pendaftaran = $row->no_pendaftaran;
            $nama_siswa = $row->nama_siswa;
            $nilai_atribut_prodi = ($row->nilai_atribut_prodi - $prodi_min <= 0) ? 0 : round((($row->nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3);
            $nilai_atribut = ($row->nilai_atribut - $sekolah_min <= 0) ? 0 : round((($row->nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3);
            $skor_nilai_seleksi = ($row->skor_nilai_seleksi - $seleksi_min <= 0) ? 0 : round((($row->skor_nilai_seleksi - $seleksi_min) / (($row->skor_nilai_seleksi >= $seleksi_max) ? ($row->skor_nilai_seleksi - $seleksi_min) : ($seleksi_max - $seleksi_min))) * (1 - 0) + 0, 3);
            $skor_nilai_kondisi_ekonomi = ($row->skor_nilai_kondisi_ekonomi - $ekonomi_min <= 0) ? 0 : round((($row->skor_nilai_kondisi_ekonomi - $ekonomi_min) / (($row->skor_nilai_kondisi_ekonomi >= $ekonomi_max) ? ($row->skor_nilai_kondisi_ekonomi - $ekonomi_min) : ($ekonomi_max - $ekonomi_min))) * (1 - 0) + 0, 3);
            $skor_nilai_wawancara = ($row->skor_nilai_wawancara - $wawancara_min <= 0) ? 0 : round((($row->skor_nilai_wawancara - $wawancara_min) / (($row->skor_nilai_wawancara >= $wawancara_max) ? ($row->skor_nilai_wawancara - $wawancara_min) : ($wawancara_max - $wawancara_min))) * (1 - 0) + 0, 3);
            $skor_nilai_hasil_survey = ($row->skor_nilai_hasil_survey - $survey_min <= 0) ? 0 : round((($row->skor_nilai_hasil_survey - $survey_min) / (($row->skor_nilai_hasil_survey >= $survey_max) ? ($row->skor_nilai_hasil_survey - $survey_min) : ($survey_max - $survey_min))) * (1 - 0) + 0, 3);
            $skor_prestasi_akademik = ($row->skor_prestasi_akademik - $akademik_min <= 0) ? 0 : round((($row->skor_prestasi_akademik - $akademik_min) / (($row->skor_prestasi_akademik >= $akademik_max) ? ($row->skor_prestasi_akademik - $akademik_min) : ($akademik_max - $akademik_min))) * (1 - 0) + 0, 3);
            $skor_nilai_prestasi_non_akademik = ($row->skor_nilai_prestasi_non_akademik - $non_min <= 0) ? 0 : round((($row->skor_nilai_prestasi_non_akademik - $non_min) / (($row->skor_nilai_prestasi_non_akademik >= $non_max) ? ($row->skor_nilai_prestasi_non_akademik - $non_min) : ($non_max - $non_min))) * (1 - 0) + 0, 3);

            $saveNorm = [
                'no_pendaftaran' => $no_pendaftaran,
                'nama_siswa' => $nama_siswa,
                'pilihan_program_studi' => $nilai_atribut_prodi,
                'asal_sekolah' => $nilai_atribut,
                'skor_nilai_seleksi' => $skor_nilai_seleksi,
                'skor_nilai_wawancara' => $skor_nilai_wawancara,
                'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
                'skor_prestasi_akademik' => $skor_prestasi_akademik,
                'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
                'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey,
            ];
            $cek = $this->testNorm->where($saveNorm)->first();
            if ($cek == null) {
                $this->testNorm->save($saveNorm);
            }
            $testData = [
                'pilihan_program_studi' => $nilai_atribut_prodi,
                'asal_sekolah' => $nilai_atribut,
                'skor_nilai_seleksi' => $skor_nilai_seleksi,
                'skor_nilai_wawancara' => $skor_nilai_wawancara,
                'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
                'skor_prestasi_akademik' => $skor_prestasi_akademik,
                'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
                'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey
            ];

            $k = 3;
            $neighbors = $this->normalized->Distance($testData, $k);
            $labelCounts = array_count_values(array_column($neighbors, 'label'));
            $dominantLabel = array_search(max($labelCounts), $labelCounts);
            // dd($dominantLabel);

            //update label di database
            $domLabel = ($dominantLabel == '1') ? 'Layak' : 'Tidak Layak';
            $this->testingModel->where(['no_pendaftaran' => $no_pendaftaran, 'nama_siswa' => $nama_siswa])->set(['prediksi' => $domLabel])->update();
            $this->testNorm->where($saveNorm)->set(['label' => $dominantLabel])->update();
            $sekolah = $this->sekolahModel->where('nilai_atribut', $row->nilai_atribut)->first();
            $prodi = $this->prodiModel->where('nilai_atribut_prodi', $row->nilai_atribut_prodi)->first();

            $id_sekolah = $sekolah['id_sekolah'];
            $id_prodi = $prodi['id_prodi'];
            $cek = $this->trainingModel->where([
                'no_pendaftaran' => $row->no_pendaftaran,
                'nama_siswa' => $row->nama_siswa,
                'id_prodi' => $id_prodi,
                'id_sekolah' => $id_sekolah,
                'skor_nilai_seleksi' => $row->skor_nilai_seleksi,
                'skor_nilai_wawancara' => $row->skor_nilai_wawancara,
                'skor_nilai_kondisi_ekonomi' => $row->skor_nilai_kondisi_ekonomi,
                'skor_prestasi_akademik' => $row->skor_prestasi_akademik,
                'skor_nilai_prestasi_non_akademik' => $row->skor_nilai_prestasi_non_akademik,
                'skor_nilai_hasil_survey' => $row->skor_nilai_hasil_survey,
            ])->first();
            if ($cek == null) {
                $this->trainingModel->save([
                    'no_pendaftaran' => $row->no_pendaftaran,
                    'nama_siswa' => $row->nama_siswa,
                    'id_prodi' => $id_prodi,
                    'id_sekolah' => $id_sekolah,
                    'skor_nilai_seleksi' => $row->skor_nilai_seleksi,
                    'skor_nilai_wawancara' => $row->skor_nilai_wawancara,
                    'skor_nilai_kondisi_ekonomi' => $row->skor_nilai_kondisi_ekonomi,
                    'skor_prestasi_akademik' => $row->skor_prestasi_akademik,
                    'skor_nilai_prestasi_non_akademik' => $row->skor_nilai_prestasi_non_akademik,
                    'skor_nilai_hasil_survey' => $row->skor_nilai_hasil_survey,
                    'label' => $domLabel
                ]);
            }

            $dataTrain = $this->normalized->where($saveNorm)->first();
            if ($dataTrain == null) {
                $this->normalized->save([
                    'no_pendaftaran' => $no_pendaftaran,
                    'nama_siswa' => $nama_siswa,
                    'pilihan_program_studi' => $nilai_atribut_prodi,
                    'asal_sekolah' => $nilai_atribut,
                    'skor_nilai_seleksi' => $skor_nilai_seleksi,
                    'skor_nilai_wawancara' => $skor_nilai_wawancara,
                    'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
                    'skor_prestasi_akademik' => $skor_prestasi_akademik,
                    'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
                    'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey,
                    'label' => $dominantLabel
                ]);
            }
        }

        // $newTrain = $this->trainingModel->getAll();
        // $prodi_min = min(array_column($newTrain, 'nilai_atribut_prodi'));
        // $prodi_max = max(array_column($newTrain, 'nilai_atribut_prodi'));
        // $sekolah_max = max(array_column($newTrain, 'nilai_atribut'));
        // $sekolah_min = min(array_column($newTrain, 'nilai_atribut'));
        // $seleksi_min = min(array_column($newTrain, 'skor_nilai_seleksi'));
        // $seleksi_max = max(array_column($newTrain, 'skor_nilai_seleksi'));
        // $ekonomi_max = max(array_column($newTrain, 'skor_nilai_kondisi_ekonomi'));
        // $ekonomi_min = min(array_column($newTrain, 'skor_nilai_kondisi_ekonomi'));
        // $wawancara_min = min(array_column($newTrain, 'skor_nilai_wawancara'));
        // $wawancara_max = max(array_column($newTrain, 'skor_nilai_wawancara'));
        // $survey_max = max(array_column($newTrain, 'skor_nilai_hasil_survey'));
        // $survey_min = min(array_column($newTrain, 'skor_nilai_hasil_survey'));
        // $akademik_min = min(array_column($newTrain, 'skor_prestasi_akademik'));
        // $akademik_max = max(array_column($newTrain, 'skor_prestasi_akademik'));
        // $non_max = max(array_column($newTrain, 'skor_nilai_prestasi_non_akademik'));
        // $non_min = min(array_column($newTrain, 'skor_nilai_prestasi_non_akademik'));

        // foreach ($newTrain as $key => $row) {
        //     $no = $row->no_pendaftaran;
        //     $nama = $row->nama_siswa;
        //     $nilai_prodi = ($row->nilai_atribut_prodi - $prodi_min != 0) ? round((($row->nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3) : 0;
        //     $nilai_sekolah = ($row->nilai_atribut - $sekolah_min != 0) ? round((($row->nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3) : 0;
        //     $seleksi = ($row->skor_nilai_seleksi - $seleksi_min != 0) ? round((($row->skor_nilai_seleksi - $seleksi_min) / ($seleksi_max - $seleksi_min)) * (1 - 0) + 0, 3) : 0;
        //     $ekonomi = ($row->skor_nilai_kondisi_ekonomi - $ekonomi_min != 0) ? round((($row->skor_nilai_kondisi_ekonomi - $ekonomi_min) / ($ekonomi_max - $ekonomi_min)) * (1 - 0) + 0, 3) : 0;
        //     $wawancara = ($row->skor_nilai_wawancara - $wawancara_min != 0) ? round((($row->skor_nilai_wawancara - $wawancara_min) / ($wawancara_max - $wawancara_min)) * (1 - 0) + 0, 3) : 0;
        //     $survey = ($row->skor_nilai_hasil_survey - $survey_min != 0) ? round((($row->skor_nilai_hasil_survey - $survey_min) / ($survey_max - $survey_min)) * (1 - 0) + 0, 3) : 0;
        //     $akademik = ($row->skor_prestasi_akademik - $akademik_min != 0) ? round((($row->skor_prestasi_akademik - $akademik_min) / ($akademik_max - $akademik_min)) * (1 - 0) + 0, 3) : 0;
        //     $non = ($row->skor_nilai_prestasi_non_akademik - $non_min != 0) ? round((($row->skor_nilai_prestasi_non_akademik - $non_min) / ($non_max - $non_min)) * (1 - 0) + 0, 3) : 0;
        //     $output = ($row->label == 'Tidak Layak') ? '0' : '1';

        //     $train = [
        //         'no_pendaftaran' => $no,
        //         'nama_siswa' => $nama,
        //         'pilihan_program_studi' => $nilai_prodi,
        //         'asal_sekolah' => $nilai_sekolah,
        //         'skor_nilai_seleksi' => $seleksi,
        //         'skor_nilai_wawancara' => $wawancara,
        //         'skor_nilai_kondisi_ekonomi' => $ekonomi,
        //         'skor_prestasi_akademik' => $akademik,
        //         'skor_nilai_prestasi_non_akademik' => $non,
        //         'skor_nilai_hasil_survey' => $survey,
        //         'label' => $output
        //     ];
        //     $normTrain = $this->normalized->where([
        //         'no_pendaftaran' => $no,
        //         'nama_siswa' => $nama,
        //         'pilihan_program_studi' => $nilai_prodi,
        //         'asal_sekolah' => $nilai_sekolah,
        //         'skor_nilai_wawancara' => $wawancara,
        //         'skor_prestasi_akademik' => $akademik,
        //         'skor_nilai_prestasi_non_akademik' => $non,
        //         'skor_nilai_hasil_survey' => $survey,
        //         'label' => $output
        //     ])->first();
        //     if ($normTrain) {
        //         $this->normalized->where([
        //             'no_pendaftaran' => $no,
        //             'nama_siswa' => $nama,
        //             'pilihan_program_studi' => $nilai_prodi,
        //             'asal_sekolah' => $nilai_sekolah,
        //             'skor_nilai_wawancara' => $wawancara,
        //             'skor_prestasi_akademik' => $akademik,
        //             'skor_nilai_prestasi_non_akademik' => $non,
        //             'skor_nilai_hasil_survey' => $survey,
        //             'label' => $output
        //         ])->set([
        //             'skor_nilai_seleksi' => $skor_nilai_seleksi,
        //             'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
        //         ])->update();
        //     } else {
        //         $this->normalized->save($train);
        //     }

        session()->setFlashdata('pesan', "Data berhasil diprediksi");
        return redirect()->to('data-testing');
    }
    public function upload()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate(
            [
                'importfile' => [
                    'rules' => 'uploaded[importfile]|ext_in[importfile,xls,xlsx,csv]',
                    'error' => [
                        'uploaded' => '{field} harus diisi',
                        'ext_in' => '{field} harus memiliki extention xls, xlsx atau csv'
                    ]
                ]
            ]
        );
        if (!$valid) {
            session()->setFlashdata('error', $validation->getError('importfile'));
            return redirect()->to('data-training-import');
        } else {
            $file_excel = $this->request->getFile('importfile');
            $ext = $file_excel->getClientExtension();
            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } elseif ($ext == 'xlsx') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            }
            $excel = $render->load($file_excel);
            $data = $excel->getActiveSheet()->toArray();
            foreach ($data as $x => $row) {
                if ($x == 0) {
                    continue;
                }
                $no_pendaftaran = $row[0];
                $nama_siswa = $row[1];
                $jenis_sekolah = $row[2];
                $nama_prodi = $row[3];
                $skor_nilai_seleksi = round(($row[4] === '0') ? 0 : ((empty($row[4])) ? 54.4 : $row[4]), 2);
                $skor_nilai_wawancara = round(($row[5] === '0') ? 0 : ((empty($row[5])) ? 72.2 : $row[5]), 2);
                $skor_nilai_kondisi_ekonomi = round(($row[6] === '0') ? 0 : ((empty($row[6])) ? 251082 : $row[6]));
                $skor_prestasi_akademik =  round(($row[7] === '0') ? 0 : ((empty($row[7])) ? 83.6 : $row[7]), 2);
                $skor_nilai_prestasi_non_akademik = round(($row[8] === '0') ? 0 : ((empty($row[8])) ? 33.0 : $row[8]), 2);
                $skor_nilai_hasil_survey =  round(($row[9] === '0') ? 0 : ((empty($row[9])) ? 81.8 : $row[9]), 2);
                $label = ($row[10] == 'Layak_diterima') ? 'Layak' : 'Tidak Layak';

                $sekolah = $this->sekolahModel->where('jenis_sekolah', $jenis_sekolah)->first();
                $prodi = $this->prodiModel->where('nama_prodi', $nama_prodi)->first();

                $id_sekolah = $sekolah['id_sekolah'];
                $id_prodi = $prodi['id_prodi'];

                $test = [
                    'no_pendaftaran' => $no_pendaftaran,
                    'nama_siswa' => $nama_siswa,
                    'id_sekolah' => $id_sekolah,
                    'id_prodi' => $id_prodi,
                    'skor_nilai_seleksi' => $skor_nilai_seleksi,
                    'skor_nilai_wawancara' => $skor_nilai_wawancara,
                    'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
                    'skor_prestasi_akademik' => $skor_prestasi_akademik,
                    'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
                    'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey,
                    'label' => $label
                ];
                //cek data pada database
                $cek = $this->testingModel->where($test)->first();
                if ($cek) {
                    session()->setFlashdata('error', 'Data testing sudah ada!');
                    return redirect()->to('data-testing');
                } else {
                    $this->testingModel->save($test);
                }
            }
            session()->setFlashdata('pesan', "Data berhasil disimpan");
            return redirect()->to('data-testing');
        }
    }


    public function export()
    {
        $testing = $this->testingModel->getAll();
        $excel = new Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setCellValue('A1', 'No Pendaftaran');
        $sheet->setCellValue('B1', 'Nama Siswa');
        $sheet->setCellValue('C1', 'Asal Sekolah');
        $sheet->setCellValue('D1', 'Pilihan Program Studi');
        $sheet->setCellValue('E1', 'Skor Nilai Seleksi');
        $sheet->setCellValue('F1', 'Skor Nilai Wawancara');
        $sheet->setCellValue('G1', 'Skor Kondisi Ekonomi');
        $sheet->setCellValue('H1', 'Skor Prestasi Akademik');
        $sheet->setCellValue('I1', 'Skor Prestasi Non Akademik');
        $sheet->setCellValue('J1', 'Skor Hasil Survey');
        $sheet->setCellValue('K1', 'Label Sebenarnya');
        $sheet->setCellValue('L1', 'Prediksi');

        $col = 2;
        foreach ($testing as $key => $data) {
            $sheet->setCellValue('A' . $col, $data->no_pendaftaran);
            $sheet->setCellValue('B' . $col, $data->nama_siswa);
            $sheet->setCellValue('C' . $col, $data->jenis_sekolah);
            $sheet->setCellValue('D' . $col, $data->nama_prodi);
            $sheet->setCellValue('E' . $col, $data->skor_nilai_seleksi);
            $sheet->setCellValue('F' . $col, $data->skor_nilai_wawancara);
            $sheet->setCellValue('G' . $col, $data->skor_nilai_kondisi_ekonomi);
            $sheet->setCellValue('H' . $col, $data->skor_prestasi_akademik);
            $sheet->setCellValue('I' . $col, $data->skor_nilai_prestasi_non_akademik);
            $sheet->setCellValue('J' . $col, $data->skor_nilai_hasil_survey);
            $sheet->setCellValue('K' . $col, $data->label);
            $sheet->setCellValue('L' . $col, $data->prediksi);
            $col++;
        }
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $styeArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb', '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:L' . ($col - 1))->applyFromArray($styeArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        $writer = new Xlsx($excel);
        $filename = 'datatesting.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attechment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    public function view()
    {
        $search = $this->request->getVar('searching');
        $data =  $this->testNorm->getPage(5, $search);
        return view('Admin/DataTesting/view', $data);
    }
}
