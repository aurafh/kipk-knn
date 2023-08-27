<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-3" href="dashboard"><img src="images/logo.png" class="ml-2" alt="logo" width="240px" /></a>
        <a class="navbar-brand brand-logo-mini" href="dashboard"><img src="images/logo-mini.png" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="submit" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <form action="" method="get">
                    <div class="input-group">
                        <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                            <button class="input-group-text" type="submit" id=" search" name="submit">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                        <?php $request = \Config\Services::request(); ?>
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search Data" name="searching" value="<?= $request->getVar('searching'); ?>">
                    </div>
                </form>
            </li>
        </ul>
        <?php
        $session = session();
        $id = $session->get('id');
        $role = $session->get('role');
        $username = $session->get('username');
        $model = new \App\Models\PesertaModel();
        $user = $model->where('no_pendaftaran', $username)->first();
        ?>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item mt-2">
                <h5 class=" text-center">
                    <?php if ($user) : ?>
                        <?= $user['nama_siswa']; ?>
                    <?php else : ?>
                        <?= $role; ?>
                    <?php endif; ?>
                </h5>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="images/faces/face28.jpg" alt="profile" />
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a href="data-profile-<?= $id; ?>" class="dropdown-item">
                        <i class="ti-settings text-primary"></i>
                        Profile
                    </a>
                    <a href="logout" class="dropdown-item">
                        <i class="ti-power-off text-primary"></i>
                        Keluar
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>