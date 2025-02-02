<?php

namespace Config;

//use App\Controllers\Theptarin;
//use App\Controllers\Pages;

//use App\Controllers\Bootstrap;
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
$routes->get('/', 'AipnCTL::index');
$routes->get('aipn', 'AipnCTL::index');
$routes->post('aipn/upload', 'AipnCTL::upload');
$routes->post('aipn/create', 'AipnCTL::create');
//$routes->post('aipn/ipadt', 'Aipn::ipadt');
//$routes->post('aipn/ipadt/upload', 'Aipn::ipadt_upload');
//$routes->get('aipn/ipdx', 'Aipn::ipdx');
$routes->get('about', 'AipnCTL::about');
//$routes->get('upload', 'Upload::index');          // Add this line.
//$routes->post('upload/upload', 'Upload::upload'); // Add this line.
//$routes->get('theptarin', [Theptarin::class, 'index']);
//$routes->get('(:segment)', [Pages::class, 'view']);
//$routes->get('bs5-examples','Bootstrap::index');
//$routes->get('(:any)', 'Pages::view/$1');
//$routes->get('/', 'StudentController::index');
//$routes->match(['get', 'post'], 'StudentController/importCsvToDb', 'StudentController::importCsvToDb');
//
//$routes->get('pages', [Pages::class, 'index']);
//$routes->get('(:segment)', [Pages::class, 'view']);
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
