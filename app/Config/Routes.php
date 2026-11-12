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
$routes->setDefaultController('Crud');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Crud::index');
$routes->get('/crud', 'Crud::index');
$routes->get('/crud/create', 'Crud::create');
$routes->post('/crud/create', 'Crud::save');
$routes->get('/crud/edit/(:num)', 'Crud::edit/$1');
$routes->post('/crud/update/(:num)', 'Crud::update/$1');
$routes->get('/crud/hapus/(:num)', 'Crud::delete/$1');

// Routes Departemen
$routes->get('/departemen', 'Departemen::index');
$routes->get('/departemen/create', 'Departemen::create');
$routes->post('/departemen/create', 'Departemen::save');
$routes->get('/departemen/edit/(:num)', 'Departemen::edit/$1');
$routes->post('/departemen/update/(:num)', 'Departemen::update/$1');
$routes->get('/departemen/hapus/(:num)', 'Departemen::delete/$1');

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
