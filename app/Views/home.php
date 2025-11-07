<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="hero-section text-center" style="background-image: url('<?= base_url('img/hero-bg.jpg'); ?>');">
    <div class="hero-overlay d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary bg-opacity-10 px-3 py-2 rounded-pill mb-4 fw-medium" style="background-color: rgba(255,255,255,0.9) !important; color: #0d6efd !important;">
                        <i class="fas fa-briefcase me-2"></i> Portal Resmi Magang
                    </span>
                    <h1 class="display-4 fw-bold text-white mb-4" style="line-height: 1.2;">Awali Karir Profesional Anda Bersama Kami</h1>
                    <p class="lead text-white-50 mb-0 px-lg-5">Dapatkan pengalaman nyata membangun infrastruktur negeri di lingkungan kerja yang profesional dan kolaboratif di BWS SUMATERA V.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="alur" class="py-6 bg-white" style="padding-top: 6rem; padding-bottom: 6rem;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6">Alur Pendaftaran</h2>
            <p class="text-muted lead">Tahapan mudah untuk bergabung menjadi bagian dari kami</p>
        </div>

        <div class="row text-center mb-5 d-none d-lg-flex step-container">
            <div class="step-line"></div>
            <div class="col"><div class="step-icon">1</div></div>
            <div class="col"><div class="step-icon">2</div></div>
            <div class="col"><div class="step-icon">3</div></div>
            <div class="col"><div class="step-icon">4</div></div>
            <div class="col"><div class="step-icon">5</div></div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4 col-xl">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-user-plus fa-3x text-primary mb-4"></i>
                        <h5 class="fw-bold mb-3">Buat Akun</h5>
                        <p class="text-muted small">Daftarkan diri Anda untuk mendapatkan akses ke portal magang.</p>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary w-100 mt-3 rounded-pill fw-bold">DAFTAR SEKARANG</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-file-upload fa-3x text-success mb-4"></i>
                        <h5 class="fw-bold mb-3">Kirim Permohonan</h5>
                        <p class="text-muted small">Unggah surat pengantar resmi dari institusi pendidikan Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-clipboard-check fa-3x text-warning mb-4"></i>
                        <h5 class="fw-bold mb-3">Proses Seleksi</h5>
                        <p class="text-muted small">Tim kami akan meninjau berkas Anda. Pantau status di dashboard.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-user-edit fa-3x text-info mb-4"></i>
                        <h5 class="fw-bold mb-3">Lengkapi Data</h5>
                        <p class="text-muted small">Jika diterima, lengkapi biodata diri dan dokumen pendukung lainnya.</p>
                    </div>
                </div>
            </div>
             <div class="col-md-6 col-lg-4 col-xl">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-building fa-3x text-danger mb-4"></i>
                        <h5 class="fw-bold mb-3">Mulai Magang</h5>
                        <p class="text-muted small">Selamat! Anda siap memulai kegiatan magang sesuai jadwal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="lowongan" class="py-6" style="background-color: #f9fafb; padding-top: 6rem; padding-bottom: 6rem;">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-end mb-5">
            <div>
                <h6 class="text-primary fw-bold text-uppercase letter-spacing-1">Kesempatan Karir</h6>
                <h2 class="fw-bold display-6 mb-0">Posisi Tersedia</h2>
            </div>
            <div class="mt-3 mt-md-0">
                <select class="form-select shadow-sm border-0" style="min-width: 200px; cursor: pointer;">
                    <option selected>Semua Departemen</option>
                    <option>Teknik Sipil</option>
                    <option>Teknologi Informasi</option>
                    <option>Administrasi</option>
                </select>
            </div>
        </div>

        <div class="row g-4">
            <?php if (empty($lowongan)): ?>
                <div class="col-12">
                    <div class="alert alert-light text-center py-5 shadow-soft border-0 rounded-4">
                        <i class="fas fa-info-circle fa-2x mb-3 text-primary opacity-50"></i>
                        <h5>Belum ada lowongan dibuka saat ini</h5>
                        <p class="text-muted mb-0">Silakan kembali lagi nanti untuk melihat kesempatan terbaru.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($lowongan as $job): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-soft border-0 rounded-4 overflow-hidden hover-lift">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between mb-4">
                                <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success fw-bold d-flex align-items-center">
                                    <i class="fas fa-circle me-2" style="font-size: 8px;"></i> <?= $job['status']; ?>
                                </span>
                            </div>
                            <h4 class="card-title fw-bold text-dark mb-2"><?= $job['posisi']; ?></h4>
                            <p class="text-primary fw-medium mb-3"><i class="far fa-building me-2"></i><?= $job['unit']; ?></p>
                            <p class="text-muted mb-4 flex-grow-1" style="line-height: 1.6;"><?= $job['deskripsi']; ?></p>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <div class="text-muted small fw-bold">
                                    <i class="fas fa-users me-2 text-primary opacity-50"></i>Kuota: <?= $job['kebutuhan']; ?>
                                </div>
                                <a href="#" class="btn btn-primary rounded-pill px-4 fw-bold">Apply Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>