<?php

namespace App\Controllers;

// Panggil semua 4 Model
use App\Models\LowonganModel;
use App\Models\LamaranModel;
use App\Models\BiodataModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $lowonganModel;
    protected $lamaranModel;
    protected $biodataModel;
    protected $userModel;

    public function __construct()
    {
        $this->lowonganModel = new LowonganModel();
        $this->lamaranModel = new LamaranModel();
        $this->biodataModel = new BiodataModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // (Fungsi Dashboard)
        $total_lowongan = $this->lowonganModel->countAllResults();
        $total_lamaran = $this->lamaranModel->countAllResults();
        $total_pending = $this->lamaranModel->where('status_lamaran', 'Pending')->countAllResults();
        $total_peserta = $this->userModel->where('role', 'mahasiswa')->countAllResults();
        
        $pendaftar_terbaru = $this->lamaranModel
            ->select('tb_users.nama, tb_lowongan.posisi, tb_lamaran.tanggal_melamar')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->orderBy('tb_lamaran.tanggal_melamar', 'DESC')
            ->limit(5)
            ->findAll();
        $data = [
            'title'    => 'Dashboard Admin',
            'total_lowongan' => $total_lowongan,
            'total_lamaran' => $total_lamaran,
            'total_pending' => $total_pending,
            'total_peserta' => $total_peserta,
            'pendaftar_terbaru' => $pendaftar_terbaru
        ];
        return view('admin/dashboard', $data);
    }

    // --- (Fungsi CRUD Lowongan) ---
    public function lowongan()
    {
        $data = [
            'title'    => 'Kelola Lowongan Magang',
            'lowongan' => $this->lowonganModel->orderBy('id', 'DESC')->findAll()
        ];
        return view('admin/lowongan_index', $data);
    }
    
    public function tambah()
    {
        $data = ['title' => 'Tambah Lowongan Baru'];
        return view('admin/lowongan_tambah', $data);
    }

    /**
     * ==========================================================
     * [FUNGSI INI DIMODIFIKASI]
     * Menambahkan Pengecekan Duplikasi Data
     * ==========================================================
     */
    public function simpan()
    {
        $posisi = $this->request->getVar('posisi');
        $unit   = $this->request->getVar('unit');

        // 1. CEK DUPLIKASI
        // Cari apakah ada data dengan Posisi DAN Unit yang sama persis
        $cekDuplikat = $this->lowonganModel
            ->where('posisi', $posisi)
            ->where('unit', $unit)
            ->first();

        // 2. JIKA DITEMUKAN DUPLIKAT
        if ($cekDuplikat) {
            // Set pesan error flashdata
            session()->setFlashdata('pesan_error', 'Gagal! Lowongan untuk posisi <b>' . $posisi . '</b> di unit <b>' . $unit . '</b> sudah terdaftar. Mohon cek kembali atau edit data yang ada.');
            
            // Kembalikan ke halaman sebelumnya + Bawa data inputan (withInput) agar tidak capek ngetik ulang
            return redirect()->back()->withInput();
        }

        // 3. JIKA AMAN (TIDAK ADA DUPLIKAT), LANJUT SIMPAN
        $data = [
            'posisi'    => $posisi,
            'unit'      => $unit,
            'kebutuhan' => $this->request->getVar('kebutuhan'),
            'status'    => $this->request->getVar('status'),
            'deskripsi' => $this->request->getVar('deskripsi'),
        ];
        $this->lowonganModel->save($data);
        
        session()->setFlashdata('pesan_sukses', 'Data lowongan baru berhasil ditambahkan!');
        return redirect()->to(base_url('admin/lowongan'));
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Lowongan',
            'lowongan' => $this->lowonganModel->find($id) 
        ];
        return view('admin/lowongan_edit', $data);
    }

    public function update()
    {
        $idLowongan = $this->request->getVar('id');
        $data = [
            'posisi'    => $this->request->getVar('posisi'),
            'unit'      => $this->request->getVar('unit'),
            'kebutuhan' => $this->request->getVar('kebutuhan'),
            'status'    => $this->request->getVar('status'),
            'deskripsi' => $this->request->getVar('deskripsi'),
        ];
        $this->lowonganModel->update($idLowongan, $data);
        session()->setFlashdata('pesan_sukses', 'Data lowongan berhasil diperbarui!');
        return redirect()->to(base_url('admin/lowongan'));
    }

    public function hapus($id)
    {
        $this->lowonganModel->delete($id);
        session()->setFlashdata('pesan_sukses', 'Data lowongan berhasil dihapus!');
        return redirect()->to(base_url('admin/lowongan'));
    }


    // -------------------------------------------------------------------
    // FITUR KELOLA PENDAFTAR
    // -------------------------------------------------------------------
    public function pendaftar()
    {
        $keyword = $this->request->getGet('keyword');
        $query = $this->lamaranModel->searchPendaftar($keyword);

        $data = [
            'title'         => 'Data Pendaftar Magang',
            'dataPendaftar' => $query->paginate(10, 'pendaftar'), 
            'pager'         => $this->lamaranModel->pager, 
            'keyword'       => $keyword 
        ];
        
        return view('admin/pendaftar_index', $data);
    }

    public function updateStatus($id_lamaran, $status_baru)
    {
        if (!in_array($status_baru, ['Diterima', 'Ditolak'])) {
            session()->setFlashdata('pesan_error', 'Status tidak valid!');
            return redirect()->to(base_url('admin/pendaftar'));
        }

        $lamaranIni = $this->lamaranModel->find($id_lamaran);
        if (!$lamaranIni) {
            session()->setFlashdata('pesan_error', 'Data lamaran tidak ditemukan!');
            return redirect()->to(base_url('admin/pendaftar'));
        }
        $id_user_peserta = $lamaranIni->id_user;

        if ($status_baru == 'Diterima') {
            $lamaranDiterimaLain = $this->lamaranModel
                ->where('id_user', $id_user_peserta)
                ->where('status_lamaran', 'Diterima')
                ->where('id !=', $id_lamaran) 
                ->first();

            if ($lamaranDiterimaLain) {
                session()->setFlashdata('pesan_error', 'GAGAL! Peserta ini sudah diterima di lowongan lain. Tolak lamaran yang lama jika ingin menerima yang ini.');
                return redirect()->to(base_url('admin/pendaftar'));
            }
        }

        $this->lamaranModel->update($id_lamaran, ['status_lamaran' => $status_baru]);

        $dataEmail = $this->lamaranModel
            ->select('tb_users.email, tb_users.nama, tb_lowongan.posisi')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->find($id_lamaran); 

        $emailTujuan = $dataEmail->email;
        $namaPendaftar = $dataEmail->nama;
        $posisiDilamar = $dataEmail->posisi;
        
        $subject = ""; $message = "";
        if ($status_baru == 'Diterima') {
            $subject = "Selamat! Lamaran Magang Anda di BWS Sumatera V Diterima";
            $message = $this->_templateEmail("Selamat, " . $namaPendaftar . "!", "Dengan senang hati kami informasikan bahwa lamaran Anda untuk posisi <b>" . $posisiDilamar . "</b> telah kami terima.", "Sebagai tahap selanjutnya, kami mohon Anda untuk segera mengantarkan berkas pengantar (hardcopy) dari kampus/sekolah Anda ke Kantor BWS Sumatera V di Jl. Khatib Sulaiman No.86A, Padang.", "", "");
        } else {
            $subject = "Pemberitahuan Status Lamaran Magang BWS Sumatera V";
            $message = $this->_templateEmail("Pemberitahuan Lamaran", "Halo, " . $namaPendaftar . ".<br>Terima kasih atas antusiasme Anda untuk bergabung dengan program magang BWS Sumatera V untuk posisi <b>" . $posisiDilamar . "</b>.", "Setelah melalui proses peninjauan, dengan berat hati kami sampaikan bahwa Anda belum dapat melanjutkan ke tahap berikutnya untuk posisi ini. Jangan berkecil hati, kami menantikan partisipasi Anda di kesempatan berikutnya.", "", "");
        }

        $emailTerkirim = $this->_kirimEmail($emailTujuan, $subject, $message);

        if ($emailTerkirim) {
            session()->setFlashdata('pesan_sukses', 'Status lamaran berhasil diperbarui dan notifikasi email telah terkirim!');
        } else {
            session()->setFlashdata('pesan_error', 'Status berhasil diperbarui, TAPI notifikasi email GAGAL terkirim.');
        }
        return redirect()->to(base_url('admin/pendaftar'));
    }

    public function detailPendaftar($id_lamaran)
    {
        $dataLamaran = $this->lamaranModel
            ->select('tb_lamaran.*, tb_users.id as id_user, tb_users.nama, tb_users.email, tb_lowongan.posisi, tb_lowongan.unit')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->find($id_lamaran); 

        if (!$dataLamaran) {
             session()->setFlashdata('pesan_error', 'Data lamaran tidak ditemukan!');
             return redirect()->to(base_url('admin/pendaftar'));
        }
        
        $dataBiodata = $this->biodataModel->where('id_user', $dataLamaran->id_user)->first();
        
        $data = [ 'title'   => 'Detail Pendaftar', 'lamaran' => $dataLamaran, 'biodata' => $dataBiodata ];
        return view('admin/pendaftar_detail', $data);
    }

    public function hapusPendaftar($id_lamaran)
    {
        $this->lamaranModel->delete($id_lamaran);
        session()->setFlashdata('pesan_sukses', 'Data lamaran berhasil dihapus permanen.');
        return redirect()->to(base_url('admin/pendaftar'));
    }
    
    // -------------------------------------------------------------------
    // FITUR KELOLA ADMIN
    // -------------------------------------------------------------------
    public function kelolaAdmin()
    {
        $data = [
            'title' => 'Kelola Pengguna Admin',
            // Ambil semua kolom untuk admin, termasuk created_at dan ID.
            'admins' => $this->userModel->select('id, nama, email, created_at, role')->whereIn('role', ['admin', 'superadmin'])->findAll()
        ];
        return view('admin/admin_index', $data);
    }
    
    public function tambahAdmin()
    {
        $data = [
            'title' => 'Tambah Admin Baru'
        ];
        return view('admin/admin_tambah', $data);
    }

    public function simpanAdmin()
    {
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
            return redirect()->to(base_url('admin/users/tambah'))->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = [
            'nama'     => $this->request->getVar('nama'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'admin'
        ];
        $this->userModel->save($data);
        session()->setFlashdata('pesan_sukses', 'Admin baru berhasil ditambahkan!');
        return redirect()->to(base_url('admin/users'));
    }
    
    /**
     * Menampilkan form edit admin.
     */
    public function editAdmin($id)
    {
        $admin = $this->userModel->find($id);

        if (!$admin || ($admin['role'] !== 'admin' && $admin['role'] !== 'superadmin')) {
             session()->setFlashdata('pesan_error', 'Admin tidak ditemukan atau bukan pengguna Admin.');
             return redirect()->to(base_url('admin/users'));
        }

        $data = [
            'title' => 'Edit Pengguna Admin',
            'admin' => $admin
        ];
        return view('admin/admin_edit', $data);
    }

    /**
     * Memproses update data admin.
     */
    public function updateAdmin()
    {
        $id = $this->request->getVar('id');
        $passwordBaru = $this->request->getVar('password');
        $emailBaru = $this->request->getVar('email');
        
        $adminLama = $this->userModel->find($id);

        // Aturan validasi
        $aturan = [
            'nama' => ['rules' => 'required', 'errors' => ['required' => 'Nama lengkap wajib diisi.']],
            'email' => [
                // Cek unik email, kecuali email yang sedang diedit
                'rules' => "required|valid_email|is_unique[tb_users.email,id,{$id}]", 
                'errors' => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.', 'is_unique' => 'Email ini sudah terdaftar.']
            ],
            // Jika password diisi, validasi konfirmasi
            'confpassword' => ['rules' => 'matches[password]', 'errors' => ['matches' => 'Konfirmasi password tidak sama.']]
        ];

        // Jika password diisi, tambahkan aturan minimal panjang
        if (!empty($passwordBaru)) {
            $aturan['password'] = ['rules' => 'required|min_length[6]', 'errors' => ['required' => 'Password wajib diisi.', 'min_length' => 'Password minimal 6 karakter.']];
        }

        if (!$this->validate($aturan)) {
            // Jika validasi gagal, kembali ke form edit dengan error
            return redirect()->to(base_url('admin/users/edit/' . $id))->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'  => $this->request->getVar('nama'),
            'email' => $emailBaru,
            'role'  => $this->request->getVar('role') // Memungkinkan superadmin mengubah role
        ];

        // Hanya update password jika diisi
        if (!empty($passwordBaru)) {
            $data['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        
        session()->setFlashdata('pesan_sukses', 'Data Admin berhasil diperbarui!');
        return redirect()->to(base_url('admin/users'));
    }

    /**
     * Menghapus admin
     */
    public function hapusAdmin($id)
    {
        $admin = $this->userModel->find($id);

        // Batasi penghapusan Super Admin pertama (ID 1)
        if ($id == 1 && $admin['role'] == 'superadmin') {
             session()->setFlashdata('pesan_error', 'Pengguna Super Admin utama tidak dapat dihapus!');
             return redirect()->to(base_url('admin/users'));
        }

        $this->userModel->delete($id);
        session()->setFlashdata('pesan_sukses', 'Pengguna Admin berhasil dihapus.');
        return redirect()->to(base_url('admin/users'));
    }
    
    private function _kirimEmail($to, $subject, $message) {
        $email = \Config\Services::email();
        $email->setTo($to); $email->setSubject($subject); $email->setMessage($message);
        if ($email->send()) { return true; } 
        else { log_message('error', $email->printDebugger(['headers'])); return false; }
    }
    private function _templateEmail($judul, $paragraf1, $paragraf2, $urlTombol, $teksTombol) {
        $tombolEmail = "";
        if (!empty($urlTombol) && !empty($teksTombol)) {
            $tombolEmail = "<a href='" . $urlTombol . "' style='display: inline-block; background-color: #0d6efd; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; margin-top: 15px;'>" . $teksTombol . "</a>";
        }
        return "<div style='font-family: Poppins, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>" 
               . "<h2 style='color: #0d6efd;'>" . $judul . "</h2>" 
               . "<p style='font-size: 16px; color: #333; line-height: 1.6;'>" . $paragraf1 . "</p>" 
               . "<p style='font-size: 16px; color: #333; line-height: 1.6;'>" . $paragraf2 . "</p>" 
               . $tombolEmail 
               . "<hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>"
               . "<p style='font-size: 12px; color: #888;'>Email ini dikirim otomatis. Mohon tidak membalas.</p>"
               . "</div>";
    }
}