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
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex justify-content-center py-4">
                            <a href="<?= base_url(); ?>" class="logo d-flex align-items-center w-auto">
                                <img src="<?= base_url('assets/img/logo.png'); ?>" alt="">
                                <span class="d-none d-lg-block">PayListrik</span>
                            </a>
                        </div><!-- Akhir Logo -->
                        <div class="card mb-3 rounded-4">
                            <div class="card-body px-md-4">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Buat Akun</h5>
                                    <p class="text-center small">Masukkan data pribadi Anda untuk membuat akun</p>
                                </div>

                                <!-- Formulir Pendaftaran -->
                                <form action="<?= base_url('frontend/autentifikasi/proses_register'); ?>" method="post" class="row g-3 needs-validation" novalidate>
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourTarif" class="form-label">Pilih Tarif</label>
                                        <select name="id_tarif" class="form-select" id="yourTarif" required>
                                            <option value="" disabled selected>Pilih Tarif</option>
                                            <?php if (!empty($tarif)): ?>
                                                <?php foreach ($tarif as $t): ?>
                                                    <option value="<?= htmlspecialchars($t['id_tarif']); ?>">
                                                        <?= htmlspecialchars($t['daya']) . ' (' . rupiah($t['tarifperkwh']) . ' / kWh)'; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option value="" disabled>Data tarif tidak tersedia</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourNamaPelanggan" class="form-label">Nama Pelanggan</label>
                                        <input type="text" name="nama_pelanggan" class="form-control" id="yourNamaPelanggan" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourAlamat" class="form-label">Alamat</label>
                                        <textarea name="alamat" class="form-control" id="yourAlamat" rows="3" required></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourTelepon" class="form-label">Telepon</label>
                                        <input type="text" name="telepon" class="form-control" id="yourTelepon">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="yourEmail" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Kata Sandi</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourConfirmPassword" class="form-label">Konfirmasi Kata Sandi</label>
                                        <input type="password" name="confirm_password" class="form-control" id="yourConfirmPassword" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Daftar</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="small mb-0">Sudah punya akun? <a href="<?= base_url('login'); ?>">Masuk di sini</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="credits">
                            Kembali ke <a href="<?=base_url('');?>">Halaman Utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>


<style>
    .navbar.navbar-expand-lg{
        display: none;
    }

    .footer {
        display: none;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.needs-validation');

    // Fungsi untuk memeriksa validitas input
    function validateInput(input, validationFunction, invalidFeedback) {
        if (!validationFunction(input.value)) {
            input.classList.add('is-invalid');
            input.nextElementSibling.textContent = invalidFeedback;
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        }
    }

    // Aturan validasi untuk setiap input
    const validationRules = {
        yourUsername: {
            rule: (value) => value.length >= 5,
            message: 'Username harus minimal 5 karakter.'
        },
        yourTarif: {
            rule: (value) => value !== '',
            message: 'Pilih tarif listrik yang sesuai.'
        },
        yourNamaPelanggan: {
            rule: (value) => value.trim() !== '',
            message: 'Masukkan nama lengkap Anda.'
        },
        yourAlamat: {
            rule: (value) => value.trim() !== '',
            message: 'Masukkan alamat Anda.'
        },
        yourTelepon: {
            rule: (value) => /^[0-9]{10,15}$/.test(value),
            message: 'Nomor telepon harus berupa angka dengan panjang 10-15 digit.'
        },
        yourEmail: {
            rule: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Masukkan alamat email yang valid.'
        },
        yourPassword: {
            rule: (value) => value.length >= 6,
            message: 'Kata sandi harus minimal 6 karakter.'
        },
        yourConfirmPassword: {
            rule: (value) => value === document.getElementById('yourPassword').value,
            message: 'Kata sandi tidak cocok.'
        }
    };

    // Event listener untuk setiap input
    for (const [id, rules] of Object.entries(validationRules)) {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', () => {
                validateInput(input, rules.rule, rules.message);
            });
        }
    }

    // Validasi saat submit
    form.addEventListener('submit', function (event) {
        let isValid = true;

        for (const [id, rules] of Object.entries(validationRules)) {
            const input = document.getElementById(id);
            if (input) {
                if (!rules.rule(input.value)) {
                    validateInput(input, rules.rule, rules.message);
                    isValid = false;
                }
            }
        }

        if (!isValid) {
            event.preventDefault(); // Mencegah pengiriman formulir jika ada kesalahan
        }
    });
});
</script>