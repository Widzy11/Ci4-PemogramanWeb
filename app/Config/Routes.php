<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Home / Beranda
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

// Routes Data Pegawai (permission: data-pegawai)
$routes->get('/crud', 'Crud::index', ['filter' => 'permission:data-pegawai']);
$routes->get('/crud/create', 'Crud::create', ['filter' => 'permission:data-pegawai']);
$routes->post('/crud/create', 'Crud::save', ['filter' => 'permission:data-pegawai']);
$routes->get('/crud/edit/(:num)', 'Crud::edit/$1', ['filter' => 'permission:data-pegawai']);
$routes->post('/crud/update/(:num)', 'Crud::update/$1', ['filter' => 'permission:data-pegawai']);
$routes->get('/crud/hapus/(:num)', 'Crud::delete/$1', ['filter' => 'permission:data-pegawai']);
$routes->match(['get', 'post'], '/crud/cekNomorPegawai', 'Crud::cekNomorPegawai', ['filter' => 'permission:data-pegawai']);
$routes->get('/crud/searchPegawai', 'Crud::searchPegawai', ['filter' => 'permission:data-pegawai']);
$routes->get('/crud/exportWord', 'Crud::exportWord', ['filter' => 'permission:data-pegawai']);
$routes->get('/crud/exportWord/(:num)', 'Crud::exportWord/$1', ['filter' => 'permission:data-pegawai']);

// Routes Data Departemen (permission: data-departemen)
$routes->get('/departemen', 'Departemen::index', ['filter' => 'permission:data-departemen']);
$routes->get('/departemen/search', 'Departemen::search', ['filter' => 'permission:data-pegawai']);
$routes->get('/departemen/create', 'Departemen::create', ['filter' => 'permission:data-departemen']);
$routes->post('/departemen/create', 'Departemen::save', ['filter' => 'permission:data-departemen']);
$routes->get('/departemen/edit/(:num)', 'Departemen::edit/$1', ['filter' => 'permission:data-departemen']);
$routes->post('/departemen/update/(:num)', 'Departemen::update/$1', ['filter' => 'permission:data-departemen']);
$routes->get('/departemen/hapus/(:num)', 'Departemen::delete/$1', ['filter' => 'permission:data-departemen']);

// Routes Data Penilaian (permission: data-penilaian; hapus hanya data-pegawai/admin)
$routes->get('/penilaian', 'Penilaian::index', ['filter' => 'permission:data-penilaian']);
$routes->get('/penilaian/create', 'Penilaian::create', ['filter' => 'permission:data-penilaian']);
$routes->post('/penilaian/create', 'Penilaian::save', ['filter' => 'permission:data-penilaian']);
$routes->get('/penilaian/edit/(:num)', 'Penilaian::edit/$1', ['filter' => 'permission:data-penilaian']);
$routes->post('/penilaian/update/(:num)', 'Penilaian::update/$1', ['filter' => 'permission:data-penilaian']);
$routes->get('/penilaian/hapus/(:num)', 'Penilaian::delete/$1', ['filter' => 'permission:data-pegawai']);
$routes->get('/penilaian/exportWord', 'Penilaian::exportWord', ['filter' => 'permission:data-penilaian']);

// Routes Data User (permission: data-users)
$routes->get('/users', 'Users::index', ['filter' => 'permission:data-users']);
$routes->get('/users/create', 'Users::create', ['filter' => 'permission:data-users']);
$routes->post('/users/create', 'Users::save', ['filter' => 'permission:data-users']);
$routes->post('/users/reset-password/(:num)', 'Users::resetPassword/$1', ['filter' => 'permission:data-users']);
$routes->post('/users/hapus/(:num)', 'Users::delete/$1', ['filter' => 'permission:data-users']);

// Routes Profile & Ubah Password (semua user login)
$routes->get('/profile', 'Profile::index');
$routes->post('/profile/update', 'Profile::updateProfil');
$routes->get('/profile/ubah-password', 'Profile::ubahPassword');
$routes->post('/profile/update-password', 'Profile::updatePassword');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
