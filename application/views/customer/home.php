<!-- Hero Banner Singkat -->
<div class="bg-brand bg-opacity-10 py-4 px-3 mb-4 text-center border-bottom border-warning border-opacity-25">
    <h4 class="fw-bold brand-color mb-1">Lagi Pengen Risol?</h4>
    <p class="text-muted small mb-3">Risol hangat dengan isian melimpah, digoreng dadakan khusus buat kamu.</p>
    <span class="badge bg-white text-dark shadow-sm border px-3 py-2 rounded-pill fw-semibold">
        <i class="fas fa-map-marker-alt text-danger me-1"></i> Jl. Bantul, Yogyakarta
    </span>
</div>

<div class="container-fluid px-3">
    <h6 class="fw-bold mb-3 border-start border-4 border-warning ps-2">Menu Favorit</h6>
    
    <!-- Grid Katalog (2 Kolom di HP) -->
    <div class="row g-3 mb-5">
        <?php foreach ($products as $p): ?>
            
            <!-- Agar tampil 2 kolom di HP (col-6), dan responsif di tablet/laptop (col-md-4, col-lg-3) -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card h-100">
                    
                    <!-- Area Foto / Placeholder -->
                    <div class="product-image-placeholder position-relative">
                        <i class="fas fa-image text-muted opacity-25 fs-1"></i>
                        
                        <?php if ($p['stock_frozen'] < 1): ?>
                            <!-- Overlay Habis -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">HABIS</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body p-2 d-flex flex-column">
                        <h6 class="fw-bold mb-1 lh-sm" style="font-size: 0.9rem;"><?= $p['name']; ?></h6>
                        <!-- Tambahkan ini di bawah <h6 class="fw-bold mb-3...">Menu Favorit</h6> -->
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show border-0 rounded-pill py-2 shadow-sm fs-6" role="alert">
                            <i class="fas fa-check-circle me-1"></i> <?= $this->session->flashdata('success'); ?>
                            <button type="button" class="btn-close pb-2 pt-3" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- ... Kode grid produk lainnya tetap sama, HINGGA bagian bawah ini ... -->

                    <!-- CARI BAGIAN INI LALU TIMPA: (Harga dan Tombol Tambah di dalam looping foreach) -->
                    <form action="<?= base_url('cart/add'); ?>" method="post" class="mt-auto d-flex justify-content-between align-items-end">
                        <input type="hidden" name="id" value="<?= $p['id']; ?>">
                        <input type="hidden" name="price" value="<?= $p['price']; ?>">
                        <input type="hidden" name="name" value="<?= $p['name']; ?>">
                        <input type="hidden" name="variant" value="<?= $p['variant']; ?>">
                        <input type="hidden" name="is_spicy" value="<?= $p['is_spicy']; ?>">

                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">Rp<?= number_format($p['price'], 0, ',', '.'); ?></span>
                        
                        <button type="submit" class="btn btn-sm <?= $p['stock_frozen'] > 0 ? 'btn-brand' : 'btn-secondary disabled'; ?> rounded-circle shadow-sm" style="width: 30px; height: 30px; padding: 0;" <?= $p['stock_frozen'] < 1 ? 'disabled' : ''; ?>>
                            <i class="fas fa-plus"></i>
                        </button>
                    </form>
                        
                        <!-- Indikator Pedas / Varian -->
                        <div class="mb-2">
                            <span class="badge <?= $p['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $p['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal" style="font-size: 0.7rem;">
                                <?= $p['is_spicy'] ? '🌶 ' : ''; ?><?= $p['variant']; ?>
                            </span>
                        </div>
                        
                        <!-- Harga dan Tombol Tambah (di bawah) -->
                        <div class="mt-auto d-flex justify-content-between align-items-end">
                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">Rp<?= number_format($p['price'], 0, ',', '.'); ?></span>
                            
                            <button class="btn btn-sm <?= $p['stock_frozen'] > 0 ? 'btn-brand' : 'btn-secondary disabled'; ?> rounded-circle shadow-sm" style="width: 30px; height: 30px; padding: 0;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tombol Plus
    const plusBtns = document.querySelectorAll('.btn-plus');
    plusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Hanya cari input yang berada persis di sebelah tombol ini
            const input = this.previousElementSibling;
            input.value = parseInt(input.value) + 1;
        });
    });

    // Tombol Minus
    const minusBtns = document.querySelectorAll('.btn-minus');
    minusBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Hanya cari input yang berada persis di sebelah tombol ini
            const input = this.nextElementSibling;
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        });
    });
});
</script>