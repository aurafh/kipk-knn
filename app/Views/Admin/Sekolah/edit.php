<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="data-sekolah-update-<?= $sekolah['id_sekolah']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tambah Data Sub Atribut</h4>
                    <p class="card-description">
                        Masukkan data sekolah atribut baru!
                    </p>
                    <input type="hidden" name="id_sekolah" value="<?= $sekolah['id_sekolah']; ?>">
                    <div class="form-group">
                        <label for="jenis_sekolah">Jenis Sekolah</label>
                        <input type="text" class="form-control form-control-sm" name=" jenis_sekolah" placeholder="Jenis Sekolah" id="jenis_sekolah" value="<?= (old('jenis_sekolah')) ? old('jenis_sekolah') : $sekolah['jenis_sekolah']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nilai_atribut">Nilai Atribut</label>
                        <input type="number" class="form-control form-control-sm" name="nilai_atribut" placeholder="Nilai Atribut" id="nilai_atribut" value="<?= (old('nilai_atribut')) ? old('nilai_atribut') : $sekolah['nilai_atribut']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <a class="btn btn-light" href="data-sekolah">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>