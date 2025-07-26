<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Improved title and meta information -->
        <title>PayListrik</title>
        <meta name="description" content="Your compelling website description here" />
        <meta name="keywords" content="relevant, keywords, for, your, site" />

        <!-- Favicons (improved base_url usage) -->
        <link href="<?=base_url('assets/img/favicon.png')?>" rel="icon" />
        <link href="<?=base_url('assets/img/apple-touch-icon.png')?>" rel="apple-touch-icon" />

        <!-- Google Fonts with display=swap -->
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Nunito:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Vendor CSS Files -->
        <link href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet" />
        <link href="<?=base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css')?>" rel="stylesheet" />
        <link href="<?=base_url('assets/vendor/boxicons/css/boxicons.min.css')?>" rel="stylesheet" />
        <link href="<?=base_url('assets/vendor/quill/quill.snow.css')?>" rel="stylesheet" />
        <link href="<?=base_url('assets/vendor/quill/quill.bubble.css')?>" rel="stylesheet" />
        <link href="<?=base_url('assets/vendor/remixicon/remixicon.css')?>" rel="stylesheet" />

        <!-- Template Main CSS File -->
        <link href="<?=base_url('assets/css/style.css')?>" rel="stylesheet" />
        <link href="<?=base_url('assets/css/frontend.css')?>" rel="stylesheet" />

        <!-- License information (better as comment) -->
        <!-- 
          Template Name: NiceAdmin
          Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
          Author: BootstrapMade.com
          License: https://bootstrapmade.com/license/
        -->
    </head>

    <body class="">
            
        <!-- ======= Header ======= -->
        <header class="navbar navbar-expand-lg navbar-light bg-white fixed-top py-2">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="<?= base_url(''); ?>">
                    <img src="<?=base_url('assets/img/logo.png');?>" class="me-2 f-logo" alt="Logo">
                    <span>PayListrik</span>
                </a>
                
                <!-- Navbar Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Content -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item px-lg-1">
                            <a class="nav-link <?= in_array(uri_string(), ['', 'landing']) ? 'active' : '' ?>" href="<?= base_url(''); ?>">Beranda</a>
                        </li>

                        <?php if ($this->session->userdata('sesi_pelanggan')): ?>
                        <li class="nav-item px-lg-1">
                            <a class="nav-link <?= in_array(uri_string(), ['cek_tagihan/p']) ? 'active' : '' ?>" href="<?= base_url('cek_tagihan/p'); ?>">
                                Tagihan
                            </a>
                        </li>

                        <li class="nav-item dropdown px-lg-1">
                            <a class="nav-link dropdown-toggle <?= in_array(uri_string(), ['riwayat_penggunaan', 'riwayat_pembayaran']) ? 'active' : '' ?>" href="#" id="nav-riwayat" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Riwayat
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="nav-riwayat">
                                <li>
                                    <a class="dropdown-item <?= uri_string() == 'riwayat_penggunaan' ? 'active' : '' ?>" href="<?= base_url('riwayat_penggunaan'); ?>">
                                        Riwayat Penggunaan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item <?= uri_string() == 'riwayat_pembayaran' ? 'active' : '' ?>" href="<?= base_url('riwayat_pembayaran'); ?>">
                                        Riwayat Pembayaran
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <?php else: ?>
                        <li class="nav-item px-lg-1">
                            <a class="nav-link <?= in_array(uri_string(), ['cek_tagihan/g', 'cek_tagihan/g/hasil']) ? 'active' : '' ?>" href="<?= base_url('cek_tagihan/g'); ?>">
                                Cek Tagihan
                            </a>
                        </li>
                        <?php endif; ?>

                        <li class="nav-item px-lg-1"><a class="nav-link <?= in_array(uri_string(), ['tarif']) ? 'active' : '' ?>" href="<?=base_url('tarif');?>">Tarif Listrik</a></li>
                        <li class="nav-item px-lg-1">
                            <a class="nav-link position-relative" target="_blank" href="https://api.whatsapp.com/send?phone=+6287875715508&text=Hallo Saya Butuh Bantuan!%0AApp Name: PayListrik%0A">Dukungan 
                            </a>
                        </li>
                    </ul>

                    <?php if ($this->session->userdata('sesi_pelanggan')): ?>
                        <ul class="navbar-nav d-flex gap-lg-2">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i> <?= htmlspecialchars($this->session->userdata('nama_pelanggan')); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profilDropdown">
                                    <li><a class="dropdown-item" href="<?=base_url('profil');?>"><i class="bi bi-person me-1"></i> Profil Saya</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?=base_url('logout');?>"><i class="bi bi-box-arrow-right me-1"></i> Keluar</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php else: ?>
                        <ul class="navbar-nav d-flex gap-lg-2">
                            <li class="nav-item mb-2 mb-lg-0"><a class="btn btn-outline-primary rounded-3 w-100 mx-lg-3" href="<?=base_url('register')?>">Daftar</a></li>
                            <li class="nav-item"><a class="btn btn-primary rounded-3 w-100 mx-lg-3" href="<?=base_url('login')?>">Login</a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </header>

<!-- Pesan Error -->
<!-- <?php if ($this->session->flashdata('error')) : ?>
    <div class="position-fixed top-15 start-50 translate-middle-x z-3 w-100 d-flex justify-content-center">
        <div class="alert alert-danger bg-danger text-light border-0 rounded-4 shadow alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= strip_tags($this->session->flashdata('error')); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close" data-bs-theme="dark"></button>
        </div>
    </div>
<?php endif; ?>
 -->