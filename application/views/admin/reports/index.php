<div class="container-fluid py-4 px-3 px-md-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Laporan Keuangan</h4>
            <p class="text-muted mb-0"><?= $period_title; ?></p>
        </div>
        
        <!-- Tombol Filter Periode -->
        <div class="btn-group bg-white p-1 rounded-pill shadow-sm border" role="group">
            <a href="<?= base_url('admin/laporan?period=daily'); ?>" class="btn rounded-pill px-3 fw-semibold <?= $active_period == 'daily' ? 'btn-primary-custom' : 'btn-light text-muted border-0'; ?>">Harian</a>
            <a href="<?= base_url('admin/laporan?period=weekly'); ?>" class="btn rounded-pill px-3 fw-semibold <?= $active_period == 'weekly' ? 'btn-primary-custom' : 'btn-light text-muted border-0'; ?>">Mingguan</a>
            <a href="<?= base_url('admin/laporan?period=monthly'); ?>" class="btn rounded-pill px-3 fw-semibold <?= $active_period == 'monthly' ? 'btn-primary-custom' : 'btn-light text-muted border-0'; ?>">Bulanan</a>
        </div>
    </div>

    <!-- Ringkasan Angka (4 Kotak) -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="text-muted small fw-semibold mb-2">Penjualan Kotor</div>
                    <h4 class="fw-bold text-success mb-0">Rp<?= number_format($summary['total_sales'], 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center">
                    <div class="text-muted small fw-semibold mb-2">Total Pengeluaran</div>
                    <h4 class="fw-bold text-danger mb-0">Rp<?= number_format($summary['total_expenses'], 0, ',', '.'); ?></h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 <?= $summary['net_profit'] >= 0 ? 'bg-primary bg-opacity-10' : 'bg-danger bg-opacity-10'; ?>">
                <div class="card-body p-4 text-center">
                    <div class="text-muted small fw-semibold mb-2">Laba Bersih</div>
                    <h3 class="fw-bold <?= $summary['net_profit'] >= 0 ? 'text-primary' : 'text-danger'; ?> mb-0">
                        Rp<?= number_format($summary['net_profit'], 0, ',', '.'); ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Risol Terjual</div>
                        <h4 class="fw-bold mb-0"><?= $summary['items_sold']; ?> <span class="fs-6 text-muted fw-normal">pcs</span></h4>
                    </div>
                    <i class="fas fa-box-open fs-1 text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Produk Terlaris -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h6 class="fw-bold mb-0"><i class="fas fa-trophy text-warning me-2"></i> Produk Paling Laris</h6>
        </div>
        <div class="card-body p-0 mt-2">
            <?php if (empty($top_products)): ?>
                <div class="text-center py-5">
                    <p class="text-muted mb-0">Belum ada data penjualan pada periode ini.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Produk</th>
                                <th class="text-center">Varian</th>
                                <th class="text-center">Jumlah Terjual</th>
                                <th class="text-end pe-4">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $rank = 1; foreach ($top_products as $tp): ?>
                            <tr class="border-bottom border-light">
                                <td class="ps-4 py-3">
                                    <span class="text-muted me-2">#<?= $rank++; ?></span>
                                    <span class="fw-bold"><?= $tp['name']; ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= $tp['is_spicy'] ? 'bg-danger' : 'bg-success'; ?> bg-opacity-10 <?= $tp['is_spicy'] ? 'text-danger' : 'text-success'; ?> fw-normal">
                                        <?= $tp['is_spicy'] ? '🌶 ' : ''; ?><?= $tp['variant']; ?>
                                    </span>
                                </td>
                                <td class="text-center fw-bold fs-5"><?= $tp['total_qty']; ?></td>
                                <td class="text-end pe-4 fw-semibold text-success">Rp<?= number_format($tp['total_revenue'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<div style="height: 50px;"></div>