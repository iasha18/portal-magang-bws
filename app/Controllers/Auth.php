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
        // Jika user sudah login, langsung arahkan ke halaman yang seharusnya
        if (session()->get('is_logged_in')) {
            if (session()->get('user_role') == 'admin' || session()->get('user_role') == 'superadmin') {
                return redirect()->to(base_url('admin')); // Langsung ke Dashboard Admin
            }
            if (session()->get('user_role') == 'mahasiswa') {
                 return redirect()->to(base_url('peserta')); // Langsung ke Dashboard Peserta
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
        $loginType = $this->request->getVar('login_type'); // Ambil 'penanda' dari form (admin atau mahasiswa)
        
        $dataUser = $userModel->where('email', $email)->first();

        if ($dataUser) {
            if (password_verify($password, $dataUser['password'])) {
                
                $roleAsli = $dataUser['role']; 

                // [LOGIKA KEAMANAN] Mencegah salah form login
                if ($loginType == 'admin' && ($roleAsli !== 'admin' && $roleAsli !== 'superadmin')) {
                    $session->setFlashdata('pesan_error', 'Akun ini bukan Admin. Gunakan tab Peserta.');
                    return redirect()->to(base_url('login'));
                }
                if ($loginType == 'mahasiswa' && ($roleAsli == 'admin' || $roleAsli == 'superadmin')) {
                    $session->setFlashdata('pesan_error', 'Akun Admin tidak bisa login di form Peserta. Gunakan tab Admin.');
                    return redirect()->to(base_url('login'));
                }

                // SUKSES LOGIN
                $sessLogin = [
                    'is_logged_in' => true,
                    'user_id'      => $dataUser['id'],
                    'user_nama'    => $dataUser['nama'],
                    'user_role'    => $roleAsli
                ];
                $session->set($sessLogin);

                // Arahkan ke Dashboard yang sesuai
                if ($roleAsli == 'admin' || $roleAsli == 'superadmin') {
                    return redirect()->to(base_url('admin'));
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
    
    public function lupaPassword()
    {
        $data = ['title' => 'Lupa Password'];
        return view('auth/lupa_password', $data);
    }

    public function kirimLinkReset()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            $session->setFlashdata('pesan_error', 'Email tidak terdaftar di sistem.');
            return redirect()->to(base_url('lupa-password'));
        }

        $token = bin2hex(random_bytes(20));
        $expires = date('Y-m-d H:i:s', time() + 3600); // 1 jam

        $userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expires' => $expires
        ]);

        $linkReset = base_url('reset-password/' . $token);
        $subject = "Reset Password Akun Portal Magang BWS V";
        $message = "Halo, " . $user['nama'] . ".<br><br>Kami menerima permintaan untuk mereset password Anda. Silakan klik link di bawah ini:<br><br>"
                   . "<a href='" . $linkReset . "' style='background-color: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Reset Password Saya</a>"
                   . "<br><br>Link ini hanya berlaku selama 1 jam.";

        $emailTujuan = $user['email']; 
        $emailTerkirim = $this->_kirimEmail($emailTujuan, $subject, $message);

        if ($emailTerkirim) {
            $session->setFlashdata('pesan_sukses', 'Link reset password telah terkirim ke email Anda.');
        } else {
            $session->setFlashdata('pesan_error', 'Gagal mengirim email. Cek konfigurasi SMTP Anda.');
        }

        return redirect()->to(base_url('lupa-password'));
    }

    public function resetPassword($token = null)
    {
        $userModel = new UserModel();
        if ($token == null) {
            session()->setFlashdata('pesan_error', 'Token tidak valid.');
            return redirect()->to(base_url('login'));
        }
        $user = $userModel->where('reset_token', $token)->first();
        if (!$user) {
            session()->setFlashdata('pesan_error', 'Token tidak ditemukan.');
            return redirect()->to(base_url('login'));
        }
        if (strtotime($user['reset_token_expires']) < time()) {
            session()->setFlashdata('pesan_error', 'Token sudah kedaluwarsa.');
            return redirect()->to(base_url('lupa-password'));
        }
        $data = ['title' => 'Buat Password Baru', 'token' => $token];
        return view('auth/form_reset_password', $data);
    }

    public function updatePasswordBaru()
    {
        $session = session();
        $userModel = new UserModel();
        $token = $this->request->getVar('token');
        $password = $this->request->getVar('password');
        $confpassword = $this->request->getVar('confpassword');

        if ($password !== $confpassword) {
            return redirect()->to(base_url('reset-password/' . $token))->with('pesan_error', 'Konfirmasi password tidak cocok.');
        }
        if (strlen($password) < 6) {
            return redirect()->to(base_url('reset-password/' . $token))->with('pesan_error', 'Password minimal 6 karakter.');
        }

        $user = $userModel->where('reset_token', $token)->first();
        if (!$user) {
            session()->setFlashdata('pesan_error', 'Token tidak valid.');
            return redirect()->to(base_url('login'));
        }

        $userModel->update($user['id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);

        $session->setFlashdata('pesan_sukses', 'Password berhasil diperbarui! Silakan login.');
        return redirect()->to(base_url('login'));
    }
    
    private function _kirimEmail($to, $subject, $message)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message); 
        
        if ($email->send()) {
            return true;
        } else {
            log_message('error', $email->printDebugger(['headers']));
            return false;
        }
    }
}