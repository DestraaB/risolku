<div class="container-fluid py-4 px-3 mb-5">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('cart'); ?>" class="text-dark me-3"><i class="fas fa-arrow-left fs-4"></i></a>
        <h5 class="fw-bold mb-0">Checkout</h5>
    </div>

    <form action="<?= base_url('checkout/process'); ?>" method="post">
        
        <!-- Data Pemesan -->
        <div class="bg-white p-3 rounded-4 shadow-sm mb-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-user-circle text-muted me-2"></i>Data Pemesan</h6>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div class="mb-2">
                <label class="form-label small fw-semibold">Nomor WhatsApp</label>
                <input type="number" name="phone" class="form-control" placeholder="Contoh: 08123456789" required>
            </div>
        </div>

        <!-- Metode Pengambilan -->
        <div class="bg-white p-3 rounded-4 shadow-sm mb-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-motorcycle text-muted me-2"></i>Pengiriman</h6>
            
            <select name="pickup_method" id="pickupMethod" class="form-select fw-semibold mb-3">
                <option value="pickup">Ambil di Stand</option>
                <option value="delivery">Diantar (Delivery)</option>
            </select>

            <div id="addressBox" class="mb-2" style="display: none;">
                <label class="form-label small fw-semibold">Alamat Lengkap (Diantar)</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Detail alamat, RT/RW, atau patokan rumah..."></textarea>
            </div>
        </div>

        <!-- Catatan Tambahan -->
        <div class="bg-white p-3 rounded-4 shadow-sm mb-4">
            <h6 class="fw-bold mb-2">Catatan Tambahan <span class="text-muted fw-normal small">(Opsional)</span></h6>
            <textarea name="notes" class="form-control" rows="2" placeholder="Cth: Sambal dipisah ya..."></textarea>
        </div>

        <!-- Metode Pembayaran -->
        <div class="bg-white p-3 rounded-4 shadow-sm mb-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-wallet text-muted me-2"></i>Pembayaran</h6>
            <select name="payment_method" class="form-select fw-semibold">
                <option value="cash">Bayar di Tempat (Cash)</option>
                <option value="transfer">Transfer Bank / E-Wallet</option>
            </select>
        </div>

        <!-- Sticky Bawah -->
        <div class="fixed-bottom p-3 bg-white border-top shadow-lg" style="bottom: 70px; z-index: 1030;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-muted fw-bold">Total:</span>
                <h5 class="fw-bold brand-color mb-0">Rp<?= number_format($this->cart->total(), 0, ',', '.'); ?></h5>
            </div>
            <button type="submit" class="btn btn-brand btn-lg rounded-pill fw-bold w-100 shadow-sm">
                Buat Pesanan Sekarang
            </button>
        </div>
    </form>
</div>

<!-- Script simpel untuk menampilkan/menyembunyikan form alamat -->
<script>
    document.getElementById('pickupMethod').addEventListener('change', function() {
        var addressBox = document.getElementById('addressBox');
        if (this.value === 'delivery') {
            addressBox.style.display = 'block';
            addressBox.querySelector('textarea').required = true;
        } else {
            addressBox.style.display = 'none';
            addressBox.querySelector('textarea').required = false;
        }
    });
</script>