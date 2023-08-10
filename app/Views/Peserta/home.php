<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-12">
                <h3 class="font-weight-bold">Selamat Datang, <?= $user['nama_siswa']; ?></h3>
                <h6 class="font-weight-normal mb-0">Sistem Informasi Penerimaan Beasiswa KIPK <span class="text-primary">Institut Teknologi Garut</span></h6>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php if ($user['status'] == 'WAITING') : ?>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="alert alert-warning">
                <h4>Menunggu Verifikasi</h4>
                Maaf, akun anda sedang menunggu untuk proses verifikasi akun KIP-Kuliah ITG, informasi
                berkaitan penerimaan KIP-Kuliah di Institut Teknologi Garut akan kami sampaikan melalui sistem ini.
                Silahkan selalu cek sistem ini secara berkala.
                <hr>
                Panitia Penerimaan Mahasiswa Baru Jalur KIP-Kuliah ITG
            </div>
        </div>
    <?php endif; ?>
    <?php if ($user['status'] == 'VALIDATE') : ?>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="alert alert-success">
                <h4>Akun Terverifikasi</h4>
                Selamat, akun anda telah kami verifikasi, informasi
                berkaitan penerimaan KIP-Kuliah di Institut Teknologi Garut akan kami sampaikan melalui sistem ini.
                Silahkan selalu cek sistem ini secara berkala.
                <hr>
                Panitia Penerimaan Mahasiswa Baru Jalur KIP-Kuliah ITG
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>