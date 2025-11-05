<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        $data = [
            'title' => 'Login - Portal Magang BWS V'
        ];
        return view('auth/login', $data);
    }

    public function register()
    {
        $data = [
            'title' => 'Daftar Akun - Portal Magang BWS V'
        ];
        return view('auth/register', $data);
    }
}