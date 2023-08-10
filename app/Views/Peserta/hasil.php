<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<?php if (!$cekLabel) : ?>
    <div class="col-lg-12 grid-margin stretch-card mt-3">
        <div class="card">
            <div class="card-header">HASIL KELULUSAN</div>
            <div class="card-body text-center">
                <h4>KELULUSAN MASIH DALAM PROSES</h4>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class=" col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">HASIL KELULUSAN</div>
            <div class="card-body">
                <?php if ($user['label'] == 'Tidak Layak') : ?>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="alert alert-warning">
                            <h3 class="text-center mb-4">TIDAK LULUS</h3>
                            Mohon Maaf, anda dinyatakan tidak lulus untuk pengajuan KIP-Kuliah di Institut Teknologi Garut.
                            Tetap semangat untuk terus mengejar pendidikan yang lebih tinggi.
                            <hr>
                            Panitia Penerimaan Mahasiswa Baru Jalur KIP-Kuliah ITG
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (($user['label'] == 'Layak') && ($user['ranking'] == null)) : ?>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="alert alert-warning">
                            <h3 class="text-center mb-4">TIDAK LULUS</h3>
                            Mohon Maaf, anda dinyatakan tidak lulus untuk pengajuan KIP-Kuliah di Institut Teknologi Garut.
                            Tetap semangat untuk terus mengejar pendidikan yang lebih tinggi.
                            <hr>
                            Panitia Penerimaan Mahasiswa Baru Jalur KIP-Kuliah ITG
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (($user['label'] == 'Layak') && ($user['ranking'] != null)) : ?>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="alert alert-success">
                            <h3 class="text-center mb-4">LULUS</h3>
                            Selamat, anda dinyatakan lulus dan diterima
                            di Institut Teknologi Garut melalui jalur KIP-Kuliah.
                            Untuk informasi lebih lanjut silahkan tetap memantau grup WA KIP-Kuliah ITG.
                            <hr>
                            Panitia Penerimaan Mahasiswa Baru Jalur KIP-Kuliah ITG
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <?= $this->endSection(); ?>