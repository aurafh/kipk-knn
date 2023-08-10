<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="prediksi-update-<?= $seleksi['id']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-warning">
                        <?= session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <h4 class="card-title">Edit Data Pendaftar</h4>
                    <p class="card-description">
                        Verifikasi data pendaftar
                    </p>
                    <input type="hidden" name="id" value="<?= $seleksi['id']; ?>">
                    <div class="form-group">
                        <label for="no_pendaftaran">No. Pendaftaran</label>
                        <input type="text" class="form-control form-control-sm" name="no_pendaftaran" placeholder="Nomor Pendaftaran" id="no_pendaftaran" value="<?= (old('no_pendaftaran')) ? old('no_pendaftaran') : $seleksi['no_pendaftaran']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="nama_siswa" placeholder="Nama Lengkap" id="nama_siswa" value="<?= (old('nama_siswa')) ? old('nama_siswa') : $seleksi['nama_siswa']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="id_prodi">Program Studi</label>
                        <select name="id_prodi" class="form-control form-control-sm" id="id_prodi" disabled>
                            <?php foreach ($prodi as $key => $data) : ?>
                                <option value="<?= $data['id_prodi']; ?>" <?= $seleksi['id_prodi'] == $data['id_prodi'] ? 'selected' : old('id_prodi'); ?>>
                                    <?= $data['nama_prodi']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="label">Status</label>
                        <select name="label" class="form-control form-control-sm" id="label">
                            <option value="Layak" <?= ($seleksi['label'] == 'Layak') ? "selected" : old('label'); ?>>Layak</option>
                            <option value="Tidak Layak" <?= ($seleksi['label'] == 'Tidak Layak') ? "selected" : old('label'); ?>>Tidak Layak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ranking">Ranking</label>
                        <input type="number" class="form-control form-control-sm" name="ranking" placeholder="Ranking" id="ranking" value="<?= (old('ranking')) ? old('ranking') : $seleksi['ranking']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control form-control-sm" name="keterangan" placeholder="Keterangan" id="keterangan" value="<?= (old('keterangan')) ? old('keterangan') : $seleksi['keterangan']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <!-- <a class="btn btn-light" href="data-prediksi">Cancel</a> -->
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>