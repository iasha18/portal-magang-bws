<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-soft border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Lupa Password?</h3>
                        <p class="text-muted">Masukkan email Anda. Kami akan mengirimkan link untuk mereset password Anda.</p>
                    </div>

                    <?php if (session()->getFlashdata('pesan_sukses')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('pesan_sukses') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('pesan_error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('pesan_error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('lupa-password/kirim') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email terdaftar" required>
                            <label for="email">Email Terdaftar</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">KIRIM LINK RESET</button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <a href="<?= base_url('login') ?>" class="text-decoration-none small text-muted">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>