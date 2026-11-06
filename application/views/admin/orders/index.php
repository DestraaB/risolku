<div class="container-fluid py-4 px-3 px-md-4">
    <h4 class="fw-bold mb-4">Kelola Pesanan Online</h4>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <?php if (empty($orders)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag text-muted opacity-25 fs-3 mb-3"></i>
                    <p class="text-muted mb-0">Belum ada pesanan online masuk.</p>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush rounded-4">
                    <?php foreach ($orders as $o): ?>
                        <a href="<?= base_url('admin/orders/detail/' . $o['id']); ?>" class="list-group-item list-group-item-action p-3 border-light text-decoration-none">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark"><?= $o['order_number']; ?></span>
                                
                                <!-- Badge Status Pesanan -->
                                <?php 
                                    $badge_bg = 'bg-secondary';
                                    if($o['order_status'] == 'pending') $badge_bg = 'bg-warning text-dark';
                                    elseif($o['order_status'] == 'confirmed') $badge_bg = 'bg-info text-dark';
                                    elseif($o['order_status'] == 'processing') $badge_bg = 'bg-primary';
                                    elseif($o['order_status'] == 'ready') $badge_bg = 'bg-success';
                                    elseif($o['order_status'] == 'completed') $badge_bg = 'bg-success bg-opacity-75';
                                    elseif($o['order_status'] == 'cancelled') $badge_bg = 'bg-danger';
                                ?>
                                <span class="badge <?= $badge_bg; ?> px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem;">
                                    <?= strtoupper($o['order_status']); ?>
                                </span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center text-muted small">
                                <span><i class="fas fa-user me-1"></i> <?= $o['name']; ?> (<?= $o['phone']; ?>)</span>
                                <span class="fw-bold text-dark">Rp<?= number_format($o['total_amount'], 0, ',', '.'); ?></span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>