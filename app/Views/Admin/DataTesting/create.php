<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>


<form action="/data-testing-prediksi" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Data Testing</h4>
            <p class="card-description">
                Masukkan data testing baru!
            </p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_pendaftaran">Nomor Pendaftaran</label>
                        <input type="number" class="form-control form-control-sm" name=" no_pendaftaran" placeholder="Nomor Pendaftaran" id="no_pendaftaran" value="<?= old('no_pendaftaran'); ?>" required>
                    </div>
                    <div class=" form-group">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" class="form-control form-control-sm" name="nama_siswa" placeholder="Nama Siswa" id="nama_siswa" value="<?= old('nama_siswa'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_prodi">Pilihan Program Studi</label>
                        <select name="id_prodi" class="form-control form-control-sm" id="id_prodi">
                            <option value="" selected>Program Studi</option>
                            <?php foreach ($prodi as $key => $data) : ?>
                                <option value="<?= $data['id_prodi']; ?>"><?= $data['nama_prodi']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_sekolah">Asal Sekolah</label>
                        <select name="id_sekolah" class="form-control form-control-sm" id="id_sekolah">
                            <option value="" selected>Asal Sekolah</option>
                            <?php foreach ($sekolah as $key => $data) : ?>
                                <option value="<?= $data['id_sekolah']; ?>"><?= $data['jenis_sekolah']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_seleksi">Skor Nilai Seleksi</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_seleksi" placeholder="Skor Nilai Seleksi" id="skor_nilai_seleksi" value="<?= old('skor_nilai_seleksi'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_wawancara">Skor Nilai Wawancara</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_wawancara" placeholder="Skor Nilai Wawancara" id="skor_nilai_wawancara" value="<?= old('skor_nilai_wawancara'); ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="skor_nilai_kondisi_ekonomi">Skor Nilai Kondisi Ekonomi</label>
                        <input type="number" id="skor_nilai_kondisi_ekonomi" class="form-control form-control-sm" name="skor_nilai_kondisi_ekonomi" placeholder="Skor Nilai Kondisi Ekonomi" value="<?= old('skor_nilai_kondisi_ekonomi'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_hasil_survey">Skor Nilai Hasil Survey</label>
                        <input type="number" id="skor_nilai_hasil_survey" class="form-control form-control-sm" name="skor_nilai_hasil_survey" placeholder="Nilai Hasil Survey" value="<?= old('skor_nilai_hasil_survey'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_prestasi_akademik">Skor Prestasi Akademik</label>
                        <input type="number" id="skor_prestasi_akademik" class="form-control form-control-sm" name="skor_prestasi_akademik" placeholder="Prestasi Akademik" value="<?= old('skor_prestasi_akademik'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_prestasi_non_akademik">Skor Prestasi Non Akademik</label>
                        <input type="number" id="skor_nilai_prestasi_non_akademik" class="form-control form-control-sm " name="skor_nilai_prestasi_non_akademik" placeholder="Skor Prestasi Non Akademik" value="<?= old('skor_nilai_prestasi_non_akademik'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_k">Jumlah Tetangga <i>(k)</i></label>
                        <select name="jumlah_k" class="form-control form-control-sm" id="jumlah_k">
                            <option value="" selected>Jumlah Tetangga</option>
                            <option value="3">3</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2 my-2">Prediksi</button>
                    <a class="btn btn-light my-2" href="data-training">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>