<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin BWS V'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f8f9fa; 
        }
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: 260px; 
            background-color: #1f2937; /* [DIUBAH] Warna Dark Slate */
            padding-top: 20px; 
            z-index: 100;
        }
        .sidebar-brand {
            font-size: 1.5rem; 
            font-weight: 700; 
            color: #fff;
            text-align: center; 
            display: block; 
            margin-bottom: 20px;
            text-decoration: none;
        }
        .sidebar-nav .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            display: flex; 
            align-items: center;
            font-weight: 500;
            transition: 0.3s;
        }
        .sidebar-nav .nav-link i { 
            margin-right: 15px; 
            width: 20px; 
            text-align: center; 
        }
        .sidebar-nav .nav-link:hover {
            color: #fff;
            background-color: #374151; /* [DIUBAH] Warna hover lebih halus */
            border-radius: 8px;
        }
        .sidebar-nav .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
            border-radius: 8px;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .navbar-admin {
            background: #fff; 
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 20px; 
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar shadow">
        <a href="<?= base_url('admin') ?>" class="sidebar-brand">ADMIN BWS SUMATERA V</a>
        
        <ul class="nav flex-column sidebar-nav px-3">
            <li class="nav-item">
                <a class="nav-link <?= (uri_string() == 'admin' || uri_string() == 'admin/') ? 'active' : '' ?>" href="<?= base_url('admin') ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos(uri_string(), 'admin/lowongan') !== false) ? 'active' : '' ?>" href="<?= base_url('admin/lowongan') ?>">
                    <i class="fas fa-briefcase"></i> Kelola Lowongan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (strpos(uri_string(), 'admin/pendaftar') !== false) ? 'active' : '' ?>" href="<?= base_url('admin/pendaftar') ?>">
                    <i class="fas fa-users"></i> Data Pendaftar
                </a>
            </li>
            <hr class="text-secondary">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/') ?>" target="_blank">
                    <i class="fas fa-home"></i> Lihat Website
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <nav class="navbar-admin d-flex justify-content-between">
            <h4 class="h5 mb-0 fw-bold"><?= $title; ?></h4>
            <span class="text-muted">Selamat Datang, <?= session()->get('user_nama'); ?>!</span>
        </nav>

        <div class="content-wrapper">
            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>