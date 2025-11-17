<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="card border-0 rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4">
        <h5 class="mb-0 fw-bold"><i class="fas fa-pen me-2 text-warning"></i> Edit Pengguna Admin: <?= esc($admin['nama']) ?></h5>
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
        <?php if (session()->getFlashdata('pesan_error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i>
                <?= session()->getFlashdata('pesan_error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/users/update') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= esc($admin['id']) ?>">
            
            <div class="mb-3">
                <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $admin['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $admin['email']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="role" class="form-label fw-bold">Role Pengguna</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin" <?= ($admin['role'] == 'admin') ? 'selected' : '' ?>>Admin Biasa</option>
                    <option value="superadmin" <?= ($admin['role'] == 'superadmin') ? 'selected' : '' ?>>Super Admin</option>
                </select>
                <div class="form-text">Perubahan Role hanya bisa dilakukan oleh Super Admin.</div>
            </div>

            <hr class="my-4">
            <h6 class="fw-bold text-danger">Ubah Password (Kosongkan jika tidak ingin diubah)</h6>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-bold">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="form-text">Minimal 6 karakter.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="confpassword" class="form-label fw-bold">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="confpassword" name="confpassword">
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
            </div>

        </form>

    </div>
</div>

<?= $this->endSection(); ?>