<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="data-training-update-<?= $training['id']; ?>" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ubah Data Trainning</h4>
                    <p class="card-description">
                        Ubah data trainning!
                    </p>
                    <input type="hidden" name="id" value="<?= $training['id']; ?>">
                    <div class="form-group">
                        <label for="no_pendaftaran">Nomor Pendaftaran</label>
                        <input type="number" class="form-control form-control-sm" name=" no_pendaftaran" placeholder="Nomor Pendaftaran" id="no_pendaftaran" value="<?= (old('no_pendaftaran')) ? old('no_pendaftaran') : $training['no_pendaftaran']; ?>" required>
                    </div>
                    <div class=" form-group">
                        <label for="nama_siswa">Nama Siswa</label>
                        <input type="text" class="form-control form-control-sm" name="nama_siswa" placeholder="Nama Siswa" id="nama_siswa" value="<?= (old('nama_siswa')) ? old('nama_siswa') : $training['nama_siswa']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_prodi">Pilihan Program Studi</label>
                        <select name="id_prodi" class="form-control form-control-sm" id="id_prodi">
                            <option value="" hidden></option>
                            <?php foreach ($prodi as $key => $data) : ?>
                                <option value="<?= $data['id_prodi']; ?>" <?= $training['id_prodi'] == $data['id_prodi'] ? 'selected' : old('id_prodi'); ?>>
                                    <?= $data['nama_prodi']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_sekolah">Asal Sekolah</label>
                        <select name="id_sekolah" class="form-control form-control-sm" id="id_sekolah">
                            <option value="" hidden></option>
                            <?php foreach ($sekolah as $key => $data) : ?>
                                <option value="<?= $data['id_sekolah']; ?>" <?= $training['id_sekolah'] == $data['id_sekolah'] ? 'selected' : old('id_sekolah'); ?>>
                                    <?= $data['jenis_sekolah']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_seleksi">Skor Nilai Seleksi</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_seleksi" placeholder="Skor Nilai Seleksi" id="skor_nilai_seleksi" value="<?= (old('skor_nilai_seleksi')) ? old('skor_nilai_seleksi') : $training['skor_nilai_seleksi']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_wawancara">Skor Nilai Wawancara</label>
                        <input type="number" class="form-control form-control-sm" name="skor_nilai_wawancara" placeholder="Skor Nilai Wawancara" id="skor_nilai_wawancara" value="<?= (old('skor_nilai_wawancara')) ? old('skor_nilai_wawancara') : $training['skor_nilai_wawancara']; ?>" required>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 grid-margin stretch-card mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="skor_nilai_kondisi_ekonomi">Skor Nilai Kondisi Ekonomi</label>
                        <input type="number" id="skor_nilai_kondisi_ekonomi" class="form-control form-control-sm" name="skor_nilai_kondisi_ekonomi" placeholder="Skor Nilai Kondisi Ekonomi" value="<?= (old('skor_nilai_kondisi_ekonomi')) ? old('skor_nilai_kondisi_ekonomi') : $training['skor_nilai_kondisi_ekonomi']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_hasil_survey">Skor Nilai Hasil Survey</label>
                        <input type="number" id="skor_nilai_hasil_survey" class="form-control form-control-sm" name="skor_nilai_hasil_survey" placeholder="Nilai Hasil Survey" value="<?= (old('skor_nilai_hasil_survey')) ? old('skor_nilai_hasil_survey') : $training['skor_nilai_hasil_survey']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_prestasi_akademik">Skor Prestasi Akademik</label>
                        <input type="number" id="skor_prestasi_akademik" class="form-control form-control-sm" name="skor_prestasi_akademik" placeholder="Prestasi Akademik" value="<?= (old('skor_prestasi_akademik')) ? old('skor_prestasi_akademik') : $training['skor_prestasi_akademik']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="skor_nilai_prestasi_non_akademik">Skor Prestasi Non Akademik</label>
                        <input type="number" id="skor_nilai_prestasi_non_akademik" class="form-control form-control-sm " name="skor_nilai_prestasi_non_akademik" placeholder="Skor Prestasi Non Akademik" value="<?= (old('skor_nilai_prestasi_non_akademik')) ? old('skor_nilai_prestasi_non_akademik') : $training['skor_nilai_prestasi_non_akademik']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="label">Label</label>
                        <select name="label" class="form-control form-control-sm" id="label">
                            <option value="" selected>Label</option>
                            <option value="Layak" <?= ($training['label'] == 'Layak') ? "selected" : old('label'); ?>>Layak</option>
                            <option value="Tidak Layak" <?= ($training['label'] == 'Tidak Layak') ? "selected" : old('label'); ?>>Tidak Layak</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <a class="btn btn-light" href="/data-training">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>