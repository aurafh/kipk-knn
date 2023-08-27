<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<form action="edit-profile" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
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
                <div class="card-body">
                    <h4 class="card-title">Edit Akun User</h4>
                    <p class="card-description">
                        Ubah akun anda!
                    </p>
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                        <label for="username">Username</label>
                        <input type="text" class="form-control form-control-sm" name="username" id="username" value="<?= $user['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password_lama">Password Lama</label>
                        <input type="password" class="form-control form-control-sm" name="password_lama" placeholder="Password Lama" id="password_lama">
                    </div>
                    <div class="form-group">
                        <label for="password_baru">Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="password_baru" placeholder="Password Baru" id="password_baru">
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Update Data</button>
                    <a class="btn btn-light" href="data-testing">Cancel</a>
                </div>
            </div>
        </div>
        <!-- </div> -->

</form>
<?= $this->endSection(); ?>