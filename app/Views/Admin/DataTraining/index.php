<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<script>
    function checkAll(source) {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = source.checked;
        });
    }
</script>
<?php if (!$searched) : ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class=" card-body">
                <form action="data-training" method="get">
                    <div class="row">
                        <div class="col-3">
                            <select name="column" id="column" class="form-control form-control-sm">
                                <!-- <option value=""></option> -->
                                <option value="no_pendaftaran">Nomor Pendaftaran</option>
                                <option value="nama_siswa">Nama Siswa</option>
                                <option value="asal_sekolah">Asal Sekolah</option>
                                <option value="pilihan_program_studi">Program Studi</option>
                                <option value="skor_nilai_seleksi">Nilai Seleksi</option>
                                <option value="skor_nilai_wawancara">Nilai Wawancara</option>
                                <option value="skor_nilai_kondisi_ekonomi">Kondisi Ekonomi</option>
                                <option value="skor_prestasi_akademik">Prestasi Akademik</option>
                                <option value="skor_nilai_prestasi_non_akademik">Prestasi Non Akademik</option>
                                <option value="skor_nilai_hasil_survey">Hasil Survey</option>
                                <option value="label">Label</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="type" id="type" class="form-control form-control-sm">
                                <!-- <option value=""></option> -->
                                <option value="asc">A-Z</option>
                                <option value="desc">Z-A</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <select name="column2" id="column2" class="form-control form-control-sm">
                                <!-- <option value=""></option> -->
                                <option value="no_pendaftaran">Nomor Pendaftaran</option>
                                <option value="nama_siswa">Nama Siswa</option>
                                <option value="asal_sekolah">Asal Sekolah</option>
                                <option value="pilihan_program_studi">Program Studi</option>
                                <option value="skor_nilai_seleksi">Nilai Seleksi</option>
                                <option value="skor_nilai_wawancara">Nilai Wawancara</option>
                                <option value="skor_nilai_kondisi_ekonomi">Kondisi Ekonomi</option>
                                <option value="skor_prestasi_akademik">Prestasi Akademik</option>
                                <option value="skor_nilai_prestasi_non_akademik">Prestasi Non Akademik</option>
                                <option value="skor_nilai_hasil_survey">Hasil Survey</option>
                                <option value="label">Label</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="type2" id="type2" class="form-control form-control-sm">
                                <!-- <option value=""></option> -->
                                <option value="asc">A-Z</option>
                                <option value="desc">Z-A</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary btn-sm mt-1" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<form action="data-training-multiple" method="post">
    <?= csrf_field(); ?>
    <div class="col-6">
        <a class="btn btn-primary btn-sm" href="data-training-tambah">Tambah Data</a>
        <a href="data-training-import" class="btn btn-outline-primary btn-sm">Import</a>
        <?php if (!$searched) : ?>
            <a href="data-training-export" class="btn btn-outline-primary btn-sm">Export</a>
        <?php endif; ?>
        <button type="submit" class=" btn btn-danger btn-sm" onclick="return confirm('Apakah anda ingin mengahpus data-data ini?');">Hapus</button>
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
                <div class="row">
                    <div class="col-6">
                        <h4 class="card-title">DATA TRAINING</h4>
                        <p class="card-description">
                            Data training yang akan dijadikan data latih
                        </p>
                    </div>
                    <div class="col-6">
                        <a href="data-norm" class="btn btn-outline-success btn-md float-right" onclick="return confirm('Apakah anda yakin data sudah lengkap dan akan menormalisasi data ini?');">NORMALISASI DATA</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class=""><input type="checkbox" name="item_ids[]" onchange="checkAll(this)"></th>
                                <th>Nomor Pendaftaran</th>
                                <th>Nama Siswa</th>
                                <th>Prodi Pilihan</th>
                                <th>Asal Sekolah</th>
                                <th>Nilai Seleksi</th>
                                <th>Nilai Wawancara</th>
                                <th>Nilai Kondisi Ekonomi</th>
                                <th>Hasil Survey</th>
                                <th>Prestasi Akademik</th>
                                <th>Prestasi Non Akademik</th>
                                <th>Label</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $no = 1 + (5 * ($page - 1));
                            foreach ($training as $train) : ?>
                                <tr>
                                    <td class=""><input type="checkbox" name="item_ids[]" value="<?= $train['id']; ?>"></td>
                                    <!-- <td><?= $no++; ?></td> -->
                                    <td><?= $train['no_pendaftaran']; ?></td>
                                    <td><?= $train['nama_siswa']; ?></td>
                                    <td><?= $train['nama_prodi']; ?></td>
                                    <td><?= $train['jenis_sekolah']; ?></td>
                                    <td><?= $train['skor_nilai_seleksi']; ?></td>
                                    <td><?= $train['skor_nilai_wawancara']; ?></td>
                                    <td><?= $train['skor_nilai_kondisi_ekonomi']; ?></td>
                                    <td><?= $train['skor_nilai_hasil_survey']; ?></td>
                                    <td><?= $train['skor_prestasi_akademik']; ?></td>
                                    <td><?= $train['skor_nilai_prestasi_non_akademik']; ?></td>
                                    <td><?= $train['label']; ?></td>
                                    <td>
                                        <a href="data-training-edit-<?= $train['id']; ?>" class="btn btn-success btn-sm"><i class="ti-pencil"></i></a>
                                        <form action="data-training-<?= $train['id']; ?>" method="post" class="d-inline" id="form-delete">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda ingin mengahpus data ini?');" form="form-delete" formaction="data-training-<?= $train['id']; ?>"><i class="icon-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="float-left mt-3">
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