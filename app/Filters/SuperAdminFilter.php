<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SuperAdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        /* * [PERBAIKAN] Ini adalah komentar yang benar.
         * Tugas Satpam: Cek peran dari "kartu visitor" (Session).
         */
        
        // Cek: Apakah peran user BUKAN 'superadmin'?
        if (session()->get('user_role') !== 'superadmin') {
            
            // Jika bukan, lempar dia kembali ke dashboard admin biasa
            // Sambil bawa pesan error
            session()->setFlashdata('pesan_error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            return redirect()->to(base_url('admin'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah halaman dimuat
    }
}