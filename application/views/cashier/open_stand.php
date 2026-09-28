<div class="container-fluid py-3 px-3">
    <!-- Top Bar Khusus Halaman Form (Ada tombol Back) -->
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('cashier/dashboard'); ?>" class="text-dark me-3"><i class="fas fa-arrow-left fs-4"></i></a>
        <h4 class="fw-bold mb-0">Bawa Stok</h4>
    </div>

    <p class="text-muted small">Masukkan jumlah risol yang akan Anda bawa ke stand hari ini.</p>

    <form action="<?= base_url('cashier/process-open'); ?>" method="post">
        
        <div class="list-group list-group-flush mb-4 rounded-4 shadow-sm bg-white">
            <?php foreach ($products as $p): ?>
            <div class="list-group-item p-3 border-light">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <span class="fw-bold d-block"><?= $p['name']; ?></span>
                        <span class="badge <?= $p['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $p['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal">
                            <?= $p['is_spicy'] ? '🌶 ' : ''; ?><?= $p['variant']; ?>
                        </span>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block" style="font-size:0.7rem;">Stok Gudang</small>
                        <span class="fw-bold text-primary"><?= $p['stock_frozen']; ?> pcs</span>
                    </div>
                </div>
                
                <!-- Input berukuran besar dan mudah ditekan -->
                <input type="number" name="qty[<?= $p['id']; ?>]" class="form-control form-control-lg bg-light text-center fw-bold" placeholder="0" min="0" max="<?= $p['stock_frozen']; ?>">
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Sticky Button -->
        <div class="fixed-bottom p-3 bg-white border-top shadow-lg">
            <button type="submit" class="btn btn-primary-custom btn-lg rounded-pill fw-bold w-100 fs-5">
                ✓ Buka Stand
            </button>
        </div>
        
    </form>
</div>
<div style="height: 100px;"></div> <!-- Spacer bawah -->