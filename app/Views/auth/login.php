<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Silakan Masuk</h3>
                        <p class="text-muted">Portal Magang BWS V</p>
                    </div>

                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                            <label for="email">Alamat Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" placeholder="Password" required>
                            <label for="password">Kata Sandi</label>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small">Lupa sandi?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">MASUK</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Belum punya akun? <a href="<?= base_url('register') ?>" class="text-primary text-decoration-none fw-bold">Daftar disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>