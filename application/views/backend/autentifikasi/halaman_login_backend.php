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
<style>
    .navbar.navbar-expand-lg {
        display: none;
    }
    .footer {
        display: none;
    }
</style>

<main class="">
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-5 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
                                <img src="<?=base_url('');?>assets/img/logo.png" alt="" />
                                <span class="d-none d-lg-block">PayListrik</span>
                            </a>
                        </div>
                        <!-- End Logo -->

                        <div class="card rounded-4 mb-3 p-2">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Masuk ke Akun Anda</h5>
                                    <p class="text-center small">Silakan masukkan username dan kata sandi Administrator atau Petugas untuk masuk.</p>
                                </div>
                                <form class="row g-3 needs-validation" action="<?php echo site_url('backend/autentifikasi_backend/proses_login'); ?>" method="post" novalidate>
                                    <!-- Field username -->
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Username</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="username" class="form-control <?php echo (form_error('username')) ? 'is-invalid' : ''; ?>" id="yourUsername" value="<?php echo set_value('username'); ?>" required />
                                            <div class="invalid-feedback"><?php echo form_error('username') ? form_error('username') : 'Harap masukkan username Anda.'; ?></div>
                                        </div>
                                    </div>
                                    <!-- Field Kata Sandi -->
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Kata Sandi</label>
                                        <input type="password" name="password" class="form-control <?php echo (form_error('password')) ? 'is-invalid' : ''; ?>" id="yourPassword" required />
                                        <div class="invalid-feedback"><?php echo form_error('password') ? form_error('password') : 'Harap masukkan kata sandi Anda!'; ?></div>
                                    </div>
                                    <!-- Checkbox Ingat Saya -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe" />
                                            <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                        </div>
                                    </div>
                                    <!-- Tombol Masuk -->
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Masuk</button>
                                    </div>
                                    <!-- Tautan Kembali ke Halaman Utama -->
                                    <div class="col-12">
                                        <p class="small mb-0">Kembali ke <a href="<?=base_url('');?>">Halaman Utama</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>