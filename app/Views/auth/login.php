<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<style>
    /* CSS Khusus Halaman Login agar lebih premium */
    body {
        background-color: #f0f2f5; /* Background halaman lebih netral */
    }
    .login-container {
        min-height: 85vh; /* Sedikit lebih tinggi agar posisi vertikal lebih pas */
    }
    .login-card {
        border: none;
        border-radius: 20px; /* Sudut lebih bulat */
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08); /* Bayangan lembut tapi dalam */
        overflow: hidden;
    }
    .login-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); /* Gradient biru profesional */
        padding: 30px 20px;
        text-align: center;
        color: white;
    }
    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .nav-pills .nav-link.active {
        background-color: #0d6efd; /* Biru untuk tab aktif */
        color: white;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
    /* Khusus tab admin warnanya beda sedikit agar jelas */
    .nav-pills .nav-link#pills-admin-tab.active {
        background-color: #dc3545; /* Merah untuk admin */
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
    .form-control {
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }
    .form-control:focus {
        background-color: #fff;
        box-shadow: none;
        border-color: #0d6efd;
    }
    .btn-login {
        padding: 12px;
        border-radius: 10px;
        font-weight: 700;
        letter-spacing: 1px;
    }
</style>

<div class="container login-container d-flex align-items-center justify-content-center">
    <div class="col-md-5 col-lg-4">
        
        <div class="card login-card">
            <div class="login-header">
                <h4 class="fw-bold mb-1">Selamat Datang</h4>
                <p class="mb-0 opacity-75 small">Portal Sistem Informasi Magang</p>
            </div>

            <div class="card-body p-4 p-md-5">

                <?php if(session()->getFlashdata('pesan_error')): ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4 fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('pesan_error') ?>
                    </div>
                <?php endif; ?>

                <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist" style="background: #f8f9fa; padding: 5px; border-radius: 12px;">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-peserta-tab" data-bs-toggle="pill" data-bs-target="#pills-peserta" type="button" role="tab" aria-selected="true">
                            <i class="fas fa-user-graduate me-2"></i>Peserta
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-admin-tab" data-bs-toggle="pill" data-bs-target="#pills-admin" type="button" role="tab" aria-selected="false">
                            <i class="fas fa-user-shield me-2"></i>Admin
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    
                    <div class="tab-pane fade show active" id="pills-peserta" role="tabpanel">
                        <form action="<?= base_url('login/proses') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="email" class="form-label small text-muted fw-bold ms-1">Email Peserta</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted ps-3"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-2" id="email" name="email" placeholder="contoh@email.com" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label small text-muted fw-bold ms-1">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted ps-3"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-2" id="password" name="password" placeholder="••••••••" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-login shadow-sm">
                                MASUK SEKARANG
                            </button>
                        </form>
                        <div class="text-center mt-4 pt-3 border-top">
                            <span class="text-muted small">Belum memiliki akun?</span>
                            <a href="<?= base_url('register') ?>" class="fw-bold text-primary text-decoration-none ms-1">Daftar Magang</a>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-admin" role="tabpanel">
                        <div class="alert alert-warning small border-0 bg-warning bg-opacity-10 text-warning mb-4">
                            <i class="fas fa-info-circle me-2"></i>Area khusus pegawai/administrator BWS V.
                        </div>
                        <form action="<?= base_url('login/proses') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold ms-1">Email Admin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted ps-3"><i class="fas fa-user-shield"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-2" name="email" placeholder="admin@bws.go.id" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label small text-muted fw-bold ms-1">Kata Sandi Admin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted ps-3"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control border-start-0 ps-2" name="password" placeholder="••••••••" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger w-100 btn-login shadow-sm">
                                LOGIN ADMIN
                            </button>
                        </form>
                    </div>

                </div> </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>