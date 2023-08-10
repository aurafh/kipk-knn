<?php

namespace App\Controllers;

use App\Models\DataTrainingModel;
use App\Models\ProdiModel;
use App\Models\SekolahModel;
use App\Models\TrainingNormalized;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataTraining extends BaseController
{
    protected $trainingModel;
    protected $prodiModel;
    protected $sekolahModel;
    protected $normalized;
    public function __construct()
    {
        $this->trainingModel = new DataTrainingModel();
        $this->prodiModel = new ProdiModel();
        $this->sekolahModel = new SekolahModel();
        $this->normalized = new TrainingNormalized();
    }

    public function index()
    {
        $search = $this->request->getVar('searching');
        $column = $this->request->getVar('column');
        $type = $this->request->getVar('type');
        $column2 = $this->request->getVar('column2');
        $type2 = $this->request->getVar('type2');
        $data =  $this->trainingModel->getPage(5, $search, $column, $type, $column2, $type2);
        return view('Admin/DataTraining/index', $data);
    }

    public function create()
    {

        $data = [
            'validation' => \Config\Services::validation(),
            'prodi' => $this->prodiModel->findAll(),
            'sekolah' => $this->sekolahModel->findAll()
        ];
        return view('Admin/DataTraining/create', $data);
    }

    public function save()
    {
        $train = [
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
            'label' => $this->request->getVar('label')
        ];
        //cek data pada database
        $cek = $this->trainingModel->where($train)->first();
        if ($cek) {
            session()->setFlashdata('error', 'Data training sudah ada!');
            return redirect()->to('data-training');
        } else {
            $this->trainingModel->insert($train);
        }


        session()->setFlashdata('pesan', 'Data training ' . $this->request->getVar('nama_siswa') . ' berhasil ditambahkan!');
        return redirect()->to('data-training');
    }

    public function edit($id)
    {
        $data = [
            'validation' => \Config\Services::validation(),
            'sekolah' => $this->sekolahModel->findAll(),
            'prodi' => $this->prodiModel->findAll(),
            'training' => $this->trainingModel->getTraining($id)
        ];
        return view('Admin/DataTraining/edit', $data);
    }

    public function update($id)
    {

        $this->trainingModel->save([
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
            'label' => $this->request->getVar('label')
        ]);

        // $data = $this->trainingModel->getAll();
        // $prodi_min = min(array_column($data, 'nilai_atribut_prodi'));
        // $prodi_max = max(array_column($data, 'nilai_atribut_prodi'));
        // $sekolah_max = max(array_column($data, 'nilai_atribut'));
        // $sekolah_min = min(array_column($data, 'nilai_atribut'));
        // $seleksi_min = min(array_column($data, 'skor_nilai_seleksi'));
        // $seleksi_max = max(array_column($data, 'skor_nilai_seleksi'));
        // $ekonomi_max = max(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        // $ekonomi_min = min(array_column($data, 'skor_nilai_kondisi_ekonomi'));
        // $wawancara_min = min(array_column($data, 'skor_nilai_wawancara'));
        // $wawancara_max = max(array_column($data, 'skor_nilai_wawancara'));
        // $survey_max = max(array_column($data, 'skor_nilai_hasil_survey'));
        // $survey_min = min(array_column($data, 'skor_nilai_hasil_survey'));
        // $akademik_min = min(array_column($data, 'skor_prestasi_akademik'));
        // $akademik_max = max(array_column($data, 'skor_prestasi_akademik'));
        // $non_max = max(array_column($data, 'skor_nilai_prestasi_non_akademik'));
        // $non_min = min(array_column($data, 'skor_nilai_prestasi_non_akademik'));


        // $trains = $this->trainingModel->find($id);
        // $id_sekolah = $trains['id_sekolah'];
        // $id_prodi = $trains['id_prodi'];
        // $sekolah = $this->sekolahModel->where('id_sekolah', $id_sekolah)->first();
        // $prodi = $this->prodiModel->where('id_prodi', $id_prodi)->first();

        // $nilai_atribut = $sekolah['nilai_atribut'];
        // $nilai_atribut_prodi = $prodi['nilai_atribut_prodi'];

        // //minmax norm
        // $no_pendaftaran = $trains['no_pendaftaran'];
        // $nama_siswa = $trains['nama_siswa'];
        // $nilai_atribut_prodi = ($nilai_atribut_prodi - $prodi_min != 0) ? round((($nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3) : 0;
        // $nilai_atribut = ($nilai_atribut - $sekolah_min != 0) ? round((($nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3) : 0;
        // $skor_nilai_seleksi = ($trains['skor_nilai_seleksi'] - $seleksi_min != 0) ? round((($trains['skor_nilai_seleksi'] - $seleksi_min) / ($seleksi_max - $seleksi_min)) * (1 - 0) + 0, 3) : 0;
        // $skor_nilai_kondisi_ekonomi = ($trains['skor_nilai_kondisi_ekonomi'] - $ekonomi_min != 0) ? round((($trains['skor_nilai_kondisi_ekonomi'] - $ekonomi_min) / ($ekonomi_max - $ekonomi_min)) * (1 - 0) + 0, 3) : 0;
        // $skor_nilai_wawancara = ($trains['skor_nilai_wawancara'] - $wawancara_min != 0) ? round((($trains['skor_nilai_wawancara'] - $wawancara_min) / ($wawancara_max - $wawancara_min)) * (1 - 0) + 0, 3) : 0;
        // $skor_nilai_hasil_survey = ($trains['skor_nilai_hasil_survey'] - $survey_min != 0) ? round((($trains['skor_nilai_hasil_survey'] - $survey_min) / ($survey_max - $survey_min)) * (1 - 0) + 0, 3) : 0;
        // $skor_prestasi_akademik = ($trains['skor_prestasi_akademik'] - $akademik_min != 0) ? round((($trains['skor_prestasi_akademik'] - $akademik_min) / ($akademik_max - $akademik_min)) * (1 - 0) + 0, 3) : 0;
        // $skor_nilai_prestasi_non_akademik = ($trains['skor_nilai_prestasi_non_akademik'] - $non_min != 0) ? round((($trains['skor_nilai_prestasi_non_akademik'] - $non_min) / ($non_max - $non_min)) * (1 - 0) + 0, 3) : 0;
        // $label = ($trains['label'] == 'Tidak Layak') ? '0' : '1';

        // $norm = [
        //     'id' => $id,
        //     'no_pendaftaran' => $no_pendaftaran,
        //     'nama_siswa' => $nama_siswa,
        //     'pilihan_program_studi' => $nilai_atribut_prodi,
        //     'asal_sekolah' => $nilai_atribut,
        //     'skor_nilai_seleksi' => $skor_nilai_seleksi,
        //     'skor_nilai_wawancara' => $skor_nilai_wawancara,
        //     'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
        //     'skor_prestasi_akademik' => $skor_prestasi_akademik,
        //     'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
        //     'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey,
        //     'label' => $label
        // ];
        // //cek data pada database
        // $cek = $this->normalized->where($norm)->first();
        // if ($cek) {
        //     session()->setFlashdata('error', 'Data training sudah ada!');
        // return redirect()->to('data-training');
        // } else {
        //     $this->normalized->update($id, $norm);
        // }

        session()->setFlashdata('pesan', 'Data training ' . $this->request->getVar('nama_siswa') . ' berhasil diubah!');
        return redirect()->to('data-training');
    }

    public function delete($id)
    {
        $this->trainingModel->delete($id);
        $this->normalized->delete($id);

        session()->setFlashdata('pesan', 'Data training berhasil dihapus!');
        return redirect()->to('data-training');
    }

    public function delete_multiple()
    {
        $item_ids = $this->request->getPost('item_ids');
        if (!empty($item_ids)) {
            foreach ($item_ids as $item) {
                $this->trainingModel->delete($item);
                $this->normalized->delete($item);
            }
            session()->setFlashdata('pesan', 'Data training berhasil dihapus!');
            return redirect()->to('data-training');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih');
        }
    }
    public function update_multiple()
    {
        $item_ids = $this->request->getPost();
        if (!empty($item_ids)) {
            foreach ($item_ids['item_ids'] as $item) {
                $this->trainingModel->update($item, ['label' => $item_ids['label'][$item]]);
                $this->trainingModel->update($item, ['label' => $item_ids['label'][$item]]);
            }
            session()->setFlashdata('pesan', 'Data training berhasil dihapus!');
            return redirect()->to('data-training');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih');
        }
    }

    public function export()
    {
        $training = $this->trainingModel->getAll();
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
        $sheet->setCellValue('K1', 'Label');

        $col = 2;
        foreach ($training as $key => $data) {
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
            $col++;
        }
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $styeArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb', '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:K' . ($col - 1))->applyFromArray($styeArray);

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
        $filename = 'datatraining.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attechment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }


    public function import()
    {
        return view('Admin/DataTraining/import');
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

                $train = [
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
                $cek = $this->trainingModel->where($train)->first();
                if ($cek) {
                    session()->setFlashdata('error', 'Data training sudah ada!');
                    return redirect()->to('data-training');
                } else {
                    $this->trainingModel->save($train);
                }
            }
            //perhitungan minmax
            // $data = $this->trainingModel->getAll();
            // $prodi_min = min(array_column($data, 'nilai_atribut_prodi'));
            // $prodi_max = max(array_column($data, 'nilai_atribut_prodi'));
            // $sekolah_max = max(array_column($data, 'nilai_atribut'));
            // $sekolah_min = min(array_column($data, 'nilai_atribut'));
            // $seleksi_min = min(array_column($data, 'skor_nilai_seleksi'));
            // $seleksi_max = max(array_column($data, 'skor_nilai_seleksi'));
            // $ekonomi_max = max(array_column($data, 'skor_nilai_kondisi_ekonomi'));
            // $ekonomi_min = min(array_column($data, 'skor_nilai_kondisi_ekonomi'));
            // $wawancara_min = min(array_column($data, 'skor_nilai_wawancara'));
            // $wawancara_max = max(array_column($data, 'skor_nilai_wawancara'));
            // $survey_max = max(array_column($data, 'skor_nilai_hasil_survey'));
            // $survey_min = min(array_column($data, 'skor_nilai_hasil_survey'));
            // $akademik_min = min(array_column($data, 'skor_prestasi_akademik'));
            // $akademik_max = max(array_column($data, 'skor_prestasi_akademik'));
            // $non_max = max(array_column($data, 'skor_nilai_prestasi_non_akademik'));
            // $non_min = min(array_column($data, 'skor_nilai_prestasi_non_akademik'));

            // foreach ($data as $key => $row) {
            //     $no_pendaftaran = $row->no_pendaftaran;
            //     $nama_siswa = $row->nama_siswa;
            //     $nilai_atribut_prodi = ($row->nilai_atribut_prodi - $prodi_min != 0) ? round((($row->nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3) : 0;
            //     $nilai_atribut = ($row->nilai_atribut - $sekolah_min != 0) ? round((($row->nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3) : 0;
            //     $skor_nilai_seleksi = ($row->skor_nilai_seleksi - $seleksi_min != 0) ? round((($row->skor_nilai_seleksi - $seleksi_min) / ($seleksi_max - $seleksi_min)) * (1 - 0) + 0, 3) : 0;
            //     $skor_nilai_kondisi_ekonomi = ($row->skor_nilai_kondisi_ekonomi - $ekonomi_min != 0) ? round((($row->skor_nilai_kondisi_ekonomi - $ekonomi_min) / ($ekonomi_max - $ekonomi_min)) * (1 - 0) + 0, 3) : 0;
            //     $skor_nilai_wawancara = ($row->skor_nilai_wawancara - $wawancara_min != 0) ? round((($row->skor_nilai_wawancara - $wawancara_min) / ($wawancara_max - $wawancara_min)) * (1 - 0) + 0, 3) : 0;
            //     $skor_nilai_hasil_survey = ($row->skor_nilai_hasil_survey - $survey_min != 0) ? round((($row->skor_nilai_hasil_survey - $survey_min) / ($survey_max - $survey_min)) * (1 - 0) + 0, 3) : 0;
            //     $skor_prestasi_akademik = ($row->skor_prestasi_akademik - $akademik_min != 0) ? round((($row->skor_prestasi_akademik - $akademik_min) / ($akademik_max - $akademik_min)) * (1 - 0) + 0, 3) : 0;
            //     $skor_nilai_prestasi_non_akademik = ($row->skor_nilai_prestasi_non_akademik - $non_min != 0) ? round((($row->skor_nilai_prestasi_non_akademik - $non_min) / ($non_max - $non_min)) * (1 - 0) + 0, 3) : 0;
            //     $label = ($row->label == 'Tidak Layak') ? '0' : '1';

            //     $this->normalized->save([
            //         'no_pendaftaran' => $no_pendaftaran,
            //         'nama_siswa' => $nama_siswa,
            //         'pilihan_program_studi' => $nilai_atribut_prodi,
            //         'asal_sekolah' => $nilai_atribut,
            //         'skor_nilai_seleksi' => $skor_nilai_seleksi,
            //         'skor_nilai_wawancara' => $skor_nilai_wawancara,
            //         'skor_nilai_kondisi_ekonomi' => $skor_nilai_kondisi_ekonomi,
            //         'skor_prestasi_akademik' => $skor_prestasi_akademik,
            //         'skor_nilai_prestasi_non_akademik' => $skor_nilai_prestasi_non_akademik,
            //         'skor_nilai_hasil_survey' => $skor_nilai_hasil_survey,
            //         'label' => $label
            //     ]);
            // }
            session()->setFlashdata('pesan', "Data berhasil disimpan");
            return redirect()->to('data-training');
        }
    }

    public function normalized()
    {
        $search = $this->request->getVar('searching');
        $data =  $this->normalized->getPage(5, $search);
        return view('Admin/DataTraining/view', $data);
    }

    public function norm()
    {
        $data = $this->trainingModel->getAll();
        if (empty($data)) {
            $search = $this->request->getVar('searching');
            $data =  $this->normalized->getPage(5, $search);
            return view('Admin/DataTraining/view', $data);
        } else {
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

            foreach ($data as $key => $row) {
                $no_pendaftaran = $row->no_pendaftaran;
                $nama_siswa = $row->nama_siswa;
                $nilai_atribut_prodi = ($row->nilai_atribut_prodi - $prodi_min != 0) ? round((($row->nilai_atribut_prodi - $prodi_min) / ($prodi_max - $prodi_min)) * (1 - 0) + 0, 3) : 0;
                $nilai_atribut = ($row->nilai_atribut - $sekolah_min != 0) ? round((($row->nilai_atribut - $sekolah_min) / ($sekolah_max - $sekolah_min)) * (1 - 0) + 0, 3) : 0;
                $skor_nilai_seleksi = ($row->skor_nilai_seleksi - $seleksi_min != 0) ? round((($row->skor_nilai_seleksi - $seleksi_min) / ($seleksi_max - $seleksi_min)) * (1 - 0) + 0, 3) : 0;
                $skor_nilai_kondisi_ekonomi = ($row->skor_nilai_kondisi_ekonomi - $ekonomi_min != 0) ? round((($row->skor_nilai_kondisi_ekonomi - $ekonomi_min) / ($ekonomi_max - $ekonomi_min)) * (1 - 0) + 0, 3) : 0;
                $skor_nilai_wawancara = ($row->skor_nilai_wawancara - $wawancara_min != 0) ? round((($row->skor_nilai_wawancara - $wawancara_min) / ($wawancara_max - $wawancara_min)) * (1 - 0) + 0, 3) : 0;
                $skor_nilai_hasil_survey = ($row->skor_nilai_hasil_survey - $survey_min != 0) ? round((($row->skor_nilai_hasil_survey - $survey_min) / ($survey_max - $survey_min)) * (1 - 0) + 0, 3) : 0;
                $skor_prestasi_akademik = ($row->skor_prestasi_akademik - $akademik_min != 0) ? round((($row->skor_prestasi_akademik - $akademik_min) / ($akademik_max - $akademik_min)) * (1 - 0) + 0, 3) : 0;
                $skor_nilai_prestasi_non_akademik = ($row->skor_nilai_prestasi_non_akademik - $non_min != 0) ? round((($row->skor_nilai_prestasi_non_akademik - $non_min) / ($non_max - $non_min)) * (1 - 0) + 0, 3) : 0;
                $label = ($row->label == 'Tidak Layak') ? '0' : '1';

                $train = [
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
                $cek = $this->normalized->getDataCriteria($train);
                if ($cek) {
                    session()->setFlashdata('error', 'Tidak ada data training baru yang ditambahkan!');
                    return redirect()->to('data-training-norm');
                } else {
                    $dataTrain = $this->normalized->findAll();
                    if (isset($dataTrain['no_pendaftaran']) && isset($dataTrain['nama_siswa']) && isset($dataTrain['label'])) {
                        $this->normalized->where(['no_pendaftaran' => $no_pendaftaran, 'nama_siswa' => $nama_siswa, 'label' => $label])
                            ->save($train);
                    } else {
                        $this->normalized->save($train);
                    }
                }
            }
        }
        return redirect()->to('data-training-norm')->withInput('pesan', 'Data training normalized diperbaharui!');
    }
}
