<div class="container-fluid py-4 px-3 px-md-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Stok Stand (Aktif)</h4>
    </div>

    <?php if (empty($active_stands)): ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-store-slash text-muted fs-3 mb-3"></i>
                <p class="text-muted mb-0">Saat ini tidak ada stand yang sedang beroperasi.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($active_stands as $stand): ?>
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0"><i class="fas fa-user-circle text-warning-emphasis me-2"></i> Kasir: <?= $stand['cashier_name']; ?></h6>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Sedang Jualan</span>
                        </div>
                        <div class="card-body">
                            <div class="text-muted small mb-3">
                                <i class="far fa-clock me-1"></i> Dibuka sejak: <?= date('H:i, d M Y', strtotime($stand['opened_at'])); ?>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <thead class="table-light rounded">
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center text-muted">Dibawa</th>
                                            <th class="text-center text-success">Laku</th>
                                            <th class="text-center fw-bold">Sisa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($stand['stock'] as $item): ?>
                                        <tr class="border-bottom border-light">
                                            <td>
                                                <span class="d-block fw-semibold" style="font-size: 0.85rem;"><?= $item['name']; ?></span>
                                                <span class="badge <?= $item['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $item['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal" style="font-size: 0.65rem;">
                                                    <?= $item['is_spicy'] ? '🌶 ' : ''; ?><?= $item['variant']; ?>
                                                </span>
                                            </td>
                                            <td class="text-center text-muted"><?= $item['quantity_opened']; ?></td>
                                            <td class="text-center text-success fw-semibold"><?= $item['quantity_sold']; ?></td>
                                            <td class="text-center fw-bold text-primary fs-6"><?= $item['quantity_remaining']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>