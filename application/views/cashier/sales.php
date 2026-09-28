<div class="container-fluid py-3 px-3 bg-light min-vh-100">
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Kasir</h4>
        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Stand Aktif</span>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm py-2" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="#" method="post" id="formPenjualan">
        
        <!-- List Produk (Tombol +/-) -->
        <div class="row g-2 mb-4">
            <?php foreach ($stand_stock as $s): ?>
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h6 class="fw-bold mb-1"><?= $s['name']; ?></h6>
                                <span class="badge <?= $s['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $s['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal">
                                    <?= $s['is_spicy'] ? '🌶 ' : ''; ?><?= $s['variant']; ?>
                                </span>
                            </div>
                            <div class="text-end">
                                <h6 class="fw-bold text-primary mb-0">Rp<?= number_format($s['price'], 0, ',', '.'); ?></h6>
                                <small class="text-muted" style="font-size:0.75rem;">Sisa: <?= $s['quantity_remaining']; ?></small>
                            </div>
                        </div>
                        
                        <!-- Stepper Input (Plus Minus Besar) -->
                        <div class="input-group input-group-lg">
                            <button type="button" class="btn btn-light border fw-bold fs-4 px-4 btn-minus" data-id="<?= $s['product_id']; ?>">-</button>
                            
                            <input type="number" name="sell_qty[<?= $s['product_id']; ?>]" id="input-<?= $s['product_id']; ?>" 
                                   class="form-control text-center fw-bold fs-4 bg-white input-qty" 
                                   value="0" min="0" max="<?= $s['quantity_remaining']; ?>" readonly
                                   data-price="<?= $s['price']; ?>">
                            
                            <button type="button" class="btn btn-light border fw-bold fs-4 px-4 btn-plus" data-id="<?= $s['product_id']; ?>">+</button>
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </form>
</div>

<!-- Panel Total Belanja Bawah (Di Atas Bottom Nav) -->
<div class="fixed-bottom bg-white border-top shadow-lg" style="bottom: 70px; z-index: 1030;">
    <div class="container-fluid px-3 py-3 d-flex justify-content-between align-items-center">
        <div>
            <small class="text-muted fw-bold d-block">Total Tagihan:</small>
            <h3 class="fw-bold text-success mb-0" id="totalHargaDisplay">Rp0</h3>
        </div>
        <button type="button" class="btn btn-primary-custom btn-lg rounded-pill fw-bold px-4 shadow-sm" id="btnSimpan" disabled>
            ✓ Bayar
        </button>
    </div>
</div>

<script>
    // JavaScript Sederhana untuk menangani tombol + dan - serta menghitung Total
    document.addEventListener('DOMContentLoaded', function() {
        const btnMinus = document.querySelectorAll('.btn-minus');
        const btnPlus = document.querySelectorAll('.btn-plus');
        const totalDisplay = document.getElementById('totalHargaDisplay');
        const btnSimpan = document.getElementById('btnSimpan');

        function updateTotal() {
            let total = 0;
            let hasItem = false;
            document.querySelectorAll('.input-qty').forEach(input => {
                let qty = parseInt(input.value) || 0;
                let price = parseInt(input.getAttribute('data-price')) || 0;
                total += (qty * price);
                if (qty > 0) hasItem = true;
            });
            totalDisplay.innerText = 'Rp' + total.toLocaleString('id-ID');
            btnSimpan.disabled = !hasItem; // Nonaktifkan tombol bayar jika Rp0
        }

        btnPlus.forEach(btn => {
            btn.addEventListener('click', function() {
                let input = document.getElementById('input-' + this.getAttribute('data-id'));
                let max = parseInt(input.getAttribute('max'));
                let val = parseInt(input.value);
                if (val < max) {
                    input.value = val + 1;
                    updateTotal();
                }
            });
        });

        btnMinus.forEach(btn => {
            btn.addEventListener('click', function() {
                let input = document.getElementById('input-' + this.getAttribute('data-id'));
                let val = parseInt(input.value);
                if (val > 0) {
                    input.value = val - 1;
                    updateTotal();
                }
            });
        });
    });
</script>