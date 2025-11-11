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

    // Halaman Dashboard Admin
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

    // --- (Fungsi CRUD Lowongan) ---
    public function lowongan() { /*...*/ }
    public function tambah() { /*...*/ }
    public function simpan() { /*...*/ }
    public function edit($id) { /*...*/ }
    public function update() { /*...*/ }
    public function hapus($id) { /*...*/ }

    // --- (Fungsi Kelola Pendaftar) ---
    public function pendaftar() { /*...*/ }
    public function updateStatus($id_lamaran, $status_baru) { /*...*/ }
    public function detailPendaftar($id_lamaran) { /*...*/ }
    public function hapusPendaftar($id_lamaran) { /*...*/ }
    
    // -------------------------------------------------------------------
    // [FUNGSI BARU] KELOLA ADMIN
    // -------------------------------------------------------------------
    public function kelolaAdmin()
    {
        $data = [
            'title' => 'Kelola Pengguna Admin',
            // Ambil semua user yang rolenya 'admin' ATAU 'superadmin'
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
            'role'     => 'admin' // PENTING: Admin baru otomatis 'admin' biasa, bukan 'superadmin'
        ];
        $this->userModel->save($data);
        session()->setFlashdata('pesan_sukses', 'Admin baru berhasil ditambahkan!');
        return redirect()->to(base_url('admin/users'));
    }
    
    // --- (Fungsi kirim email: _kirimEmail dan _templateEmail) ---
    private function _kirimEmail($to, $subject, $message) { /*...*/ }
    private function _templateEmail($judul, $paragraf1, $paragraf2, $urlTombol, $teksTombol) { /*...*/ }
}