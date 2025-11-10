<?php

namespace App\Models;

use CodeIgniter\Model;

class BiodataModel extends Model
{
    protected $table            = 'tb_biodata'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Kolom-kolom yang boleh diisi oleh aplikasi
    protected $allowedFields    = [
        'id_user',
        'nim',
        'perguruan_tinggi',
        'jurusan',
        'semester',
        'no_hp',
        'alamat',
        'file_cv',
        'file_surat_pengantar',
        'file_foto'
    ];
}