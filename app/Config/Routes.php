<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login');
$routes->get('logout', 'Login::logout');
$routes->get('register', 'Peserta::index');
$routes->post('register', 'Peserta::save');

$routes->get('data-profile-(:num)', 'Login::edit/$1');
$routes->post('edit-profile', 'Login::update');
$routes->get('dashboard', 'Dashboard::index');

$routes->get('data-prodi', 'Prodi::index');
$routes->get('data-prodi-tambah', 'Prodi::create');
$routes->get('data-prodi-order', 'Prodi::orderBy');
$routes->post('data-prodi-save', 'Prodi::save');
$routes->get('data-prodi-edit-(:num)', 'Prodi::edit/$1');
$routes->post('data-prodi-update-(:num)', 'Prodi::update/$1');
$routes->delete('data-prodi-(:num)', 'Prodi::delete/$1');
$routes->delete('data-prodi-multiple', 'Prodi::delete_multiple');

$routes->get('data-sekolah', 'Sekolah::index');
$routes->get('data-sekolah-tambah', 'Sekolah::create');
$routes->post('data-sekolah-save', 'Sekolah::save');
$routes->get('data-sekolah-order', 'Sekolah::orderBy');
$routes->get('data-sekolah-edit-(:num)', 'Sekolah::edit/$1');
$routes->post('data-sekolah-update-(:num)', 'Sekolah::update/$1');
$routes->delete('data-sekolah-(:num)', 'Sekolah::delete/$1');
$routes->delete('data-sekolah-multiple', 'Sekolah::delete_multiple');

$routes->get('data-training', 'DataTraining::index');
$routes->get('data-training-tambah', 'DataTraining::create');
$routes->post('data-training-save', 'DataTraining::save');
$routes->post('data-training-update-(:num)', 'DataTraining::update/$1');
$routes->delete('data-training-(:num)', 'DataTraining::delete/$1');
$routes->delete('data-training-multiple', 'DataTraining::delete_multiple');
$routes->delete('data-training-multiple', 'DataTraining::delete_multiple');
$routes->get('data-training-edit-(:num)', 'DataTraining::edit/$1');
$routes->get('data-training-export', 'DataTraining::export');
$routes->get('data-training-import', 'DataTraining::import');
$routes->post('data-training-upload', 'DataTraining::upload');
$routes->post('data-training-label', 'DataTraining::update_multiple');
$routes->get('data-training-norm', 'DataTraining::normalized');
$routes->get('data-norm', 'DataTraining::norm');

$routes->get('data-testing', 'DataTesting::index');
$routes->post('data-testing-update-(:num)', 'DataTesting::update/$1');
$routes->get('data-testing-order', 'DataTesting::orderBy');
$routes->get('data-testing-edit-(:num)', 'DataTesting::edit/$1');
$routes->delete('data-testing-multiple', 'DataTesting::delete_multiple');
$routes->delete('data-testing-(:num)', 'DataTesting::delete/$1');
$routes->get('data-testing-export', 'DataTesting::export');
$routes->get('data-testing-import', 'DataTesting::import');
$routes->get('data-prediksi', 'DataTesting::hasil');
$routes->post('data-testing-upload', 'DataTesting::upload');
$routes->post('data-testing-prediksi', 'DataTesting::prediksi');
$routes->get('data-testing-view', 'DataTesting::view');



$routes->get('home', 'Peserta::home');
$routes->get('hasil', 'Peserta::hasil');
$routes->get('pendaftar', 'Peserta::data_pendaftar');
$routes->get('seleksi', 'Peserta::data_seleksi');

$routes->get('main-(:any)', 'Periode::dashboard/$1');
$routes->get('periode', 'Periode::index');
$routes->post('periode-save', 'Periode::save');
$routes->delete('periode-(:num)', 'Periode::delete/$1');
$routes->get('data-peserta-(:any)', 'Periode::show/$1');
$routes->get('peserta-edit-(:num)', 'Periode::edit/$1');
$routes->post('peserta-update-(:num)', 'Periode::update/$1');
$routes->get('data-seleksi-(:any)', 'Periode::data_seleksi/$1');
$routes->get('seleksi-edit-(:num)', 'Periode::edit_seleksi/$1');
$routes->post('seleksi-update-(:num)', 'Periode::update_seleksi/$1');
$routes->get('peserta-prediksi-(:any)', 'Periode::prediksi/$1');
$routes->get('hasil-prediksi-(:any)', 'Periode::hasil/$1');
$routes->get('hasil-filter-(:any)', 'Periode::filter/$1');
$routes->get('keputusan-(:any)', 'Periode::keputusan/$1');
$routes->get('prediksi-edit-(:num)', 'Periode::edit_prediksi/$1');
$routes->post('prediksi-update-(:num)', 'Periode::update_prediksi/$1');
$routes->get('simpan-prediksi-(:any)', 'Periode::simpan_prediksi/$1');
$routes->get('laporan-prediksi-(:any)', 'Periode::export/$1');
$routes->get('laporan-contoh-(:any)', 'Periode::contoh/$1');



$routes->get('data-prediksi', 'DataTesting::create');
$routes->get('data-prediksi-hasil', 'DataTesting::prediksi');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
