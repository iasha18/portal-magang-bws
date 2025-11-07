<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    // Dijalankan SEBELUM masuk ke halaman
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek: Apakah dia TIDAK punya kartu visitor ('is_logged_in')?
        if (! session()->get('is_logged_in')) {
            // Kalau tidak punya, tendang balik ke halaman login
            return redirect()->to(base_url('login'));
        }
    }

    // Dijalankan SETELAH halaman dimuat (kita biarkan kosong dulu)
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing here
    }
}