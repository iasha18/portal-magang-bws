<?php

namespace App\Controllers;

// Panggil Model yang sudah kita buat
use App\Models\LowonganModel;

class Admin extends BaseController
{
    protected $lowonganModel;

    // function construct ini akan dijalankan setiap kali Controller Admin diakses
    public function __construct()
    {
        // Aktifkan LowonganModel agar bisa dipakai di semua function
        $this->lowonganModel = new LowonganModel();
    }

    // Function untuk Dashboard (nanti kita isi)
    public function index()
    {
        // Arahkan saja ke halaman lowongan untuk saat ini
        return redirect()->to(base_url('admin/lowongan'));
    }

    // Function untuk halaman KELOLA LOWONGAN
    public function lowongan()
    {
        // Ambil SEMUA lowongan (termasuk yang 'Penuh') dari database
        $dataLowongan = $this->lowonganModel->findAll();

        $data = [
            'title' => 'Kelola Lowongan Magang',
            'lowongan' => $dataLowongan
        ];

        // Tampilkan view di folder 'admin' yang akan kita buat
        return view('admin/lowongan_index', $data);
    }
}