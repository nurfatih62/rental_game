<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginProcess');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('games', 'Admin::games');
    $routes->get('games/create', 'Admin::createGame');
    $routes->post('games/store', 'Admin::storeGame');
    $routes->get('games/edit/(:num)', 'Admin::editGame/$1');
    $routes->post('games/update/(:num)', 'Admin::updateGame/$1');
    $routes->get('games/delete/(:num)', 'Admin::deleteGame/$1');
    $routes->get('users', 'Admin::users');
    $routes->get('users/delete/(:num)', 'Admin::deleteUser/$1');
    $routes->get('transactions', 'Admin::transactions');
    $routes->get('transactions/return/(:num)', 'Admin::returnGame/$1');
});

$routes->group('user', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'UserPanel::dashboard');
    $routes->get('games', 'UserPanel::games');
    $routes->get('rent/(:num)', 'UserPanel::rent/$1');
    $routes->post('rent/(:num)', 'UserPanel::rentProcess/$1');
    $routes->get('transactions', 'UserPanel::transactions');
});