<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-3 my-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Buat Akun Baru</h3>
                        <p class="text-muted">Mulai perjalanan magang Anda di BWS V</p>
                    </div>

                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap" required>
                            <label for="nama">Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                            <label for="email">Alamat Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="kampus" placeholder="Asal Kampus/Sekolah" required>
                            <label for="kampus">Asal Kampus/Sekolah</label>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" placeholder="Password" required>
                                    <label for="password">Kata Sandi</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="confpassword" placeholder="Ulangi Password" required>
                                    <label for="confpassword">Ulangi Sandi</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="" id="terms" required>
                            <label class="form-check-label small text-muted" for="terms">
                                Saya setuju dengan syarat & ketentuan yang berlaku.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">DAFTAR SEKARANG</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-primary text-decoration-none fw-bold">Masuk disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>