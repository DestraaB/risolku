<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container-fluid px-3">
        
        <!-- Tombol Hamburger untuk memunculkan Sidebar -->
        <button class="navbar-toggler border-0 px-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
            <i class="fas fa-bars fs-4 text-dark"></i>
        </button>

        <!-- Brand / Logo -->
        <a class="navbar-brand fw-bold text-warning-emphasis ms-3" href="<?= base_url('admin/dashboard'); ?>">
            <i class="fas fa-box-open me-1"></i> RisolKu
        </a>

        <!-- User Profile Ringkas -->
        <div class="d-flex align-items-center ms-auto">
            <span class="d-none d-md-inline text-muted me-2">Halo, <?= $this->session->userdata('name'); ?></span>
            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                <i class="fas fa-user text-warning-emphasis"></i>
            </div>
        </div>

    </div>
</nav>

<!-- Sidebar (Offcanvas) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel" style="width: 280px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold text-warning-emphasis" id="adminSidebarLabel">Menu Admin</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="list-group list-group-flush">
            
            <!-- Sesuai struktur menu final di Master Prompt #76 -->
            <a href="<?= base_url('admin/dashboard'); ?>" class="list-group-item list-group-item-action py-3 fw-semibold border-0 <?= ($this->uri->segment(2) == 'dashboard') ? 'bg-light text-warning-emphasis border-start border-4 border-warning' : 'text-secondary'; ?>">
                <i class="fas fa-home fa-fw me-2"></i> Beranda
            </a>
           
            <!--stock-->
            <a href="#menuStok" data-bs-toggle="collapse" class="list-group-item list-group-item-action py-3 fw-semibold border-0 text-secondary">
                <i class="fas fa-boxes fa-fw me-2"></i> Stok <i class="fas fa-chevron-down float-end mt-1" style="font-size: 0.8rem;"></i>
            </a>
            <div class="collapse <?= ($this->uri->segment(2) == 'stok-beku' || $this->uri->segment(2) == 'riwayat-stok') ? 'show' : ''; ?>" id="menuStok">
                <div class="bg-light ps-4 py-2">
                    <a href="<?= base_url('admin/stok-beku'); ?>" class="list-group-item list-group-item-action border-0 bg-transparent py-2 <?= ($this->uri->segment(2) == 'stok-beku') ? 'text-warning-emphasis fw-bold' : 'text-secondary'; ?>">Stok Beku</a>
                    <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent py-2 text-secondary">Stok Stand</a>
                    <a href="<?= base_url('admin/riwayat-stok'); ?>" class="list-group-item list-group-item-action border-0 bg-transparent py-2 <?= ($this->uri->segment(2) == 'riwayat-stok') ? 'text-warning-emphasis fw-bold' : 'text-secondary'; ?>">Riwayat Stok</a>
                </div>
            </div>
            
            <a href="#" class="list-group-item list-group-item-action py-3 fw-semibold border-0 text-secondary">
                <i class="fas fa-wallet fa-fw me-2"></i> Keuangan
            </a>

            <a href="#" class="list-group-item list-group-item-action py-3 fw-semibold border-0 text-secondary">
                <i class="fas fa-shopping-bag fa-fw me-2"></i> Pesanan Online
            </a>
            
            <a href="#" class="list-group-item list-group-item-action py-3 fw-semibold border-0 text-secondary">
                <i class="fas fa-chart-line fa-fw me-2"></i> Laporan
            </a>

            <a href="#" class="list-group-item list-group-item-action py-3 fw-semibold border-0 text-secondary">
                <i class="fas fa-users fa-fw me-2"></i> Kelola Kasir
            </a>

            <div class="mt-4 border-top"></div>
            
            <a href="<?= base_url('logout'); ?>" class="list-group-item list-group-item-action py-3 fw-semibold border-0 text-danger">
                <i class="fas fa-sign-out-alt fa-fw me-2"></i> Keluar
            </a>

        </div>
    </div>
</div>