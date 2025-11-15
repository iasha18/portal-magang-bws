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
        // (Fungsi Dashboard Anda sudah ada di sini)
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
            ->findAll(); // Biarkan ini findAll, ini untuk widget dashboard
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

    // --- (Fungsi CRUD Lowongan Anda TIDAK BERUBAH) ---
    public function lowongan()
    {
        $data = [
            'title'    => 'Kelola Lowongan Magang',
            'lowongan' => $this->lowonganModel->orderBy('id', 'DESC')->findAll() // Tambah orderBy
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
        // (Validasi bisa ditambahkan di sini)
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
    // FITUR KELOLA PENDAFTAR (FUNGSI INI KITA MODIFIKASI TOTAL)
    // -------------------------------------------------------------------

    /**
     * [FUNGSI INI DI-UPDATE]
     * Menampilkan daftar semua pendaftar dengan search dan pagination
     */
    public function pendaftar()
    {
        // 1. Ambil keyword pencarian dari URL (jika ada)
        $keyword = $this->request->getGet('keyword');

        // 2. Siapkan query dasar (JOIN 3 tabel)
        // Kita gunakan $this->lamaranModel yang dari construct
        // Kita tambahkan ALIAS agar sesuai dengan view
        $query = $this->lamaranModel
            ->select('
                tb_lamaran.id as id_lamaran, 
                tb_lamaran.status_lamaran as status, 
                tb_lamaran.tanggal_melamar as tgl_daftar, 
                tb_users.nama as nama_pendaftar, 
                tb_users.email, 
                tb_lowongan.posisi
            ')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan');

        // 3. Jika ada keyword, tambahkan filter pencarian
        if ($keyword) {
            $query->groupStart() // Memulai grup ( ...
                ->like('tb_users.nama', $keyword)
                ->orLike('tb_users.email', $keyword)
                ->orLike('tb_lowongan.posisi', $keyword)
                ->orLike('tb_lamaran.status_lamaran', $keyword) // cari status juga
                ->groupEnd(); // Menutup grup ... )
        }

        // 4. UBAH findAll() MENJADI paginate()
        // 10 data per halaman, dengan nama grup 'pendaftar'
        $daftarPendaftar = $query->orderBy('tb_lamaran.tanggal_melamar', 'DESC')
                                 ->paginate(10, 'pendaftar');

        // 5. Siapkan data untuk View
        $data = [
            'title'         => 'Data Pendaftar Magang',
            'dataPendaftar' => $daftarPendaftar, // Ganti nama var
            'pager'         => $this->lamaranModel->pager, // Tambahkan pager
            'keyword'       => $keyword 
        ];
        
        return view('admin/pendaftar_index', $data);
    }

    // --- (Fungsi-fungsi Anda yang lain TIDAK BERUBAH) ---

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
    // FITUR KELOLA ADMIN (TIDAK BERUBAH)
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
    
    // --- (Fungsi kirim email TIDAK BERUBAH) ---
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
        // (Template email disingkat untuk keringkasan)
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