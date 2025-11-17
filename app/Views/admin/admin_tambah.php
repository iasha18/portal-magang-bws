<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="card border-0 rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4">
        <h5 class="mb-0 fw-bold"><i class="fas fa-user-plus me-2" style="color: var(--nude-primary);"></i> Tambah Pengguna Admin Baru</h5>
    </div>
    <div class="card-body p-4">

        <?php $errors = session()->get('errors'); ?>
        <?php if($errors): ?>
            <div class="alert alert-danger p-3 small" role="alert">
                <h6 class="alert-heading fw-bold">Gagal Menyimpan!</h6>
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Formulir ini mengirim data ke 'admin/users/simpan' -->
        <form action="<?= base_url('admin/users/simpan') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
            </div>
            
            <hr class="my-4">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="form-text">Minimal 6 karakter.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confpassword" class="form-label fw-bold">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="confpassword" name="confpassword" required>
                </div>
            </div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" 
        class="btn rounded-pill fw-bold px-4 text-white"
        style="background-color:#0000FF; border: none;">
        <i class="fas fa-save me-2"></i>Simpan Admin
    </button>

 <a href="<?= base_url('admin/users') ?>" 
       class="btn btn-danger rounded-pill px-4 text-white">
       Batal
    </a>
</div>


        </form>

    </div>
</div>

<?= $this->endSection(); ?>