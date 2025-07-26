<?php
function encrypt_id_pelanggan($id_pelanggan) {
    $encryption_key = 'rahasia123'; 
    $encrypted = openssl_encrypt($id_pelanggan, 'AES-128-ECB', $encryption_key);

    $numeric_hash = sprintf('%u', crc32($encrypted));

    return 'PLG-' . $numeric_hash;
}
?>


<?php if ($this->session->flashdata('error')) : ?>
    <div class="position-fixed d-flex justify-content-center translate-middle-x start-50 w-100" style="z-index: 9999 !important;top: 15%;">
        <div class="alert alert-danger bg-danger text-white border-0 rounded-4 shadow alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= strip_tags($this->session->flashdata('error')); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')) : ?>
    <div class="position-fixed d-flex justify-content-center translate-middle-x start-50 w-100" style="z-index: 9999 !important;top: 15%;">
        <div class="alert alert-success bg-success text-white border-0 rounded-4 shadow alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= strip_tags($this->session->flashdata('success')); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<div class="section-profil mt-5 pt-5">
    <div class="container">

        <div class="text-center">
            <h2 class="section-title fw-bold text-pc">Kelola Profil Anda</h2>
            <p class="section-subtitle text-muted">Perbarui informasi akun atau lihat detail informasi lainnya</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card rounded-4 overflow-hidden">
                    <form action="<?= site_url('frontend/profil/update') ?>" method="post">
                        <div class="card-header my-0 py-0">
                            <h4 class="card-title p-2 py-0 my-3">Edit Profil</h4>
                        </div>
                        <div class="card-body mt-1">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="username" class="form-label small my-2 text-muted">Username</label>
                                    <input type="text" class="form-control" name="username" 
                                    value="<?= html_escape($profil->username) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_pelanggan" class="form-label small my-2 text-muted">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_pelanggan" 
                                    value="<?= html_escape($profil->nama_pelanggan) ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="alamat" class="form-label small my-2 text-muted">Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="3" required><?= 
                                    html_escape($profil->alamat) ?></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label small my-2 text-muted">Telepon</label>
                                    <input type="tel" class="form-control" name="telepon" 
                                    value="<?= html_escape($profil->telepon) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small my-2 text-muted">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                    value="<?= html_escape($profil->email) ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer my-0 py-0">
                            <div class="d-flex p-2 justify-content-between align-items-center">
                                <small class="text-decoration-underline text-pc" style="cursor:default;">
                                    Form update profile
                                </small>
                                <button type="submit" class="btn btn-primary px-4">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card rounded-4 overflow-hidden">
                    <form action="<?= site_url('frontend/profil/ubah_password') ?>" method="post">
                        <div class="card-header my-0 py-0">
                            <h4 class="card-title p-2 py-0 my-3">Ubah Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label for="password_lama" class="form-label small my-2 text-muted">Password Lama</label>
                                    <input type="password" class="form-control" name="password_lama" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_baru" class="form-label small my-2 text-muted">Password Baru</label>
                                    <input type="password" class="form-control" name="password_baru" 
                                    minlength="6" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="konfirmasi_password" class="form-label small my-2 text-muted">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="konfirmasi_password" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer my-0 py-0">
                            <div class="d-flex p-2 justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    Update Password
                                </button>
                                <small class="text-decoration-underline text-pc" style="cursor:default;">
                                    Form update password
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card rounded-4 overflow-hidden">
                    <div class="card-header my-0 py-0">
                        <h4 class="card-title p-2 py-0 my-3">Detail Akun</h4>
                    </div>
                    <div class="card-body mt-1 mb-0 pb-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <small class="text-muted">ID Pelanggan</small>
                                    <div class="fw-semibold">#<?= encrypt_id_pelanggan($profil->id_pelanggan) ?></div>
                                </div>
                            </div>
                            
                            <div class="list-group-item px-0">
                                <small class="text-muted">Nomor KWH</small>
                                <div class="fw-semibold"><?= $profil->nomor_kwh ?></div>
                            </div>
                            
                            <div class="list-group-item px-0">
                                <small class="text-muted">Daya</small>
                                <div class="fw-semibold"><?= $profil->daya ?></div>
                            </div>
                            
                            <div class="list-group-item px-0">
                                <small class="text-muted">Tarif per KWH</small>
                                <div class="fw-semibold"><?= rupiah($profil->tarifperkwh) ?></div>
                            </div>
                            
                            <div class="list-group-item px-0">
                                <small class="text-muted">Registrasi</small>
                                <div class="fw-semibold"><?= $profil->tanggal_registrasi ?></div>
                            </div>
                            
                            <div class="list-group-item px-0">
                                <small class="text-muted">Penggunaan</small>
                                <div class="fw-semibold"><?= $profil->total_penggunaan_kwh ?> KWH</div>
                            </div>
                            
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <small class="text-muted">Tagihan Lunas</small>
                                    <div class="fw-semibold"><?= $profil->total_tagihan_lunas ?>x</div>
                                </div>
                                <span class="badge bg-success rounded-3"><?= $profil->total_tagihan_lunas ?></span>
                            </div>
                            
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <small class="text-muted">Total Tagihan</small>
                                    <div class="fw-semibold"><?= $profil->total_tagihan ?>x</div>
                                </div>
                                <span class="badge bg-primary rounded-3"><?= $profil->total_tagihan ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer my-0 py-0">
                        <div class="d-flex p-2 justify-content-end">
                            <small class="text-decoration-underline text-pc" style="cursor:default;">
                                Card Detail Pelanggan
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>