<div class="container-fluid py-4 px-3 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Tutup Stand</h4>
        <a href="<?= base_url('cashier'); ?>" class="btn btn-light rounded-pill"><i class="fas fa-arrow-left"></i> Batal</a>
    </div>

    <div class="alert alert-warning border-0 rounded-4 shadow-sm mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i> Pastikan semua pesanan sudah diselesaikan (Selesai/Batal) sebelum menutup stand!
    </div>

    <form action="<?= base_url('cashier/process_close'); ?>" method="post">
        
        <!-- Ringkasan Sistem -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h6 class="fw-bold text-muted"><i class="fas fa-calculator me-2"></i>Rekap Pendapatan (Sistem)</h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Pembayaran QRIS/Transfer</span>
                    <span class="fw-semibold">Rp <?= number_format($sales['transfer'], 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                    <span class="text-muted">Total Pembayaran Tunai (Cash)</span>
                    <span class="fw-bold text-success">Rp <?= number_format($sales['cash'], 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-6">Total Omzet Sesi Ini</span>
                    <h5 class="fw-bold brand-color mb-0">Rp <?= number_format($sales['total'], 0, ',', '.'); ?></h5>
                </div>
            </div>
        </div>

        <!-- Input Uang Fisik -->
        <div class="card border-0 shadow-sm rounded-4 border-start border-4 border-primary mb-4">
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold">Uang Tunai di Laci (Actual Cash) <span class="text-danger">*</span></label>
                    <p class="small text-muted mb-2">Hitung jumlah uang fisik yang ada di laci kasir saat ini.</p>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">Rp</span>
                        <!-- Tambahkan ID 'inputUang' di sini -->
                        <input type="text" name="actual_cash" id="inputUang" class="form-control border-start-0" placeholder="0" required>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-bold">Catatan Penutupan</label>
                    <textarea name="closing_notes" class="form-control" rows="2" placeholder="Catat selisih uang, barang rusak, atau info lainnya..."></textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-danger btn-lg w-100 rounded-pill fw-bold shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menutup stand? Pesanan online tidak akan bisa masuk lagi.');">
            <i class="fas fa-lock me-2"></i> Konfirmasi Tutup Stand
        </button>
    </form>
</div>

<!-- Script Format Titik Ribuan (Rupiah) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var inputUang = document.getElementById('inputUang');
    
    inputUang.addEventListener('keyup', function(e) {
        // Hapus karakter selain angka
        var value = this.value.replace(/[^,\d]/g, '').toString();
        var split = value.split(',');
        var sisa = split[0].length % 3;
        var rupiah = split[0].substr(0, sisa);
        var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // Tambahkan titik jika yang diinput sudah menjadi angka ribuan
        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        this.value = rupiah;
    });
});
</script>