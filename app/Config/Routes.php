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

$routes->get('lupa-password', 'Auth::lupaPassword');
$routes->post('lupa-password/kirim', 'Auth::kirimLinkReset');
$routes->get('reset-password/(:any)', 'Auth::resetPassword/$1');
$routes->post('reset-password/update', 'Auth::updatePasswordBaru');

// 3. RUTE PESERTA
$routes->group('peserta', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Peserta::index');
    $routes->get('apply/(:num)', 'Peserta::apply/$1');
    $routes->get('profil', 'Peserta::profil');
    $routes->post('profil/update', 'Peserta::updateProfil');
});

// 4. RUTE ADMIN
$routes->group('admin', ['filter' => 'auth'], function($routes) { // <-- Grup Admin Dibuka
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
    $routes->get('pendaftar/detail/(:num)', 'Admin::detailPendaftar/$1');
    $routes->get('pendaftar/hapus/(:num)', 'Admin::hapusPendaftar/$1');

    // Kelola Admin (dijaga 'auth' DAN 'superadmin')
    $routes->group('users', ['filter' => 'superadmin'], function($routes) { // <-- Grup Users Dibuka
        $routes->get('/', 'Admin::kelolaAdmin');
        $routes->get('tambah', 'Admin::tambahAdmin');
        $routes->post('simpan', 'Admin::simpanAdmin');
    }); // <-- Grup Users Ditutup

}); // <-- [PERBAIKAN] Ini adalah penutup untuk Grup Admin