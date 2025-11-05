<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="py-5 bg-white text-center">
    <div class="container py-5">
        <h1 class="display-5 fw-bold text-dark">Selamat Datang Calon Magang</h1>
        <p class="lead text-muted mb-4">Bergabunglah bersama kami di BWS Sumatera V.</p>
        <a href="#alur" class="btn btn-outline-primary btn-lg">Lihat Alur Pendaftaran</a>
    </div>
</section>

<section id="alur" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Alur Pendaftaran Magang</h2>
            <p class="text-muted">Ikuti langkah-langkah mudah berikut untuk bergabung</p>
        </div>
        <div class="row text-center mb-4 d-none d-md-flex step-container">
            <div class="step-line"></div>
            <div class="col"><div class="step-icon">1</div><p class="fw-semibold mt-2">Pendaftaran Akun</p></div>
            <div class="col"><div class="step-icon">2</div><p class="fw-semibold mt-2">Kirim Permohonan</p></div>
            <div class="col"><div class="step-icon">3</div><p class="fw-semibold mt-2">Proses Seleksi</p></div>
            <div class="col"><div class="step-icon">4</div><p class="fw-semibold mt-2">Lengkapi Data</p></div>
            <div class="col"><div class="step-icon">5</div><p class="fw-semibold mt-2">Mulai Magang</p></div>
        </div>
        <div class="row g-4">
            <div class="col-md-4 col-lg"><div class="card card-alu h-100 p-4"><div class="card-body"><h5 class="card-title fw-bold mb-3">Pendaftaran Akun</h5><p class="card-text text-muted">Pemohon membuat akun terlebih dahulu pada portal website Magang BWS V.</p><a href="<?= base_url('register') ?>" class="btn btn-primary w-100 mt-3">DAFTAR SEKARANG</a></div></div></div>
            <div class="col-md-4 col-lg"><div class="card card-alu h-100 p-4"><div class="card-body"><h5 class="card-title fw-bold mb-3">Mengirimkan Form Permohonan</h5><p class="card-text text-muted">Mengirimkan dokumen surat permohonan magang resmi yang telah ditandatangani oleh institusi/kampus Anda.</p></div></div></div>
            <div class="col-md-4 col-lg"><div class="card card-alu h-100 p-4"><div class="card-body"><h5 class="card-title fw-bold mb-3">Proses Permohonan</h5><p class="card-text text-muted">Tim Admin BWS V akan meninjau permohonan Anda. Hasil diterima atau ditolak akan diinfokan melalui dashboard.</p></div></div></div>
            <div class="col-md-4 col-lg"><div class="card card-alu h-100 p-4"><div class="card-body"><h5 class="card-title fw-bold mb-3">Lengkapi Data</h5><p class="card-text text-muted">Jika diterima, pemohon WAJIB melengkapi biodata diri dan dokumen pendukung lainnya secara lengkap.</p></div></div></div>
            <div class="col-md-4 col-lg"><div class="card card-alu h-100 p-4"><div class="card-body"><h5 class="card-title fw-bold mb-3">Mulai Magang</h5><p class="card-text text-muted">Tim admin mempersiapkan data. Anda bisa mulai magang sesuai tanggal yang telah disepakati bersama.</p></div></div></div>
        </div>
    </div>
</section>
<section id="lowongan" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Posisi Magang Tersedia</h2>
        <div class="row g-4">
            <?php if (empty($lowongan)): ?>
                <div class="col-12"><div class="alert alert-info text-center">Belum ada lowongan yang ditampilkan saat ini.</div></div>
            <?php else: ?>
                <?php foreach ($lowongan as $posisi): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-body d-flex flex-column">
                            <span class="badge <?= ($posisi['status'] == 'Dibuka') ? 'bg-success' : 'bg-danger'; ?> position-absolute top-0 end-0 m-3 fs-6"><?= $posisi['status']; ?></span>
                            <h5 class="card-title fw-bold text-primary mb-1"><?= $posisi['posisi']; ?></h5>
                            <p class="card-subtitle mb-3 text-muted small"><i class="fas fa-briefcase me-2"></i><?= $posisi['unit']; ?></p>
                            <p class="card-text small text-muted"><?= $posisi['deskripsi']; ?></p>
                            <div class="mt-auto pt-3">
                                <p class="mb-2 fw-bold small">Kebutuhan: <?= $posisi['kebutuhan']; ?> orang</p>
                                <a href="#" class="btn btn-primary w-100 fw-bold <?= ($posisi['status'] != 'Dibuka') ? 'disabled' : ''; ?>">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<section id="lowongan" class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Posisi Magang Tersedia</h2>
        <div class="row g-4">
            <?php if (empty($lowongan)): ?>
                <div class="col-12"><div class="alert alert-info text-center">Belum ada lowongan yang ditampilkan saat ini.</div></div>
            <?php else: ?>
                <?php foreach ($lowongan as $posisi): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        <div class="card-body d-flex flex-column">
                            <span class="badge <?= ($posisi['status'] == 'Dibuka') ? 'bg-success' : 'bg-danger'; ?> position-absolute top-0 end-0 m-3 fs-6"><?= $posisi['status']; ?></span>
                            <h5 class="card-title fw-bold text-primary mb-1"><?= $posisi['posisi']; ?></h5>
                            <p class="card-subtitle mb-3 text-muted small"><i class="fas fa-briefcase me-2"></i><?= $posisi['unit']; ?></p>
                            <p class="card-text small text-muted"><?= $posisi['deskripsi']; ?></p>
                            <div class="mt-auto pt-3">
                                <p class="mb-2 fw-bold small">Kebutuhan: <?= $posisi['kebutuhan']; ?> orang</p>
                                <a href="#" class="btn btn-primary w-100 fw-bold <?= ($posisi['status'] != 'Dibuka') ? 'disabled' : ''; ?>">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>