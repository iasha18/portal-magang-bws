<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BiodataModel; 

class Auth extends BaseController
{
    /**
     * Menampilkan halaman login utama (Tabbed)
     */
    public function login()
    {
        // [PERBAIKAN] Cek apakah 'admin' ATAU 'superadmin'
        if (session()->get('is_logged_in')) {
            if (session()->get('user_role') == 'admin' || session()->get('user_role') == 'superadmin') {
                return redirect()->to(base_url('admin'));
            }
            if (session()->get('user_role') == 'mahasiswa') {
                 return redirect()->to(base_url('peserta'));
            }
        }

        $data = ['title' => 'Login - Portal Magang BWS V'];
        return view('auth/login', $data);
    }

    /**
     * Memproses data login dari KEDUA form (mahasiswa & admin)
     */
    public function loginProses()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $dataUser = $userModel->where('email', $email)->first();

        if ($dataUser) {
            if (password_verify($password, $dataUser['password'])) {
                // Login Sukses! Buat session.
                $sessLogin = [
                    'is_logged_in' => true,
                    'user_id'      => $dataUser['id'],
                    'user_nama'    => $dataUser['nama'],
                    'user_role'    => $dataUser['role']
                ];
                $session->set($sessLogin);

                // [PERBAIKAN] Arahkan 'admin' DAN 'superadmin' ke halaman admin
                if ($dataUser['role'] == 'admin' || $dataUser['role'] == 'superadmin') {
                    return redirect()->to(base_url('admin')); // Arahkan ke dashboard admin
                } else {
                    return redirect()->to(base_url('peserta')); // Arahkan ke Dashboard Peserta
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

    /**
     * Menghancurkan session (kartu visitor) saat logout.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    /**
     * Menampilkan halaman register.
     */
    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->back();
        }
        $data = ['title' => 'Daftar Akun - Portal Magang BWS V'];
        return view('auth/register', $data);
    }

    /**
     * Memproses form registrasi peserta.
     */
    public function registerProses()
    {
        $session = session();
        $userModel = new UserModel();
        $biodataModel = new BiodataModel();

        $aturan = [
            'nama' => ['rules' => 'required', 'errors' => ['required' => 'Nama lengkap wajib diisi.']],
            'email' => [
                'rules' => 'required|valid_email|is_unique[tb_users.email]',
                'errors' => ['required'    => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.', 'is_unique'   => 'Email ini sudah terdaftar.']
            ],
            'password' => ['rules' => 'required|min_length[6]', 'errors' => ['required'   => 'Password wajib diisi.', 'min_length' => 'Password minimal 6 karakter.']],
            'confpassword' => ['rules' => 'matches[password]', 'errors' => ['matches' => 'Konfirmasi password tidak sama.']]
        ];
        if (!$this->validate($aturan)) {
            return redirect()->to(base_url('register'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUser = [
            'nama'     => $this->request->getVar('nama'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'mahasiswa'
        ];
        $userModel->save($dataUser);
        $idUserBaru = $userModel->getInsertID();
        $dataBiodata = ['id_user' => $idUserBaru];
        $biodataModel->save($dataBiodata);

        $session->setFlashdata('pesan_sukses', 'Pendaftaran berhasil! Silakan login untuk melengkapi biodata.');
        return redirect()->to(base_url('login'));
    }

    // --- (Fungsi Lupa Password) ---
    public function lupaPassword() { /* ... */ }
    public function kirimLinkReset() { /* ... */ }
    public function resetPassword($token = null) { /* ... */ }
    public function updatePasswordBaru() { /* ... */ }
    private function _kirimEmail($to, $subject, $message) { /* ... */ }
}