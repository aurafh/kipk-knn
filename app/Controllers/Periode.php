<?php

namespace App\Controllers;

use App\Models\DataTestingModel;
use App\Models\DataTrainingModel;
use App\Models\DataUjiModel;
use App\Models\PeriodeModel;
use App\Models\PesertaModel;
use App\Models\ProdiModel;
use App\Models\SekolahModel;
use App\Models\TestingNormalized;
use App\Models\TrainingNormalized;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

/**
 * @property string $password
 */
class Periode extends BaseController
{
    protected $periode;
    protected $prodi;
    protected $sekolah;
    protected $testingNorm;
    protected $trainNorm;
    protected $training;
    protected $pesertaModel;
    protected $seleksiModel;

    public function __construct()
    {
        $this->periode = new PeriodeModel();
        $this->prodi = new ProdiModel();
        $this->sekolah = new SekolahModel();
        $this->pesertaModel = new PesertaModel();
        $this->testingNorm = new TestingNormalized();
        $this->training = new DataTrainingModel();
        $this->trainNorm = new TrainingNormalized();
        $this->seleksiModel = new DataUjiModel();
    }
    public function dashboard($periode)
    {
        $session = session();
        $session->set('selectedPeriode', $periode);
        // dd($session);
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $db = \Config\Database::connect();
        //count data training
        $queryPeserta = $db->table('data_peserta');
        $queryPeserta->where('id_periode', $id_periode);
        $counPeserta = $queryPeserta->countAllResults();
        //count data testing
        $queryTerima = $db->table('data_peserta');
        $queryTerima->where('id_periode', $id_periode);
        $queryTerima->where('label', 'Layak');
        $queryTerima->where('ranking !=', null);
        $counDiterima = $queryTerima->countAllResults();
        //count label layak
        $queryLayak = $db->table('data_peserta');
        $queryLayak->where('id_periode', $id_periode);
        $queryLayak->where('label', 'Layak');
        $countLayak = $queryLayak->countAllResults();
        //count label tidak layak
        $queryTidak = $db->table('data_peserta');
        $queryTidak->where('id_periode', $id_periode);
        $queryTidak->where('label', 'Layak');
        $counTidak = $queryTidak->countAllResults();

        $data = [
            'peserta' => $counPeserta,
            'terima' => $counDiterima,
            'layak' => $countLayak,
            'tidak' => $counTidak
        ];
        return view('Operator/main', $data);
    }
    public function index()
    {
        $data = [
            'periode' => $this->periode->findAll()
        ];
        return view('Operator/periode', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'periode' => 'required',
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('periode')->withInput()->with('validation', $validation);
        }

        $this->periode->save([
            'periode' => $this->request->getVar('periode'),

        ]);
        session()->setFlashdata('pesan', 'Periode ' . $this->request->getVar('periode') . ' berhasil ditambahkan!');
        return redirect()->to('periode');
    }

    public function delete($id_periode)
    {
        $this->periode->delete($id_periode);
        session()->setFlashdata('pesan', 'Periode berhasil dihapus!');
        return redirect()->to('periode');
    }

    public function show($periode)
    {
        $session = session();
        $session->set(['selectedPeriode' => $periode]);
        $tahun = $this->periode->where('periode', $periode)->first();
        if ($tahun) {
            $dataTest = $tahun['id_periode'];
            $data = $this->pesertaModel->getAll(5, $dataTest);
            // dd($data);
            return view('Operator/dataPeserta', $data);
        }
    }

    public function edit($id_peserta)
    {
        $data = [
            'prodi' => $this->prodi->findAll(),
            'peserta' => $this->pesertaModel->where(['id_peserta' => $id_peserta])->first()
        ];
        return view('Operator/editPeserta', $data);
    }

    public function update($id_peserta)
    {
        $peserta = $this->pesertaModel->where(['id_peserta' => $id_peserta])->first();
        $id_periode = $this->periode->where(['id_periode' => $peserta['id_periode']])->first();
        $periode = $id_periode['periode'];
        $this->pesertaModel->save([
            'id_peserta' => $id_peserta,
            'status' => $this->request->getVar('status'),
        ]);
        session()->setFlashdata('pesan', 'Status peserta berhasil diubah!');
        return redirect()->to('data-peserta-' . $periode);
    }

