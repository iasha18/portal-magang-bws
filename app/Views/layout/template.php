<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Portal Magang BWS V'; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 600;
            color: #0d6efd !important;
        }
        /* CSS Khusus Alur Magang */
        .step-icon {
            width: 40px;
            height: 40px;
            background-color: #2ecc71;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin: 0 auto 10px;
            position: relative;
            z-index: 2;
        }
        .step-line {
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 3px;
            background-color: #2ecc71;
            z-index: 1;
        }
        .step-container {
            position: relative;
        }
        .card-alu {
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .card-alu:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
      <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">MAGANG BWS V</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>#lowongan">Lowongan</a></li>
            <li class="nav-item"><a class="nav-link btn btn-primary text-white px-4 ms-2" href="<?= base_url('login') ?>">Masuk</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div style="margin-top: 80px;">
        <?= $this->renderSection('content'); ?>
    </div>

    <footer class="bg-dark text-white py-4 mt-5" style="font-size: 0.9rem;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5 class="fw-bold text-white mb-2">BWS SUMATERA V</h5>
                    <p class="text-white-50 small mb-0">SIGAP MEMBANGUN NEGERI UNTUK RAKYAT</p>
                </div>
                <div class="col-md-5">
                    <h6 class="fw-bold text-uppercase mb-3">Kontak Kami</h6>
                    <ul class="list-unstyled text-white-50 mb-0">
                        <li class="mb-2 d-flex"><i class="fas fa-map-marker-alt mt-1 me-3 flex-shrink-0"></i><span>Jl. Khatib Sulaiman No.86A, Padang</span></li>
                        <li class="mb-2"><i class="fas fa-phone me-3"></i> (0751) 7058350</li>
                        <li><i class="fas fa-envelope me-3"></i> bws.sv@pu.go.id</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold text-uppercase mb-3">Ikuti Kami</h6>
                    <div class="d-flex">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center text-white-50 small">
                © <?= date('Y'); ?> Balai Wilayah Sungai Sumatera V. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>