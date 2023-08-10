<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<?php if (!$cekData) : ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">DATA SELEKSI</div>
            <div class="card-body text-center">
                <h4>
                    <i>Belum ada Data Peserta yang sudah diseleksi pada Periode ini</i>
                </h4>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-warning">
                    <?= session()->getFlashdata('error'); ?>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="card-title">DATA SELEKSI</h4>
                        <p class="card-description">
                            Data peserta yang akan dilakukan seleksi
                        </p>
                    </div>
                    <div class="col-6">
                        <?php $session = session();
                        $periode = $session->get('selectedPeriode'); ?>
                        <a href="peserta-prediksi-<?= $periode; ?>" class="btn btn-outline-success btn-md float-right" onclick="return confirm('Apakah anda yakin data sudah lengkap dan akan memprediksi data ini?');">PREDIKSI DATA</a>
                    </div>
                </div>
                <!-- <div class=" mt-3">
                </div> -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <!-- <th></th> -->
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Prodi</th>
                                <th>Sekolah</th>
                                <th>Skor Seleksi</th>
                                <th>Skor Wawancara</th>
                                <th>Kondisi Ekonomi</th>
                                <th>Hasil Survey</th>
                                <th>Prestasi Akademik</th>
                                <th>Prestasi Non Akademik</th>
                                <th colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $no = 1 + (5 * ($page - 1));
                            foreach ($seleksi as $seleksi) : ?>
                                <tr>
                                    <!-- <td class=""><input type="checkbox" name="item_ids[]" value="<?= $seleksi['id']; ?>"></td> -->
                                    <td><?= $seleksi['no_pendaftaran']; ?></td>
                                    <td><?= $seleksi['nama_siswa']; ?></td>
                                    <td><?= $seleksi['nama_prodi']; ?></td>
                                    <td><?= $seleksi['nama_sekolah']; ?></td>
                                    <td><?= ($seleksi['skor_nilai_seleksi'] === null) ? 'NULL' : $seleksi['skor_nilai_seleksi']; ?></td>
                                    <td><?= ($seleksi['skor_nilai_wawancara'] === null) ? 'NULL' : $seleksi['skor_nilai_wawancara']; ?></td>
                                    <td><?= ($seleksi['skor_nilai_kondisi_ekonomi'] === null) ? 'NULL' : $seleksi['skor_nilai_kondisi_ekonomi']; ?></td>
                                    <td><?= ($seleksi['skor_nilai_hasil_survey'] === null) ? 'NULL' : $seleksi['skor_nilai_hasil_survey']; ?></td>
                                    <td><?= ($seleksi['skor_prestasi_akademik'] === null) ? 'NULL' : $seleksi['skor_prestasi_akademik']; ?></td>
                                    <td><?= ($seleksi['skor_nilai_prestasi_non_akademik'] === null) ? 'NULL' : $seleksi['skor_nilai_prestasi_non_akademik']; ?></td>
                                    <td>
                                        <a href="seleksi-edit-<?= $seleksi['id']; ?>" class="btn btn-warning btn-sm"><i class="ti-pencil"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="float-left mt-4">
                    <i>Showing <?= 1 + (5 * ($page - 1)) ?> to <?= $no - 1 ?> of <?= $pager->getTotal() ?> entries</i>
                </div>
                <div class="float-right mt-3">
                    <?= $pager->links('default', 'paginate'); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>