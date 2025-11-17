<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<?php if (session()->getFlashdata('pesan_sukses')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('pesan_sukses'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-list-alt me-2"></i> Data Lowongan Magang</h5>
        
        <a href="<?= base_url('admin/lowongan/tambah') ?>" class="btn btn-primary btn-sm rounded-pill fw-bold px-3">
            <i class="fas fa-plus me-1"></i> Tambah Lowongan Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 25%;">Posisi</th>
                        <th scope="col" style="width: 25%;">Unit Penempatan</th>
                        <th scope="col" style="width: 10%;">Kuota</th>
                        <th scope="col" style="width: 10%;">Status</th>
                        <th scope="col" style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lowongan)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> Belum ada data. Silakan tambah lowongan baru.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; ?>
                        <?php foreach ($lowongan as $job) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= esc($job->posisi); ?></td>
                                <td><?= esc($job->unit); ?></td>
                                <td><?= esc($job->kebutuhan); ?></td>
                                <td>
                                    <?php
                                        // PERBAIKAN: Menggunakan strtolower() untuk membuat perbandingan case-insensitive
                                        $status = strtolower($job->status);
                                        $badge_color = 'bg-danger'; // Default untuk 'Tutup'

                                        if ($status == 'dibuka') {
                                            $badge_color = 'bg-success';
                                        } elseif ($status == 'penuh') {
                                            $badge_color = 'bg-warning text-dark';
                                        }
                                    ?>
                                    <span class="badge <?= $badge_color; ?>"><?= esc($job->status); ?></span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/lowongan/edit/' . $job->id) ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-pen"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/lowongan/hapus/' . $job->id) ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data lowongan: <?= esc($job->posisi) ?>?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
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