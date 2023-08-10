<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="seleksi" method="get">
                <div class="row">
                    <?php $request = \Config\Services::request(); ?>
                    <div class="col-3">
                        <label for="periode">Periode</label>
                        <select name="periode" id="periode" class="form-control form-control-sm">
                            <?php foreach ($tahun as $thn) : ?>
                                <option value="">Periode</option>
                                <option value="<?= $thn['id_periode']; ?>" <?= ($request->getVar('periode') == $thn['id_periode']) ? 'selected' : $thn['id_periode']; ?>><?= $thn['periode']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-2 mt-4">
                        <button class="btn btn-primary btn-md" type="submit">
                            FILTER</button>
                    </div>
                </div>
            </form>
        </div>
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
                    <h4 class="card-title">DATA SELEKSI KIP-KUIAH</h4>
                    <p class="card-description">
                        Seluruh data pendaftar yang telah diseleksi dengan label prediksi
                    </p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nomor Pendaftaran</th>
                            <th>Nama Siswa</th>
                            <th>Nama Sekolah</th>
                            <th>Prodi Pilihan</th>
                            <th>Skor Seleksi</th>
                            <th>Skor Wawancara</th>
                            <th>Kondisi Ekonomi</th>
                            <th>Hasil Survey</th>
                            <th>Akademik</th>
                            <th>Non Akademik</th>
                            <th>Label</th>
                            <th>Ranking</th>
                            <th>Keterangan</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (5 * ($page - 1));
                        foreach ($seleksi as $uji) : ?>
                            <tr>
                                <td><?= $uji['no_pendaftaran']; ?></td>
                                <td><?= $uji['nama_siswa']; ?></td>
                                <td><?= $uji['nama_sekolah']; ?></td>
                                <td><?= $uji['nama_prodi']; ?></td>
                                <td><?= ($uji['skor_nilai_seleksi'] === null) ? 'NULL' : $uji['skor_nilai_seleksi']; ?></td>
                                <td><?= ($uji['skor_nilai_wawancara'] === null) ? 'NULL' : $uji['skor_nilai_wawancara']; ?></td>
                                <td><?= ($uji['skor_nilai_kondisi_ekonomi'] === null) ? 'NULL' : $uji['skor_nilai_kondisi_ekonomi']; ?></td>
                                <td><?= ($uji['skor_nilai_hasil_survey'] === null) ? 'NULL' : $uji['skor_nilai_hasil_survey']; ?></td>
                                <td><?= ($uji['skor_prestasi_akademik'] === null) ? 'NULL' : $uji['skor_prestasi_akademik']; ?></td>
                                <td><?= ($uji['skor_nilai_prestasi_non_akademik'] === null) ? 'NULL' : $uji['skor_nilai_prestasi_non_akademik']; ?></td>
                                <td><?php if ($uji['label'] == 'Tidak Layak') : ?>
                                        <span class="badge bg-danger text-white"><?= $uji['label']; ?></span>
                                    <?php else : ?>
                                        <span class="badge bg-success text-white"><?= $uji['label']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $uji['ranking']; ?></td>
                                <td><?= $uji['keterangan']; ?></td>
                                <td>
                                    <a href="data-pendaftar-edit-<?= $uji['id']; ?>" class="btn btn-warning btn-sm"><i class="ti-pencil"></i></a>
                                    <form action="data-pendaftar-<?= $uji['id']; ?>" method="post" class="d-inline" id="form-delete">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Apakah anda ingin mengahpus data ini?');" form="form-delete" formaction="data-pendaftar-<?= $uji['id']; ?>"><i class=" icon-trash"></i></button>
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