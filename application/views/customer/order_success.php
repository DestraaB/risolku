<div class="container-fluid py-5 px-3 text-center mb-5">
    
    <div class="mb-4">
        <span class="d-inline-block bg-success bg-opacity-10 text-success rounded-circle p-4 mb-3">
            <i class="fas fa-check-circle fs-1"></i>
        </span>
        <h3 class="fw-bold text-dark">Pesanan Berhasil 🎉</h3>
        <p class="text-muted">Terima kasih, <b><?= $order['name']; ?></b>! Pesananmu sedang kami terima.</p>
    </div>

    <div class="card border-0 bg-white shadow-sm rounded-4 text-start mb-4">
        <div class="card-body p-4">
            <div class="mb-3">
                <small class="text-muted d-block">Nomor Pesanan</small>
                <span class="fw-bold text-dark fs-5"><?= $order['order_number']; ?></span>
            </div>
            <div class="mb-3">
                <small class="text-muted d-block">Total Pembayaran</small>
                <span class="fw-bold brand-color fs-5">Rp<?= number_format($order['total_amount'], 0, ',', '.'); ?></span>
            </div>
            <div class="mb-0">
                <small class="text-muted d-block">Status Saat Ini</small>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mt-1">
                    <i class="fas fa-clock me-1"></i> Menunggu Konfirmasi
                </span>
            </div>
        </div>
    </div>

    <?php 
        // Otomatis buat pesan WA
        $pesanWA = "Halo admin RisolKu, saya *" . $order['name'] . "*.%0A%0A"
                 . "Pesanan baru dengan nomor: *" . $order['order_number'] . "*%0A"
                 . "Total: *Rp" . number_format($order['total_amount'], 0, ',', '.') . "*%0A%0A"
                 . "Mohon segera diproses ya. Terima kasih!";
        $nomorAdmin = "62895422394340"; // Ganti dengan nomor asli nanti
    ?>

    <a href="https://wa.me/<?= $nomorAdmin; ?>?text=<?= $pesanWA; ?>" target="_blank" class="btn btn-success btn-lg rounded-pill fw-bold w-100 shadow-sm mb-3">
        <i class="fab fa-whatsapp me-2 fs-5"></i> Konfirmasi via WhatsApp
    </a>

    <a href="<?= base_url(); ?>" class="btn btn-light btn-lg rounded-pill fw-bold w-100 text-muted border">
        Kembali ke Menu
    </a>

</div>
<div style="height: 100px;"></div>