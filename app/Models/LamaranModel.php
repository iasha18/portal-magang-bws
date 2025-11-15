<?php

namespace App\Models;

use CodeIgniter\Model;

class LamaranModel extends Model
{
    protected $table            = 'tb_lamaran'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // ==========================================================
    // TAMBAHKAN BARIS INI
    // ==========================================================
    protected $returnType       = 'object'; // Ini akan memperbaiki error Anda
    // ==========================================================
    
    // Kolom-kolom yang boleh diisi oleh aplikasi
    protected $allowedFields    = [
        'id_user',
        'id_lowongan',
        'status_lamaran',
        'catatan_admin',
        'tanggal_melamar'
    ];

    // Kita akan set 'tanggal_melamar' secara otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'tanggal_melamar';
    protected $updatedField  = ''; // Kita tidak pakai updated_at di tabel ini

    
    /**
     * Fungsi baru untuk search dan pagination pendaftar
     */
    public function searchPendaftar($keyword = null)
    {
        // Tentukan tabel utama
        $this->table('tb_lamaran');

        // 1. Pilih kolom-kolom yang kita butuhkan dari 3 tabel
        $this->select('
            tb_lamaran.id as id_lamaran,
            tb_lamaran.status_lamaran as status,
            tb_lamaran.tanggal_melamar as tgl_daftar,
            tb_users.nama as nama_pendaftar,
            tb_users.email,
            tb_lowongan.posisi
        ');

        // 2. JOIN dengan tabel User
        $this->join('tb_users', 'tb_users.id = tb_lamaran.id_user');

        // 3. JOIN dengan tabel Lowongan
        $this->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan');

        // 4. Jika ada keyword pencarian, lakukan filter LIKE
        if ($keyword) {
            $this->groupStart(); // ( ...
            $this->like('tb_users.nama', $keyword);
            $this->orLike('tb_users.email', $keyword);
            $this->orLike('tb_lowongan.posisi', $keyword);
            $this->orLike('tb_lamaran.status_lamaran', $keyword);
            $this->groupEnd();   // ... )
        }

        // 5. Urutkan berdasarkan data terbaru
        $this->orderBy('tb_lamaran.tanggal_melamar', 'DESC');

        // 6. Kembalikan $this (Query Builder)
        return $this;
    }
}
