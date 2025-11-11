<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    /**
     * Tugas Satpam: Cek apakah user yang login adalah Admin atau Super Admin.
     * Filter ini harus dijalankan SETELAH filter 'auth' (yang mengecek login).
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('user_role');

        // Jika rolenya BUKAN 'admin' DAN BUKAN 'superadmin'
        if ($role !== 'admin' && $role !== 'superadmin') {
            
            // Berarti dia 'mahasiswa' atau 'peserta'. Lempar dia ke dashboard-nya.
            session()->setFlashdata('pesan_error', 'Akses ditolak! Anda tidak memiliki hak akses ke Halaman Admin.');
            return redirect()->to(base_url('peserta')); // Arahkan ke dashboard peserta
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah halaman dimuat
    }
}