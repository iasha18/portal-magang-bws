<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('pesan_sukses')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('pesan_sukses'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('pesan_error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-times-circle me-2"></i>
        <?= session()->getFlashdata('pesan_error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-user-shield me-2" style="color: var(--nude-primary);"></i> Kelola Pengguna Admin</h5>
        
<a href="<?= base_url('admin/users/tambah') ?>" 
   class="btn rounded-pill fw-bold px-4 text-white"
   style="background-color:#0000FF; border:none;">
    <i class="fas fa-plus me-1"></i> Tambah Admin Baru
</a>

    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle" style="border-spacing: 0 10px !important;">
                <thead class="table-light">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Nama Lengkap</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Role</th>
                        <th class="p-3">Tanggal Bergabung</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admins)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> Belum ada data admin.
                            </td>
                        </tr>
                    <?php else: ?> <?php $i = 1; ?>
                        <?php foreach ($admins as $admin) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td class="fw-bold"><?= esc($admin['nama']); ?></td>
                                <td><?= esc($admin['email']); ?></td>
                                <td>
                                    <span class="badge bg-<?= ($admin['role'] == 'superadmin') ? 'danger' : 'success'; ?> px-3">
                                        <?= esc(ucwords($admin['role'])); ?>
                                    </span>
                                </td>
                                <td><?= date('d M Y', strtotime($admin['created_at'])); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="<?= base_url('admin/users/edit/' . $admin['id']) ?>" class="btn btn-warning btn-aksi" title="Edit">
                                            <i class="fas fa-pen text-white"></i>
                                        </a>
                                        
                                        <!-- Tombol Hapus (Nonaktifkan untuk Superadmin ID 1) -->
                                        <?php if ($admin['id'] != 1): ?>
                                            <a href="<?= base_url('admin/users/hapus/' . $admin['id']) ?>" class="btn btn-danger btn-aksi" title="Hapus" 
                                               onclick="return confirm('PERINGATAN! Anda akan menghapus admin <?= esc($admin['nama']) ?>. Lanjutkan?')">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-aksi disabled" title="Superadmin utama tidak dapat dihapus">
                                                <i class="fas fa-trash text-white"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>