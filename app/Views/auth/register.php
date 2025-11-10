<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-soft border-0 rounded-4 my-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Buat Akun Baru</h3>
                        <p class="text-muted">Mulai perjalanan magang Anda di BWS V</p>
                    </div>

                    <?php $errors = session()->get('errors'); ?>
                    <?php if($errors): ?>
                        <div class="alert alert-danger p-3 small" role="alert">
                            <h6 class="alert-heading fw-bold">Gagal Mendaftar</h6>
                            <ul class="mb-0">
                                <?php foreach ($errors as $err): ?>
                                    <li><?= esc($err) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register/proses') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= old('nama') ?>" required>
                            <label for="nama">Nama Lengkap</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= old('email') ?>" required>
                            <label for="email">Alamat Email</label>
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                    <label for="password">Kata Sandi</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="confpassword" name="confpassword" placeholder="Ulangi Password" required>
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

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">DAFTAR SEKARANG</button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted small">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-primary text-decoration-none fw-bold">Masuk disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>