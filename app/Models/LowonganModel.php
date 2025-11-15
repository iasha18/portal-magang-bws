<?php

namespace App\Models;

use CodeIgniter\Model;

class LowonganModel extends Model
{
    protected $table            = 'tb_lowongan';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    // Field yang boleh diisi (harus sesuai kolom tabel)
    protected $allowedFields    = [
        'posisi',
        'unit',
        'kebutuhan',
        'status',
        'deskripsi'
    ];

    // Jika tabelmu punya kolom created_at & updated_at, aktifkan timestamps
    protected $useTimestamps = false;

    // Default return type (object lebih rapi untuk view)
    protected $returnType = 'object';

    // Pagination default
    protected $perPage = 6;
}
