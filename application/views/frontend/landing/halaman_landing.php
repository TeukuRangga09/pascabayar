<!-- ======= Hero Section ======= -->
<section class="hero" id="beranda">
    <div class="container">
        <div class="row">
            <!-- Text Content -->
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center gap-3">
                <?php if ($this->session->userdata('sesi_pelanggan')): ?>
                    <h1 class="text-center text-lg-start display-4 fw-bold hero-title">
                        Selamat datang, <?= format_nama_pelanggan($this->session->userdata('nama_pelanggan')); ?>!
                    </h1>
                    <p class="text-muted fs-5 text-center text-lg-start">
                        Kelola tagihan listrik Anda dengan mudah. Periksa riwayat penggunaan, cek tagihan terbaru, dan lakukan pembayaran secara cepat dan aman.
                    </p>
                <?php else: ?>
                    <h1 class="text-center text-lg-start display-4 fw-bold hero-title">
                        Web Pembayaran <span class="text-primary">Listrik</span> Pascabayar
                    </h1>
                    <p class="text-muted fs-5 text-center text-lg-start">
                        Cek riwayat penggunaan, pantau tagihan terbaru, dan lakukan pembayaran secara online dengan aman.
                    </p>
                <?php endif; ?>
                <?php if ($this->session->userdata('sesi_pelanggan')): ?>
                    <div class="text-center text-lg-start d-flex flex-column flex-lg-row justify-content-lg-start gap-3">
                        <a href="<?= base_url('cek_tagihan/p'); ?>" class="btn btn-primary rounded-3 btn-lg px-4">Bayar Tagihan</a>
                        <a href="<?= base_url('riwayat_penggunaan'); ?>" class="btn btn-outline-primary rounded-3 btn-lg px-4">Riwayat Penggunaan</a>
                    </div>
                <?php else: ?>
                    <div class="text-center text-lg-start d-flex flex-column flex-lg-row justify-content-lg-start gap-3">
                        <a href="<?= base_url('cek_tagihan/g'); ?>" class="btn btn-primary rounded-3 btn-lg px-4">Cek Tagihan</a>
                        <a href="<?= base_url('register'); ?>" class="btn btn-outline-primary rounded-3 btn-lg px-4">Daftar Sekarang</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 d-flex flex-column justify-content-center">
                <img src="<?= base_url('assets/svg/Online-payment-receipt.svg'); ?>" class="img-fluid" alt="Energy Illustration" />
            </div>
        </div>
    </div>
</section>

