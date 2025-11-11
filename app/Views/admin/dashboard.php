<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-primary border-4 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class_("text-muted small text-uppercase fw-bold">Total Lowongan</div>
                        <h3 class="fw-bold mb-0"><?= $total_lowongan; ?></h3>
                    </div>
                    <i class="fas fa-briefcase fa-3x text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-success border-4 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class_("text-muted small text-uppercase fw-bold">Lamaran Masuk</div>
                        <h3 class="fw-bold mb-0"><?= $total_lamaran; ?></h3>
                    </div>
                    <i class="fas fa-file-invoice fa-3x text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-warning border-4 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class_("text-muted small text-uppercase fw-bold">Lamaran Pending</div>
                        <h3 class="fw-bold mb-0"><?= $total_pending; ?></h3>
                    </div>
                    <i class="fas fa-clock fa-3x text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0 border-start border-info border-4 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class_("text-muted small text-uppercase fw-bold">Total Peserta</div>
                        <h3 class="fw-bold mb-0"><?= $total_peserta; ?></h3>
                    </div>
                    <i class="fas fa-users fa-3x text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-user-clock me-2"></i> Pendaftar Terbaru</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Pendaftar</th>
                        <th>Posisi Dilamar</th>
                        <th>Waktu Mendaftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendaftar_terbaru)): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Belum ada data pendaftar.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pendaftar_terbaru as $pendaftar): ?>
                            <tr>
                                <td class="fw-bold"><?= esc($pendaftar['nama']); ?></td>
                                <td><?= esc($pendaftar['posisi']); ?></td>
                                <td><?= date('d M Y, H:i', strtotime($pendaftar['tanggal_melamar'])); ?> WIB</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white text-center">
        <a href="<?= base_url('admin/pendaftar') ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            Lihat Semua Pendaftar <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
</div>

<?= $this->endSection(); ?>