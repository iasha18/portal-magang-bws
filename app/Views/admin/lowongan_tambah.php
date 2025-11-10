<?= $this->extend('layout/admin_template'); ?>

<?= $this->section('content'); ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-plus-circle me-2"></i>Tambah Lowongan Baru</h5>
    </div>
    <div class="card-body p-4">
        
        <form action="<?= base_url('admin/lowongan/simpan') ?>" method="post">
            <?= csrf_field(); ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Posisi Magang</label>
                    <input type="text" class="form-control" name="posisi" placeholder="Contoh: IT Support" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Unit Kerja / Penempatan</label>
                    <input type="text" class="form-control" name="unit" placeholder="Contoh: Subbag Umum & Tata Usaha" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kuota Kebutuhan</label>
                    <input type="number" class="form-control" name="kebutuhan" placeholder="0" min="1" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status Lowongan</label>
                    <select class="form-select" name="status">
                        <option value="Dibuka">Dibuka</option>
                        <option value="Tutup">Tutup</option>
                        <option value="Penuh">Penuh</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Deskripsi Pekerjaan</label>
                <textarea class="form-control" name="deskripsi" rows="4" placeholder="Jelaskan tugas dan tanggung jawab singkat..." required></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
                <a href="<?= base_url('admin/lowongan') ?>" class="btn btn-secondary px-4">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection(); ?>