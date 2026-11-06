<div class="container-fluid py-4 px-3 px-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Catatan Pengeluaran</h4>
        <button type="button" class="btn btn-primary-custom rounded-pill px-3 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPengeluaran">
            <i class="fas fa-plus me-1"></i> Tambah
        </button>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <?php if (empty($expenses)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-receipt text-muted fs-3 mb-3"></i>
                    <p class="text-muted mb-0">Belum ada pengeluaran yang dicatat.</p>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush rounded-4">
                    <?php foreach ($expenses as $e): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-3 border-light">
                            <div>
                                <span class="fw-bold text-dark d-block mb-1"><?= $e['category']; ?></span>
                                <span class="text-muted small"><?= $e['description']; ?></span>
                                <div class="text-muted small mt-1">
                                    <i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($e['expense_date'])); ?>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold text-danger mb-0">- Rp<?= number_format($e['amount'], 0, ',', '.'); ?></h6>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Tambah Pengeluaran -->
<div class="modal fade" id="modalTambahPengeluaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Pengeluaran</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/tambah-pengeluaran'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <input type="text" name="category" class="form-control form-control-lg" placeholder="Contoh: Beli Minyak Goreng" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah (Rp)</label>
                        <input type="number" name="amount" class="form-control form-control-lg" placeholder="Contoh: 150000" min="500" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="expense_date" class="form-control form-control-lg" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Catatan <span class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4 fw-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>