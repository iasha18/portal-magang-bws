<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-11"> <div class="card shadow-soft border-0 rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-5 bg-primary text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                    <h2 class="fw-bold">Halo, <?= session()->get('user_nama'); ?>! 👋</h2>
                    <p class="lead mb-0 opacity-75">Selamat datang di Dashboard Peserta Magang BWS SUMATERA V.</p>
                </div>
            </div>

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

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="fw-bold mb-0"><i class="fas fa-file-alt me-2 text-info"></i>Daftar Lamaran Saya</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($daftar_lamaran)): ?>
                                <div class="text-center p-5">
                                    <p class="text-muted mb-3">Anda belum mengirimkan lamaran magang apapun.</p>
                                    <a href="<?= base_url('/#lowongan') ?>" class="btn btn-outline-primary rounded-pill fw-bold px-4">
                                        Cari Lowongan Sekarang
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-3">Posisi Dilamar</th>
                                                <th>Unit Kerja</th>
                                                <th>Tanggal Melamar</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($daftar_lamaran as $lamaran): ?>
                                                <tr>
                                                    <td class="p-3 fw-bold"><?= esc($lamaran->posisi); ?></td>
                                                    <td><?= esc($lamaran->unit); ?></td>
                                                    <td><?= date('d M Y, H:i', strtotime($lamaran->tanggal_melamar)); ?></td>
                                                    <td>
                                                        <?php 
                                                            $status = $lamaran->status_lamaran; // Diubah
                                                            $badge_color = 'bg-warning text-dark'; // Default (Pending)
                                                            if ($status == 'Diterima') {
                                                                $badge_color = 'bg-success';
                                                            } elseif ($status == 'Ditolak') {
                                                                $badge_color = 'bg-danger';
                                                            }
                                                        ?>
                                                        <span class="badge <?= $badge_color; ?>"><?= esc($status); ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-white border-0 p-4">
                            <h5 class="fw-bold mb-0"><i class="fas fa-user-circle me-2 text-warning"></i>Profil Saya</h5>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <p class="text-muted small">
                                <?php if (empty($biodata) || empty($biodata['nim'])): ?>
                                    Profil Anda belum lengkap. Silakan lengkapi biodata dan upload dokumen.
                                <?php else: ?>
                                    <span class="text-success fw-bold"><i class="fas fa-check-circle"></i> Profil Anda sudah lengkap!</span>
                                <?php endif; ?>
                            </p>
                            <div class="mt-auto">
                                <a href="<?= base_url('peserta/profil') ?>" class="btn btn-warning rounded-pill fw-bold px-4 w-100">
                                    <i class="fas fa-pen me-1"></i> 
                                    <?= (empty($biodata) || empty($biodata['nim'])) ? 'Lengkapi Profil' : 'Edit Profil'; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div> </div>
    </div>
</div>
<?= $this->endSection(); ?>