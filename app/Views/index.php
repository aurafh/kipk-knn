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
                        <img src="images/logo.png" alt="logo" class=" mb-4" width="280px">
                        <h4>Hello! let's get started</h4>
                        <h6 class=" font-weight-light">Sign in to continue.</h6>
                        <form action="login" method="post" class="pt-3">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-control-md" id="username" placeholder="Username atau No Peserta">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-md" id="password" placeholder="Password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class=" btn btn-primary btn-md btn-block ">MASUK</button>
                            </div>
                            <div class="mt-3 text-center">
                                Belum memiliki akun?<a href="register" class="link-underline link-underline-opacity-0"> Daftar sekarang</a>
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