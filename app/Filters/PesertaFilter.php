<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PesertaFilter implements FilterInterface
{
    /**
     * Tugas Satpam: Cek apakah role-nya 'mahasiswa'.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika rolenya BUKAN 'mahasiswa' (misal: admin atau superadmin)
        if (session()->get('user_role') !== 'mahasiswa') {
            
            // Lempar dia kembali ke dashboard-nya sendiri (admin)
            session()->setFlashdata('pesan_error', 'Akses ditolak. Anda login sebagai Admin.');
            return redirect()->to(base_url('admin'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa
    }
}