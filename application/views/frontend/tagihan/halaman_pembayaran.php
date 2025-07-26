<?php
if (!function_exists('encrypt_id_tagihan')) {
    /**
     * Fungsi untuk mengenkripsi ID tagihan menjadi angka tetap
     *
     * @param int $id_tagihan ID tagihan asli
     * @return string Nomor invoice numerik tetap
     */
    function encrypt_id_tagihan($id_tagihan) {
        // Kunci enkripsi (harus dirahasiakan dan cukup kuat)
        $encryption_key = 'rahasia1234567890abcdefghijklmnopqrstuv'; // 32 karakter

        // Hash ID tagihan menggunakan HMAC-SHA256
        $hashed = hash_hmac('sha256', (string)$id_tagihan, $encryption_key);

        // Ambil 8 karakter pertama dari hash dan konversi ke angka
        $numeric_hash = hexdec(substr($hashed, 0, 8));

        // Tambahkan padding jika diperlukan untuk memastikan panjang tetap
        return str_pad($numeric_hash, 10, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('decrypt_id_tagihan')) {
    /**
     * Fungsi untuk mendekripsi nomor invoice numerik tetap menjadi ID tagihan asli
     *
     * @param string $numeric_invoice Nomor invoice numerik tetap
     * @return int|null ID tagihan asli atau null jika gagal
     */
    function decrypt_id_tagihan($numeric_invoice) {
        // Kunci enkripsi (harus sama dengan yang digunakan saat enkripsi)
        $encryption_key = 'rahasia1234567890abcdefghijklmnopqrstuv'; // 32 karakter

        // Cari ID tagihan asli berdasarkan numeric hash
        for ($id = 1; $id <= 1000000; $id++) { // Sesuaikan batas pencarian
            $encrypted = encrypt_id_tagihan($id);
            if ($encrypted === $numeric_invoice) {
                return $id; // Cocok, kembalikan ID tagihan asli
            }
        }

        return null; // Tidak ditemukan
    }
}
?>

<section class="section-pembayaran py-5 mt-5">
    <div class="container">
        <!-- Judul Section -->
        <div class="text-center mb-3">
            <h2 class="section-title fw-bold text-pc">Transaksi Pembayaran Listrik</h2>
            <p class="section-subtitle text-muted">Ikuti langkah-langkah berikut untuk menyelesaikan pembayaran dengan mudah dan aman.</p>
        </div>

        <!-- Header Transaksi -->
        <div class="row">
            <!-- Panel Utama Transaksi -->
            <div class="col-lg-8">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="card rounded-4 border-0 overflow-hidden mb-4">
                            <div class="card-body p-3">
                                <!-- Step Indicator -->
                                <div class="d-flex justify-content-center" id="stepIndicator" aria-label="Indicator Langkah Transaksi">
                                    <div class="step-indicator d-flex align-items-center w-100">
                                        <div class="step-item active">
                                            <div class="w-100 d-flex justify-content-center">
                                                <div class="step-circle rounded-circle d-flex justify-content-center align-items-center bg-primary text-white">
                                                    <i class="bi bi-receipt"></i>
                                                </div>
                                            </div>
                                            <p class="small text-nowrap mt-2 text-muted mb-0">Detail Tagihan</p>
                                        </div>

                                        <div class="step-line flex-grow-1 mx-2" data-step-line="1"></div>

                                        <div class="step-item text-center me-3">
                                            <div class="w-100 d-flex justify-content-center">
                                                <div class="step-circle rounded-circle d-flex justify-content-center align-items-center">
                                                    <i class="bi bi-bank"></i>
                                                </div>
                                            </div>
                                            <p class="small text-nowrap mt-2 text-muted mb-0">Rekening Tujuan</p>
                                        </div>

                                        <div class="step-line flex-grow-1 mx-2" data-step-line="2"></div>

                                        <div class="step-item text-center">
                                            <div class="w-100 d-flex justify-content-center">
                                                <div class="step-circle rounded-circle d-flex justify-content-center align-items-center">
                                                    <i class="bi bi-upload"></i>
                                                </div>
                                            </div>
                                            <p class="small text-nowrap mt-2 text-muted mb-0">Unggah Bukti</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card rounded-4 border-0 overflow-hidden">
                            <div class="card-body pt-4 p-md-5">
                                <!-- Step 1: Detail Tagihan -->
                                <div class="step" id="step1">
                                    <h5 class="fw-bold text-body">Detail Tagihan</h5>
                                    <p class="text-muted small">Periksa detail tagihan Anda dengan seksama sebelum melanjutkan ke langkah berikutnya.</p>
                                    <ul class="list-unstyled card shadow-none rounded-3 bg-abu-sc border border-1 p-3">
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">Nama Pelanggan</span>
                                            <span class="fw-semibold"><?= htmlspecialchars($tagihan->nama_pelanggan) ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">No.Invoice</span>
                                            <span class="fw-semibold">#<?= encrypt_id_tagihan($tagihan->id_tagihan) ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">Nomor KWH</span>
                                            <span class="fw-semibold"><?= htmlspecialchars($tagihan->nomor_kwh) ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">Bulan/Tahun</span>
                                            <span class="fw-semibold"><?= htmlspecialchars($tagihan->bulan) ?> <?= htmlspecialchars($tagihan->tahun) ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">Jumlah Meter</span>
                                            <span class="fw-semibold"><?= format_kwh($tagihan->jumlah_meter) ?> kWh</span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">Tarif per kWh</span>
                                            <span class="fw-semibold"><?= rupiah($tagihan->tarifperkwh) ?></span>
                                        </li>
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted small">Biaya Admin</span>
                                            <span class="fw-semibold"><?= rupiah($biaya_admin) ?></span>
                                        </li>
                                        <div class="p-0 m-0 border-top border-1 mb-2"></div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-muted">Total Bayar</span>
                                            <span class="fw-bold text-primary h4"><?= rupiah($total_bayar) ?></span>
                                        </div>
                                    </ul>

                                    <div class="float-end">
                                        <button class="btn btn-primary rounded-3 py-2" id="nextStep1">Lanjut ke Rekening Tujuan <i class="bi bi-arrow-right ms-2"></i></button>
                                    </div>
                                </div>
                                <!-- Step 2: Rekening Tujuan -->
                                <div class="mb-5 step d-none " id="step2">
                                    <div class="mb-4">
                                        <h5 class="fw-bold text-body mb-3">Rekening Tujuan</h5>
                                        <p class="text-muted small mb-0">Pilih rekening tujuan sesuai metode pembayaran yang Anda inginkan.</p>
                                        <p class="text-muted small mb-0">Pastikan Anda mentransfer sesuai dengan nominal yang tertera: <span class="fw-bold text-primary"><?= rupiah($total_bayar) ?></span> a.n PT PayListrik</p>
                                    </div>
                                    <div class="row g-4">
                                        <!-- Bank -->
                                        <?php if (!empty($rekening_tujuan['bank'])): ?>
                                        <div class="col-md-6">
                                            <div class="card bg-abu-sc p-3 rounded-3 shadow-none">
                                                <h6 class="fw-bold text-center text-body mb-4">Bank</h6>
                                                <?php foreach ($rekening_tujuan['bank'] as $bank): ?>
                                                    <div class="card rounded-3 shadow-none p-4 pb-0 pt-3 mb-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <img src="<?= base_url('assets/img/pembayaran/' . $bank['logo']) ?>" alt="<?= htmlspecialchars($bank['nama_bank']) ?>" width="60" class="" />
                                                            <div class="ms-3">
                                                                <!-- <p class="mb-0 fw-semibold"><?= htmlspecialchars($bank['nama_bank']) ?></p> -->
                                                                <small class="fw-bold d-block m-0 p-0">No.Rekening</small>
                                                                <small class="d-block m-0 p-0"><?= htmlspecialchars($bank['nomor_rekening']) ?></small>
                                                                <!-- <small class="d-block text-muted m-0 p-0">a.n <?= htmlspecialchars($bank['atas_nama']) ?></small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <!-- E-Wallet -->
                                        <?php if (!empty($rekening_tujuan['e_wallet'])): ?>
                                        <div class="col-md-6">
                                            <div class="card bg-abu-sc p-3 rounded-3 shadow-none">
                                                <h6 class="fw-bold text-center text-body mb-4">E-Wallet</h6>
                                                <?php foreach ($rekening_tujuan['e_wallet'] as $ewallet): ?>
                                                    <div class="card rounded-3 shadow-none p-4 pb-0 pt-3 mb-3">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <!-- Logo E-Wallet -->
                                                            <img src="<?= base_url('assets/img/pembayaran/' . $ewallet['logo']) ?>" alt="<?= htmlspecialchars($ewallet['nama']) ?>" width="60" class="" />
                                                            <div class="ms-3">
                                                                <!-- Nama E-Wallet -->
                                                                <!-- <p class="mb-0 fw-semibold"><?= htmlspecialchars($ewallet['nama']) ?></p> -->
                                                                <!-- Nomor Akun E-Wallet -->
                                                                <small class="fw-bold d-block m-0 p-0">No.Akun</small>
                                                                <small class="d-block m-0 p-0"><?= htmlspecialchars($ewallet['nomor']) ?></small>
                                                                <!-- Atas Nama (Opsional) -->
                                                                <!-- <small class="d-block text-muted m-0 p-0">a.n <?= htmlspecialchars($ewallet['atas_nama']) ?></small> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex flex-column flex-column-reverse flex-md-row justify-content-end float-end float-md-none justify-content-md-between gap-3">
                                        <!-- Tombol Kembali -->
                                        <button 
                                            class="btn btn-outline-secondary rounded-3 py-2" 
                                            id="prevStep2">
                                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Detail Tagihan
                                        </button>

                                        <!-- Tombol Lanjut -->
                                        <button 
                                            class="btn btn-primary rounded-3 py-2" 
                                            id="nextStep2">
                                            Lanjut ke Unggah Bukti <i class="bi bi-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Step 3: Unggah Bukti Pembayaran -->
                                <div class="step d-none " id="step3">
                                    <h5 class="fw-bold text-body mb-3">Unggah Bukti Pembayaran</h5>
                                    <p class="text-muted small mb-4">Unggah bukti pembayaran yang jelas (format JPG, JPEG, PNG, atau PDF, maksimal 2MB) sebagai konfirmasi pembayaran Anda.</p>
                                    <form action="<?= site_url('cek_tagihan/p/proses_pembayaran') ?>" method="POST" enctype="multipart/form-data" id="uploadForm">
                                        <input type="hidden" name="id_tagihan" value="<?= htmlspecialchars($tagihan->id_tagihan) ?>" />
                                        <div class="mb-4">
                                            <label for="bukti_pembayaran" class="form-label small text-muted">Bukti Pembayaran</label>
                                            <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required />
                                            <small class="form-text text-muted">Pastikan file yang diunggah berukuran maksimal 2MB.</small>
                                        </div>
                                        <div class="d-flex flex-column flex-column-reverse flex-md-row justify-content-end float-end float-md-none justify-content-md-between gap-3">
                                            <!-- Tombol Kembali -->
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-secondary rounded-2 py-2" 
                                                id="prevStep3"
                                                style="max-width: 280px;">
                                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Rekening Tujuan
                                            </button>

                                            <!-- Tombol Unggah Bukti -->
                                            <button 
                                                type="submit" 
                                                class="btn btn-primary rounded-2 py-2" 
                                                style="max-width: 280px;">
                                                <i class="bi bi-upload me-2"></i> Unggah Bukti Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Cara Pembayaran -->
            <div class="col-lg-4">
                <div class="card rounded-4 border-0">
                    <div class="card-body p-4 pt-1">
                        <h5 class="card-title text-body mb-0 pb-2">Cara Pembayaran</h5>
                        <p class="small card-text text-muted mb-3">
                            Ikuti panduan singkat berikut untuk menyelesaikan transaksi pembayaran listrik Anda.
                        </p>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 p-0 mb-3">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary rounded-pill me-3" style="font-size: 1rem;">1</span>
                                    <div>
                                        <h6 class="mb-1">Periksa Tagihan</h6>
                                        <p class="mb-0 small text-muted">
                                            Pastikan semua data tagihan telah sesuai dan benar.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 p-0 mb-3">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary rounded-pill me-3" style="font-size: 1rem;">2</span>
                                    <div>
                                        <h6 class="mb-1">Pilih Metode Pembayaran</h6>
                                        <p class="mb-0 small text-muted">
                                            Tentukan rekening bank atau e-wallet yang ingin Anda gunakan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 p-0 mb-3">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary rounded-pill me-3" style="font-size: 1rem;">3</span>
                                    <div>
                                        <h6 class="mb-1">Transfer Nominal Tepat</h6>
                                        <p class="mb-0 small text-muted">
                                            Lakukan transfer sesuai dengan jumlah total yang tertera.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 p-0">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary rounded-pill me-3" style="font-size: 1rem;">4</span>
                                    <div>
                                        <h6 class="mb-1">Unggah Bukti Pembayaran</h6>
                                        <p class="mb-0 small text-muted">
                                            Upload bukti transfer sebagai konfirmasi pembayaran Anda.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                Butuh bantuan? Hubungi CS di <a href="#" class="text-decoration-none">0812-3456-789</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const steps = document.querySelectorAll(".step");
        const stepIndicatorItems = document.querySelectorAll("#stepIndicator .step-item");
        const stepLines = document.querySelectorAll("#stepIndicator .step-line");

        let currentStep = 0;

        function updateStepIndicator() {
            stepIndicatorItems.forEach((item, index) => {
                const stepCircle = item.querySelector(".step-circle");
                const isActive = index <= currentStep;

                item.classList.toggle("active", isActive);
                stepCircle.classList.toggle("bg-primary", isActive);
                stepCircle.classList.toggle("text-white", isActive);
                stepCircle.classList.toggle("bg-light", !isActive);
                stepCircle.classList.toggle("text-muted", !isActive);
            });

            stepLines.forEach((line, index) => {
                line.classList.toggle("bg-primary", index < currentStep);
                line.classList.toggle("bg-light", index >= currentStep);
            });
        }

        function showStep(stepIndex) {
            if (stepIndex < 0 || stepIndex >= steps.length) return;
            steps.forEach((step, index) => {
                step.classList.toggle("d-none", index !== stepIndex);
            });
            currentStep = stepIndex;
            updateStepIndicator();
        }

        document.getElementById("nextStep1")?.addEventListener("click", () => showStep(1));
        document.getElementById("nextStep2")?.addEventListener("click", () => showStep(2));
        document.getElementById("prevStep2")?.addEventListener("click", () => showStep(0));
        document.getElementById("prevStep3")?.addEventListener("click", () => showStep(1));

        // Validasi unggah bukti pembayaran
        document.getElementById("uploadForm")?.addEventListener("submit", (e) => {
            const fileInput = document.getElementById("bukti_pembayaran");
            if (!fileInput || !fileInput.files.length) {
                e.preventDefault();
                alert("Silakan unggah bukti pembayaran terlebih dahulu.");
                return;
            }

            const file = fileInput.files[0];
            const allowedExtensions = ["jpg", "jpeg", "png", "pdf"];
            const fileSizeLimit = 2 * 1024 * 1024; // 2MB
            const fileExtension = file.name.split(".").pop().toLowerCase();

            if (!allowedExtensions.includes(fileExtension)) {
                e.preventDefault();
                alert("Format file tidak valid. Hanya JPG, JPEG, PNG, dan PDF yang diperbolehkan.");
                return;
            }

            if (file.size > fileSizeLimit) {
                e.preventDefault();
                alert("Ukuran file terlalu besar. Maksimal 2MB.");
            }
        });

        updateStepIndicator();
    });
</script>
