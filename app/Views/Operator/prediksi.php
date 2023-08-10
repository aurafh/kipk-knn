<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<?php if (!$cekData) : ?>
    <div class="col-lg-12 grid-margin stretch-card mt-3">
        <div class="card">
            <div class="card-header">HASIL PREDIKSI</div>
            <div class="card-body text-center">
                <h4>
                    <i>Belum ada Data Hasil Prediksi pada Periode ini</i>
                </h4>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php $request = \Config\Services::request(); ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">PERANKINGAN DATA PREDIKSI</div>
            <div class="card-body">
                <form action="hasil-filter-<?= $periode; ?>" method="get">
                    <div class="row">
                        <div class="col-2">
                            <label for="skor_nilai_seleksi">Seleksi</label>
                            <input type="number" class="form-control form-control-sm" name="skor_nilai_seleksi" placeholder="Bobot Seleksi" id="skor_nilai_seleksi" value="<?= $request->getVar('skor_nilai_seleksi'); ?>">
                        </div>
                        <div class="col-2">
                            <label for="skor_nilai_wawancara">Wawancara</label>
                            <input type="number" class="form-control form-control-sm" name="skor_nilai_wawancara" placeholder="Bobot Wawancara" id="skor_nilai_wawancara" value="<?= $request->getVar('skor_nilai_wawancara'); ?>">
                        </div>
                        <!-- <div class="col-2">
                            <label for="skor_nilai_kondisi_ekonomi">Ekonomi</label>
                            <input type="number" class="form-control form-control-sm" name="skor_nilai_kondisi_ekonomi" placeholder="Bobot Ekonomi" id="skor_nilai_kondisi_ekonomi" value="<?= $request->getVar('skor_nilai_kondisi_ekonomi'); ?>" >
                        </div> -->
                        <div class="col-2">
                            <label for="skor_prestasi_akademik">Akademik</label>
                            <input type="number" class="form-control form-control-sm" name="skor_prestasi_akademik" placeholder="Bobot Akademik" id="skor_prestasi_akademik" value="<?= $request->getVar('skor_prestasi_akademik'); ?>">
                        </div>
                        <div class="col-2">
                            <label for="skor_nilai_prestasi_non_akademik">Non Akademik</label>
                            <input type="number" class="form-control form-control-sm" name="skor_nilai_prestasi_non_akademik" placeholder="Bobot Non Akademik" id="skor_nilai_prestasi_non_akademik" value="<?= $request->getVar('skor_nilai_prestasi_non_akademik'); ?>">
                        </div>
                        <div class="col-2">
                            <label for="skor_nilai_hasil_survey">Survey</label>
                            <input type="number" class="form-control form-control-sm" name="skor_nilai_hasil_survey" placeholder="Bobot Suvey" id="skor_nilai_hasil_survey" value="<?= $request->getVar('skor_nilai_hasil_survey'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <input type="text" class="form-control form-control-sm" name="prodi[]" placeholder="Kuota Teknik Informatika" id="prodi" value="Teknik Informatika" hidden>
                        <input type="text" class="form-control form-control-sm" name="prodi[]" placeholder="Kuota Teknik Informatika" id="prodi" value="Teknik Industri" hidden>
                        <input type="text" class="form-control form-control-sm" name="prodi[]" placeholder="Kuota Teknik Informatika" id="prodi" value="Teknik Sipil" hidden>
                        <input type="text" class="form-control form-control-sm" name="prodi[]" placeholder="Kuota Teknik Informatika" id="prodi" value="Arsitektur" hidden>
                        <input type="text" class="form-control form-control-sm" name="prodi[]" placeholder="Kuota Teknik Informatika" id="prodi" value="Sistem Informasi " hidden>

                        <div class="col-4 mt-3">
                            <label for="kuota[Teknik Informatika]">Kuota Teknik Informatika</label>
                            <input type="number" class="form-control form-control-sm" name="kuota[Teknik Informatika]" placeholder="Kuota Teknik Informatika" id="kuota[Teknik Informatika]" value="<?= $request->getVar('kuota[Teknik Informatika]'); ?>" required>
                        </div>
                        <div class="col-4 mt-3">
                            <label for="kuota[Teknik Industri]">Kuota Teknik Industri</label>
                            <input type="number" class="form-control form-control-sm" name="kuota[Teknik Industri]" placeholder="Kuota Teknik Industri" id="kuota[Teknik Industri]" value="<?= $request->getVar('kuota[Teknik Industri]'); ?>">
                        </div>
                        <div class="col-4 mt-3">
                            <label for="kuota[Teknik Sipil]">Kuota Teknik Sipil</label>
                            <input type="number" class="form-control form-control-sm" name="kuota[Teknik Sipil]" placeholder="Kuota Teknik Sipil" id="kuota[Teknik Sipil]" value="<?= $request->getVar('kuota[Teknik Sipil]'); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 mt-3">
                            <label for="kuota[Arsitektur]">Kuota Arsitektur</label>
                            <input type="number" class="form-control form-control-sm" name="kuota[Arsitektur]" placeholder="Kuota  Arsitektur" id="kuota[Arsitektur]" value="<?= $request->getVar('kuota[Arsitektur]'); ?>">
                        </div>
                        <div class="col-4 mt-3">
                            <label for="kuota[Sistem Informasi]">Kuota Sistem Informasi</label>
                            <input type="number" class="form-control form-control-sm" name="kuota[Sistem Informasi]" placeholder="Kuota Sistem Informasi" id="kuota[Sistem Informasi]" value="<?= $request->getVar('kuota[Sistem Informasi]'); ?>">
                        </div>
                        <div class="col-2 mt-4">
                            <button class="btn btn-primary btn-md" type="submit">RANKING</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="col-6 mb-3">
        <?php $session = session();
        $periode = $session->get('selectedPeriode'); ?>
        <a href="laporan-prediksi-<?= $periode; ?>" id="submitButton" class=" btn btn-outline-primary btn-md btn-icon-text">LAPORAN<i class="ti-printer btn-icon-append"></i></a>
    </div> -->
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
                    <h4 class="card-title">DATA HASIL PREDIKSI</h4>
                    <p class="card-description">
                        Data peserta yang telah dilakukan prediksi
                    </p>
                </div>
                <div class="col-6">
                    <a href="simpan-prediksi-<?= $periode; ?>" id="submitButton" class=" btn btn-outline-success btn-md float-right btn-icon-text" onclick="return confirm('Setelah ini anda tidak akan dapat mengedit data ini lagi. Apakah anda yakin akan menyimpan seluruh data ini?');">SIMPAN DATA<i class="ti-file btn-icon-append"></i></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- <th></th> -->
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Seleksi</th>
                            <th>Wawancara</th>
                            <th>Kondisi Ekonomi</th>
                            <th>Akademik</th>
                            <th>Non Akademik</th>
                            <th>Suvey</th>
                            <th>Label</th>
                            <th>Akumulasi</th>
                            <th>Ranking</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (5 * ($page - 1)); ?>
                        <?php foreach ($seleksi as $seleksi) : ?>
                            <tr>
                                <td><?= $seleksi['no_pendaftaran']; ?></td>
                                <td><?= $seleksi['nama_siswa']; ?></td>
                                <td><?= $seleksi['nama_prodi']; ?></td>
                                <td><?= $seleksi['skor_nilai_seleksi']; ?></td>
                                <td><?= $seleksi['skor_nilai_wawancara']; ?></td>
                                <td><?= $seleksi['skor_nilai_kondisi_ekonomi']; ?></td>
                                <td><?= $seleksi['skor_prestasi_akademik']; ?></td>
                                <td><?= $seleksi['skor_nilai_prestasi_non_akademik']; ?></td>
                                <td><?= $seleksi['skor_nilai_hasil_survey']; ?></td>
                                <td><?php if ($seleksi['label'] == 'Tidak Layak') : ?>
                                        <span class="badge bg-danger text-white"><?= $seleksi['label']; ?></span>
                                    <?php else : ?>
                                        <span class="badge bg-success text-white"><?= $seleksi['label']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $seleksi['akumulasi']; ?></td>
                                <td><?= $seleksi['ranking']; ?></td>
                                <td><?= $seleksi['keterangan']; ?></td>
                                <td>
                                    <a href="prediksi-edit-<?= $seleksi['id_peserta']; ?>" id="editButton" class=" btn btn-warning btn-sm"><i class="ti-pencil"></i></a>
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
<?php endif; ?>
<?= $this->endSection(); ?>