<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Selamat Datang, Admin</h3>
                <h6 class="font-weight-normal mb-0">Sitem Prediksi Penerima Beasiswa KIPK <span class="text-primary">Institut Teknologi Garut</span></h6>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card tale-bg">
            <div class="card-people mt-auto">
                <img src="images/dashboard/people.svg" alt="people">
                <!-- <div class="weather-info">
                    <div class="d-flex">
                        <div>
                            <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
                        </div>
                        <div class="ml-2">
                            <h4 class="location font-weight-normal">Bangalore</h4>
                            <h6 class="font-weight-normal">India</h6>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin transparent">
        <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Data Training</p>
                        <p class="fs-30 mb-2"><?= $train; ?></p>
                        <!-- <p>10.00% (30 days)</p> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Data Testing</p>
                        <p class="fs-30 mb-2"><?= $test; ?></p>
                        <!-- <p>22.00% (30 days)</p> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Jumlah Pendaftar Layak</p>
                        <p class="fs-30 mb-2"><?= $layak; ?></p>
                        <!-- <p>2.00% (30 days)</p> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Jumlah Pendaftar Tidak Layak</p>
                        <p class="fs-30 mb-2"><?= $tidak; ?></p>
                        <!-- <p>0.22% (30 days)</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>