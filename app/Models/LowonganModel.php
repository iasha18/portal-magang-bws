<?php

namespace App\Models;

use CodeIgniter\Model;

class LowonganModel extends Model
{
    protected $table            = 'tb_lowongan'; // Nama tabel di database
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['posisi', 'unit', 'kebutuhan', 'status', 'deskripsi'];
}