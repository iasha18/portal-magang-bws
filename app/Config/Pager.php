<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Pager Templates
     * --------------------------------------------------------------------------
     *
     * This file contains the aliases of view files for pagination templates.
     * These views are used by the Pager library to render the links.
     *
     * @var array<string, string>
     */
    public $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        
        /* * ==========================================================
         * TAMBAHKAN BARIS INI:
         * ==========================================================
         * Ini mendaftarkan file yang baru saja Anda buat.
         * 'custom_bootstrap' adalah nama alias baru kita.
         * 'App\Views\layout\pagination_links' adalah path ke file baru.
         * (Gunakan 'App\Views\...' bukan 'app/Views/...')
         */
        'custom_bootstrap' => 'App\Views\layout\pagination_links',
    ];

    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The default number of results shown in a single page.
     *
     * @var int
     */
    public $perPage = 20;
}