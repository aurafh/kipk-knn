<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class=" card-body">
            <form action="data-prodi-order" method="get">
                <div class="row">
                    <div class="col-4">
                        <select name="column" id="column" class="form-control form-control-sm">
                            <option value="nama_prodi">Nama Prodi</option>
                            <option value="nilai_atribut_prodi">Nilai Atribut Prodi</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <select name="type" id="type" class="form-control form-control-sm">
                            <option value="asc">A-Z</option>
                            <option value="desc">Z-A</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary btn-sm" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<form action="data-prodi-multiple" method="post">
    <?= csrf_field(); ?>
    <div class="col-6">
        <a class="btn btn-primary btn-sm" href="data-prodi-tambah">Tambah</a>
        <button type="submit" class=" btn btn-danger btn-sm" onclick="return confirm('Apakah anda ingin mengahpus data ini?');">Hapus</button>
    </div>
    <div class="col-lg-12 grid-margin stretch-card mt-3">
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
                <h4 class="card-title">DATA PROGRAM STUDI</h4>
                <p class="card-description">
                    Data Program Studi
                </p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID PRODI</th>
                                <th>NAMA PRODI</th>
                                <th>NILAI ATRIBUT</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $no = 1 + (5 * ($page - 1));
                            foreach ($prodi as $prodi) : ?>
                                <tr>
                                    <td class=""><input type="checkbox" name="item_ids[]" value="<?= $prodi['id_prodi']; ?>"></td>
                                    <td><?= $prodi['id_prodi']; ?></td>
                                    <td><?= $prodi['nama_prodi']; ?></td>
                                    <td><?= $prodi['nilai_atribut_prodi']; ?></td>
                                    <td>
                                        <a href="data-prodi-edit-<?= $prodi['id_prodi']; ?>" class="btn btn-success btn-sm"><i class="ti-pencil"></i></a>
                                        <form action="data-prodi-<?= $prodi['id_prodi']; ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda ingin mengahpus data ini?');"><i class="icon-trash"></i></button>
                                        </form>
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
</form>
<?= $this->endSection(); ?>