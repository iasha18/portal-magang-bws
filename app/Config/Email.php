<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    // Pengaturan default saat memanggil \Config\Services::email()
    public string $fromEmail = 'email-pengirim@gmail.com'; // Ganti dengan email Anda
    public string $fromName  = 'Portal Magang BWS Sumatera V';
    public string $protocol  = 'smtp'; // Gunakan SMTP
    public string $SMTPHost  = 'smtp.gmail.com';
    public string $SMTPUser  = 'indahiashaa@gmail.com'; // Ganti dengan email Anda
    public string $SMTPPass  = 'hwwg ompt ixpk qtis'; // GANTI INI
    public int    $SMTPPort  = 465;
    public string $SMTPCrypto = 'ssl'; // Gunakan SSL
    public string $mailType  = 'html'; // Kirim sebagai email HTML
    public string $charset   = 'UTF-8';
    public bool   $wordWrap  = true;
    public string $newline   = "\r\n";
    public bool   $validate  = true; // Validasi email
}