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
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users me-2"></i> Data Pendaftar Magang</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Pendaftar</th>
                        <th>Email</th>
                        <th>Posisi Dilamar</th>
                        <th>Tgl. Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendaftar)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pendaftar.</td></tr>
                    <?php else: ?>
                        <?php $i = 1; ?>
                        <?php foreach ($pendaftar as $lamaran) : ?>
                            <tr>
                                <th><?= $i++; ?></th>
                                <td><?= esc($lamaran['nama']); ?></td>
                                <td><?= esc($lamaran['email']); ?></td>
                                <td class="fw-bold"><?= esc($lamaran['posisi']); ?></td>
                                <td><?= date('d M Y', strtotime($lamaran['tanggal_melamar'])); ?></td>
                                <td>
                                    <?php 
                                        $status = $lamaran['status_lamaran'];
                                        $badge_color = 'bg-warning text-dark'; // Pending
                                        if ($status == 'Diterima') $badge_color = 'bg-success';
                                        if ($status == 'Ditolak') $badge_color = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge_color; ?>"><?= esc($status); ?></span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/pendaftar/update/' . $lamaran['id_lamaran'] . '/Diterima') ?>" 
                                       class="btn btn-success btn-sm" title="Terima Lamaran" 
                                       onclick="return confirm('Anda yakin ingin MENERIMA lamaran ini?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pendaftar/update/' . $lamaran['id_lamaran'] . '/Ditolak') ?>" 
                                       class="btn btn-danger btn-sm" title="Tolak Lamaran"
                                       onclick="return confirm('Anda yakin ingin MENOLAK lamaran ini?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pendaftar/detail/' . $lamaran['id_lamaran']) ?>" 
                                       class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
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