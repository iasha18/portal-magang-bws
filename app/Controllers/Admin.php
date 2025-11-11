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
        // Aktifkan semua Model
        $this->lowonganModel = new LowonganModel();
        $this->lamaranModel = new LamaranModel();
        $this->biodataModel = new BiodataModel();
        $this->userModel = new UserModel();
    }

    /**
     * Halaman Dashboard Admin
     */
    public function index()
    {
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
            'title'     => 'Dashboard Admin',
            'total_lowongan' => $total_lowongan,
            'total_lamaran' => $total_lamaran,
            'total_pending' => $total_pending,
            'total_peserta' => $total_peserta,
            'pendaftar_terbaru' => $pendaftar_terbaru
        ];
        
        return view('admin/dashboard', $data);
    }

    // -------------------------------------------------------------------
    // [DIKEMBALIKAN] FITUR KELOLA LOWONGAN (CRUD)
    // -------------------------------------------------------------------

    public function lowongan()
    {
        $data = [
            'title'    => 'Kelola Lowongan Magang',
            'lowongan' => $this->lowonganModel->findAll()
        ];
        return view('admin/lowongan_index', $data);
    }

    public function tambah()
    {
        $data = ['title' => 'Tambah Lowongan Baru'];
        return view('admin/lowongan_tambah', $data);
    }

    public function simpan()
    {
        $data = [
            'posisi'    => $this->request->getVar('posisi'),
            'unit'      => $this->request->getVar('unit'),
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
    // [DIKEMBALIKAN] FITUR KELOLA PENDAFTAR
    // -------------------------------------------------------------------

    public function pendaftar()
    {
        $keyword = $this->request->getGet('keyword');
        $query = $this->lamaranModel
            ->select('tb_lamaran.id as id_lamaran, tb_lamaran.status_lamaran, tb_lamaran.tanggal_melamar, tb_users.nama, tb_users.email, tb_lowongan.posisi')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan');
        if ($keyword) {
            $query->groupStart()
                  ->like('tb_users.nama', $keyword)
                  ->orLike('tb_users.email', $keyword)
                  ->orLike('tb_lowongan.posisi', $keyword)
                  ->groupEnd();
        }
        $daftarPendaftar = $query->orderBy('tb_lamaran.tanggal_melamar', 'DESC')->findAll();
        $data = [
            'title'     => 'Data Pendaftar Magang',
            'pendaftar' => $daftarPendaftar,
            'keyword'   => $keyword
        ];
        return view('admin/pendaftar_index', $data);
    }

    public function updateStatus($id_lamaran, $status_baru)
    {
        if (!in_array($status_baru, ['Diterima', 'Ditolak'])) {
            session()->setFlashdata('pesan_error', 'Status tidak valid!');
            return redirect()->to(base_url('admin/pendaftar'));
        }

        $lamaranData = $this->lamaranModel
            ->select('tb_users.email, tb_users.nama, tb_lowongan.posisi')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->find($id_lamaran);

        if (!$lamaranData) {
            session()->setFlashdata('pesan_error', 'Data lamaran tidak ditemukan!');
            return redirect()->to(base_url('admin/pendaftar'));
        }

        $this->lamaranModel->update($id_lamaran, ['status_lamaran' => $status_baru]);
        
        $emailTujuan = $lamaranData['email'];
        $namaPendaftar = $lamaranData['nama'];
        $posisiDilamar = $lamaranData['posisi'];
        
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
        $dataBiodata = $this->biodataModel->where('id_user', $dataLamaran['id_user'])->first();
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
    // [DIKEMBALIKAN] FITUR KELOLA ADMIN
    // -------------------------------------------------------------------
    public function kelolaAdmin()
    {
        $data = [
            'title' => 'Kelola Pengguna Admin',
            'admins' => $this->userModel->whereIn('role', ['admin', 'superadmin'])->findAll()
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
    
    // --- (Fungsi kirim email: _kirimEmail dan _templateEmail) ---
    private function _kirimEmail($to, $subject, $message) {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) { return true; } 
        else { log_message('error', $email->printDebugger(['headers'])); return false; }
    }
    private function _templateEmail($judul, $paragraf1, $paragraf2, $urlTombol, $teksTombol) {
        $tombolEmail = "";
        if (!empty($urlTombol) && !empty($teksTombol)) {
            $tombolEmail = "<a href='" . $urlTombol . "' style='display: inline-block; background-color: #0d6efd; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; margin-top: 15px;'>" . $teksTombol . "</a>";
        }
        return "<div style='font-family: Poppins, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden;'><div style='background-color: #0d6efd; color: white; padding: 20px 30px;'><h2 style='margin: 0; font-weight: 600;'>Portal Magang BWS Sumatera V</h2></div><div style='padding: 30px; line-height: 1.6;'><h3 style='font-weight: 600; color: #111827; margin-top: 0;'>" . $judul . "</h3><p style='color: #4b5563;'>" . $paragraf1 . "</p><p style='color: #4b5563;'>" . $paragraf2 . "</p>" . $tombolEmail . "<hr style='border: none; border-top: 1px solid #e5e7eb; margin-top: 30px;'><p style='color: #6c757d; font-size: 0.9em;'>Hormat kami,<br>Tim Perekrutan<br>BWS SUMATERA V</p><small style='color: #adb5bd; font-size: 0.8em;'>Ini adalah email otomatis, mohon untuk tidak membalas.</small></div></div>";
    }
}