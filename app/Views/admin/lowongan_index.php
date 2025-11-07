<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Lowongan Magang</h5>
        <a href="#" class="btn btn-primary btn-sm rounded-pill">
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
                    <?php $i = 1; ?>
                    <?php foreach ($lowongan as $job) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $job['posisi']; ?></td>
                            <td><?= $job['unit']; ?></td>
                            <td><?= $job['kebutuhan']; ?></td>
                            <td>
                                <?php if ($job['status'] == 'Dibuka') : ?>
                                    <span class="badge bg-success">Dibuka</span>
                                <?php else : ?>
                                    <span class="badge bg-danger">Penuh</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>