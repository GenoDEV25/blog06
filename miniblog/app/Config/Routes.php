<?php

namespace Config;

use CodeIgniter\Routing\RouteCollection;
use CodeIgniter\Services;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// API  
$routes->group('api', function($routes){
    $routes->get('posts', 'Api\Posts::index');
    $routes->get('posts/(:num)', 'Api\Posts::show/$1');
});

// Admin 
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/login', 'Admin\Auth::attemptLogin');
$routes->get('admin/logout', 'Admin\Auth::logout');

// Admin protegido con filtro de autenticación
$routes->group('admin', ['filter' => 'authfilter'], function($routes){
    $routes->get('posts', 'Admin\PostsController::index');
    $routes->get('posts/create', 'Admin\PostsController::create');
    $routes->post('posts/store', 'Admin\PostsController::store');
    $routes->get('posts/edit/(:num)', 'Admin\PostsController::edit/$1');
    $routes->post('posts/update/(:num)', 'Admin\PostsController::update/$1');
    $routes->get('posts/delete/(:num)', 'Admin\PostsController::delete/$1');
});