<!-- ======= Layanan Section ======= -->
<section class="services py-5" id="layanan">
    <div class="container">
        <div class="d-flex flex-row justify-content-center">
            <div class="text-center">
                <h2 class="section-title">Layanan Kami</h2>
                <p class="section-subtitle">Nikmati berbagai kemudahan dalam mengelola dan membayar tagihan listrik</p>
            </div>
        </div>

        <div class="row">
            <!-- Cek Tagihan -->
            <div class="col-6 col-lg-4 mb-4">
                <div class="card h-100 rounded-4 flex">
                    <div class="card-body d-flex flex-column justify-content-center text-center mt-2 mb-0">
                        <i class="bi bi-receipt mb-3 display-4 text-primary"></i>
                        <h5 class="fw-bold mt-3 text-body">Cek Tagihan</h5>
                        <p class="text-muted mb-0">Dapatkan informasi tagihan listrik Anda secara real-time dan terperinci.</p>
                    </div>
                </div>
            </div>

            <!-- Pembayaran Online -->
            <div class="col-6 col-lg-4 mb-4">
                <div class="card h-100 rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center text-center mt-2 mb-0">
                        <i class="bi bi-credit-card mb-3 display-4 text-primary"></i>
                        <h5 class="fw-bold mt-3 text-body">Pembayaran Online</h5>
                        <p class="text-muted mb-0">Lakukan pembayaran dengan berbagai metode aman dan cepat.</p>
                    </div>
                </div>
            </div>

            <!-- Customer Support -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center text-center mt-2 mb-0">
                        <i class="bi bi-headset mb-3 display-4 text-primary"></i>
                        <h5 class="fw-bold mt-3 text-body">Dukungan Pelanggan</h5>
                        <p class="text-muted mb-0">Layanan pelanggan siap membantu Anda 24/7 untuk setiap pertanyaan dan keluhan.</p>
                    </div>
                </div>
            </div>

            <!-- Riwayat Penggunaan -->
            <div class="col-6 col-lg-4 mb-4">
                <div class="card h-100 rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center text-center mt-2 mb-0">
                        <i class="bi bi-clock-history mb-3 display-4 text-primary"></i>
                        <h5 class="fw-bold mt-3 text-body">Riwayat Penggunaan</h5>
                        <p class="text-muted mb-0">Pantau riwayat penggunaan listrik Anda untuk manajemen yang lebih baik.</p>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pembayaran -->
            <div class="col-6 col-lg-4 mb-4">
                <div class="card h-100 rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center text-center mt-2 mb-0">
                        <i class="bi bi-wallet2 mb-3 display-4 text-primary"></i>
                        <h5 class="fw-bold mt-3 text-body">Riwayat Pembayaran</h5>
                        <p class="text-muted mb-0">Pantau detail transaksi pembayaran Anda dengan mudah untuk pengelolaan keuangan yang lebih baik.</p>
                    </div>
                </div>
            </div>


            <!-- Keamanan Transaksi -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 rounded-4">
                    <div class="card-body d-flex flex-column justify-content-center text-center mt-2 mb-0">
                        <i class="bi bi-shield-lock mb-3 display-4 text-primary"></i>
                        <h5 class="fw-bold mt-3 text-body">Keamanan Transaksi</h5>
                        <p class="text-muted mb-0">Sistem keamanan tinggi untuk melindungi setiap transaksi Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ======= Contact Section ======= -->
<section class="contact-section" id="kontak_kami">
    <div class="container">
        <div class="section-header text-center mb-0">
            <h2 class="section-title"><i class="bi bi-envelope-paper me-3"></i>Hubungi Kami</h2>
            <p class="section-subtitle">Kami siap membantu menjawab pertanyaan Anda</p>
        </div>

        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-6 mb-4">
                <div class="rounded-4 contact-card h-100">
                    <form class="contact-form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label"> <i class="bi bi-person"></i> Nama Lengkap </label>
                                    <input type="text" class="form-control" id="name" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label"> <i class="bi bi-envelope"></i> Alamat Email </label>
                                    <input type="email" class="form-control" id="email" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subject" class="form-label"> <i class="bi bi-chat-square-text"></i> Subjek </label>
                                    <input type="text" class="form-control" id="subject" required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message" class="form-label"> <i class="bi bi-chat-left-text"></i> Pesan </label>
                                    <textarea class="form-control" id="message" rows="5" required></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-send"></i> Kirim Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-6 mb-4">
                <div class="rounded-4 contact-card h-100">
                    <div class="row">
                        <div class="info-item col-lg-8">
                            <div class="info-icon bg-primary">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="info-content col-lg-12">
                                <h4>Lokasi Kantor</h4>
                                <p>Jl. Jaya Wijaya<br />Depok, 16914</p>
                            </div>
                        </div>

                        <div class="info-item col-lg-8">
                            <div class="info-icon bg-success">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="info-content col-lg-12">
                                <h4>Nomor Telepon</h4>
                                <p>
                                    <a href="tel:+6287875715508">+62 878 7571 5508</a><br />
                                    <a href="tel:+6289506103170">+62 895 0610 3170</a>
                                </p>
                            </div>
                        </div>

                        <div class="info-item col-lg-8">
                            <div class="info-icon bg-warning">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="info-content col-lg-12">
                                <h4>Jam Operasional</h4>
                                <p>
                                    Senin-Jumat: 08:00 - 17:00 WIB<br />
                                    Sabtu: 08:00 - 14:00 WIB
                                </p>
                            </div>
                        </div>

                        <div class="social-links mt-4">
                            <a href="#" class="social-link">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
