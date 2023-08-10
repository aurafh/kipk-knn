<?= $this->extend('partials/login'); ?>

<?= $this->section('content'); ?>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('pesan'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <!-- <div class="brand-logo">
                        </div> -->
                        <!-- <img src="images/logo.png" alt="logo" class=" mb-4" width="280px"> -->
                        <h4 class="text-center">Hello! Silahkan daftar</h4>
                        <h6 class="text-center font-weight-light">Masukan data dengan benar.</h6>
                        <hr>
                        <form action="register" method="post" class=" pt-3" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="no_pendaftaran">No. Peserta</label>
                                <input type="text" class="form-control form-control-sm" name=" no_pendaftaran" placeholder="Nomor Peserta" id="no_pendaftaran" value="<?= old('no_pendaftaran'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_siswa">Nama Lengkap</label>
                                <input type="text" class="form-control form-control-sm" name="nama_siswa" placeholder="Nama Lengkap" id="nama_siswa" value="<?= old('nama_siswa'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kel">Jenis Kelamin</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="jenis_kel" id="jenis_kel" value="L">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="jenis_kel" id="jenis_kel" value="P">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="number" class="form-control form-control-sm" name="nisn" placeholder="NISN" id="nisn" value="<?= old('nisn'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_prodi">Jenis Sekolah</label>
                                <select name="id_sekolah" class="form-control form-control-sm" id="id_sekolah">
                                    <option>Jenis Sekolah</option>
                                    <?php foreach ($sekolah as $key => $data) : ?>
                                        <option value="<?= $data['id_sekolah']; ?>"><?= $data['jenis_sekolah']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" class="form-control form-control-sm" name="nama_sekolah" placeholder="Nama Sekolah" id="nama_sekolah" value="<?= old('nama_sekolah'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="no_wa">No. WA</label>
                                <input type="text" class="form-control form-control-sm" name=" no_wa" placeholder="Nomor WhatsApp" id="no_wa" value="<?= old('no_wa'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nilai_atribut_prodi">Program Studi Pilihan</label>
                                <select name="id_prodi" class="form-control form-control-sm" id="id_prodi">
                                    <option>Program Studi</option>
                                    <?php foreach ($prodi as $key => $data) : ?>
                                        <option value="<?= $data['id_prodi']; ?>"><?= $data['nama_prodi']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="periode">Periode</label>
                                <select name="id_periode" class="form-control form-control-sm" id="id_periode">
                                    <option>Periode</option>
                                    <?php foreach ($periode as $key => $data) : ?>
                                        <option value=" <?= $data['id_periode']; ?>"><?= $data['periode']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bukti">Kartu Peserta</label>
                                <div class="col-xl-12">
                                    <img class="img-thumbnail img-preview">
                                </div>
                                <input type="file" name="bukti" class="file-upload-default <?= ($validation->hasError('bukti')) ? 'is-invalid' : ''; ?>" id="bukti" onchange="previewImg()">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" id="bukti">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('bukti'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Kata Sandi</label>
                                <input type="password" name="password" class="form-control form-control-md" id="password" placeholder="Password" autocomplete="off">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class=" btn btn-primary btn-md btn-block ">DAFTAR</button>
                            </div>
                            <div class="mt-3 text-center">
                                Sudah memiliki akun?<a href="/" class="link-underline link-underline-opacity-0"> Masuk sekarang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<?= $this->endSection(); ?>