<?php helper('text'); // Dibutuhkan untuk fungsi word_limiter() ?>

<div class="row g-4">
    <?php if (empty($lowongan)): ?>
        <div class="col-12">
            <div class="alert alert-light text-center py-5 shadow-soft border-0 rounded-4">
                <i class="fas fa-info-circle fa-2x mb-3 text-primary opacity-50"></i>
                <h5>Belum ada lowongan dibuka saat ini</h5>
                <p class="text-muted mb-0">Silakan kembali lagi nanti untuk melihat kesempatan terbaru.</p>
            </div>
        </div>
    <?php else: ?>

        <?php 
        /*
         * Looping untuk setiap lowongan.
         * PENTING: $job adalah OBJECT, jadi kita gunakan $job->nama_kolom
         */
        ?>
        <?php foreach ($lowongan as $job): ?>
            <?php $modal_id = 'modalDetail' . $job->id; ?>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-soft border-0 rounded-4 overflow-hidden hover-lift">
                    <div class="card-body p-4 d-flex flex-column">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="badge rounded-pill px-3 py-2 bg-success-subtle text-success fw-bold d-flex align-items-center">
                                <i class="fas fa-circle me-2" style="font-size: 8px;"></i> <?= esc($job->status) ?>
                            </span>
                        </div>
                        
                        <a href="#" data-bs-toggle="modal" data-bs-target="#<?= $modal_id ?>" class="text-decoration-none">
                            <h4 class="card-title fw-bold text-dark mb-2 hover-text-primary"><?= esc($job->posisi); ?></h4>
                        </a>

                        <p class="text-primary fw-medium mb-3">
                            <i class="far fa-building me-2"></i><?= esc($job->unit); ?>
                        </p>

                        <p class="text-muted mb-4 flex-grow-1">
                            <?= esc(word_limiter($job->deskripsi, 15)); ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <div class="text-muted small fw-bold">
                                <i class="fas fa-users me-2 text-primary opacity-50"></i>Kuota: <?= esc($job->kebutuhan) ?>
                            </div>

                            <a href="<?= base_url('peserta/apply/' . $job->id) ?>"
                               class="btn btn-primary rounded-pill px-4 fw-bold"
                               onclick="return confirm('Anda yakin ingin melamar di posisi <?= esc($job->posisi) ?>?')">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content rounded-4">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold text-dark">Detail Posisi: <?= esc($job->posisi); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body p-4">
                            <h6 class="fw-bold text-primary">Unit Kerja:</h6>
                            <p><?= esc($job->unit); ?></p>

                            <h6 class="fw-bold text-primary mt-4">Kuota Tersedia:</h6>
                            <p><?= esc($job->kebutuhan); ?> orang</p>

                            <h6 class="fw-bold text-primary mt-4">Deskripsi Lengkap:</h6>
                            <div class="p-3 bg-light rounded-3">
                                <p class="text-dark mb-0" style="white-space: pre-wrap;"><?= nl2br(esc($job->deskripsi)); ?></p>
                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                            <a href="<?= base_url('peserta/apply/' . $job->id) ?>"
                               class="btn btn-primary rounded-pill fw-bold px-4"
                               onclick="return confirm('Anda yakin ingin melamar di posisi <?= esc($job->posisi) ?>?')">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>

<nav class="mt-5 d-flex justify-content-center">
    <?php if ($pager) : ?>
        <?= $pager->links('lowongan', 'custom_bootstrap') ?>
    <?php endif; ?>
</nav>
