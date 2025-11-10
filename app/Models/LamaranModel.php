<?php

namespace App\Models;

use CodeIgniter\Model;

class LamaranModel extends Model
{
    protected $table            = 'tb_lamaran'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
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
}