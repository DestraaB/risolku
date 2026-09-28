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