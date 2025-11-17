<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="card shadow-sm border-0">
    <!-- 
    PERBAIKAN: Menggunakan $lowongan->posisi (object) bukan $lowongan['posisi'] (array)
    -->
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-pen me-2"></i>Edit Lowongan: <?= esc($lowongan->posisi); ?></h5>
    </div>
    <div class="card-body p-4">
        
        <form action="<?= base_url('admin/lowongan/update') ?>" method="post">
            <?= csrf_field(); ?>
            
            <!-- PERBAIKAN: $lowongan->id -->
            <input type="hidden" name="id" value="<?= $lowongan->id; ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Posisi Magang</label>
                    <!-- PERBAIKAN: $lowongan->posisi -->
                    <input type="text" class="form-control" name="posisi" value="<?= esc($lowongan->posisi); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Unit Kerja / Penempatan</label>
                    <!-- PERBAIKAN: $lowongan->unit -->
                    <input type="text" class="form-control" name="unit" value="<?= esc($lowongan->unit); ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kuota Kebutuhan</label>
                    <!-- PERBAIKAN: $lowongan->kebutuhan -->
                    <input type="number" class="form-control" name="kebutuhan" value="<?= esc($lowongan->kebutuhan); ?>" min="1" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status Lowongan</label>
                    <select class="form-select" name="status">
                        <!-- PERBAIKAN: $lowongan->status -->
                        <option value="Dibuka" <?= ($lowongan->status == 'Dibuka') ? 'selected' : ''; ?>>Dibuka</option>
                        <option value="Tutup" <?= ($lowongan->status == 'Tutup') ? 'selected' : ''; ?>>Tutup</option>
                        <option value="Penuh" <?= ($lowongan->status == 'Penuh') ? 'selected' : ''; ?>>Penuh</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Deskripsi Pekerjaan</label>
                <!-- PERBAIKAN: $lowongan->deskripsi -->
                <textarea class="form-control" name="deskripsi" rows="4" required><?= esc($lowongan->deskripsi); ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
                <a href="<?= base_url('admin/lowongan') ?>" class="btn btn-secondary px-4">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>