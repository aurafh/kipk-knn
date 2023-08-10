<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

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
        <div class=" card-body">
            <h4 class="card-title">DATA TRAINING NORMALIZED</h4>
            <p class="card-description">
                Data Training Normalized
            </p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nomor Pendaftaran</th>
                            <th>Nama Siswa</th>
                            <th>Prodi Pilihan</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai Seleksi</th>
                            <th>Nilai Wawancara</th>
                            <th>Nilai Kondisi Ekonomi</th>
                            <th>Hasil Survey</th>
                            <th>Prestasi Akademik</th>
                            <th>Prestasi Non Akademik</th>
                            <th>Label</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (5 * ($page - 1));
                        foreach ($norm as $latih) : ?>
                            <tr>
                                <td><?= $latih['no_pendaftaran']; ?></td>
                                <td><?= $latih['nama_siswa']; ?></td>
                                <td><?= $latih['pilihan_program_studi']; ?></td>
                                <td><?= $latih['asal_sekolah']; ?></td>
                                <td><?= $latih['skor_nilai_seleksi']; ?></td>
                                <td><?= $latih['skor_nilai_wawancara']; ?></td>
                                <td><?= $latih['skor_nilai_kondisi_ekonomi']; ?></td>
                                <td><?= $latih['skor_nilai_hasil_survey']; ?></td>
                                <td><?= $latih['skor_prestasi_akademik']; ?></td>
                                <td><?= $latih['skor_nilai_prestasi_non_akademik']; ?></td>
                                <td><?= $latih['label']; ?></td>
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
<?= $this->endSection(); ?>