<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BiodataModel; 

class Auth extends BaseController
{
    // --- (Fungsi login, loginProses, logout, register, registerProses) ---
    // --- (Ini semua sudah benar dari sebelumnya) ---

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

    public function registerProses()
    {
        $session = session();
        $userModel = new UserModel();
        $biodataModel = new BiodataModel();

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
            'password' => ['rules' => 'required|min_length[6]', 'errors' => ['required' => 'Password wajib diisi.', 'min_length' => 'Password minimal 6 karakter.']],
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


    // -------------------------------------------------------------------
    // [FITUR LUPA PASSWORD]
    // -------------------------------------------------------------------

    /**
     * 1. Menampilkan halaman form 'Lupa Password'
     */
    public function lupaPassword()
    {
        $data = [
            'title' => 'Lupa Password'
        ];
        return view('auth/lupa_password', $data);
    }

    /**
     * 2. Memproses pengiriman link reset via email (FUNGSI DIPERBAIKI)
     */
    public function kirimLinkReset()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $user = $userModel->where('email', $email)->first();

        // Cek apakah emailnya ada di database
        if (!$user) {
            $session->setFlashdata('pesan_error', 'Email tidak terdaftar di sistem.');
            return redirect()->to(base_url('lupa-password'));
        }

        // 1. Buat Token Rahasia
        $token = bin2hex(random_bytes(20));
        $expires = date('Y-m-d H:i:s', time() + 3600); // Token berlaku 1 jam

        // 2. Simpan token ke database
        $userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expires' => $expires
        ]);

        // 3. Kirim email
        $linkReset = base_url('reset-password/' . $token);
        $subject = "Reset Password Akun Portal Magang BWS V";
        $message = "Halo, " . $user['nama'] . ".<br><br>Kami menerima permintaan untuk mereset password Anda. Silakan klik link di bawah ini untuk membuat password baru:<br><br>"
                   . "<a href='" . $linkReset . "' style='background-color: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Reset Password Saya</a>"
                   . "<br><br>Link ini hanya berlaku selama 1 jam.<br>Jika Anda tidak merasa meminta reset password, silakan abaikan email ini."
                   . "<br><br>Terima kasih,<br>Admin BWS Sumatera V";

        // --- [PERBAIKAN ERROR ADA DI SINI] ---
        // Kita definisikan $emailTujuan sebelum memanggilnya
        $emailTujuan = $user['email']; 
        $emailTerkirim = $this->_kirimEmail($emailTujuan, $subject, $message);
        // --- [SELESAI PERBAIKAN] ---

        if ($emailTerkirim) {
            $session->setFlashdata('pesan_sukses', 'Link reset password telah terkirim ke email Anda. Silakan cek inbox (atau folder spam).');
        } else {
            $session->setFlashdata('pesan_error', 'Gagal mengirim email. Cek konfigurasi SMTP Anda di app/Config/Email.php');
        }

        return redirect()->to(base_url('lupa-password'));
    }

    /**
     * 3. Menampilkan form "Password Baru" (setelah link di email diklik)
     */
    public function resetPassword($token = null)
    {
        $userModel = new UserModel();
        
        if ($token == null) {
            session()->setFlashdata('pesan_error', 'Token tidak valid.');
            return redirect()->to(base_url('login'));
        }

        // Cari user berdasarkan token
        $user = $userModel->where('reset_token', $token)->first();

        if (!$user) {
            session()->setFlashdata('pesan_error', 'Token tidak ditemukan atau tidak valid.');
            return redirect()->to(base_url('login'));
        }

        // Cek apakah token sudah kedaluwarsa
        if (strtotime($user['reset_token_expires']) < time()) {
            session()->setFlashdata('pesan_error', 'Token sudah kedaluwarsa. Silakan minta reset baru.');
            return redirect()->to(base_url('lupa-password'));
        }

        // Jika lolos semua, tampilkan form
        $data = [
            'title' => 'Buat Password Baru',
            'token' => $token
        ];
        return view('auth/form_reset_password', $data);
    }

    /**
     * 4. Memproses penyimpanan password baru
     */
    public function updatePasswordBaru()
    {
        $session = session();
        $userModel = new UserModel();
        $token = $this->request->getVar('token');
        $password = $this->request->getVar('password');
        $confpassword = $this->request->getVar('confpassword');

        // Validasi password baru
        if ($password !== $confpassword) {
            return redirect()->to(base_url('reset-password/' . $token))->with('pesan_error', 'Konfirmasi password tidak cocok.');
        }
        if (strlen($password) < 6) {
            return redirect()->to(base_url('reset-password/' . $token))->with('pesan_error', 'Password minimal 6 karakter.');
        }

        // Cari user berdasarkan token (untuk keamanan ganda)
        $user = $userModel->where('reset_token', $token)->first();
        if (!$user) {
            session()->setFlashdata('pesan_error', 'Token tidak valid.');
            return redirect()->to(base_url('login'));
        }

        // Update password baru & hapus tokennya
        $userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null, // Hapus token agar tidak bisa dipakai lagi
            'reset_token_expires' => null
        ]);

        $session->setFlashdata('pesan_sukses', 'Password berhasil diperbarui! Silakan login.');
        return redirect()->to(base_url('login'));
    }
    
    
    // Fungsi helper kirim email (Salin dari Admin.php jika belum ada)
    private function _kirimEmail($to, $subject, $message)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message); // Asumsikan $message sudah HTML
        
        if ($email->send()) {
            return true;
        } else {
            log_message('error', $email->printDebugger(['headers']));
            return false;
        }
    }
}