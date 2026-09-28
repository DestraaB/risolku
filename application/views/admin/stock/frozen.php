<div class="container-fluid py-4 px-3 px-md-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Stok Beku</h4>
        <!-- Tombol untuk memunculkan Modal Tambah Stok -->
        <button type="button" class="btn btn-primary-custom rounded-pill px-3 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
            <i class="fas fa-plus me-1"></i> Tambah
        </button>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- List Produk dalam Card -->
    <div class="row g-3">
        <?php 
        $total_stok = 0;
        foreach ($products as $p): 
            $total_stok += $p['stock_frozen'];
        ?>
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1"><?= $p['name']; ?></h6>
                        <span class="badge <?= $p['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $p['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal">
                            <?= $p['is_spicy'] ? '🌶 ' : ''; ?><?= $p['variant']; ?>
                        </span>
                    </div>
                    <div class="text-end">
                        <h4 class="fw-bold mb-0 text-primary"><?= $p['stock_frozen']; ?></h4>
                        <small class="text-muted">pcs</small>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-4 p-3 bg-white rounded-4 shadow-sm d-flex justify-content-between align-items-center">
        <span class="fw-bold text-muted">Total Seluruh Stok:</span>
        <h4 class="fw-bold text-warning-emphasis mb-0"><?= $total_stok; ?> pcs</h4>
    </div>

</div>

<!-- Modal Tambah Stok -->
<div class="modal fade" id="modalTambahStok" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Stok Beku (Produksi)</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('stock/add_frozen'); ?>" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Varian Risol</label>
                        <select class="form-select form-select-lg" name="product_id" required>
                            <option value="" selected disabled>-- Pilih Risol --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id']; ?>">
                                    <?= $p['name']; ?> - <?= $p['variant']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Jumlah (pcs)</label>
                        <input type="number" name="quantity" class="form-control form-control-lg" min="1" placeholder="Contoh: 100" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4 fw-bold">Simpan Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>