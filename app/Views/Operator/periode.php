<?= $this->extend('partials/login'); ?>

<?= $this->section('content'); ?>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center">
            <div class="container text-center">
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
                <div class="row justify-content-center">
                    <?php foreach ($periode as $thn) : ?>
                        <div class="col-4 px-2">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">DATA PERIODE</h5>
                                    <!-- <h6 class="card-subtitle mb-2 text-body-secondary"></h6> -->
                                    <h4 class="card-subtitle mb-3 text-body-secondary"><?= $thn['periode']; ?></h4>
                                    <hr>
                                    <a href="data-peserta-<?= $thn['periode']; ?>" class="card-link">BUKA</a>
                                    <form action="periode-<?= $thn['id_periode']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-link" onclick="return confirm('Apakah anda ingin mengahpus data ini?');">HAPUS</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="col-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">TAMBAH PERIODE</h5>
                                <!-- <h6 class="card-subtitle mb-2 text-body-secondary"></h6> -->
                                <form action="periode-save" method="post">
                                    <input type="text" name="periode" class="form-control form-control-sm" placeholder="Tambah periode baru">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Tambah</button>
                                </form>
                                <!-- <hr> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- content-wrapper ends -->
</div>
<!-- page-body-wrapper ends -->
<<?= $this->endSection(); ?>