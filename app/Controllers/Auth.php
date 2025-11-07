<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    // 1. Menampilkan Halaman Login Utama
    public function login()
    {
        // Jika user sudah login, langsung arahkan ke halaman yang seharusnya
        if (session()->get('is_logged_in')) {
            if (session()->get('role') == 'admin') {
                return redirect()->to(base_url('admin/lowongan'));
            }
            return redirect()->to(base_url('/'));
        }

        $data = [
            'title' => 'Login - Portal Magang BWS V'
        ];
        return view('auth/login', $data);
    }

    // 2. Proses Login (Otak yang menangani kedua formulir)
    public function loginProses()
    {
        $session = session();
        $userModel = new UserModel();

        // Ambil data dari form (baik dari form atas maupun bawah)
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // Cari user di database
        $dataUser = $userModel->where('email', $email)->first();

        if ($dataUser) {
            // Cek password
            if (password_verify($password, $dataUser['password'])) {
                // Login Sukses! Buat session.
                $sessLogin = [
                    'is_logged_in' => true,
                    'user_id'      => $dataUser['id'],
                    'user_nama'    => $dataUser['nama'],
                    'user_role'    => $dataUser['role'] // 'admin' atau 'mahasiswa'
                ];
                $session->set($sessLogin);

                // Arahkan sesuai peran
                if ($dataUser['role'] == 'admin') {
                    return redirect()->to(base_url('admin/lowongan'));
                } else {
                    return redirect()->to(base_url('/'));
                }
            } else {
                // Password salah
                $session->setFlashdata('pesan_error', 'Password salah!');
                return redirect()->to(base_url('login'));
            }
        } else {
            // Email tidak ditemukan
            $session->setFlashdata('pesan_error', 'Email tidak terdaftar!');
            return redirect()->to(base_url('login'));
        }
    }

    // 3. Proses Logout
    public function logout()
    {
        $session = session();
        $session->destroy(); // Hapus semua session
        return redirect()->to(base_url('login'));
    }

    // 4. Halaman Register
    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->back();
        }

        $data = [
            'title' => 'Daftar Akun - Portal Magang BWS V'
        ];
        return view('auth/register', $data);
    }
}