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
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <h4 class="card-title">TINGKAT AKURASI SISTEM</h4>
            <p class="card-description">
                Tingkat akurasi sistem pada saat ini
            </p>
            <h3 class="text-primary fs-20 font-weight-medium"><?= $akurasi; ?> %</h3>
            <hr>
            <form action="data-testing-order" method="get">
                <div class="row">
                    <div class="col-3">
                        <select name="column" id="column" class="form-control form-control-sm">
                            <option value="no_pendaftaran">Nomor Pendaftaran</option>
                            <option value="nama_siswa">Nama Siswa</option>
                            <option value="asal_sekolah">Asal Sekolah</option>
                            <option value="pilihan_program_studi">Pilihan Program Studi</option>
                            <option value="skor_nilai_seleksi">Skor Nilai Seleksi</option>
                            <option value="skor_nilai_wawancara">Skor Nilai Wawancara</option>
                            <option value="skor_nilai_kondisi_ekonomi">Skor Kondisi Ekonomi</option>
                            <option value="skor_prestasi_akademik">Skor Prestasi Akademik</option>
                            <option value="skor_nilai_prestasi_non_akademik">Skor Prestasi Non Akademik</option>
                            <option value="skor_nilai_hasil_survey">Skor Hasil Survey</option>
                            <option value="label">Label</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="type" id="type" class="form-control form-control-sm">
                            <option value="asc">A-Z</option>
                            <option value="desc">Z-A</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <select name="column2" id="column2" class="form-control form-control-sm">
                            <option value="no_pendaftaran">Nomor Pendaftaran</option>
                            <option value="nama_siswa">Nama Siswa</option>
                            <option value="asal_sekolah">Asal Sekolah</option>
                            <option value="pilihan_program_studi">Pilihan Program Studi</option>
                            <option value="skor_nilai_seleksi">Skor Nilai Seleksi</option>
                            <option value="skor_nilai_wawancara">Skor Nilai Wawancara</option>
                            <option value="skor_nilai_kondisi_ekonomi">Skor Kondisi Ekonomi</option>
                            <option value="skor_prestasi_akademik">Skor Prestasi Akademik</option>
                            <option value="skor_nilai_prestasi_non_akademik">Skor Prestasi Non Akademik</option>
                            <option value="skor_nilai_hasil_survey">Skor Hasil Survey</option>
                            <option value="label">Label</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <select name="type2" id="type2" class="form-control form-control-sm">
                            <option value="asc">A-Z</option>
                            <option value="desc">Z-A</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary btn-sm" type="submit"><i class="ti-filter"></i>Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<form action="data-testing-multiple" method="post">
    <?= csrf_field(); ?>
    <div class="row ml-2">
        <div class="col-6">
            <a href="data-testing-import" class="btn btn-outline-primary btn-sm">Import</a>
            <a href="data-testing-export" class="btn btn-outline-primary btn-sm">Export</a>
            <button type="submit" class=" btn btn-danger btn-sm" onclick="return confirm('Apakah anda ingin mengahpus data ini?');">Hapus</button>
        </div>
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
                        <h4 class="card-title">DATA TESTING</h4>
                        <p class="card-description">
                            Data testing yang akan dijadikan data uji-kan
                        </p>
                    </div>
                    <div class="col-6">
                        <a href="data-prediksi" class="btn btn-outline-success btn-md float-right" onclick="return confirm('Apakah anda yakin data sudah lengkap dan akan memprediksi data ini?');">PERDIKSI DATA</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                <th>Prediksi</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            $no = 1 + (5 * ($page - 1));
                            foreach ($testing as $uji) : ?>
                                <tr>
                                    <td class=""><input type="checkbox" name="item_ids[]" value="<?= $uji['id']; ?>"></td>
                                    <td><?= $uji['no_pendaftaran']; ?></td>
                                    <td><?= $uji['nama_siswa']; ?></td>
                                    <td><?= $uji['nama_prodi']; ?></td>
                                    <td><?= $uji['jenis_sekolah']; ?></td>
                                    <td><?= $uji['skor_nilai_seleksi']; ?></td>
                                    <td><?= $uji['skor_nilai_wawancara']; ?></td>
                                    <td><?= $uji['skor_nilai_kondisi_ekonomi']; ?></td>
                                    <td><?= $uji['skor_nilai_hasil_survey']; ?></td>
                                    <td><?= $uji['skor_prestasi_akademik']; ?></td>
                                    <td><?= $uji['skor_nilai_prestasi_non_akademik']; ?></td>
                                    <td><?= $uji['label']; ?></td>
                                    <td><?= $uji['prediksi']; ?></td>
                                    <td>
                                        <a href="data-testing-edit-<?= $uji['id']; ?>" class="btn btn-success btn-sm"><i class="ti-pencil"></i></a>
                                        <form action="data-testing-<?= $uji['id']; ?>" method="post" class="d-inline" id="form-delete">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda ingin mengahpus data ini?');" form="form-delete" formaction="data-testing-<?= $uji['id']; ?>"><i class=" icon-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="float-left mt-4">
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