<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_users'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // Kolom-kolom yang boleh diisi atau diubah oleh aplikasi
    protected $allowedFields    = ['nama', 'email', 'password', 'role', 'created_at'];

    // Fitur tambahan: Otomatis mencatat waktu saat data dibuat/diubah
    // (Opsional tapi bagus untuk ke depannya)
    protected $useTimestamps = false; 
}