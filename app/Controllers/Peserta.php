<?php

namespace App\Controllers;

use App\Models\LamaranModel;
use App\Models\BiodataModel;

class Peserta extends BaseController
{
    protected $lamaranModel;
    protected $biodataModel;

    public function __construct()
    {
        $this->lamaranModel = new LamaranModel();
        $this->biodataModel = new BiodataModel();
    }

    // Fungsi Dashboard
    public function index()
    {
        $id_user = session()->get('user_id');

        $daftarLamaran = $this->lamaranModel
            ->select('tb_lamaran.id as id_lamaran, tb_lamaran.status_lamaran, tb_lamaran.tanggal_melamar, tb_lowongan.posisi, tb_lowongan.unit')
            ->join('tb_lowongan', 'tb_lowongan.id = tb_lamaran.id_lowongan')
            ->where('tb_lamaran.id_user', $id_user)
            ->orderBy('tb_lamaran.tanggal_melamar', 'DESC')
            ->findAll();
        
        $biodata = $this->biodataModel->where('id_user', $id_user)->first();

        $data = [
            'title' => 'Dashboard Peserta - Portal Magang BWS V',
            'daftar_lamaran' => $daftarLamaran,
            'biodata' => $biodata
        ];
        return view('peserta/dashboard', $data);
    }
    
    // Fungsi Apply Lowongan
    public function apply($id_lowongan) 
    {
        $id_user = session()->get('user_id');

        $cek = $this->lamaranModel->where('id_user', $id_user)
                                  ->where('id_lowongan', $id_lowongan)
                                  ->first();
        
        if ($cek) {
            session()->setFlashdata('pesan_error', 'Anda sudah pernah melamar di posisi ini!');
            return redirect()->to(base_url('peserta'));
        }

        $data = [
            'id_user'     => $id_user,
            'id_lowongan' => $id_lowongan,
            'status_lamaran' => 'Pending'
        ];

        $this->lamaranModel->save($data);
        session()->setFlashdata('pesan_sukses', 'Lamaran Anda berhasil terkirim!');
        return redirect()->to(base_url('peserta'));
    }

    // -------------------------------------------------------------------
    // FITUR PROFIL
    // -------------------------------------------------------------------

    /**
     * 4. PROFIL (Form)
     * Menampilkan halaman formulir biodata
     */
    public function profil()
    {
        $id_user = session()->get('user_id');
        $data = [
            'title'   => 'Lengkapi Profil Saya',
            'biodata' => $this->biodataModel->where('id_user', $id_user)->first()
        ];
        return view('peserta/form_profil', $data);
    }

    /**
     * 5. PROFIL (Process) - [PERBAIKAN ERROR ADA DI SINI]
     * Menyimpan data biodata dan upload file
     */
    public function updateProfil()
    {
        $session = session();
        $id_user = session()->get('user_id');
        
        $dataBiodataLama = $this->biodataModel->where('id_user', $id_user)->first();

        // 1. Validasi Input
        $aturan = [
            'nim' => 'required',
            'perguruan_tinggi' => 'required',
            'jurusan' => 'required',
            'semester' => 'required|numeric',
            'no_hp' => 'required|min_length[10]',
            'alamat' => 'required'
        ];
        
        if (!$this->validate($aturan)) {
             return redirect()->to(base_url('peserta/profil'))
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        // 2. Siapkan Data Teks
        $data = [
            'nim' => $this->request->getVar('nim'),
            'perguruan_tinggi' => $this->request->getVar('perguruan_tinggi'),
            'jurusan' => $this->request->getVar('jurusan'),
            'semester' => $this->request->getVar('semester'),
            'no_hp' => $this->request->getVar('no_hp'),
            'alamat' => $this->request->getVar('alamat'),
        ];

        // 3. Proses Upload File (Opsional)
        
        // --- Upload CV ---
        $fileCV = $this->request->getFile('file_cv');
        if ($fileCV->isValid() && !$fileCV->hasMoved()) {
            if ($dataBiodataLama && $dataBiodataLama['file_cv']) {
                // [PERBAIKAN] Menggunakan 1 TITIK (.), bukan 3 (...)
                @unlink('uploads/cv/' . $dataBiodataLama['file_cv']);
            }
            $namaFileCV = $id_user . '_CV_' . $fileCV->getRandomName();
            $fileCV->move('uploads/cv/', $namaFileCV);
            $data['file_cv'] = $namaFileCV;
        }

        // --- Upload Surat Pengantar ---
        $fileSurat = $this->request->getFile('file_surat');
        if ($fileSurat->isValid() && !$fileSurat->hasMoved()) {
            if ($dataBiodataLama && $dataBiodataLama['file_surat_pengantar']) {
                // [PERBAIKAN] Menggunakan 1 TITIK (.), bukan 3 (...)
                @unlink('uploads/surat/' . $dataBiodataLama['file_surat_pengantar']);
            }
            $namaFileSurat = $id_user . '_SURAT_' . $fileSurat->getRandomName();
            $fileSurat->move('uploads/surat/', $namaFileSurat);
            $data['file_surat_pengantar'] = $namaFileSurat;
        }

        // 4. Update ATAU Simpan Data ke Database
        if ($dataBiodataLama) {
            // JIKA DATA LAMA DITEMUKAN, lakukan UPDATE
            $this->biodataModel->update($dataBiodataLama['id'], $data);
        } else {
            // JIKA DATA LAMA NULL, lakukan INSERT BARU
            $data['id_user'] = $id_user; // Tambahkan id_user ke array data
            $this->biodataModel->save($data);
        }

        $session->setFlashdata('pesan_sukses', 'Profil Anda berhasil diperbarui!');
        return redirect()->to(base_url('peserta/profil'));
    }
}