<?php

use CodeIgniter\Router\RouteCollection;
use App\Models\UserModel; // Dibutuhkan jika Anda masih punya rute reset

/**
 * @var RouteCollection $routes
 */

// 1. RUTE PUBLIK
$routes->get('/', 'Home::index');

// 2. RUTE OTENTIKASI
$routes->get('login', 'Auth::login');
$routes->post('login/proses', 'Auth::loginProses');
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Auth::register');
$routes->post('register/proses', 'Auth::registerProses');

// 3. RUTE PESERTA
$routes->group('peserta', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Peserta::index');
    $routes->get('apply/(:num)', 'Peserta::apply/$1');
    // RUTE BARU: PROFIL & BIODATA
    $routes->get('profil', 'Peserta::profil'); // Menampilkan form edit profil
    $routes->post('profil/update', 'Peserta::updateProfil'); // Proses simpan/update profil
});

// 4. RUTE ADMIN
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin::index');
    
    // Lowongan
    $routes->get('lowongan', 'Admin::lowongan');
    $routes->get('lowongan/tambah', 'Admin::tambah');
    $routes->post('lowongan/simpan', 'Admin::simpan');
    $routes->get('lowongan/edit/(:num)', 'Admin::edit/$1');
    $routes->post('lowongan/update', 'Admin::update');
    $routes->get('lowongan/hapus/(:num)', 'Admin::hapus/$1');

    // Pendaftar
    $routes->get('pendaftar', 'Admin::pendaftar');
    $routes->get('pendaftar/update/(:num)/(:segment)', 'Admin::updateStatus/$1/$2');
    
    // [INI RUTE PENTINGNYA] Pastikan baris ini ada
    $routes->get('pendaftar/detail/(:num)', 'Admin::detailPendaftar/$1');
});