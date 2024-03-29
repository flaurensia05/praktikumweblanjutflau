<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', function () {
	$data = [
		'title' => "Blog - Home"
	];
	echo view('layouts/header', $data);
	echo view('layouts/navbar');
	echo view('v_home');
	echo view('layouts/footer');
});

$routes->post('/saveRegister', 'Templating::saveRegister');
$routes->get('/admin/posts', 'AdminpostsController::index');
$routes->get('/admin/posts/create', 'AdminpostsController::create');
$routes->get('/admin/posts/edit/(:segment)', 'AdminpostsController::edit/$1');
$routes->get('/admin/posts/delete/(:segment)', 'AdminpostsController::delete/$1');
$routes->post('/admin/posts/update/(:segment)', 'AdminpostsController::update/$1');
$routes->post('/admin/posts/store', 'AdminpostsController::store');
$routes->get('/admin', 'Templating::index');
$routes->get('/register', 'Templating::register');
$routes->get('/posts', 'PostController::index');

$routes->get('/about', function () {
	$data = [
		'title' => "Blog - About"
	];
	echo view('layouts/header', $data);
	echo view('layouts/navbar');
	echo view('v_about');
	echo view('layouts/footer');
	//supaya tidak kebanyakan controller
});


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
