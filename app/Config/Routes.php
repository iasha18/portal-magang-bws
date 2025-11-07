<?php

namespace Config;

// Tambahkan baris ini agar kita bisa pakai Model di dalam file Routes
use CodeIgniter\Router\RouteCollection;
use App\Models\UserModel; 

/**
 * @var RouteCollection $routes
 */

// ==================================================
// 1. RUTE PUBLIK (Bisa diakses siapa saja)
// ==================================================
$routes->get('/', 'Home::index');


// ==================================================
// 2. RUTE OTENTIKASI (Login, Register, Logout)
// ==================================================
$routes->get('login', 'Auth::login');              // Menampilkan halaman login
$routes->post('login/proses', 'Auth::loginProses'); // Memproses form login
$routes->get('logout', 'Auth::logout');            // Proses logout
$routes->get('register', 'Auth::register');        // Menampilkan halaman daftar
// $routes->post('register/proses', 'Auth::registerProses'); // (Akan datang)


// ==================================================
// 3. RUTE ADMIN (Dijaga oleh filter 'auth')
// ==================================================
// Semua URL yang dimulai dengan 'admin' Wajib Login dulu
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('lowongan', 'Admin::lowongan');
});


// ==================================================
// 4. RUTE DARURAT (HANYA UNTUK RESET PASSWORD!)
// ==================================================
// PERINGATAN: Segera hapus bagian ini setelah berhasil login!
$routes->get('reset-admin', function() {
    $userModel = new UserModel();
    
    // Kita paksa password 'admin123' dienkripsi ulang oleh sistem server Anda saat ini
    // agar 100% cocok.
    $passwordBaru = password_hash('admin123', PASSWORD_DEFAULT);
    
    // Update database
    $userModel->where('email', 'admin@bws.com')
              ->set(['password' => $passwordBaru])
              ->update();
              
    echo "<h1 style='color:green;'>SUKSES!</h1>";
    echo "<p>Password untuk <b>admin@bws.com</b> telah direset menjadi: <b>admin123</b></p>";
    echo "<a href='" . base_url('login') . "'>Klik di sini untuk Login Admin</a>";
    echo "<br><br><hr>";
    echo "<h3 style='color:red;'>PENTING:</h3>";
    echo "<p style='color:red;'>Segera hapus kembali rute 'reset-admin' ini dari file Routes.php Anda agar website aman.</p>";
});