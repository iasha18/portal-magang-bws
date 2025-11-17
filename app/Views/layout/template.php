<?php
// app/Views/layout/template.php

// Pastikan helper URL dimuat untuk fungsi base_url()
helper('url');
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Portal Magang BWS V'; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
        /* --- PENGATURAN GLOBAL --- */
        :root { --bs-primary: #0d6efd; --bs-primary-rgb: 13, 110, 253; }
        body { font-family: 'Poppins', sans-serif; background-color: #f9fafb; color: #4b5563; display: flex; flex-direction: column; min-height: 100vh; }
        .navbar-brand { font-weight: 700; color: var(--bs-primary) !important; letter-spacing: -0.5px; }

        /* --- UTILITY --- */
        .shadow-soft { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025) !important; }
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important; }

        /* --- HERO SECTION --- */
        .hero-section { position: relative; background-size: cover; background-position: center center; color: white; }
        .hero-overlay { position: relative; z-index: 2; background-color: rgba(17, 24, 39, 0.65); padding-top: 160px; padding-bottom: 160px; }

        /* --- CSS ALUR MAGANG (PRESISI TINGGI) --- */
        /* Menggantikan .step-container */
        .alur-magang-container {
            position: relative;
            padding: 20px 0;
        }
        /* Menggantikan .step-icon */
        .alur-magang-icon {
            width: 60px; height: 60px;
            background-color: var(--bs-primary);
            color: white; font-size: 1.5rem; font-weight: 700;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            position: relative; z-index: 2;
            border: 5px solid #fff;
            box-shadow: 0 0 0 5px rgba(var(--bs-primary-rgb), 0.2);
        }

/* Menggantikan .step-line dan memperbaiki kalkulasi */
.alur-magang-line {
    position: absolute;
    height: 4px;
    background-color: var(--bs-primary);
    opacity: 0.3;
    z-index: 1;
    border-radius: 10px;
    top: 50px;
    /* Mulai di tepi kanan ikon 1: 12.5% + 30px */
    left: calc(12.5% + 30px);
    /* [DIKOREKSI] Akhir garis: Berhenti tepat 30px setelah pusat ikon 3.
       Pusat ikon 3 berada 62.5% dari kiri. Jarak dari kanan harus 37.5% - 30px.
       Ini akan memanjangkan garis melewati nilai yang salah sebelumnya.
       
       *Catatan*: Jika Anda ingin garis berhenti di tengah-tengah antara 3 dan 4, 
       coba gunakan `right: 25%`. Jika ingin berhenti di tepi ikon 3, gunakan nilai ini:
    */
    right: calc(37.5% - 30px); 
    transform: translateY(-50%);
}


    
        /* --- ALUR MAGANG (robust) --- */
.alur-magang-wrapper {
    position: relative;
    padding: 24px 0;
    min-height: 100px; /* memberi ruang untuk ikon dan garis */
}

/* Garis horizontal yang membentang di belakang ikon */
.alur-magang-line {
    position: absolute;
    top: 50%;
    left: 4%;
    right: 4%;
    height: 6px;
    background-color: var(--bs-primary);
    opacity: 0.18;
    border-radius: 6px;
    transform: translateY(-50%);
    z-index: 1; /* di bawah ikon */
}

/* Ikon (tetap seperti sebelumya, tapi z-index lebih tinggi sehingga menutupi garis) */
.alur-magang-icon {
    width: 60px;
    height: 60px;
    background-color: var(--bs-primary);
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    position: relative;
    z-index: 2; /* di atas garis */
    border: 5px solid #fff;
    box-shadow: 0 0 0 5px rgba(var(--bs-primary-rgb), 0.18);
}

/* Kolom pembungkus ikon agar distribusi benar di d-flex */
.alur-magang-col {
    flex: 0 0 calc(25% - 1rem); /* sediakan 4 kolom seimbang */
    display: flex;
    justify-content: center;
    align-items: center;
}
        /* --- KARTU ALUR --- */
        .card-alu { border: none; transition: 0.3s; border-radius: 15px; background: #fff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .card-alu:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }

        /* ===========================================================
        [CSS BARU] Tambahkan ini untuk transisi fade
        ===========================================================
        */
        #lowongan-container {
            /* Menentukan properti yang akan dianimasikan */
            transition: opacity 0.3s ease-in-out;
            opacity: 1; /* Status normal (terlihat) */
        }

        #lowongan-container.fading {
            opacity: 0; /* Status fade-out (menghilang) */
        }

/* Responsive tweak: pada layar besar wrapper akan terlihat, di bawah lg Anda sudah punya versi kartu */
/* Jika butuh, sesuaikan left/right pada .alur-magang-line untuk melebarkan/mempersempit garis */

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top py-3">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">MAGANG BWS SUMATERA V</a>
        <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center fw-medium">
            <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('/') ?>">Beranda</a></li>
            <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('/') ?>#lowongan">Lowongan</a></li>
            <?php if (session()->get('is_logged_in')) : ?>
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> <?= session()->get('user_nama'); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <?php if (session()->get('user_role') == 'admin') : ?>
                            <li><a class="dropdown-item" href="<?= base_url('admin/lowongan') ?>">Dashboard Admin</a></li>
                        <?php else : ?>
                            <li><a class="dropdown-item" href="<?= base_url('peserta') ?>">Dashboard Peserta</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Keluar</a></li>
                    </ul>
                </li>
            <?php else : ?>
                <li class="nav-item ms-2"><a class="btn btn-primary rounded-pill px-4" href="<?= base_url('login') ?>">Masuk</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div style="flex: 1;">
        <?= $this->renderSection('content'); ?>
    </div>

    <footer class="bg-dark text-white pt-5 pb-3 mt-auto" style="font-size: 0.95rem;">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3">BWS SUMATERA V</h5>
                    <p class="text-white-50 mb-0" style="line-height: 1.8;">Melayani negeri dengan integritas dalam pengelolaan sumber daya air yang berkelanjutan untuk kesejahteraan rakyat.</p>
                </div>
                <div class="col-lg-3 offset-xl-1">
                    <h6 class="fw-bold text-white text-uppercase mb-3" style="letter-spacing: 1px; font-size: 0.8rem;">Hubungi Kami</h6>
                    <ul class="list-unstyled text-white-50 mb-0" style="line-height: 2;">
                        <li>Jl. Khatib Sulaiman No.86A, Padang</li>
                        <li>(0751) 7058350</li>
                        <li>bws.sv@pu.go.id</li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="fw-bold text-white text-uppercase mb-3" style="letter-spacing: 1px; font-size: 0.8rem;">Sosial Media</h6>
                    <div class="d-flex gap-2">
                        <a href="https://x.com/bws_sumatera5" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="X/Twitter">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/balaiwilayahsungai.sumaterav" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/pu_sda_sumatera5/" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@pupr_sda_bwssumatera5padang" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                </div>
            <hr class="my-5 border-secondary opacity-25">
            <div class="text-center text-white-50 small">© <?= date('Y'); ?> Balai Wilayah Sungai Sumatera V. All rights reserved.</div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?= $this->renderSection('scripts'); ?>
</body>
</html>