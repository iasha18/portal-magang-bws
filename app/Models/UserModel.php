<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_users'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // Tentukan tipe data balikan (array/object)
    // Biarkan 'array' agar sesuai dengan Controller Auth Anda
    protected $returnType       = 'array'; 

    // Kolom-kolom yang boleh diisi atau diubah oleh aplikasi
    protected $allowedFields    = [
        'nama', 
        'email', 
        'password', 
        'role', 
        'created_at',
        'reset_token', // <-- Dibutuhkan untuk fitur Lupa Password
        'reset_token_expires' // <-- Dibutuhkan untuk fitur Lupa Password
    ];

    // Fitur tambahan: Otomatis mencatat waktu saat data dibuat/diubah
    // Anda menonaktifkannya (false), ini tidak masalah jika Anda mengaturnya manual.
    protected $useTimestamps = false; 
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}