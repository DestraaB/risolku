<!-- Spasi kosong agar konten tidak tertutup navbar bawah -->
<div style="height: 80px;"></div>

<nav class="navbar fixed-bottom bg-white shadow-lg border-top">
    <div class="container-fluid px-3 pb-1 d-flex justify-content-around">
        
        <a href="<?= base_url('cashier/dashboard'); ?>" class="text-decoration-none text-center <?= ($this->uri->segment(2) == 'dashboard') ? 'text-warning-emphasis' : 'text-muted'; ?>">
            <i class="fas fa-home fs-4 d-block mb-1"></i>
            <small class="fw-semibold" style="font-size: 0.75rem;">Beranda</small>
        </a>
        
        <a href="<?= base_url('cashier/sales'); ?>" class="text-decoration-none text-center <?= ($this->uri->segment(2) == 'sales') ? 'text-warning-emphasis' : 'text-muted'; ?>">
            <i class="fas fa-shopping-cart fs-4 d-block mb-1"></i>
            <small class="fw-semibold" style="font-size: 0.75rem;">Jualan</small>
        </a>
        
        <a href="#" class="text-decoration-none text-center text-muted">
            <i class="fas fa-box fs-4 d-block mb-1"></i>
            <small class="fw-semibold" style="font-size: 0.75rem;">Stok</small>
        </a>

    </div>
</nav>