<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<form action="seleksi-update-<?= $seleksi['id']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data Pendaftar</h4>
                    <p class="card-description">
                        Verifikasi data pendaftar
                    </p>
                    <input type="hidden" name="id" value="<?= $seleksi['id']; ?>">
                    <div class="form-group">
                        <label for="no_pendaftaran">No. Pendaftaran</label>
                        <input type="text" class="form-control form-control-sm" name="no_pendaftaran" id="no_pendaftaran" value="<?= (old('no_pendaftaran')) ? old('no_pendaftaran') : $seleksi['no_pendaftaran']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="nama_siswa" id="nama_siswa" value="<?= (old('nama_siswa')) ? old('nama_siswa') : $seleksi['nama_siswa']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="id_prodi">Prodi</label>
                        <select name="id_prodi" class="form-control form-control-sm" id="id_prodi" disabled>
                            <?php foreach ($prodi as $key => $data) : ?>
                                <option value="<?= $data['id_prodi']; ?>" <?= $seleksi['id_prodi'] == $data['id_prodi'] ? 'selected' : old('id_prodi'); ?>>
                                    <?= $data['nama_prodi']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_sekolah">Sekolah</label>
                        <input type="text" class="form-control form-control-sm" name="nama_sekolah" id="nama_sekolah" value="<?= (old('nama_sekolah')) ? old('nama_sekolah') : $seleksi['nama_sekolah']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_seleksi">Skor Seleksi</label>
                        <input type="number" class=" form-control form-control-sm" name="skor_nilai_seleksi" placeholder="Skor Seleksi" id="skor_nilai_seleksi" value="<?= (old('skor_nilai_seleksi')) ? old('skor_nilai_seleksi') : $seleksi['skor_nilai_seleksi']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="skor_nilai_wawancara">Skor Wawancara</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_wawancara" placeholder="Skor Wawancara" id="skor_nilai_wawancara" value="<?= (old('skor_nilai_wawancara')) ? old('skor_nilai_wawancara') : $seleksi['skor_nilai_wawancara']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_kondisi_ekonomi">Kondisi Ekonomi</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_kondisi_ekonomi" placeholder="Kondisi Ekonomi" id="skor_nilai_kondisi_ekonomi" value="<?= (old('skor_nilai_kondisi_ekonomi')) ? old('skor_nilai_kondisi_ekonomi') : $seleksi['skor_nilai_kondisi_ekonomi']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_hasil_survey">Hasil Survey</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_hasil_survey" placeholder="Hasil Survey" id="skor_nilai_hasil_survey" value="<?= (old('skor_nilai_hasil_survey')) ? old('skor_nilai_hasil_survey') : $seleksi['skor_nilai_hasil_survey']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_prestasi_akademik">Prestasi Akademik</label>
                        <input type="number" class="form-control form-control-sm" name="skor_prestasi_akademik" placeholder="Prestasi Akademik" id="skor_prestasi_akademik" value="<?= (old('skor_prestasi_akademik')) ? old('skor_prestasi_akademik') : $seleksi['skor_prestasi_akademik']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_prestasi_non_akademik">Prestasi Non Akademik</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_prestasi_non_akademik" placeholder="Prestasi Non Akademik" id="skor_nilai_prestasi_non_akademik" value="<?= (old('skor_nilai_prestasi_non_akademik')) ? old('skor_nilai_prestasi_non_akademik') : $seleksi['skor_nilai_prestasi_non_akademik']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <a class="btn btn-light" href="data-seleksi">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>