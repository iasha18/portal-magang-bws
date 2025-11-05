<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Kumpulan data lowongan pura-pura (dummy)
        $dummyLowongan = [
            [
                'posisi' => 'Web Developer (Intern)',
                'unit' => 'Seksi Operasi & Pemeliharaan',
                'kebutuhan' => 2,
                'status' => 'Dibuka',
                'deskripsi' => 'Membantu pengembangan dan pemeliharaan sistem informasi internal BWS V.'
            ],
            [
                'posisi' => 'Analis Data Hidrologi',
                'unit' => 'Seksi Perencanaan',
                'kebutuhan' => 1,
                'status' => 'Dibuka',
                'deskripsi' => 'Melakukan rekapitulasi dan analisis data curah hujan dan debit air.'
            ],
            [
                'posisi' => 'Staf Administrasi & Kearsipan',
                'unit' => 'Bagian Tata Usaha',
                'kebutuhan' => 3,
                'status' => 'Penuh',
                'deskripsi' => 'Mengelola arsip surat masuk dan surat keluar serta dokumen lainnya.'
            ]
        ];

        $data = [
            'title' => 'Beranda - Portal Magang BWS V',
            'lowongan' => $dummyLowongan // Kirim data lowongan ke view
        ];
        return view('home', $data);
    }
}