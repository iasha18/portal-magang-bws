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
        :root {
            --bs-primary: #0d6efd;
            --bs-primary-rgb: 13, 110, 253;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            color: #4b5563;
        }
        h1, h2, h3, h4, h5, h6 { color: #111827; font-weight: 600; }
        .navbar-brand { font-weight: 700; color: var(--bs-primary) !important; letter-spacing: -0.5px; }

        /* --- UTILITY KELAS PROFESIONAL --- */
        .shadow-soft { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025) !important; }
        .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important; }

        /* --- KOMPONEN --- */
        .btn-masuk-custom {
            background-color: var(--bs-primary) !important; color: white !important;
            padding: 0.6rem 1.5rem !important; border-radius: 50px !important;
            font-weight: 600 !important; text-decoration: none !important;
            transition: 0.3s; display: inline-block; box-shadow: 0 4px 6px -1px rgba(var(--bs-primary-rgb), 0.2);
        }
        .btn-masuk-custom:hover {
            background-color: #0b5ed7 !important; transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(var(--bs-primary-rgb), 0.3);
        }

        .hero-section {
            position: relative;
            background-image: url('/img/hero-bg.jpg');
            background-size: cover; background-position: center center; color: white;
        }
        .hero-overlay {
            position: relative; z-index: 2;
            background-color: rgba(17, 24, 39, 0.65); /* Sedikit lebih gelap agar teks lebih kontras */
            padding-top: 160px; padding-bottom: 160px;
        }

        /* --- CSS ALUR MAGANG (KEMBALI KE ASLI - HIJAU) --- */
        .step-icon {
            width: 45px; height: 45px; background-color: #2ecc71; color: white;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: bold; margin: 0 auto 15px; position: relative; z-index: 2;
            box-shadow: 0 0 0 5px #f0fdf4; /* Ring halus hijau muda */
        }
        .step-line {
            position: absolute; top: 22px; left: 0; right: 0; height: 3px; background-color: #2ecc71; z-index: 1;
        }
        .step-container { position: relative; }
        .card-alu {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card-alu:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top py-3">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
            MAGANG BWS V
        </a>
        <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center fw-medium">
            <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('/') ?>">Beranda</a></li>
            <li class="nav-item"><a class="nav-link px-3" href="<?= base_url('/') ?>#lowongan">Lowongan</a></li>
            <li class="nav-item ms-2">
                <a class="btn-masuk-custom" href="<?= base_url('login') ?>">Masuk</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div>
        <?= $this->renderSection('content'); ?>
    </div>

    <footer class="bg-dark text-white pt-5 pb-3 mt-5" style="font-size: 0.95rem;">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3 ls-tight">BWS SUMATERA V</h5>
                    <p class="text-white-50 mb-0" style="line-height: 1.8;">Melayani negeri dengan integritas dalam pengelolaan sumber daya air yang berkelanjutan untuk kesejahteraan rakyat.</p>
                </div>
                <div class="col-lg-3 offset-xl-1">
                    <h6 class="fw-bold text-white text-uppercase mb-3 ls-wider" style="letter-spacing: 1px; font-size: 0.8rem;">Hubungi Kami</h6>
                    <ul class="list-unstyled text-white-50 mb-0" style="line-height: 2;">
                        <li>Jl. Khatib Sulaiman No.86A, Padang</li>
                        <li>(0751) 7058350</li>
                        <li>bws.sv@pu.go.id</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fw-bold text-white text-uppercase mb-3 ls-wider" style="letter-spacing: 1px; font-size: 0.8rem;">Sosial Media</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-5 border-secondary opacity-25">
            <div class="text-center text-white-50 small">
                © <?= date('Y'); ?> Balai Wilayah Sungai Sumatera V. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>