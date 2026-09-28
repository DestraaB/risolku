<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px; border-radius: 15px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <h2 class="fw-bold text-warning-emphasis">RisolKu</h2>
                <p class="text-muted">Risol Hangat, Gurih, dan Bikin Nagih</p>
            </div>

            <!-- Notifikasi Error Jika Gagal Login -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Form Login -->
            <form action="<?= base_url('login'); ?>" method="post">
                
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" class="form-control form-control-lg fs-6" id="username" name="username" placeholder="Masukkan username" required autofocus autocomplete="off">
                    </div>
                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control form-control-lg fs-6" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2 fs-5 rounded-pill fw-bold">
                    Masuk <i class="fas fa-sign-in-alt ms-1"></i>
                </button>
                
            </form>

        </div>
    </div>
</div>