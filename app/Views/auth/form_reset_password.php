<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-soft border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Buat Password Baru</h3>
                        <p class="text-muted">Masukkan kata sandi Anda yang baru.</p>
                    </div>

                    <?php if (session()->get('pesan_error')): ?>
                        <div class="alert alert-danger"><?= session()->get('pesan_error') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('reset-password/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="token" value="<?= esc($token) ?>"> 
                        
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password Baru" required>
                            <label for="password">Password Baru</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="confpassword" name="confpassword" placeholder="Konfirmasi Password" required>
                            <label for="confpassword">Konfirmasi Password Baru</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill">SIMPAN PASSWORD BARU</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>