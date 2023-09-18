<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="/seleksi-upload" method="POST" class="forms-sample" enctype="multipart/form-data">
    <?= csrf_field(); ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Import Data Seleksi</h4>
                    <p class="card-description">
                        Upload nilai-nilai data seleksi baru!
                    </p>
                    <div class="mb-3">
                        <label for="importfile" class="form-label">Import File</label>
                        <input type="file" class="form-control file-upload-browse" name="importfile" placeholder="Upload File" id="importfile" required>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Tambah Data</button>
                </div>
            </div>
        </div>
</form>
<?= $this->endSection(); ?>