    public function data_seleksi($periode)
    {
        $tahun = $this->periode->where('periode', $periode)->first();
        // $status = 'VALIDATE';

        if ($tahun) {
            $dataTest = $tahun['id_periode'];
            $data = $this->pesertaModel->getPesertaStatus($dataTest);
            foreach ($data as $peserta) {
                $exist = $this->seleksiModel->where('id_peserta', $peserta['id_peserta'])->first();
                if (!$exist) {
                    $dataPeserta = [
                        'id_peserta' => $peserta['id_peserta'],
                        'id_prodi' => $peserta['id_prodi'],
                        'id_sekolah' => $peserta['id_sekolah'],
                        'id_periode' => $peserta['id_periode']
                    ];
                    $this->seleksiModel->insert($dataPeserta);
                }
            }
            $data = $this->seleksiModel->getSeleksi(4, $dataTest);
            return view('Operator/dataSeleksi', $data);
        }
    }
    public function edit_seleksi($id)
    {
        $data = [
            'sekolah' => $this->sekolah->findAll(),
            'prodi' => $this->prodi->findAll(),
            'seleksi' => $this->seleksiModel->getID($id)
        ];
        return view('Operator/editSeleksi', $data);
    }

    public function update_seleksi($id)
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $dataSeleksi = [
            'skor_nilai_seleksi' => $this->request->getPost('skor_nilai_seleksi') !== '' ? $this->request->getPost('skor_nilai_seleksi') : null,
            'skor_nilai_wawancara' => $this->request->getPost('skor_nilai_wawancara') !== '' ? $this->request->getPost('skor_nilai_wawancara') : null,
            'skor_nilai_kondisi_ekonomi' => $this->request->getPost('skor_nilai_kondisi_ekonomi') !== '' ? $this->request->getPost('skor_nilai_kondisi_ekonomi') : null,
            'skor_nilai_hasil_survey' => $this->request->getPost('skor_nilai_hasil_survey') !== '' ? $this->request->getPost('skor_nilai_hasil_survey') : null,
            'skor_prestasi_akademik' => $this->request->getPost('skor_prestasi_akademik') !== '' ? $this->request->getPost('skor_prestasi_akademik') : null,
            'skor_nilai_prestasi_non_akademik' => $this->request->getPost('skor_nilai_prestasi_non_akademik') !== '' ? $this->request->getPost('skor_nilai_prestasi_non_akademik') : null,
        ];
        $this->seleksiModel->update($id, $dataSeleksi);
        session()->setFlashdata('pesan', 'Data seleksi berhasil diubah!');
        return redirect()->to('data-seleksi-' . $periode);
    }

    public function prediksi()
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        //jika terdapat nilai null pada data pendaftar ketika diprediksi
        $test = $this->seleksiModel->getPeriode($id_periode);
        foreach ($test as $value) {
            $id = $value->id;
            $no_pendaftaran = $value->no_pendaftaran;
            $nama_siswa = $value->nama_siswa;
            $id_prodi = $value->id_prodi;
            $id_sekolah = $value->id_sekolah;
            $skor_nilai_seleksi = ($value->skor_nilai_seleksi == null) ? 0 : $value->skor_nilai_seleksi;
            $skor_nilai_kondisi_ekonomi = ($value->skor_nilai_kondisi_ekonomi == null) ? 0 : $value->skor_nilai_kondisi_ekonomi;
            $skor_nilai_wawancara = ($value->skor_nilai_wawancara == null) ? 0 : $value->skor_nilai_wawancara;
            $skor_nilai_hasil_survey = ($value->skor_nilai_hasil_survey == null) ? 0 : $value->skor_nilai_hasil_survey;
            $skor_prestasi_akademik = ($value->skor_prestasi_akademik == null) ? 0 : $value->skor_prestasi_akademik;
            $skor_nilai_prestasi_non_akademik = ($value->skor_nilai_prestasi_non_akademik == null) ? 0 : $value->skor_nilai_prestasi_non_akademik;

            $dataTest = [
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
            ];
            $exist = $this->seleksiModel->find($id);
            if (!$exist) {
                $this->seleksiModel->insert($dataTest);
            } else {
                $this->seleksiModel->update($id, $dataTest);
            }
        }

        //normalisasi data
        $data = $this->training->getAll();
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

        $nilai_uji = $this->seleksiModel->getPeriode($id_periode);
        foreach ($nilai_uji as $key => $uji) {
            $id = $uji->id;
            $no_pendaftaran = $uji->no_pendaftaran;
            $nama_siswa = $uji->nama_siswa;
            $nilai_atribut_prodi = ($uji->nilai_atribut_prodi - $prodi_min <= 0) ? 0 : round((($uji->nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3);
            $nilai_atribut = ($uji->nilai_atribut - $sekolah_min <= 0) ? 0 : round((($uji->nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3);
            $skor_nilai_seleksi = ($uji->skor_nilai_seleksi - $seleksi_min <= 0) ? 0 : round((($uji->skor_nilai_seleksi - $seleksi_min) / (($uji->skor_nilai_seleksi >= $seleksi_max) ? ($uji->skor_nilai_seleksi - $seleksi_min) : ($seleksi_max - $seleksi_min))) * (1 - 0) + 0, 3);
            $skor_nilai_kondisi_ekonomi = ($uji->skor_nilai_kondisi_ekonomi - $ekonomi_min <= 0) ? 0 : round((($uji->skor_nilai_kondisi_ekonomi - $ekonomi_min) / (($uji->skor_nilai_kondisi_ekonomi >= $ekonomi_max) ? ($uji->skor_nilai_kondisi_ekonomi - $ekonomi_min) : ($ekonomi_max - $ekonomi_min))) * (1 - 0) + 0, 3);
            $skor_nilai_wawancara = ($uji->skor_nilai_wawancara - $wawancara_min <= 0) ? 0 : round((($uji->skor_nilai_wawancara - $wawancara_min) / (($uji->skor_nilai_wawancara >= $wawancara_max) ? ($uji->skor_nilai_wawancara - $wawancara_min) : ($wawancara_max - $wawancara_min))) * (1 - 0) + 0, 3);
            $skor_nilai_hasil_survey = ($uji->skor_nilai_hasil_survey - $survey_min <= 0) ? 0 : round((($uji->skor_nilai_hasil_survey - $survey_min) / (($uji->skor_nilai_hasil_survey >= $survey_max) ? ($uji->skor_nilai_hasil_survey - $survey_min) : ($survey_max - $survey_min))) * (1 - 0) + 0, 3);
            $skor_prestasi_akademik = ($uji->skor_prestasi_akademik - $akademik_min <= 0) ? 0 : round((($uji->skor_prestasi_akademik - $akademik_min) / (($uji->skor_prestasi_akademik >= $akademik_max) ? ($uji->skor_prestasi_akademik - $akademik_min) : ($akademik_max - $akademik_min))) * (1 - 0) + 0, 3);
            $skor_nilai_prestasi_non_akademik = ($uji->skor_nilai_prestasi_non_akademik - $non_min <= 0) ? 0 : round((($uji->skor_nilai_prestasi_non_akademik - $non_min) / (($uji->skor_nilai_prestasi_non_akademik >= $non_max) ? ($uji->skor_nilai_prestasi_non_akademik - $non_min) : ($non_max - $non_min))) * (1 - 0) + 0, 3);

            $testData = [
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
            ];

            $cek = $this->testingNorm->where($testData)->first();
            if ($cek == null) {
                $this->testingNorm->save($testData);
            }

            $k = 3;
            $neighbors = $this->trainNorm->Distance($testData, $k);
            $labelCounts = array_count_values(array_column($neighbors, 'label'));
            $dominantLabel = array_search(max($labelCounts), $labelCounts);

            //update label di database
            $domLabel = ($dominantLabel == '1') ? 'Layak' : 'Tidak Layak';
            $this->seleksiModel->where(['id' => $id])->set(['label' => $domLabel])->update();
            $this->testingNorm->where($testData)->set(['label' => $dominantLabel])->update();
            $sekolah = $this->sekolah->where('nilai_atribut', $uji->nilai_atribut)->first();
            $prodi = $this->prodi->where('nilai_atribut_prodi', $uji->nilai_atribut_prodi)->first();

            $id_sekolah = $sekolah['id_sekolah'];
            $id_prodi = $prodi['id_prodi'];
            $check = $this->training->where([
                'no_pendaftaran' => $uji->no_pendaftaran,
                'nama_siswa' => $uji->nama_siswa,
                'id_prodi' => $id_prodi,
                'id_sekolah' => $id_sekolah,
                'skor_nilai_seleksi' => $uji->skor_nilai_seleksi,
                'skor_nilai_wawancara' => $uji->skor_nilai_wawancara,
                'skor_nilai_kondisi_ekonomi' => $uji->skor_nilai_kondisi_ekonomi,
                'skor_prestasi_akademik' => $uji->skor_prestasi_akademik,
                'skor_nilai_prestasi_non_akademik' => $uji->skor_nilai_prestasi_non_akademik,
                'skor_nilai_hasil_survey' => $uji->skor_nilai_hasil_survey,
            ])->first();
            if ($check == null) {
                $this->training->save([
                    'no_pendaftaran' => $uji->no_pendaftaran,
                    'nama_siswa' => $uji->nama_siswa,
                    'id_prodi' => $id_prodi,
                    'id_sekolah' => $id_sekolah,
                    'skor_nilai_seleksi' => $uji->skor_nilai_seleksi,
                    'skor_nilai_wawancara' => $uji->skor_nilai_wawancara,
                    'skor_nilai_kondisi_ekonomi' => $uji->skor_nilai_kondisi_ekonomi,
                    'skor_prestasi_akademik' => $uji->skor_prestasi_akademik,
                    'skor_nilai_prestasi_non_akademik' => $uji->skor_nilai_prestasi_non_akademik,
                    'skor_nilai_hasil_survey' => $uji->skor_nilai_hasil_survey,
                    'label' => $domLabel
                ]);
            }

            $dataTrain = $this->trainNorm->where($testData)->first();
            if ($dataTrain == null) {
                $this->trainNorm->save([
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
        session()->setFlashdata('pesan', 'Data berhasil diprediksi!');
        return redirect()->to('hasil-prediksi-' . $periode);
    }

    public function hasil()
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $search = $this->request->getVar('searching');
        $data = $this->seleksiModel->getOrder(
            $id_periode,
            $search,
            5
        );
        return view('Operator/prediksi', $data);
    }
    public function filter()
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $kuota = $this->request->getVar('kuota');
        $prodi = $this->request->getVar('prodi');
        $seleksi = $this->request->getVar('skor_nilai_seleksi');
        $wawancara = $this->request->getVar('skor_nilai_wawancara');
        $survey = $this->request->getVar('skor_nilai_hasil_survey');
        // $ekonomi = $this->request->getVar('skor_nilai_kondisi_ekonomi');
        $akademik = $this->request->getVar('skor_prestasi_akademik');
        $non = $this->request->getVar('skor_nilai_prestasi_non_akademik');

        if (!empty($seleksi)) {
            $dataAkumulasi = $this->seleksiModel->getAkum($id_periode);
            foreach ($dataAkumulasi as $rata) {
                $id = $rata['id_peserta'];
                $avgSeleksi = ($rata['skor_nilai_seleksi'] * $seleksi) / 100;
                $avgWawancara = ($rata['skor_nilai_wawancara'] * $wawancara) / 100;
                $avgSurvey = ($rata['skor_nilai_hasil_survey'] * $survey) / 100;
                // $avgEkonomi = ($rata['skor_nilai_kondisi_ekonomi'] * $ekonomi) / 100;
                $avgAkademik = ($rata['skor_prestasi_akademik'] * $akademik) / 100;
                $avgNon = ($rata['skor_nilai_prestasi_non_akademik'] * $non) / 100;
                $avgAll = $avgSeleksi + $avgWawancara + $avgSurvey + $avgAkademik + $avgNon;
                $this->pesertaModel->where(['id_peserta' => $id])->set(['akumulasi' => $avgAll])->update();
            }
        }
        $filterData = $this->seleksiModel->getFilter($id_periode, 5, $kuota, $prodi);

        return view('Operator/prediksi', $filterData);
    }


    public function edit_prediksi($id)
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $data = [
            'prodi' => $this->prodi->findAll(),
            'seleksi' => $this->seleksiModel->getID_Periode($id, $id_periode)
        ];
        return view('Operator/editPrediksi', $data);
    }

    public function update_prediksi($id)
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $label = $this->request->getPost('label');
        $ranking = $this->request->getPost('ranking');
        $keterangan = $this->request->getPost('keterangan');
        $no = $this->seleksiModel->find($id);
        $user = $this->pesertaModel->where(['id_peserta' => $no['id_peserta']])->first();
        $exist = $this->pesertaModel->where('id_periode', $id_periode)->where('id_prodi', $user['id_prodi'])->where('ranking', $ranking)->first();
        if ($exist) {
            return redirect()->back()->with('error', 'Ranking sudah ada!');
        }
        $dataSeleksi = [
            'label' => $label !== '' ? $label : null,
            'ranking' => $ranking !== '' ? $ranking : null,
            'keterangan' => $keterangan !== '' ? $keterangan : null
        ];
        $this->pesertaModel->update($user['id_peserta'], $dataSeleksi);
        $this->training->where(['no_pendaftaran' => $user['no_pendaftaran']])->set(['label' => $dataSeleksi['label']])->update();
        session()->setFlashdata('pesan', 'Data berhasil diubah!');
        return redirect()->to('hasil-prediksi-' . $periode);
    }
    public function simpan_prediksi()
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $hasilData = $this->seleksiModel->getDataPeriode($id_periode);

        foreach ($hasilData as $hasil) {
            $id = $hasil['id_peserta'];
            $label = $hasil['label'];
            $user = $this->pesertaModel->find($id);

            if ($user) {
                $this->pesertaModel->update($user['id_peserta'], ['label' => $label]);
            }
        }
        session()->setFlashdata('pesan', 'Data hasil prediksi berhasil disimpan!');
        return redirect()->to('keputusan-' . $periode);
    }
    public function DataKIP($periode)
    {
        $dompdf = new Dompdf();
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $dataPDF = $this->pesertaModel->getPDF($id_periode);
        $data['dataPDF'] = $dataPDF;
        $html = view('Operator/laporan', $data);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        // $dompdf->stream();
        $dompdf->stream('dataKIPK' . $periode . '.pdf', array('Attachment' => false));
    }
    public function contoh($periode)
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $dataPDF = $this->seleksiModel->getPDF($id_periode);
        $data['dataPDF'] = $dataPDF;
        return view('Operator/laporan', $data);
    }
    public function keputusan()
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $search = $this->request->getVar('searching');
        $data = $this->pesertaModel->getHasil(
            $id_periode,
            $search,
            5
        );
        return view('Operator/keputusan', $data);
    }
    public function export($periode)
    {
        $session = session();
        $periode = $session->get('selectedPeriode');
        $tahun = $this->periode->where('periode', $periode)->first();
        $id_periode = $tahun['id_periode'];
        $keputusan = $this->pesertaModel->getPDF($id_periode);
        $excel = new Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $sheet->setCellValue('A1', 'DATA CALON MAHASISWA KIP-KULIAH');
        $sheet->setCellValue('A2', 'INSTITUT TEKNOLOGI GARUT');
        $sheet->setCellValue('A3', 'PERIODE' . $periode);
        $sheet->setCellValue('A5', 'Nomor');
        $sheet->setCellValue('B5', 'Nomor Pendaftaran');
        $sheet->setCellValue('C5', 'Nama Lengkap');
        $sheet->setCellValue('D5', 'Asal Sekolah');
        $sheet->setCellValue('E5', 'Program Studi');
        $sheet->setCellValue('F5', 'Kelayakan');
        $sheet->setCellValue('G5', 'Ranking');

        $col = 6;
        $no = 1;
        foreach ($keputusan as $key => $data) {
            $sheet->setCellValue('A' . $col, $no++);
            $sheet->setCellValue('B' . $col, $data['no_pendaftaran']);
            $sheet->setCellValue('C' . $col, $data['nama_siswa']);
            $sheet->setCellValue('D' . $col, $data['nama_sekolah']);
            $sheet->setCellValue('E' . $col, $data['nama_prodi']);
            $sheet->setCellValue('F' . $col, $data['label']);
            $sheet->setCellValue('G' . $col, $data['ranking']);
            $col++;
        }
        $sheet->getStyle('A5:G5')->getFont()->setBold(true);
        $styeArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb', '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A5:G' . ($col - 1))->applyFromArray($styeArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($excel);
        $filename = 'keputusanKIPK.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attechment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}
