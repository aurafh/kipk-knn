<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="data-pendaftar-<?= $peserta['id_peserta']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data Pendaftar</h4>
                    <p class="card-description">
                        Data pendaftar
                    </p>
                    <input type="hidden" name="id_peserta" value="<?= $peserta['id_peserta']; ?>">
                    <div class="form-group">
                        <label for="no_pendaftaran">No. Pendaftaran</label>
                        <input type="text" class="form-control form-control-sm" name="no_pendaftaran" placeholder="Nomor Pendaftaran" id="no_pendaftaran" value="<?= (old('no_pendaftaran')) ? old('no_pendaftaran') : $peserta['no_pendaftaran']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="nama_siswa" placeholder="Nama Lengkap" id="nama_siswa" value="<?= (old('nama_siswa')) ? old('nama_siswa') : $peserta['nama_siswa']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="jenis_kel">Jenis Kelamin</label>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="jenis_kel" id="jenis_kel" value="L" <?= $peserta['jenis_kel'] == 'L' ? 'checked' : old('jenis_kel'); ?>>
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="jenis_kel" id="jenis_kel" value="P" <?= $peserta['jenis_kel'] == 'P' ? 'checked' : old('jenis_kel'); ?>>
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nisn">NISN</label>
                        <input type="number" class="form-control form-control-sm" name="nisn" placeholder="NISN" id="nisn" value="<?= (old('nisn')) ? old('nisn') : $peserta['nisn']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="jenis_sekolah">Jenis Sekolah</label>
                        <select name="id_sekolah" class="form-control form-control-sm" id="id_sekolah">
                            <?php foreach ($sekolah as $key => $data) : ?>
                                <option value="<?= $data['id_sekolah']; ?>" <?= $peserta['id_sekolah'] == $data['id_sekolah'] ? 'selected' : old('id_sekolah'); ?>>
                                    <?= $data['jenis_sekolah']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_sekolah">Nama Sekolah</label>
                        <input type="text" class="form-control form-control-sm" name="nama_sekolah" placeholder="Nama Sekolah" id="nama_sekolah" value="<?= (old('nama_sekolah')) ? old('nama_sekolah') : $peserta['nama_sekolah']; ?>">
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
                        <label for="no_wa">No. WA</label>
                        <input type="text" class="form-control form-control-sm" name=" no_wa" placeholder="Nomor WhatsApp" id="no_wa" value="<?= (old('no_wa')) ? old('no_wa') : $peserta['no_wa']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nilai_atribut_prodi">Program Studi Pilihan</label>
                        <select name="id_prodi" class="form-control form-control-sm" id="id_prodi">
                            <?php foreach ($prodi as $key => $data) : ?> <option value="<?= $data['id_prodi']; ?>" <?= $peserta['id_prodi'] == $data['id_prodi'] ? 'selected' : old('id_prodi'); ?>>
                                    <?= $data['nama_prodi']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="periode">Periode</label>
                        <select name="id_periode" class="form-control form-control-sm" id="id_periode">
                            <?php foreach ($periode as $key => $data) : ?>
                                <option value="<?= $data['id_periode']; ?>" <?= $peserta['id_periode'] == $data['id_periode'] ? 'selected' : old('id_periode'); ?>>
                                    <?= $data['periode']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bukti">Kartu Peserta</label>
                        <div class="col-xl-12">
                            <img class="img-thumbnail img-preview" src="files/<?= $peserta['bukti']; ?>">
                        </div>
                        <input type="file" name="bukti" class="file-upload-default" id="bukti" onchange="previewImg()">
                        <div class="input-group col-xs-12 mt-3">
                            <input type="text" class="form-control file-upload-info" placeholder="Upload Image" id="bukti" value="<?= (old('bukti')) ? old('bukti') : $peserta['bukti']; ?>">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="label">Label</label>
                        <select name="label" class="form-control form-control-sm" id="label">
                            <option value=""></option>
                            <option value="Layak" <?= $peserta['label'] == 'Layak' ? 'selected' : old('label'); ?>>Layak</option>
                            <option value="Tidak Layak" <?= $peserta['label'] == 'Tidak Layak' ? 'selected' : old('label'); ?>>Tidak Layak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a class="btn btn-light" href="data-peserta">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>