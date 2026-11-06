<div class="container-fluid py-4 px-3">
    <h5 class="fw-bold mb-4">Keranjang Pesanan</h5>

    <?php if (empty($this->cart->contents())): ?>
        <!-- Empty State Keranjang -->
        <div class="text-center py-5">
            <i class="fas fa-shopping-basket text-muted opacity-25 mb-3" style="font-size: 4rem;"></i>
            <h6 class="fw-bold text-secondary">Keranjangmu masih kosong</h6>
            <p class="text-muted small mb-4">Yuk, pilih risol favoritmu dulu!</p>
            <a href="<?= base_url(); ?>" class="btn btn-brand rounded-pill px-4 fw-semibold">Lihat Menu</a>
        </div>
    <?php else: ?>
        
        <div class="list-group list-group-flush mb-4 rounded-4 shadow-sm bg-white">
            <?php foreach ($this->cart->contents() as $items): ?>
                <div class="list-group-item p-3 border-light">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-1 fs-6"><?= $items['name']; ?></h6>
                            <span class="badge <?= $items['options']['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $items['options']['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal" style="font-size:0.7rem;">
                                <?= $items['options']['is_spicy'] ? '🌶 ' : ''; ?><?= $items['options']['variant']; ?>
                            </span>
                        </div>
                        <!-- Tombol Hapus -->
                        <a href="<?= base_url('cart/remove/'.$items['rowid']); ?>" class="text-danger" style="font-size:1.2rem;"><i class="fas fa-times-circle"></i></a>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-bold text-dark">Rp<?= number_format($items['subtotal'], 0, ',', '.'); ?></span>
                        
                        <!-- Update QTY Form -->
                        <form action="<?= base_url('cart/update'); ?>" method="post" class="d-flex align-items-center">
                            <input type="hidden" name="rowid" value="<?= $items['rowid']; ?>">
                            <input type="number" name="qty" value="<?= $items['qty']; ?>" class="form-control form-control-sm text-center border-secondary fw-bold" style="width: 50px;" min="1">
                            <button type="submit" class="btn btn-sm btn-light border ms-1"><i class="fas fa-sync-alt text-muted"></i></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Ringkasan Total & Checkout -->
        <div class="bg-white p-3 rounded-4 shadow-sm mb-4 border border-warning border-opacity-25">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted fw-bold">Total Pembayaran</span>
                <h4 class="fw-bold brand-color mb-0">Rp<?= number_format($this->cart->total(), 0, ',', '.'); ?></h4>
            </div>
        </div>

        <a href="#" class="btn btn-brand btn-lg rounded-pill fw-bold w-100 shadow-sm shadow">
            Lanjut Checkout <i class="fas fa-arrow-right ms-2"></i>
        </a>

    <?php endif; ?>
</div>