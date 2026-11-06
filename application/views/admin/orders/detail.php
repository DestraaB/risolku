<div class="container-fluid py-4 px-3 px-md-4">
    <div class="d-flex align-items-center mb-4">
        <a href="<?= base_url('admin/orders'); ?>" class="text-dark me-3"><i class="fas fa-arrow-left fs-4"></i></a>
        <h4 class="fw-bold mb-0">Detail Pesanan #<?= $order['order_number']; ?></h4>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-3">
        <!-- Informasi Pelanggan & Pengiriman -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-user-circle text-muted me-2"></i> Informasi Pembeli</h6>
                    <p class="mb-1"><strong>Nama:</strong> <?= $order['name']; ?></p>
                    <p class="mb-1"><strong>WhatsApp:</strong> <a href="https://wa.me/<?= $order['phone']; ?>" target="_blank" class="text-success text-decoration-none"><i class="fab fa-whatsapp me-1"></i><?= $order['phone']; ?></a></p>
                    <p class="mb-1"><strong>Metode:</strong> <span class="badge bg-light text-dark border"><?= strtoupper($order['pickup_method']); ?></span></p>
                    
                    <?php if($order['pickup_method'] == 'delivery'): ?>
                        <p class="mb-1 mt-2"><strong>Alamat:</strong><br><span class="text-muted"><?= $order['address']; ?></span></p>
                    <?php endif; ?>

                    <?php if(!empty($order['notes'])): ?>
                        <div class="alert alert-warning border-0 mt-3 mb-0 small">
                            <strong>Catatan:</strong> <?= $order['notes']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Ubah Status Pesanan -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-tasks text-muted me-2"></i> Perbarui Status Pesanan</h6>
                    
                    <form action="<?= base_url('admin/orders/update/' . $order['id']); ?>" method="post">
                        <div class="mb-3">
                            <select name="order_status" class="form-select form-select-lg fw-semibold">
                                <option value="pending" <?= $order['order_status'] == 'pending' ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                                <option value="confirmed" <?= $order['order_status'] == 'confirmed' ? 'selected' : ''; ?>>Dikonfirmasi</option>
                                <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : ''; ?>>Diproses</option>
                                <option value="ready" <?= $order['order_status'] == 'ready' ? 'selected' : ''; ?>>Siap Diambil / Dikirim</option>
                                <option value="completed" <?= $order['order_status'] == 'completed' ? 'selected' : ''; ?>>Selesai</option>
                                <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary-custom rounded-pill w-100 fw-bold py-2">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Item Risol yang Dibeli -->
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-receipt text-muted me-2"></i> Rincian Menu Pesanan</h6>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-light rounded">
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold d-block"><?= $item['name']; ?></span>
                                        <span class="badge <?= $item['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $item['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal" style="font-size:0.65rem;">
                                            <?= $item['is_spicy'] ? '🌶 ' : ''; ?><?= $item['variant']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold"><?= $item['quantity']; ?> pcs</td>
                                    <td class="text-end">Rp<?= number_format($item['price'], 0, ',', '.'); ?></td>
                                    <td class="text-end fw-bold">Rp<?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pt-3">Total Pembayaran:</td>
                                    <td class="text-end fw-bold text-success fs-5 pt-3">Rp<?= number_format($order['total_amount'], 0, ',', '.'); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>