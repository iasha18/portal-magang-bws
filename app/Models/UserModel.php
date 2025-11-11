<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_users'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // Kolom-kolom yang boleh diisi atau diubah oleh aplikasi
    protected $allowedFields    = [
        'nama', 
        'email', 
        'password', 
        'role', 
        'created_at',
        'reset_token', // <-- TAMBAHAN UNTUK FITUR LUPA PASSWORD
        'reset_token_expires' // <-- TAMBAHAN UNTUK FITUR LUPA PASSWORD
    ];

    // Fitur tambahan: Otomatis mencatat waktu saat data dibuat/diubah
    protected $useTimestamps = false; 
}