<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <?php if (session()->get('role') == 'Peserta') : ?>
            <li class="nav-item">
                <a class="nav-link" href="home">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Data Diri</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="hasil">
                    <i class="icon-check menu-icon"></i>
                    <span class="menu-title">Kelulusan</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('role') == 'Operator') : ?>
            <?php
            $session = session();
            $periode = $session->get('selectedPeriode'); ?>
            <li class="nav-item">
                <a class="nav-link" href="main-<?= $periode; ?>">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="data-peserta-<?= $periode; ?>">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Data Pendaftar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="data-seleksi-<?= $periode; ?>">
                    <i class="icon-columns menu-icon"></i>
                    <span class="menu-title">Data Seleksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="hasil-prediksi-<?= $periode; ?>">
                    <i class="icon-bar-graph menu-icon"></i>
                    <span class="menu-title">Hasil Prediksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="keputusan-<?= $periode; ?>">
                    <i class="icon-check menu-icon"></i>
                    <span class="menu-title">Keputusan</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if (session()->get('role') == 'Admin') : ?>
            <li class="nav-item">
                <a class="nav-link" href="dashboard">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                    <i class="icon-columns menu-icon"></i>
                    <span class="menu-title">Data Atribut</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="form-elements">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="data-prodi">Data Program Studi</a></li>
                        <li class="nav-item"><a class="nav-link" href="data-sekolah">Data Asal Sekolah</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#data" aria-expanded="false" aria-controls="data">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Training</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="data">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="data-training">Data Training</a></li>
                        <li class="nav-item"> <a class="nav-link" href="data-training-norm">Data Normalized</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                    <i class="icon-bar-graph menu-icon"></i>
                    <span class="menu-title">Testing</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="charts">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="data-testing">Data Testing</a></li>
                        <li class="nav-item"> <a class="nav-link" href="data-testing-view">Data Normalized</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Data KIP-K</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="pendaftar">Data Pendaftar</a></li>
                        <li class="nav-item"> <a class="nav-link" href="seleksi">Data Seleksi</a></li>
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="data-prediksi">
                    <i class="icon-paper menu-icon"></i>
                    <span class="menu-title">Prediksi</span>
                </a>
            </li> -->
        <?php endif; ?>
    </ul>
</nav>