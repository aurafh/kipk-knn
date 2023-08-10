<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="peserta-update-<?= $peserta['id_peserta']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data Pendaftar</h4>
                    <p class="card-description">
                        Verifikasi data pendaftar
                    </p>
                    <input type="hidden" name="id_peserta" value="<?= $peserta['id_peserta']; ?>">
                    <div class="form-group">
                        <label for="no_pendaftaran">No. Pendaftaran</label>
                        <input type="text" class="form-control form-control-sm" name="no_pendaftaran" placeholder="Nomor Pendaftaran" id="no_pendaftaran" value="<?= (old('no_pendaftaran')) ? old('no_pendaftaran') : $peserta['no_pendaftaran']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="nama_siswa" placeholder="Nama Lengkap" id="nama_siswa" value="<?= (old('nama_siswa')) ? old('nama_siswa') : $peserta['nama_siswa']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="id_prodi">Program Studi</label>
                        <select name="id_prodi" class="form-control form-control-sm" id="id_prodi" disabled>
                            <?php foreach ($prodi as $key => $data) : ?>
                                <option value="<?= $data['id_prodi']; ?>" <?= $peserta['id_prodi'] == $data['id_prodi'] ? 'selected' : old('id_prodi'); ?>>
                                    <?= $data['nama_prodi']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control form-control-sm" id="status">
                            <option value="WAITING" <?= $peserta['status'] == 'WAITING' ? 'selected' : old('status'); ?>>WAITING</option>
                            <option value="VALIDATE" <?= $peserta['status'] == 'VALIDATE' ? 'selected' : old('status'); ?>>VALIDATE</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="bukti">Kartu Peserta</label>
                        <div class="col-xl-12">
                            <img class="img-thumbnail img-preview" src="files/<?= $peserta['bukti']; ?>">
                        </div>
                        <input type="file" name="bukti" class="file-upload-default" id="bukti" onchange="previewImg()" disabled>
                        <div class="input-group col-xs-12 mt-3">
                            <input type="text" class="form-control file-upload-info" placeholder="Upload Image" id="bukti" value="<?= (old('bukti')) ? old('bukti') : $peserta['bukti']; ?>" disabled>
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button" disabled>Upload</button>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Data</button>
                    <a class="btn btn-light mt-3" href="data-peserta">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>