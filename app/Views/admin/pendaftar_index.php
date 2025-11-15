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

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users me-2"></i> Data Pendaftar Magang</h5>
        
        <form action="<?= base_url('admin/pendaftar') ?>" method="get" class="d-flex" style="max-width: 300px;">
            <input type="text" class="form-control form-control-sm me-2" name="keyword" placeholder="Cari nama, email, posisi..." value="<?= $keyword ?? '' ?>">
            <button type="submit" class="btn btn-primary btn-sm fw-bold">Cari</button>
        </form>
        </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark"> <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Pendaftar</th>
                        <th scope="col">Email</th>
                        <th scope="col">Posisi Dilamar</th>
                        <th scope="col">Tgl. Daftar</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dataPendaftar)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> 
                                <?php if (!empty($keyword)): ?>
                                    Data tidak ditemukan untuk keyword "<?= esc($keyword) ?>".
                                <?php else: ?>
                                    Belum ada data pendaftar.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        /* 3. NOMOR URUT DISESUAIKAN DENGAN PAGINATION */
                        // (10 adalah $perPage yang Anda atur di controller)
                        $nomor = 1 + (10 * ($pager->getCurrentPage('pendaftar') - 1)); 
                        ?>
                        <?php foreach ($dataPendaftar as $lamaran) : ?>
                            <tr>
                                <th scope="row"><?= $nomor++; ?></th>
                                
                                <td><?= esc($lamaran->nama_pendaftar); ?></td>
                                <td><?= esc($lamaran->email); ?></td>
                                <td class="fw-bold"><?= esc($lamaran->posisi); ?></td>
                                <td><?= date('d M Y', strtotime($lamaran->tgl_daftar)); ?></td>
                                <td>
                                    <?php 
                                        $status = $lamaran->status;
                                        $badge_color = 'bg-warning text-dark'; // Default (Pending)
                                        if ($status == 'Diterima') $badge_color = 'bg-success';
                                        if ($status == 'Ditolak') $badge_color = 'bg-danger';
                                    ?>
                                    <span class="badge <?= $badge_color; ?>"><?= esc($status); ?></span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/pendaftar/update/' . $lamaran->id_lamaran . '/Diterima') ?>" 
                                       class="btn btn-success btn-sm" title="Terima Lamaran" 
                                       onclick="return confirm('Anda yakin ingin MENERIMA lamaran ini?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pendaftar/update/' . $lamaran->id_lamaran . '/Ditolak') ?>" 
                                       class="btn btn-danger btn-sm" title="Tolak Lamaran"
                                       onclick="return confirm('Anda yakin ingin MENOLAK lamaran ini?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pendaftar/detail/' . $lamaran->id_lamaran) ?>" 
                                       class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/pendaftar/hapus/' . $lamaran->id_lamaran) ?>" 
                                       class="btn btn-outline-danger btn-sm" title="Hapus Lamaran Permanen"
                                       onclick="return confirm('PERINGATAN! Anda akan menghapus data lamaran ini secara permanen. Ini tidak bisa dibatalkan. Lanjutkan?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            <?php if ($pager) : ?>
                <?= $pager->links('pendaftar', 'custom_bootstrap') ?>
            <?php endif; ?>
        </div>
        
    </div>
</div>

<?= $this->endSection(); ?>
```eof