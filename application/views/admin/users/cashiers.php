<div class="container-fluid py-4 px-3 px-md-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kelola Akun Kasir</h4>
        <button type="button" class="btn btn-primary-custom rounded-pill px-3 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKasir">
            <i class="fas fa-plus me-1"></i> Tambah
        </button>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="list-group list-group-flush rounded-4">
                <?php foreach ($cashiers as $k): ?>
                    <div class="list-group-item p-3 border-light d-flex justify-content-between align-items-center <?= $k['status'] == 'inactive' ? 'bg-light' : ''; ?>">
                        <div class="d-flex align-items-center">
                            <div class="bg-<?= $k['status'] == 'active' ? 'success' : 'secondary'; ?> bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                                <i class="fas fa-user text-<?= $k['status'] == 'active' ? 'success' : 'secondary'; ?> fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 <?= $k['status'] == 'inactive' ? 'text-muted text-decoration-line-through' : ''; ?>"><?= $k['name']; ?></h6>
                                <div class="text-muted small">
                                    <i class="fas fa-id-card me-1"></i> <?= $k['username']; ?> 
                                    <span class="mx-1">•</span> 
                                    <i class="fab fa-whatsapp me-1"></i> <?= $k['phone'] ?: '-'; ?>
                                </div>
                            </div>
                            <div class="text-primary mt-1" style="font-size: 0.8rem;">
                                        <i class="fas fa-map-marker-alt me-1"></i> 
                                        <?= !empty($k['stand_location']) ? $k['stand_location'] : 'Lokasi belum diatur'; ?>
                            </div>
                        </div>
                        
                        <!-- Tombol Toggle Status -->
                        <a href="<?= base_url('admin/kasir/toggle/' . $k['id']); ?>" 
                           class="btn btn-sm <?= $k['status'] == 'active' ? 'btn-outline-danger' : 'btn-outline-success'; ?> rounded-pill px-3"
                           onclick="return confirm('<?= $k['status'] == 'active' ? 'Nonaktifkan' : 'Aktifkan'; ?> akun kasir ini?');">
                            <?= $k['status'] == 'active' ? 'Nonaktifkan' : 'Aktifkan'; ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kasir -->
<div class="modal fade" id="modalTambahKasir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Akun Kasir</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/kasir/add'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Siti Aminah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username <span class="text-muted fw-normal">(Untuk Login)</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Contoh: sitikasir" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="text" name="password" class="form-control" placeholder="Minimal 6 karakter" required autocomplete="off">
                        <small class="text-muted mt-1 d-block">Saran: Gunakan kombinasi yang mudah diingat kasir.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Lokasi Stand / Cabang <span class="text-danger">*</span></label>
                        <input type="text" name="stand_location" class="form-control" placeholder="Contoh: Cabang Alun-Alun Selatan" required>
                    </div>
                </div>
                <div class="modalb-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4 fw-bold">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>