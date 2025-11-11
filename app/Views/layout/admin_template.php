<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin BWS V'; ?></title>
    
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- Palet Warna Nude & Minimalis --- */
        :root {
            --nude-primary: #A97C50; /* Warna utama Nude */
            --nude-light: #F9F5F1;  /* Warna highlight */
            --page-bg: #F8F7F5;     /* Warna background halaman */
            --text-dark: #333333;
            --text-light: #777777;
            --border-color: #EAEAEA;
        }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--page-bg);
            color: var(--text-dark);
        }
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: 260px; 
            background-color: #FFFFFF; /* Sidebar PUTIH */
            border-right: 1px solid var(--border-color);
            padding-top: 20px; 
            z-index: 100;
        }
        .sidebar-brand {
            font-size: 1.5rem; 
            font-weight: 700; 
            color: var(--nude-primary);
            text-align: center; 
            display: block; 
            margin-bottom: 20px;
            text-decoration: none;
        }
        .sidebar-nav .nav-link {
            color: var(--text-light);
            padding: 12px 20px;
            display: flex; 
            align-items: center;
            font-weight: 500;
            transition: 0.2s ease-in-out;
            border-radius: 8px;
        }
        .sidebar-nav .nav-link i { 
            margin-right: 15px; 
            width: 20px; 
            text-align: center; 
        }
        .sidebar-nav .nav-link:hover {
            color: var(--nude-primary);
            background-color: var(--nude-light);
        }
        .sidebar-nav .nav-link.active {
            color: var(--nude-primary);
            background-color: var(--nude-light);
            font-weight: 600;
        }
        .main-content {
            margin-left: 260px;
            padding: 2.5rem;
        }
        .navbar-admin {
            background: transparent;
            padding: 0; 
            margin-bottom: 2rem;
        }
        .navbar-admin h4 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .navbar-admin span {
            font-weight: 500;
        }
        
        /* Tampilan Kartu & Tabel */
        .card {
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .card-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }
        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .table thead th {
            border-bottom: 2px solid var(--border-color) !important;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        .table tbody tr {
            background-color: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            border: 1px solid var(--border-color);
        }
        .table tbody td, .table tbody th {
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem;
            vertical-align: middle;
        }
        .table tbody tr td:first-child, .table tbody tr th:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .table tbody tr td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        
        .btn-aksi {
            width: 38px; height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: 0.2s ease-in-out;
        }
    </style>
</head>
<body>

    <div class="sidebar">
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
            
            <?php if (session()->get('user_role') == 'superadmin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                        <i class="fas fa-user-shield"></i> Kelola Admin
                    </a>
                </li>
            <?php endif; ?>

            <hr class="text-secondary opacity-25">
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
        <nav class="navbar-admin d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><?= $title; ?></h4>
            <span class="badge bg-light text-dark rounded-pill py-2 px-3 fw-medium">
                <i class="fas fa-user-circle me-1"></i> <?= session()->get('user_nama'); ?>
            </span>
        </nav>
        <div class="content-wrapper">
             <?php if (session()->getFlashdata('pesan_error')): ?>
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0" role="alert">
                    <i class="fas fa-times-circle me-2"></i>
                    <?= session()->getFlashdata('pesan_error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>