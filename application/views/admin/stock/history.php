<div class="container-fluid py-4 px-3 px-md-4">
    <h4 class="fw-bold mb-4">Riwayat Stok</h4>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <?php if (empty($movements)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-history text-muted fs-3 mb-3"></i>
                    <p class="text-muted mb-0">Belum ada pergerakan stok.</p>
                    <small class="text-muted">Data akan muncul setelah Anda menambahkan stok atau berjualan.</small>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush rounded-4">
                    <?php foreach ($movements as $m): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center p-3 border-light">
                            <div>
                                <small class="text-muted d-block mb-1">
                                    <?= date('d M Y, H:i', strtotime($m['created_at'])); ?>
                                </small>
                                <span class="fw-semibold text-dark"><?= $m['name']; ?> - <?= $m['variant']; ?></span>
                                <div class="text-muted small mt-1">
                                    <?php if($m['source'] == 'production'): ?>
                                        <i class="fas fa-industry me-1"></i> Produksi Baru
                                    <?php elseif($m['source'] == 'stand'): ?>
                                        <i class="fas fa-store me-1"></i> Dibawa ke Stand
                                    <?php elseif($m['source'] == 'stand_return'): ?>
                                        <i class="fas fa-undo me-1"></i> Pengembalian dari Stand
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge rounded-pill fs-6 <?= $m['type'] == 'IN' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger'; ?>">
                                    <?= $m['type'] == 'IN' ? '+' : '-'; ?><?= $m['quantity']; ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>