<div class="container-fluid py-4 px-3 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Pesanan Online Masuk</h4>
        <a href="<?= base_url('cashier'); ?>" class="btn btn-light rounded-pill"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <i class="fas fa-box-open text-muted opacity-50 mb-3" style="font-size: 4rem;"></i>
            <h5 class="fw-bold">Belum Ada Pesanan</h5>
            <p class="text-muted small">Pesanan online yang masuk hari ini akan muncul di sini.</p>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($orders as $ord): ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <?php 
                        // Tentukan warna garis samping berdasarkan status
                        $border_color = 'border-secondary';
                        if($ord['order_status'] == 'pending') $border_color = 'border-warning';
                        elseif($ord['order_status'] == 'processing') $border_color = 'border-primary';
                        elseif($ord['order_status'] == 'ready') $border_color = 'border-info';
                        elseif($ord['order_status'] == 'completed') $border_color = 'border-success';
                    ?>
                    <div class="card border-0 shadow-sm rounded-4 border-start border-4 <?= $border_color; ?> h-100">
                        <div class="card-body p-3">
                            
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-0"><?= $ord['name']; ?></h6>
                                    <small class="text-muted"><?= $ord['order_number']; ?></small>
                                </div>
                                <span class="badge <?= str_replace('border-', 'bg-', $border_color); ?> px-2 py-1 rounded-pill">
                                    <?= strtoupper($ord['order_status']); ?>
                                </span>
                            </div>

                            <div class="bg-light p-2 rounded-3 mb-3 small">
                                <div class="mb-1"><i class="fas fa-motorcycle text-muted me-1"></i> <?= strtoupper($ord['pickup_method']); ?></div>
                                <div class="mb-1"><i class="fas fa-wallet text-muted me-1"></i> <?= strtoupper($ord['payment_method']); ?> (Rp<?= number_format($ord['total_amount'], 0, ',', '.'); ?>)</div>
                                <?php if($ord['notes']): ?>
                                    <div class="text-danger"><i class="fas fa-comment-dots me-1"></i> "<?= $ord['notes']; ?>"</div>
                                <?php endif; ?>
                            </div>

                            <div class="border-top pt-2 mb-3">
                                <?php foreach($ord['items'] as $item): ?>
                                    <div class="d-flex justify-content-between small fw-semibold mb-1">
                                        <span><?= $item['quantity']; ?>x <?= $item['name']; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- TOMBOL 1-KLIK (LOGIKA CERDAS) -->
                            <div class="mt-auto">
                                <?php if ($ord['order_status'] == 'pending'): ?>
                                    <a href="<?= base_url('cashier/update_order_status/'.$ord['id'].'/processing'); ?>" class="btn btn-warning w-100 rounded-pill fw-bold" onclick="return confirm('Terima pesanan ini?');">
                                        <i class="fas fa-fire me-1"></i> Terima & Mulai Masak
                                    </a>
                                <?php elseif ($ord['order_status'] == 'processing'): ?>
                                    <a href="<?= base_url('cashier/update_order_status/'.$ord['id'].'/ready'); ?>" class="btn btn-primary w-100 rounded-pill fw-bold text-white">
                                        <i class="fas fa-check-double me-1"></i> Selesai Dimasak (Siap)
                                    </a>
                                <?php elseif ($ord['order_status'] == 'ready'): ?>
                                    <a href="<?= base_url('cashier/update_order_status/'.$ord['id'].'/completed'); ?>" class="btn btn-success w-100 rounded-pill fw-bold">
                                        <i class="fas fa-flag-checkered me-1"></i> Pesanan Diserahkan
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-light w-100 rounded-pill text-muted fw-bold" disabled>Selesai</button>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>