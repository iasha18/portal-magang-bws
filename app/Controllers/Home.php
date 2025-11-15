<?php

namespace App\Controllers;

use App\Models\LowonganModel;

class Home extends BaseController
{
    /**
     * Menampilkan halaman beranda (home)
     * * Method ini menangani dua kondisi:
     * 1. Request normal: Memuat seluruh halaman 'home' (termasuk layout).
     * 2. Request AJAX: Hanya memuat partial view '_lowongan_list' untuk pagination.
     */
    public function index()
    {
        // Panggil model
        $lowonganModel = new LowonganModel();

        // Siapkan query untuk data lowongan
        // Ambil lowongan yang 'Dibuka', urutkan berdasarkan 'kebutuhan' (kuota) DESC,
        // dan bagi menjadi 6 data per halaman.
        // 'lowongan' adalah nama Pager group, ini baik untuk mencegah konflik jika ada 
        // pagination lain di halaman yang sama.
        $dataLowongan = $lowonganModel
            ->where('status', 'Dibuka')
            ->orderBy('kebutuhan', 'DESC')
            ->paginate(6, 'lowongan'); 

        // Siapkan data untuk dikirim ke view
        $data = [
            'title'    => 'Beranda - Portal Magang BWS V',
            'lowongan' => $dataLowongan,
            'pager'    => $lowonganModel->pager, // Kirim objek Pager
        ];

        // Cek apakah ini request AJAX? (dipicu oleh JavaScript)
        if ($this->request->isAJAX()) {
            // Jika YA (diklik dari link pagination):
            // Kirim HANYA file partial view '_lowongan_list.php'.
            // Pastikan tidak ada spasi sebelum nama file.
            return view('_lowongan_list', $data);

        } else {
            // Jika TIDAK (request normal, buka halaman pertama kali):
            // Kirim file view 'home.php' yang lengkap dengan layout.
            return view('home', $data);
        }
    }
}
