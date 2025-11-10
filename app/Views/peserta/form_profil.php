<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-soft border-0 rounded-4 mb-4">
                <div class="card-header bg-white p-4">
                    <h4 class="fw-bold text-primary mb-0"><i class="fas fa-user-edit me-2"></i>Lengkapi Profil & Biodata</h4>
                </div>

                <form action="<?= base_url('peserta/profil/update') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="card-body p-4">
                        
                        <?php if (session()->getFlashdata('pesan_sukses')): ?>
                            <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('pesan_sukses'); ?></div>
                        <?php endif; ?>
                        <?php $errors = session()->get('errors'); ?>
                        <?php if($errors): ?>
                            <div class="alert alert-danger p-3 small">
                                <h6 class="alert-heading fw-bold">Gagal menyimpan!</h6>
                                <ul class="mb-0">
                                    <?php foreach ($errors as $err): ?> <li><?= esc($err) ?></li> <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <h6 class="fw-bold text-muted mb-3">Data Akademik</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                                <input type="text" class="form-control" name="nim" value="<?= old('nim', $biodata['nim'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Perguruan Tinggi / Sekolah</label>
                                <input type="text" class="form-control" name="perguruan_tinggi" value="<?= old('perguruan_tinggi', $biodata['perguruan_tinggi'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jurusan / Program Studi</label>
                                <input type="text" class="form-control" name="jurusan" value="<?= old('jurusan', $biodata['jurusan'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Semester (Saat Ini)</label>
                                <input type="number" class="form-control" name="semester" value="<?= old('semester', $biodata['semester'] ?? '') ?>" min="1" max="14" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold text-muted mb-3">Data Pribadi</h6>
                        <div class="row g-3">
                             <div class="col-md-6">
                                <label class="form-label">Nama Lengkap (Sesuai KTP)</label>
                                <input type="text" class="form-control" value="<?= session()->get('user_nama'); ?>" disabled readonly>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label">Nomor HP/WhatsApp (Aktif)</label>
                                <input type="text" class="form-control" name="no_hp" value="<?= old('no_hp', $biodata['no_hp'] ?? '') ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap (Domisili)</label>
                                <textarea class="form-control" name="alamat" rows="3" required><?= old('alamat', $biodata['alamat'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold text-muted mb-3">Upload Dokumen (Opsional)</h6>
                        <p class="small text-muted">Format file yang diizinkan: PDF. Maksimal 2MB.</p>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">File CV (.pdf)</label>
                                <input type="file" class="form-control" name="file_cv" accept=".pdf">
                                
                                <?php if (!empty($biodata) && !empty($biodata['file_cv'])): ?>
                                    <small class="text-success"><i class="fas fa-check"></i> File CV sudah terupload.</small>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Surat Pengantar Kampus (.pdf)</label>
                                <input type="file" class="form-control" name="file_surat" accept=".pdf">
                                
                                <?php if (!empty($biodata) && !empty($biodata['file_surat_pengantar'])): ?>
                                    <small class="text-success"><i class="fas fa-check"></i> Surat Pengantar sudah terupload.</small>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer bg-white p-4 d-flex justify-content-between">
                        <a href="<?= base_url('peserta') ?>" class="btn btn-secondary rounded-pill px-4">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>