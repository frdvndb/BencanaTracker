<?php

namespace Config;

use App\Controllers\AdminController;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('GMapController');
$routes->setDefaultMethod('landingPage');
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
// $routes->get('/', 'Home::index');
$routes->get('/', 'GMapController::landingPage');
// $routes->post('/', 'GMapController::showMap');
$routes->get('/beranda', 'GMapController::landingPage');
$routes->get('/map', 'GMapController::showMap');

$routes->get('/latest/(:num)', 'GMapController::getLatestReports/$1');

$routes->get('/laporan/(:num)', 'GMapController::laporan/$1');

$routes->post('/simpan_player_id', 'GMapController::simpanPlayerID');

// $routes->get('/donasi', 'GMapController::donasi');
$routes->get('/donasi', 'DonasiController::index');
$routes->post('/donasi', 'DonasiController::buatDonasi');

// $routes->get('/pencarianrelawan', 'GMapController::pencarianrelawan');
$routes->get('/pencarianrelawan', 'PencarianRelawanController::index');
$routes->get('/cariRelawan', 'PencarianRelawanController::pencarianRelawan');
$routes->get('/daftar_relawan', 'PencarianRelawanController::daftarMenjadiRelawanView');
$routes->post('/daftar_relawan', 'PencarianRelawanController::daftarMenjadiRelawanAdd');
$routes->get('/beli_premium', 'LoginController::index');
$routes->get('/relawan/(:num)', 'PencarianRelawanController::detail_relawan/$1');

$routes->get('/login', 'LoginController::index');
$routes->post('/login', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');

$routes->get('/register', 'RegisterController::index');
$routes->post('/register', 'RegisterController::buat');

$routes->get('/buat_laporan', 'BuatLaporanController::index');
$routes->post('/buat_laporan', 'BuatLaporanController::buat');

// $routes->get('/laporan', 'GMapController::laporan');

$routes->get('/laporkan_laporan/(:num)', 'LaporkanLaporanController::laporkan_laporan/$1');
$routes->post('/laporkan_laporan/(:num)', 'LaporkanLaporanController::submitPelaporanLaporan/$1');
$routes->get('/komentar/(:num)', 'KomentarController::komentar/$1');
$routes->post('/komentar/(:num)', 'KomentarController::buatKomentar/$1');


$routes->get('/notifikasi', 'NotifikasiLaporanController::index');
$routes->get('/belip', 'NotifikasiLaporanController::beliPremium');
$routes->post('/belip', 'NotifikasiLaporanController::submitBeliPremium');
$routes->post('/update_lokasi_user', 'NotifikasiLaporanController::updateLokasiUser');
$routes->post('/update_status_langganan', 'NotifikasiLaporanController::updateStatusLangganan');
$routes->post('/update_radius', 'NotifikasiLaporanController::updateRadius');

$routes->get('/histori_laporan', 'HistoriLaporanController::index');

$routes->get('/admin_daftar_lb', 'AdminController::daftarLaporanBencana');
$routes->get('/admin_daftar_user', 'AdminController::daftarUser');
$routes->get('/admin_daftar_pelaporan', 'AdminController::daftarPelaporanLaporan');
$routes->get('/admin_daftar_relawan', 'AdminController::daftarRelawan');
$routes->get('/edit_laporan_bencana/(:num)', 'AdminController::editViewLaporanBencana/$1');
$routes->post('/edit_laporan_bencana/(:num)', 'AdminController::editUpdateLaporanBencana/$1');
$routes->get('/edit_user/(:num)', 'AdminController::editViewUser/$1');
$routes->post('/edit_user/(:num)', 'AdminController::editUpdateUser/$1');
$routes->get('/edit_relawan/(:num)', 'AdminController::editViewRelawan/$1');
$routes->post('/edit_relawan/(:num)', 'AdminController::editUpdateRelawan/$1');
$routes->delete('/hapus_laporan_bencana/(:num)', 'AdminController::deleteLaporanBencana/$1');
$routes->delete('/hapus_user/(:num)', 'AdminController::deleteUser/$1');
$routes->delete('/hapus_laporan_pelaporan/(:num)', 'AdminController::deletePelaporanLaporan/$1');
$routes->delete('/hapus_relawan/(:num)', 'AdminController::deleteRelawan/$1');
$routes->post('/verifikasi_relawan/(:num)', 'AdminController::verifikasiRelawan/$1');
$routes->post('/verifikasi_laporan_bencana/(:num)', 'AdminController::verifikasiLaporanBencana/$1');
$routes->get('laporan/upvote/(:num)', 'VoteController::upVote/$1');
$routes->get('laporan/downvote/(:num)', 'VoteController::downVote/$1');

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
