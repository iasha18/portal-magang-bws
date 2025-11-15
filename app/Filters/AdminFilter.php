<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Tugas Satpam: Cek apakah user yang login adalah Admin atau Super Admin.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('user_role');

        // Jika rolenya BUKAN 'admin' DAN BUKAN 'superadmin' (berarti 'mahasiswa')
        if ($role !== 'admin' && $role !== 'superadmin') {
            
            // Lempar dia kembali ke dashboard peserta
            session()->setFlashdata('pesan_error', 'Akses ditolak! Halaman ini hanya untuk Administrator.');
            return redirect()->to(base_url('peserta'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}