<?= $this->extend('partials/dashboard'); ?>

<?= $this->section('content'); ?>

<form action="/data-training-upload" method="POST" class="forms-sample" enctype="multipart/form-data">
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
                    <h4 class="card-title">Import Data Trainning</h4>
                    <p class="card-description">
                        Upload data trainning baru!
                    </p>
                    <div class="mb-3">
                        <label for="importfile" class="form-label">Import File</label>
                        <input type="file" class="form-control file-upload-browse" name="importfile" placeholder="Upload File" id="importfile" required>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Tambah Data</button>
                    <a class="btn btn-light" href="data-training">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
<?= $this->endSection(); ?>