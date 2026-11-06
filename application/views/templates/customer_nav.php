<nav class="navbar fixed-bottom bg-white shadow-lg border-top">
    <div class="container-fluid px-2 pb-1 d-flex justify-content-around">
        
        <a href="<?= base_url(); ?>" class="text-decoration-none text-center <?= ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'home') ? 'brand-color' : 'text-muted'; ?>">
            <i class="fas fa-store fs-4 d-block mb-1"></i>
            <small class="fw-bold" style="font-size: 0.7rem;">Menu</small>
        </a>
        
        <a href="#" class="text-decoration-none text-center text-muted position-relative">
            <i class="fas fa-shopping-basket fs-4 d-block mb-1"></i>
            <small class="fw-bold" style="font-size: 0.7rem;">Keranjang</small>
            <!-- Badge Notifikasi Keranjang (Nanti dibuat dinamis di Tahap 9) -->
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                0
            </span>
        </a>
        
        <a href="#" class="text-decoration-none text-center text-muted">
            <i class="fas fa-receipt fs-4 d-block mb-1"></i>
            <small class="fw-bold" style="font-size: 0.7rem;">Pesanan</small>
        </a>

    </div>
</nav>