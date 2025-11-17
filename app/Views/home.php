<?= $this->extend('layout/template'); ?>

<?php helper('text'); ?>

<?= $this->section('content'); ?>

<!-- HERO SECTION -->
<section class="hero-section text-center" style="background-image: url('<?= base_url('img/hero-bg.jpg'); ?>');">
    <div class="hero-overlay d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <span class="badge bg-white text-primary bg-opacity-10 px-3 py-2 rounded-pill mb-4 fw-medium"
                        style="background-color: rgba(255,255,255,0.9) !important; color: #0d6efd !important;">
                        <i class="fas fa-briefcase me-2"></i> Official Internship Portal
                    </span>
                    <h1 class="display-4 fw-bold text-white mb-4" style="line-height: 1.2;">Your First Step Toward a Brighter Career</h1>
                    <p class="lead text-white-50 mb-0 px-lg-5">
                        Mulai karir profesional Anda dengan pengalaman nyata bersama BWS Sumatera V.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ALUR PENDAFTARAN -->
<section id="alur" class="py-6 bg-white" style="padding-top: 6rem; padding-bottom: 6rem;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6">Alur Pendaftaran</h2>
            <p class="text-muted lead">Tahapan mudah untuk bergabung menjadi bagian dari kami</p>
        </div>

<div class="row row-cols-4 text-center mb-5 d-none d-lg-flex">
    <!-- Wrapper baru dengan posisi relative -->
    <div class="col-12 position-relative alur-magang-wrapper">
        <!-- Garis horizontal (di belakang ikon) -->
        <div class="alur-magang-line"></div>

        <!-- Baris ikon sebenarnya: pakai d-flex agar mudah mengatur posisi -->
        <div class="d-flex justify-content-between align-items-center mx-4">
            <div class="alur-magang-col"><div class="alur-magang-icon">1</div></div>
            <div class="alur-magang-col"><div class="alur-magang-icon">2</div></div>
            <div class="alur-magang-col"><div class="alur-magang-icon">3</div></div>
            <div class="alur-magang-col"><div class="alur-magang-icon">4</div></div>
        </div>
    </div>
</div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-user-check fa-3x text-primary mb-4"></i>
                        <h5 class="fw-bold mb-3">Buat Akun & Lengkapi Data</h5>
                        <p class="text-muted small">Daftarkan diri Anda dan lengkapi biodata serta dokumen awal.</p>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary w-100 mt-3 rounded-pill fw-bold">DAFTAR SEKARANG</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-file-upload fa-3x text-success mb-4"></i>
                        <h5 class="fw-bold mb-3">Kirim Permohonan</h5>
                        <p class="text-muted small">Unggah surat pengantar resmi dari institusi pendidikan Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-clipboard-check fa-3x text-warning mb-4"></i>
                        <h5 class="fw-bold mb-3">Proses Seleksi</h5>
                        <p class="text-muted small">Tim kami akan meninjau berkas Anda. Pantau status di dashboard.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-alu h-100 p-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-building fa-3x text-danger mb-4"></i>
                        <h5 class="fw-bold mb-3">Mulai Magang</h5>
                        <p class="text-muted small">Selamat! Anda siap memulai kegiatan magang.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LOWONGAN -->
<section id="lowongan" class="py-6" style="background-color: #f9fafb; padding-top: 6rem; padding-bottom: 6rem;">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-end mb-5">
            <div>
                <h6 class="text-primary fw-bold text-uppercase letter-spacing-1">Kesempatan Karir</h6>
                <h2 class="fw-bold display-6 mb-0">Posisi Tersedia</h2>
            </div>
        </div>

        <!-- 
        ===========================================================
        MODIFIKASI UTAMA:
        Area ini sekarang menjadi "WADAH" (Container) untuk
        daftar lowongan dan pagination yang di-load via AJAX.
        ===========================================================
        -->
        <div id="lowongan-container">
            <?php
            // Muat daftar lowongan (dan pager) untuk pertama kali
            // Kita passing data $lowongan dan $pager ke partial view
            echo view('_lowongan_list', [
                'lowongan' => $lowongan,
                'pager' => $pager
            ]);
            ?>
        </div>
        <!-- 
        ===========================================================
        AKHIR DARI MODIFIKASI
        ===========================================================
        -->

    </div>
</section>

<?= $this->endSection(); ?>


<!-- 
===========================================================
BAGIAN JAVASCRIPT:
Script dipindahkan ke dalam section 'scripts' agar
lebih rapi dan dimuat setelah layout.
===========================================================
-->
<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Fungsi ini akan menangani klik pada link pagination
        function handlePaginationClick(event) {
            // Dapatkan elemen container utama
            const container = document.getElementById('lowongan-container');
            
            // Cek apakah yang diklik adalah link di dalam .pagination
            const targetLink = event.target.closest('.pagination a');
            
            if (targetLink) {
                // 1. Mencegah halaman berpindah (reload)
                event.preventDefault();
                
                const url = targetLink.getAttribute('href');
                
                // [PERUBAHAN 1: KUNCI TINGGI]
                // Kunci tinggi container untuk mencegah lompatan
                const currentHeight = container.offsetHeight;
                container.style.minHeight = currentHeight + 'px';
                
                // [PERUBAHAN 2: Mulai Fade-out]
                // Tambahkan class .fading (opacity: 0)
                container.classList.add('fading');
                
                // [PERUBAHAN 3: Tunggu animasi fade-out selesai]
                // (Durasi 300ms ini HARUS SAMA dengan durasi di CSS)
                setTimeout(() => {
                    // Tampilkan "Memuat..."
                    container.innerHTML = '<p class="text-center py-5">Memuat...</p>';

                    // 2. Ambil data dari URL
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) { throw new Error('Network response was not ok'); }
                        return response.text();
                    })
                    .then(html => {
                        // [PERUBAHAN 4: Ganti konten (masih dalam keadaan fade-out)]
                        container.innerHTML = html;

                        // [PERUBAHAN 5: Mulai Fade-in]
                        // Hapus class .fading untuk mengembalikan opacity ke 1
                        container.classList.remove('fading');

                        // Lepaskan kunci tinggi setelah konten dimuat
                        setTimeout(() => {
                             container.style.minHeight = 'auto';
                        }, 50); // Jeda singkat agar DOM update
                    })
                    .catch(err => {
                        console.error('Gagal fetch pagination:', err);
                        container.innerHTML = '<p class="text-center text-danger py-5">Maaf, gagal memuat data.</p>';
                        // Pastikan class fading dihapus & tinggi dilepas jika error
                        container.classList.remove('fading');
                        container.style.minHeight = 'auto';
                    });
                }, 300); // <-- Durasi 300ms (0.3 detik)
            }
        }
        
        // Pasang event listener di #lowongan-container
        const container = document.getElementById('lowongan-container');
        if (container) {
            container.addEventListener('click', handlePaginationClick);
        }

    });
</script>
<?= $this->endSection() ?>  