<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-id-card me-2"></i>Info Lamaran</h5>
            </div>
            <div class="card-body p-4">
                
                <a href="<?= base_url('admin/pendaftar') ?>" class="btn btn-outline-secondary btn-sm rounded-pill mb-3">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>

                <div class="mb-3">
                    <label class="form-label small text-muted">Nama Pendaftar:</label>
                    <p class="h5 fw-bold"><?= esc($lamaran['nama']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Email:</label>
                    <p><?= esc($lamaran['email']); ?></p>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="form-label small text-muted">Posisi Dilamar:</label>
                    <p class="fw-bold"><?= esc($lamaran['posisi']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Tanggal Melamar:</label>
                    <p><?= date('d F Y, H:i', strtotime($lamaran['tanggal_melamar'])); ?> WIB</p>
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted">Status Saat Ini:</label>
                    <div>
                        <?php 
                            $status = $lamaran['status_lamaran'];
                            $badge_color = 'bg-warning text-dark';
                            if ($status == 'Diterima') $badge_color = 'bg-success';
                            if ($status == 'Ditolak') $badge_color = 'bg-danger';
                        ?>
                        <span class="badge <?= $badge_color; ?> fs-6"><?= esc($status); ?></span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white p-3 d-flex gap-2">
                <a href="<?= base_url('admin/pendaftar/update/' . $lamaran['id'] . '/Diterima') ?>" class="btn btn-success flex-fill" onclick="return confirm('Yakin ingin MENERIMA lamaran ini?')">
                    <i class="fas fa-check me-2"></i>Terima
                </a>
                <a href="<?= base_url('admin/pendaftar/update/' . $lamaran['id'] . '/Ditolak') ?>" class="btn btn-danger flex-fill" onclick="return confirm('Yakin ingin MENOLAK lamaran ini?')">
                    <i class="fas fa-times me-2"></i>Tolak
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-user-check me-2"></i>Biodata & Dokumen</h5>
            </div>
            <div class="card-body p-4">
                
                <?php if (!empty($biodata) && !empty($biodata['nim'])): ?>
                    <h6 class="fw-bold">Biodata Peserta</h6>
                    <table class="table table-sm table-borderless table-striped">
                        <tbody>
                            <tr>
                                <td style="width: 40%;" class="text-muted">NIM</td>
                                <td class="fw-medium">: <?= esc($biodata['nim']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Perguruan Tinggi</td>
                                <td class="fw-medium">: <?= esc($biodata['perguruan_tinggi']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jurusan</td>
                                <td class="fw-medium">: <?= esc($biodata['jurusan']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Semester</td>
                                <td class="fw-medium">: <?= esc($biodata['semester']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. HP / WA</td>
                                <td class="fw-medium">: <?= esc($biodata['no_hp']); ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Alamat</td>
                                <td class="fw-medium">: <?= esc($biodata['alamat']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <hr class="my-4">
                    <h6 class="fw-bold">Dokumen Pendukung</h6>
                    <div class="list-group list-group-flush">
                        <a href="<?= base_url('uploads/cv/' . $biodata['file_cv']) ?>" target="_blank" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= !$biodata['file_cv'] ? 'disabled list-group-item-light text-muted' : '' ?>">
                            <span><i class="fas fa-file-pdf me-2 text-danger"></i> File CV</span>
                            <?php if ($biodata['file_cv']): ?>
                                <i class="fas fa-download text-primary"></i>
                            <?php else: ?>
                                <span class="small">Belum diupload</span>
                            <?php endif; ?>
                        </a>
                        <a href="<?= base_url('uploads/surat/' . $biodata['file_surat_pengantar']) ?>" target="_blank" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= !$biodata['file_surat_pengantar'] ? 'disabled list-group-item-light text-muted' : '' ?>">
                            <span><i class="fas fa-file-pdf me-2 text-danger"></i> Surat Pengantar</span>
                             <?php if ($biodata['file_surat_pengantar']): ?>
                                <i class="fas fa-download text-primary"></i>
                            <?php else: ?>
                                <span class="small">Belum diupload</span>
                            <?php endif; ?>
                        </a>
                    </div>
                
                <?php else: ?>
                    <div class="text-center p-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Data Belum Lengkap</h5>
                        <p class="text-muted mb-0">Peserta ini belum melengkapi biodata atau mengunggah dokumen.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>