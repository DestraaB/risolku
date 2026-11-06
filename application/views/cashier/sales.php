<div class="container-fluid py-4 px-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold mb-0">Kasir: Jualan</h4>
        <a href="<?= base_url('cashier'); ?>" class="btn btn-light rounded-pill"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-3">
        <!-- Kiri: Menu Stok Stand -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-box-open text-warning me-2"></i> Stok di Stand</h6>
                    <div class="row g-3">
                        <?php foreach ($stand_stock as $item): ?>
                            <div class="col-6 col-md-4">
                                <div class="card h-100 border-light bg-light rounded-4 text-center p-3" 
                                     style="cursor: pointer; transition: 0.2s;"
                                     onclick="addToCart(<?= $item['product_id']; ?>, '<?= $item['name']; ?>', '<?= $item['variant']; ?>', <?= $item['price']; ?>, <?= $item['quantity_remaining']; ?>)"
                                     onmouseover="this.classList.add('shadow-sm')" onmouseout="this.classList.remove('shadow-sm')">
                                    <div class="mb-2">
                                        <span class="badge <?= $item['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $item['is_spicy'] ? 'text-danger' : 'text-success'; ?>">
                                            <?= $item['is_spicy'] ? '🌶 ' : ''; ?><?= $item['variant']; ?>
                                        </span>
                                    </div>
                                    <h6 class="fw-bold mb-1" style="font-size: 0.9rem;"><?= $item['name']; ?></h6>
                                    <div class="text-primary fw-bold mb-2">Rp<?= number_format($item['price'], 0, ',', '.'); ?></div>
                                    <div class="small text-muted">Sisa: <b><?= $item['quantity_remaining']; ?></b></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Keranjang Belanja -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-shopping-cart text-primary me-2"></i> Keranjang Pesanan</h6>
                    
                    <div id="cartList" class="mb-4" style="min-height: 200px;">
                        <!-- Placeholder Kosong -->
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 border-top pt-3">
                        <span class="fw-bold text-muted">Total Pembayaran</span>
                        <h3 class="fw-bold text-success mb-0" id="totalPrice">Rp0</h3>
                    </div>

                    <!-- Form Checkout Kasir -->
                    <form action="<?= base_url('cashier/process_sale'); ?>" method="post" id="formPenjualan">
                        <div id="hiddenInputs"></div>
                        <button type="button" onclick="prosesBayar()" class="btn btn-primary-custom btn-lg w-100 rounded-pill fw-bold shadow-sm" id="btnBayar" disabled>
                            <i class="fas fa-check-circle me-1"></i> Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT LOGIKA KASIR -->
<script>
let cart = [];
const emptyCartHtml = `<div class="text-center text-muted py-5"><i class="fas fa-basket-shopping fs-1 opacity-25 mb-2"></i><p class="mb-0">Belum ada pesanan</p></div>`;

// Inisialisasi awal
document.getElementById('cartList').innerHTML = emptyCartHtml;

function addToCart(id, name, variant, price, maxStock) {
    if (maxStock < 1) {
        alert('Stok barang ini sudah habis di stand!');
        return;
    }

    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        if (existingItem.qty >= maxStock) {
            alert('Maksimal stok yang bisa dijual hanya ' + maxStock);
            return;
        }
        existingItem.qty++;
    } else {
        cart.push({ id: id, name: name, variant: variant, price: price, qty: 1 });
    }
    renderCart();
}

function changeQty(id, delta) {
    let itemIndex = cart.findIndex(item => item.id === id);
    if (itemIndex !== -1) {
        cart[itemIndex].qty += delta;
        if (cart[itemIndex].qty <= 0) {
            cart.splice(itemIndex, 1);
        }
    }
    renderCart();
}

function renderCart() {
    let cartList = document.getElementById('cartList');
    let hiddenInputs = document.getElementById('hiddenInputs');
    let btnBayar = document.getElementById('btnBayar');
    
    cartList.innerHTML = '';
    hiddenInputs.innerHTML = '';
    let total = 0;

    if (cart.length === 0) {
        cartList.innerHTML = emptyCartHtml;
        document.getElementById('totalPrice').innerText = 'Rp0';
        btnBayar.disabled = true;
        return;
    }

    btnBayar.disabled = false;

    cart.forEach((item, index) => {
        total += (item.price * item.qty);

        // Tampilan daftar pesanan
        cartList.innerHTML += `
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div>
                    <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">${item.name}</h6>
                    <div class="text-muted small">${item.variant}</div>
                    <div class="text-primary fw-bold" style="font-size: 0.85rem;">Rp${item.price.toLocaleString('id-ID')}</div>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-light border rounded-circle shadow-sm" onclick="changeQty(${item.id}, -1)"><i class="fas fa-minus"></i></button>
                    <span class="mx-3 fw-bold">${item.qty}</span>
                    <button type="button" class="btn btn-sm btn-light border rounded-circle shadow-sm" onclick="changeQty(${item.id}, 1)"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        `;

        // Input form tersembunyi (agar terbaca PHP saat dikirim)
        hiddenInputs.innerHTML += `
            <input type="hidden" name="items[${index}][id]" value="${item.id}">
            <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
            <input type="hidden" name="items[${index}][price]" value="${item.price}">
        `;
    });

    // Kirim Total Harga
    hiddenInputs.innerHTML += `<input type="hidden" name="total_amount" value="${total}">`;
    document.getElementById('totalPrice').innerText = 'Rp' + total.toLocaleString('id-ID');
}

function prosesBayar() {
    if (cart.length === 0) return;
    
    // Ubah tombol jadi status loading agar tidak diklik dua kali
    let btn = document.getElementById('btnBayar');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sedang Memproses...';
    
    // Eksekusi kirim form
    document.getElementById('formPenjualan').submit();
}
</script>