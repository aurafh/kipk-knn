<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="data-seleksi-<?= $peserta['id']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data Seleksi</h4>
                    <p class="card-description">
                        Data Peserta Seleksi
                    </p>
                    <input type="hidden" name="id" value="<?= $peserta['id']; ?>">
                    <div class="form-group">
                        <label for="no_pendaftaran">No. Pendaftaran</label>
                        <input type="text" class="form-control form-control-sm" name="no_pendaftaran" placeholder="Nomor Pendaftaran" id="no_pendaftaran" value="<?= (old('no_pendaftaran')) ? old('no_pendaftaran') : $peserta['no_pendaftaran']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_siswa">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" name="nama_siswa" placeholder="Nama Lengkap" id="nama_siswa" value="<?= (old('nama_siswa')) ? old('nama_siswa') : $peserta['nama_siswa']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_sekolah">Nama Sekolah</label>
                        <input type="text" class="form-control form-control-sm" name="nama_sekolah" placeholder="Nama Sekolah" id="nama_sekolah" value="<?= (old('nama_sekolah')) ? old('nama_sekolah') : $peserta['nama_sekolah']; ?>">
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
                        <label for="skor_nilai_seleksi">Skor Seleksi</label>
                        <input type="number" class=" form-control form-control-sm" name="skor_nilai_seleksi" placeholder="Skor Seleksi" id="skor_nilai_seleksi" value="<?= (old('skor_nilai_seleksi')) ? old('skor_nilai_seleksi') : $peserta['skor_nilai_seleksi']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_wawancara">Skor Wawancara</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_wawancara" placeholder="Skor Wawancara" id="skor_nilai_wawancara" value="<?= (old('skor_nilai_wawancara')) ? old('skor_nilai_wawancara') : $peserta['skor_nilai_wawancara']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_kondisi_ekonomi">Kondisi Ekonomi</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_kondisi_ekonomi" placeholder="Kondisi Ekonomi" id="skor_nilai_kondisi_ekonomi" value="<?= (old('skor_nilai_kondisi_ekonomi')) ? old('skor_nilai_kondisi_ekonomi') : $peserta['skor_nilai_kondisi_ekonomi']; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="skor_nilai_hasil_survey">Hasil Survey</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_hasil_survey" placeholder="Hasil Survey" id="skor_nilai_hasil_survey" value="<?= (old('skor_nilai_hasil_survey')) ? old('skor_nilai_hasil_survey') : $peserta['skor_nilai_hasil_survey']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_prestasi_akademik">Prestasi Akademik</label>
                        <input type="number" class="form-control form-control-sm" name="skor_prestasi_akademik" placeholder="Prestasi Akademik" id="skor_prestasi_akademik" value="<?= (old('skor_prestasi_akademik')) ? old('skor_prestasi_akademik') : $peserta['skor_prestasi_akademik']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_prestasi_non_akademik">Prestasi Non Akademik</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_prestasi_non_akademik" placeholder="Prestasi Non Akademik" id="skor_nilai_prestasi_non_akademik" value="<?= (old('skor_nilai_prestasi_non_akademik')) ? old('skor_nilai_prestasi_non_akademik') : $peserta['skor_nilai_prestasi_non_akademik']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="label">Label</label>
                        <select name="label" class="form-control form-control-sm" id="label">
                            <option value=""></option>
                            <option value="Layak" <?= $peserta['label'] == 'Layak' ? 'selected' : old('label'); ?>>Layak</option>
                            <option value="Tidak Layak" <?= $peserta['label'] == 'Tidak Layak' ? 'selected' : old('label'); ?>>Tidak Layak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ranking">Ranking</label>
                        <input type="number" class="form-control form-control-sm" name="ranking" placeholder="Ranking" id="ranking" value="<?= (old('ranking')) ? old('ranking') : $peserta['ranking']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control form-control-sm" name="keterangan" placeholder="Keterangan" id="keterangan" value="<?= (old('keterangan')) ? old('keterangan') : $peserta['keterangan']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a class="btn btn-light" href="seleksi">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>