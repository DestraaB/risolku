<div class="container-fluid py-4 px-3">
    <h3 class="fw-bold mb-1">Halo, <?= $this->session->userdata('name'); ?> 👋</h3>
    <p class="text-muted mb-4">Siap untuk berjualan hari ini?</p>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!$active_session): ?>
        <!-- Empty State: Belum Buka Stand -->
        <div class="card border-0 bg-white shadow-sm rounded-4 text-center py-5 px-3">
            <i class="fas fa-store text-muted mb-3" style="font-size: 4rem;"></i>
            <h5 class="fw-bold">Stand Belum Dibuka</h5>
            <p class="text-muted small mb-4">Mulai sesi jualanmu dengan mengambil stok dari gudang (stok beku).</p>
            <a href="<?= base_url('cashier/open'); ?>" class="btn btn-primary-custom btn-lg rounded-pill fw-bold w-100 shadow-sm">
                Mulai Jualan
            </a>
        </div>
    <?php else: ?>
        <!-- State: Sedang Jualan -->
        <div class="card border-0 bg-success bg-opacity-10 border-start border-4 border-success shadow-sm rounded-4 py-4 px-3 text-center mb-3">
            <h5 class="fw-bold text-success mb-1">Stand Sedang Aktif</h5>
            <p class="text-success small mb-0">Kamu membawa stok dan siap melayani pembeli.</p>
        </div>
        <a href="<?= base_url('cashier/sales'); ?>" class="btn btn-primary-custom btn-lg rounded-pill fw-bold w-100 shadow-sm mb-3">
            <i class="fas fa-shopping-cart me-2"></i> Buka Layar Kasir
        </a>
        <a href="#" class="btn btn-light btn-lg text-danger rounded-pill fw-bold w-100">
            Tutup Stand
        </a>
    <?php endif; ?>

    <div class="mt-5 text-center">
        <a href="<?= base_url('logout'); ?>" class="text-muted text-decoration-none small">
            <i class="fas fa-sign-out-alt me-1"></i> Keluar Akun
        </a>
    </div>
</div>
<!-- Bagian Performa Stand & Keuangan -->
    <div class="row g-3">
        
        <!-- Stand Hari Ini -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                    <h6 class="fw-bold mb-0"><i class="fas fa-store text-warning-emphasis me-2"></i> Stand Hari Ini (Aktif)</h6>
                </div>
                <div class="card-body">
                    <?php if(empty($active_stands)): ?>
                        <div class="text-center py-4">
                            <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-2" style="width: 50px; height: 50px;">
                                <i class="fas fa-store-slash text-muted fs-4"></i>
                            </div>
                            <p class="text-muted mb-0">Belum ada stand yang buka hari ini.</p>
                            <small class="text-muted">Data akan muncul saat kasir mulai berjualan.</small>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush mt-2">
                            <?php foreach($active_stands as $stand): ?>
                                <div class="list-group-item px-0 border-light">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-bold"><i class="fas fa-user-circle text-muted me-1"></i> <?= $stand['cashier_name']; ?></span>
                                        <span class="text-success fw-bold">Rp<?= number_format($stand['summary']['total_sales'], 0, ',', '.'); ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between text-muted small">
                                        <span>Dibawa: <?= $stand['summary']['total_brought']; ?></span>
                                        <span>Terjual: <b class="text-dark"><?= $stand['summary']['total_sold']; ?></b></span>
                                        <span>Sisa: <?= $stand['summary']['total_remaining']; ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Keuangan Hari Ini -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                    <h6 class="fw-bold mb-0"><i class="fas fa-wallet text-success me-2"></i> Keuangan Hari Ini</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Pemasukan (Penjualan)</span>
                        <span class="fw-semibold text-success fs-5">Rp<?= number_format($penjualan_hari_ini, 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Pengeluaran</span>
                        <span class="fw-semibold text-danger fs-5">- Rp<?= number_format($pengeluaran_hari_ini, 0, ',', '.'); ?></span>
                    </div>
                    <hr class="my-2 border-light">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-bold">Laba Bersih</span>
                        <span class="fw-bold fs-3 <?= $bersih_hari_ini >= 0 ? 'text-primary' : 'text-danger'; ?>">
                            Rp<?= number_format($bersih_hari_ini, 0, ',', '.'); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>