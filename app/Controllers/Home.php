<?php

namespace App\Controllers;

// Panggil Model yang baru kita buat agar dikenali di sini
use App\Models\LowonganModel;

class Home extends BaseController
{
    public function index()
    {
        // 1. Aktifkan Model (Si Kurir)
        $modelLowongan = new LowonganModel();

        // 2. Minta Kurir mengambil data yang statusnya 'Dibuka' saja
        // findAll() artinya ambil semua hasil yang cocok
        $dataLowongan = $modelLowongan->where('status', 'Dibuka')->findAll();

        // 3. Kirim data asli dari database ke View
        $data = [
            'title'    => 'Beranda - Portal Magang BWS V',
            'lowongan' => $dataLowongan
        ];

        return view('home', $data);
    }
}