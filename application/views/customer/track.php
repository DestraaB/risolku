<div class="container-fluid py-4 px-3 mb-5">
    <h5 class="fw-bold mb-4">Lacak Pesanan</h5>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm text-center" role="alert">
            <i class="fas fa-exclamation-circle mb-2 fs-4"></i><br>
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Pencarian -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="<?= base_url('track'); ?>" method="post">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Nomor Pesanan</label>
                    <input type="text" name="order_number" class="form-control form-control-lg" placeholder="Contoh: RSL-202611061234" value="<?= set_value('order_number'); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Nomor WhatsApp</label>
                    <input type="number" name="phone" class="form-control form-control-lg" placeholder="Sesuai saat checkout..." value="<?= set_value('phone'); ?>" required>
                </div>
                <button type="submit" class="btn btn-brand btn-lg rounded-pill fw-bold w-100 shadow-sm mt-2">
                    <i class="fas fa-search me-2"></i> Cek Status Pesanan
                </button>
            </form>
        </div>
    </div>

    <?php if (isset($order) && $order): ?>
        <!-- Hasil Pencarian -->
        <div class="card border-0 shadow-sm rounded-4 border-start border-4 border-warning bg-white mb-5">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h6 class="fw-bold text-muted mb-2">Status Saat Ini:</h6>
                    <?php 
                        $badge_bg = 'bg-secondary';
                        if($order['order_status'] == 'pending') $badge_bg = 'bg-warning text-dark';
                        elseif($order['order_status'] == 'confirmed') $badge_bg = 'bg-info text-dark';
                        elseif($order['order_status'] == 'processing') $badge_bg = 'bg-primary';
                        elseif($order['order_status'] == 'ready') $badge_bg = 'bg-success';
                        elseif($order['order_status'] == 'completed') $badge_bg = 'bg-success bg-opacity-75';
                        elseif($order['order_status'] == 'cancelled') $badge_bg = 'bg-danger';
                    ?>
                    <span class="badge <?= $badge_bg; ?> px-4 py-2 rounded-pill fs-6 shadow-sm">
                        <?= strtoupper($order['order_status']); ?>
                    </span>
                </div>
                
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <small class="text-muted d-block">Pemesan:</small>
                        <span class="fw-bold"><?= $order['name']; ?></span>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted d-block">Metode:</small>
                        <span class="fw-bold"><?= strtoupper($order['pickup_method']); ?></span>
                    </div>
                </div>

                <div class="bg-light p-3 rounded-4 mb-3">
                    <small class="text-muted fw-bold d-block mb-2">Rincian Menu:</small>
                    <?php foreach($items as $item): ?>
                        <div class="d-flex justify-content-between small mb-1">
                            <span><?= $item['quantity']; ?>x <?= $item['name']; ?> (<?= $item['variant']; ?>)</span>
                            <span class="fw-semibold">Rp<?= number_format($item['subtotal'], 0, ',', '.'); ?></span>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="d-flex justify-content-between align-items-center fw-bold mt-3 pt-3 border-top border-secondary border-opacity-25">
                        <span>Total:</span>
                        <span class="fs-5 brand-color">Rp<?= number_format($order['total_amount'], 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div style="height: 50px;"></div>