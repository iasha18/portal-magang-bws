<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="card border-0 rounded-4">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-user-shield me-2" style="color: var(--nude-primary);"></i> Kelola Pengguna Admin</h5>
        
        <a href="#" class="btn btn-primary rounded-pill fw-bold px-4" style="background-color: var(--nude-primary); border: none;">
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
                        <th class="p-3">Tanggal Bergabung</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admins)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> Belum ada data admin.
                            </td>
                        </tr>
                    <?php else: ?> <?php $i = 1; ?>
                        <?php foreach ($admins as $admin) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td class="fw-bold"><?= esc($admin['nama']); ?></td>
                                <td><?= esc($admin['email']); ?></td>
                                <td><?= date('d M Y', strtotime($admin['created_at'])); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-warning btn-aksi" title="Edit">
                                            <i class="fas fa-pen text-white"></i>
                                        </a>
                                        
                                        <?php if ($admin['id'] != 1): ?>
                                            <a href="#" class="btn btn-danger btn-aksi" title="Hapus" onclick="return confirm('Yakin ingin menghapus admin <?= esc($admin['nama']) ?>?')">
                                                <i class="fas fa-trash text-white"></i>
                                            </a>
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