<div class="container-fluid py-4 px-3 px-md-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Ringkasan Hari Ini</h4>
        <span class="text-muted small"><?= date('d M Y'); ?></span>
    </div>

    <!-- 4 Kotak Ringkasan Utama -->
    <div class="row g-3 mb-4">
        
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3">
                    <div class="text-muted small fw-semibold mb-1">Penjualan</div>
                    <h5 class="fw-bold mb-0 text-success">Rp<?= number_format($penjualan_hari_ini, 0, ',', '.'); ?></h5>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3">
                    <div class="text-muted small fw-semibold mb-1">Risol Terjual</div>
                    <h5 class="fw-bold mb-0"><?= $risol_terjual; ?> <span class="fs-6 text-muted fw-normal">pcs</span></h5>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3">
                    <div class="text-muted small fw-semibold mb-1">Stok Beku</div>
                    <h5 class="fw-bold mb-0 text-primary"><?= $stok_beku; ?> <span class="fs-6 text-muted fw-normal">pcs</span></h5>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3">
                    <div class="text-muted small fw-semibold mb-1">Stok Stand</div>
                    <h5 class="fw-bold mb-0 text-warning"><?= $stok_stand; ?> <span class="fs-6 text-muted fw-normal">pcs</span></h5>
                </div>
            </div>
        </div>

    </div>

    <!-- Bagian Performa Stand & Keuangan -->
    <div class="row g-3">
        
        <!-- Stand Hari Ini -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                    <h6 class="fw-bold mb-0"><i class="fas fa-store text-warning-emphasis me-2"></i> Stand Hari Ini</h6>
                </div>
                <div class="card-body">
                    <!-- Empty State ramah sesuai master prompt -->
                    <div class="text-center py-4">
                        <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-2" style="width: 50px; height: 50px;">
                            <i class="fas fa-store-slash text-muted fs-4"></i>
                        </div>
                        <p class="text-muted mb-0">Belum ada stand yang buka hari ini.</p>
                        <small class="text-muted">Data performa stand akan muncul setelah kasir mulai berjualan.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keuangan Hari Ini -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                    <h6 class="fw-bold mb-0"><i class="fas fa-wallet text-success me-2"></i> Keuangan Hari Ini</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pemasukan</span>
                        <span class="fw-semibold text-success">Rp0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">Pengeluaran</span>
                        <span class="fw-semibold text-danger">Rp0</span>
                    </div>
                    <hr class="my-2 border-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Bersih</span>
                        <span class="fw-bold fs-5">Rp0</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>