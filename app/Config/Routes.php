<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::index');
$routes->get('/pages', 'Pages::index');
$routes->get('/pages/about', 'Pages::about');
$routes->get('/pages/contact', 'Pages::contact');
$routes->get('/pages/employee', 'Pegawai::index');


// Route Generate PDF comic
$routes->get("/comic/report-comic", "Comics::generatePDF");

// Route Generate PDF pegawai
$routes->get("/employee/laporan-pegawai", "Pegawai::generate");

// Route Generate EXCEL pegawai
$routes->get("/employee/pegawai-excel", "Pegawai::exportExcel");

// Route All Comics
$routes->get('/pages/comic', 'Comics::index');

// Route Add Comic
$routes->get("/pages/comic/create", "Comics::create");

// Route Edit Comic
$routes->get("/comic/edit/(:segment)", "Comics::edit/$1");

// Route Update Comic
$routes->post("/comic/update/(:segment)", "Comics::update/$1");

// Route Save Create Comic
$routes->post("/comic/save", "Comics::save");

// Route Delete agar tidak bisa dihapus melalui URL
$routes->delete("/comic/(:num)", "Comics::delete/$1");

// Route Detail Comics
$routes->get("/comic/(:any)", "Comics::detail/$1");




// Method Delete
// $routes->get("/comic/delete/(:segment)", "Comics::delete/$1");

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
