<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<?php if (!$cekData) : ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">HASIL KEPUTUSAN</div>
            <div class="card-body text-center">
                <h4>
                    <i>Belum ada Data Hasil Keputusan pada Periode ini</i>
                </h4>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="card">
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">HASIL KEPUTUSAN</h4>
                    <p class="card-description">
                        Data calon mahasiswa yang lolos seleksi
                    </p>
                </div>
                <div class="col-6">
                    <?php $session = session();
                    $periode = $session->get('selectedPeriode'); ?>
                    <a href="laporan-prediksi-<?= $periode; ?>" id="submitButton" class=" btn btn-primary float-right btn-md btn-icon-text">LAPORAN<i class="ti-printer btn-icon-append"></i></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nomor Pendaftaran</th>
                            <th>Nama Lengkap</th>
                            <th>Asal Sekolah</th>
                            <th>Program Studi</th>
                            <th>Label</th>
                            <th>Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (5 * ($page - 1));
                        foreach ($seleksi as $seleksi) : ?>
                            <tr>
                                <td><?= $seleksi['no_pendaftaran']; ?></td>
                                <td><?= $seleksi['nama_siswa']; ?></td>
                                <td><?= $seleksi['nama_sekolah']; ?></td>
                                <td><?= $seleksi['nama_prodi']; ?></td>
                                <td><?php if ($seleksi['label'] == 'Tidak Layak') : ?>
                                        <span class="badge bg-danger text-white"><?= $seleksi['label']; ?></span>
                                    <?php else : ?>
                                        <span class="badge bg-success text-white"><?= $seleksi['label']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $seleksi['ranking']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="float-left mt-4">
                <i>Showing <?= $pager->getTotal() ?> entries</i>
            </div>
            <div class="float-right mt-3">
                <?= $pager->links('default', 'paginate'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>