<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<?php if (!$cekData) : ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">DATA PESERTA</div>
            <div class="card-body text-center">
                <h4>
                    <i>Belum ada Data Peserta pada Periode ini</i>
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
                <h4 class="card-title">DATA PENDAFTAR</h4>
                <p class="card-description">
                    Data Pendaftar yang akan menjadi peserta
                </p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <!-- <th></th> -->
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Kartu Peserta</th>
                                <th>Prodi</th>
                                <th colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $no = 1 + (5 * ($page - 1));
                            foreach ($peserta as $peserta) : ?>
                                <tr>
                                    <!-- <td class=""><input type="checkbox" name="item_ids[]" value="<?= $peserta['id_peserta']; ?>"></td> -->
                                    <td><?= $peserta['no_pendaftaran']; ?></td>
                                    <td><?= $peserta['nama_siswa']; ?></td>
                                    <td>
                                        <?php if ($peserta['status'] == 'WAITING') : ?>
                                            <span class="badge bg-warning text-white"><?= $peserta['status']; ?></span>
                                        <?php else : ?>
                                            <span class="badge bg-success text-white"><?= $peserta['status']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><img src="files/<?= $peserta['bukti']; ?>" class="rounded w-50" alt="Bukti"></td>
                                    <td><?= $peserta['nama_prodi']; ?></td>
                                    <td>
                                        <a href="peserta-edit-<?= $peserta['id_peserta']; ?>" class="btn btn-warning btn-sm"><i class="ti-pencil"></i></a>
                                    </td>
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
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>