<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BiodataModel; // 1. Panggil BiodataModel di sini

class Auth extends BaseController
{
    // ... (Fungsi login, loginProses, logout, register tetap sama) ...
    // ... (Silakan scroll ke bawah ke fungsi registerProses) ...

    public function login()
    {
        if (session()->get('is_logged_in')) {
            if (session()->get('role') == 'admin') {
                return redirect()->to(base_url('admin/lowongan'));
            }
            return redirect()->to(base_url('peserta'));
        }
        $data = ['title' => 'Login - Portal Magang BWS V'];
        return view('auth/login', $data);
    }

    public function loginProses()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $dataUser = $userModel->where('email', $email)->first();

        if ($dataUser) {
            if (password_verify($password, $dataUser['password'])) {
                $sessLogin = [
                    'is_logged_in' => true,
                    'user_id'      => $dataUser['id'],
                    'user_nama'    => $dataUser['nama'],
                    'user_role'    => $dataUser['role']
                ];
                $session->set($sessLogin);
                if ($dataUser['role'] == 'admin') {
                    return redirect()->to(base_url('admin/lowongan'));
                } else {
                    return redirect()->to(base_url('peserta'));
                }
            } else {
                $session->setFlashdata('pesan_error', 'Password salah!');
                return redirect()->to(base_url('login'));
            }
        } else {
            $session->setFlashdata('pesan_error', 'Email tidak terdaftar!');
            return redirect()->to(base_url('login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->back();
        }
        $data = ['title' => 'Daftar Akun - Portal Magang BWS V'];
        return view('auth/register', $data);
    }

    // --- FUNGSI INI YANG KITA MODIFIKASI ---
    public function registerProses()
    {
        $session = session();
        $userModel = new UserModel();
        $biodataModel = new BiodataModel(); // 2. Aktifkan BiodataModel

        // Siapkan Aturan Validasi
        $aturan = [
            'nama' => ['rules' => 'required', 'errors' => ['required' => 'Nama lengkap wajib diisi.']],
            'email' => [
                'rules' => 'required|valid_email|is_unique[tb_users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email ini sudah terdaftar. Silakan login.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'confpassword' => [
                'rules' => 'matches[password]',
                'errors' => ['matches' => 'Konfirmasi password tidak sama.']
            ]
        ];

        // Jalankan Validasi
        if (!$this->validate($aturan)) {
            return redirect()->to(base_url('register'))
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // Jika Lolos Validasi, siapkan data user
        $dataUser = [
            'nama'     => $this->request->getVar('nama'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'mahasiswa'
        ];

        // 3. Simpan data user ke tb_users
        $userModel->save($dataUser);

        // --- [BAGIAN BARU] ---
        // 4. Ambil ID dari user yang baru saja dibuat
        $idUserBaru = $userModel->getInsertID();

        // 5. Buat data biodata kosong yang terhubung dengan ID user baru
        $dataBiodata = [
            'id_user' => $idUserBaru
        ];
        $biodataModel->save($dataBiodata);
        // --- Selesai Bagian Baru ---

        // 6. Beri notifikasi sukses dan arahkan ke halaman Login
        $session->setFlashdata('pesan_sukses', 'Pendaftaran berhasil! Silakan login untuk melengkapi biodata.');
        return redirect()->to(base_url('login'));
    }
}