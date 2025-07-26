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

<main>
    <div class="container">
        <section class="section-f-login min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-10 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                            <a href="<?= base_url(); ?>" class="logo d-flex align-items-center w-auto">
                                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="">
                                <span class="d-none d-lg-block">PayListrik</span>
                            </a>
                        </div><!-- Akhir Logo -->

                        <div class="card mb-3 rounded-4">
                            <div class="card-body px-md-4 px-lg-5">
                                <div class="pt-4 pb-2 text-center">
                                    <h5 class="card-title pb-0 fs-4">Masuk ke Akun Anda</h5>
                                    <p class="small">Masukkan username atau email & kata sandi anda</p>
                                </div>

                                <!-- Formulir Login -->
                                <form action="<?= base_url('frontend/autentifikasi/proses_login'); ?>" method="post" class="row g-3 needs-validation" id="loginForm" novalidate>
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Username/Email</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text">@</span>
                                            <input type="text" name="identifier" class="form-control" id="yourUsername" required>
                                            <div class="invalid-feedback">Harap masukkan username atau email.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Kata Sandi</label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control z-1" id="yourPassword" required>
                                            <button class="btn btn-light border-2 border-light-subtle border-start-0 rounded-end-3 z-0" type="button" id="togglePassword">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <div class="invalid-feedback">Harap masukkan kata sandi!</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Ingat saya</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Masuk</button>
                                    </div>

                                    <div class="col-12 text-center">
                                        <p class="small mb-0">Belum punya akun? 
                                            <a href="<?= base_url('register'); ?>">Daftar sekarang</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="credits text-center">
                            Kembali ke <a href="<?=base_url('');?>">Halaman Utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>


<style>
    .navbar.navbar-expand-lg {
        display: none;
    }

    .footer{
        display: none;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("loginForm");
    const usernameInput = document.getElementById("yourUsername");
    const passwordInput = document.getElementById("yourPassword");
    const togglePasswordBtn = document.getElementById("togglePassword");

    // Validasi input real-time
    usernameInput.addEventListener("input", function () {
        this.classList.toggle("is-valid", this.value.length > 3);
        this.classList.toggle("is-invalid", this.value.length <= 3);
    });

    passwordInput.addEventListener("input", function () {
        this.classList.toggle("is-valid", this.value.length >= 6);
        this.classList.toggle("is-invalid", this.value.length < 6);
    });

    // Validasi sebelum submit
    form.addEventListener("submit", function (event) {
        if (!usernameInput.classList.contains("is-valid") || !passwordInput.classList.contains("is-valid")) {
            event.preventDefault();
            event.stopPropagation();
            usernameInput.classList.add("is-invalid");
            passwordInput.classList.add("is-invalid");
        }
    });

    // Toggle lihat password
    togglePasswordBtn.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            this.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            passwordInput.type = "password";
            this.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });
});
</script>
