<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Data Dummy Lengkap
        $allLowongan = [
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
                'posisi' => 'Staf Administrasi',
                'unit' => 'Bagian Tata Usaha',
                'kebutuhan' => 3,
                'status' => 'Penuh', // Ini nanti otomatis TIDAK akan tampil
                'deskripsi' => 'Mengelola arsip surat masuk dan keluar serta dokumen lainnya.'
            ]
        ];

        // FILTER OTOMATIS: Hanya ambil yang statusnya 'Dibuka'
        $lowonganDibuka = array_filter($allLowongan, function($job) {
            return $job['status'] === 'Dibuka';
        });

        $data = [
            'title' => 'Beranda - Portal Magang BWS V',
            'lowongan' => $lowonganDibuka // Kirim data yang sudah difilter
        ];

        return view('home', $data);
    }
}