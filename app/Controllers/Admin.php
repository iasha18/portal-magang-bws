<?php

namespace App\Controllers;

// Panggil semua Model
use App\Models\LowonganModel;
use App\Models\LamaranModel;
use App\Models\BiodataModel;

class Admin extends BaseController
{
    protected $lowonganModel;
    protected $lamaranModel;
    protected $biodataModel;

    public function __construct()
    {
        // Aktifkan semua Model
        $this->lowonganModel = new LowonganModel();
        $this->lamaranModel = new LamaranModel();
        $this->biodataModel = new BiodataModel();
    }

    // Halaman Dashboard Admin (default)
    public function index()
    {
        return redirect()->to(base_url('admin/lowongan'));
    }

    // -------------------------------------------------------------------
    // FITUR KELOLA LOWONGAN (CRUD)
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
    // FITUR KELOLA PENDAFTAR
    // -------------------------------------------------------------------

    public function pendaftar()
    {
        $daftarPendaftar = $this->lamaranModel
            ->select('tb_lamaran.id as id_lamaran, tb_lamaran.status_lamaran, tb_lamaran.tanggal_melamar, tb_users.nama, tb_users.email, tb_lowongan.posisi')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->orderBy('tb_lamaran.tanggal_melamar', 'DESC')
            ->findAll();
        $data = [
            'title'     => 'Data Pendaftar Magang',
            'pendaftar' => $daftarPendaftar
        ];
        return view('admin/pendaftar_index', $data);
    }

    public function updateStatus($id_lamaran, $status_baru)
    {
        if (!in_array($status_baru, ['Diterima', 'Ditolak'])) {
            session()->setFlashdata('pesan_error', 'Status tidak valid!');
            return redirect()->to(base_url('admin/pendaftar'));
        }
        $data = ['status_lamaran' => $status_baru];

        // [PERBAIKAN] Menggunakan panah '->' bukan titik '.'
        $this->lamaranModel->update($id_lamaran, $data);

        session()->setFlashdata('pesan_sukses', 'Status lamaran berhasil diperbarui!');
        return redirect()->to(base_url('admin/pendaftar'));
    }

    public function detailPendaftar($id_lamaran)
    {
        $dataLamaran = $this->lamaranModel
            ->select('tb_lamaran.*, tb_users.id as id_user, tb_users.nama, tb_users.email, tb_lowongan.posisi, tb_lowongan.unit')
            ->join('tb_users', 'tb_users.id = tb_lamaran.id_user')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->find($id_lamaran); 

        // Ambil data biodata berdasarkan id_user
        $dataBiodata = $this->biodataModel->where('id_user', $dataLamaran['id_user'])->first();

        $data = [
            'title'   => 'Detail Pendaftar',
            'lamaran' => $dataLamaran,
            'biodata' => $dataBiodata // Kirim data biodata ke view
        ];
        
        return view('admin/pendaftar_detail', $data);
    }
}