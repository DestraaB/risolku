<!-- Hero Banner Singkat -->
<div class="bg-brand bg-opacity-10 py-4 px-3 mb-4 text-center border-bottom border-warning border-opacity-25">
    <h4 class="fw-bold brand-color mb-1">Lagi Pengen Risol?</h4>
    <p class="text-muted small mb-3">Risol hangat dengan isian melimpah, digoreng dadakan khusus buat kamu.</p>
    <span class="badge bg-white text-dark shadow-sm border px-3 py-2 rounded-pill fw-semibold">
        <i class="fas fa-map-marker-alt text-danger me-1"></i> Jl. Bantul, Yogyakarta
    </span>
</div>

<div class="container-fluid px-3 mb-5">
    <h6 class="fw-bold mb-3 border-start border-4 border-warning ps-2">Menu Favorit</h6>
    
    <!-- 1. NOTIFIKASI SUKSES (DI LUAR FOREACH AGAR HANYA MUNCUL 1 KALI DI ATAS) -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 py-2 shadow-sm fs-6 mb-4" role="alert">
            <i class="fas fa-check-circle me-1"></i> <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close pb-2 pt-3" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- 2. GRID KATALOG PRODUK -->
    <div class="row g-3 mb-5">
        <?php foreach ($products as $p): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card product-card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    
                    <!-- Area Foto Produk / Fallback Gambar -->
                    <div class="product-image-placeholder position-relative bg-light text-center d-flex align-items-center justify-content-center" style="height: 140px;">
                        <?php if (!empty($p['image']) && file_exists(FCPATH . 'assets/img/products/' . $p['image'])): ?>
                            <img src="<?= base_url('assets/img/products/' . $p['image']); ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?= $p['name']; ?>">
                        <?php else: ?>
                            <i class="fas fa-utensils text-warning opacity-50 fs-1"></i>
                        <?php endif; ?>

                        <?php if ($p['stock_frozen'] < 1): ?>
                            <!-- Overlay Habis -->
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">HABIS</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Body (Tunggal & Rapi) -->
                    <div class="card-body p-3 d-flex flex-column">
                        
                        <!-- Indikator Pedas / Varian -->
                        <div class="mb-1">
                            <span class="badge <?= $p['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $p['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal" style="font-size: 0.75rem;">
                                <?= $p['is_spicy'] ? '🌶 ' : ''; ?><?= $p['variant']; ?>
                            </span>
                        </div>

                        <h6 class="fw-bold mb-3 lh-sm" style="font-size: 0.9rem;"><?= $p['name']; ?></h6>

                        <!-- Form Tambah ke Keranjang (Hanya 1 Form Per Kartu) -->
                        <form action="<?= base_url('cart/add'); ?>" method="post" class="mt-auto d-flex justify-content-between align-items-center pt-2 border-top">
                            <input type="hidden" name="id" value="<?= $p['id']; ?>">
                            <input type="hidden" name="price" value="<?= $p['price']; ?>">
                            <input type="hidden" name="name" value="<?= $p['name']; ?>">
                            <input type="hidden" name="variant" value="<?= $p['variant']; ?>">
                            <input type="hidden" name="is_spicy" value="<?= $p['is_spicy']; ?>">
                            <input type="hidden" name="qty" value="1">

                            <span class="fw-bold text-dark" style="font-size: 0.85rem;">Rp<?= number_format($p['price'], 0, ',', '.'); ?></span>
                            
                            <button type="submit" class="btn btn-sm <?= $p['stock_frozen'] > 0 ? 'btn-brand text-white' : 'btn-secondary disabled'; ?> rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; padding: 0;" <?= $p['stock_frozen'] < 1 ? 'disabled' : ''; ?> title="Tambah ke Keranjang">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>

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