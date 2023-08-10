<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">DATA TESTING</h4>
                <div class="row">
                    <label class="col-sm-5">Nomor Pendaftaran</label>
                    <div class="col-sm-7">
                        <p>: <?= $test['no_pendaftaran']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Nama Siswa</label>
                    <div class="col-sm-7">
                        <p>: <?= $test['nama_siswa']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Pilihan Program Studi</label>
                    <div class="col-sm-7">
                        <p>:
                            <?php foreach ($prodi as $key => $data) : ?>
                                <?= $test['id_prodi'] == $data['id_prodi'] ? $data['nama_prodi'] : null; ?>
                            <?php endforeach ?>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Asal Sekolah</label>
                    <div class="col-sm-7">
                        <p>:
                            <?php foreach ($sekolah as $key => $data) : ?>
                                <?= $test['id_sekolah'] == $data['id_sekolah'] ? $data['jenis_sekolah'] : null; ?>
                            <?php endforeach ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Skor Seleksi</label>
                    <div class="col-sm-7">
                        <p>: <?= $test['skor_nilai_seleksi']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Skor Wawancara</label>
                    <div class="col-sm-7">
                        <p>: <?= $test['skor_nilai_wawancara']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Skor Kondisi Ekonomi</label>
                    <div class="col-sm-7">
                        <p>: Rp. <?= $test['skor_nilai_kondisi_ekonomi']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Skor Hasil Survey</label>
                    <div class="col-sm-7">
                        <p>: <?= $test['skor_nilai_hasil_survey']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Skor Prestasi Akademik</label>
                    <div class="col-sm-7">
                        <p>: <?= $test['skor_prestasi_akademik']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-5">Skor Prestasi Non Akademik</label>
                    <div class="col-sm-7">
                        <p>: <?= $test['skor_nilai_prestasi_non_akademik']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">HASIL PREDIKSI</h4>
                <p class="card-description">
                    Data tersebut termasuk sebagai peserta
                </p>
                <h3 class="text-primary fs-20 font-weight-medium text-center"><?= $dominan; ?> Diterima</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tetangga</th>
                                <th>Label</th>
                                <th>Jarak</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($knn as $index => $neighbor) : ?>
                                <tr>
                                    <td><?= $neighbor['id']; ?></td>
                                    <?php
                                    if ($neighbor['label'] == 1) {
                                        $hasil = 'Layak Diterima';
                                    } else {
                                        $hasil = 'Tidak Layak Diterima';
                                    }
                                    ?>
                                    <td><?= $hasil; ?></td>
                                    <td><?= $neighbor['distance']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>