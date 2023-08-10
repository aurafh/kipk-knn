<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="data-prodi-update-<?= $prodi['id_prodi']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data Program Studi</h4>
                    <p class="card-description">
                        Masukkan data program studi baru!
                    </p>
                    <input type="hidden" name="id_sekolah" value="<?= $prodi['id_prodi']; ?>">
                    <div class="form-group">
                        <label for="nama_prodi">Nama Program Studi</label>
                        <input type="text" class="form-control form-control-sm" name=" nama_prodi" placeholder="Nama Program Studi" id="nama_prodi" value="<?= (old('nama_prodi')) ? old('nama_prodi') : $prodi['nama_prodi']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nilai_atribut_prodi">Nilai Atribut</label>
                        <input type="number" class="form-control form-control-sm" name="nilai_atribut_prodi" placeholder="Nilai Atribut" id="nilai_atribut_prodi" value="<?= (old('nilai_atribut_prodi')) ? old('nilai_atribut_prodi') : $prodi['nilai_atribut_prodi']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <a class="btn btn-light" href="data-prodi">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>