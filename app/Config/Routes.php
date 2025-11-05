<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// --- Rute Tambahan untuk Login & Register ---
$routes->get('login', 'Auth::login');
$routes->get('register', 'Auth::register');