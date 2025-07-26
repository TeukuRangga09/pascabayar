<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />

        <title><?= $title ?? 'Default Title' ?></title>
        <meta content="" name="description" />
        <meta content="" name="keywords" />

        <!-- Favicons -->
        <link href="<?=base_url('');?>assets/img/favicon.png" rel="icon" />
        <link href="<?=base_url('');?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

        <!-- Vendor CSS Files -->
        <link href="<?=base_url('');?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?=base_url('');?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
        <link href="<?=base_url('');?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
        <link href="<?=base_url('');?>assets/vendor/quill/quill.snow.css" rel="stylesheet" />
        <link href="<?=base_url('');?>assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
        <link href="<?=base_url('');?>assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
        <link href="<?=base_url('');?>assets/vendor/datatables/datatables.min.css" rel="stylesheet" />

        <!-- Template Main CSS File -->
        <link href="<?=base_url('');?>assets/css/style.css" rel="stylesheet" />

        <!-- Custom CSS File -->
        <link href="<?=base_url('assets/css/backend.css');?>" rel="stylesheet" />

        <!-- =======================================================
        * Template Name: NiceAdmin
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Updated: Apr 20 2024 with Bootstrap v5.3.3
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>

    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <a href="<?=base_url('backend');?>" class="logo d-flex align-items-center">
                    <img src="<?=base_url('');?>assets/img/logo.png" alt="" />
                    <span class="d-none d-lg-block">PayListrik</span>
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>
            <!-- End Logo -->

            <!-- <div class="search-bar">
                <form class="search-form d-flex align-items-center" method="POST" action="#">
                    <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
            </div> -->
            <!-- End Search Bar -->

            <div class="d-flex ms-3 align-self-stretch align-items-center hak-akses">
                <p class="badge bg-danger px-3 d-flex align-items-center mb-0">
                    <i class="bi bi-shield-lock-fill me-2"></i>
                    <?= ucfirst($user['level']); ?>
                </p>
            </div>



            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">
                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <?php
                            // Path gambar profil
                            $foto_profil = !empty($user['foto_profil']) && file_exists(FCPATH . 'assets/img/foto_profil/' . $user['foto_profil']) 
                                ? base_url('assets/img/foto_profil/' . $user['foto_profil']) 
                                : base_url('assets/img/foto_profil/default.png');
                            ?>
                            <img src="<?= $foto_profil; ?>" alt="Profile" class="rounded-circle" />
                            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['nama_admin'] ?? 'Pengguna' ?></span> </a>
                            <!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6><?= $user['nama_admin'] ?? 'Pengguna' ?></h6>
                                <span><?= $user['level'] ?? 'Pengguna' ?></span>
                            </li>
                            <?php if (($user['level'] ?? '') === 'Administrator'): ?><?php endif;?> <?php if (in_array(($user['level'] ?? ''), ['Admini', 'petugas'])): ?>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <?php endif;?>

                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?=base_url('backend/pengaturan_akun');?>">
                                    <i class="bi bi-gear"></i>
                                    <span>Pengaturan Akun</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?=base_url('backend/logout');?>">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                        <!-- End Profile Dropdown Items -->
                    </li>
                    <!-- End Profile Nav -->
                </ul>
            </nav>
            <!-- End Icons Navigation -->
        </header>
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link <?= is_active('backend/dashboard') ? 'active' : '' ?>" href="<?= base_url('backend/dashboard'); ?>">
                        <i class="bi bi-grid"></i> <!-- Bootstrap Icons: Grid -->
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('landing') ? 'active' : '' ?>" href="<?= base_url('landing'); ?>">
                        <i class="bi bi-globe"></i> <!-- Bootstrap Icons: Grid -->
                        <span>Lihat Web</span>
                    </a>
                </li>
                <!-- Harga Listrik -->
                <li class="nav-heading">Harga Listrik</li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('backend/tarif') ? 'active' : '' ?>" href="<?= base_url('backend/tarif'); ?>">
                        <i class="bi bi-currency-dollar"></i> <!-- Bootstrap Icons: Currency Dollar -->
                        <span>Tarif Listrik</span>
                    </a>
                </li>
                <!-- Pengguna (Hanya untuk Administrator) -->
                <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                    <li class="nav-heading">Pengguna</li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('backend/level_pengguna') ? 'active' : '' ?>" href="<?= base_url('backend/level_pengguna'); ?>">
                            <i class="bi bi-shield-lock"></i> <!-- Bootstrap Icons: Shield Lock -->
                            <span>Level Pengguna</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('backend/kelola_pengguna') ? 'active' : '' ?>" href="<?= base_url('backend/kelola_pengguna'); ?>">
                            <i class="bi bi-people"></i> <!-- Bootstrap Icons: People -->
                            <span>Kelola Pengguna</span>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Pelanggan -->
                <li class="nav-heading">Pelanggan</li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('backend/pelanggan') ? 'active' : '' ?>" href="<?= base_url('backend/pelanggan'); ?>">
                        <i class="bi bi-person-lines-fill"></i> <!-- Bootstrap Icons: Person Lines Fill -->
                        <span>Data Pelanggan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('backend/penggunaan') ? 'active' : '' ?>" href="<?= base_url('backend/penggunaan'); ?>">
                        <i class="bi bi-bar-chart-fill"></i> <!-- Bootstrap Icons: Bar Chart Fill -->
                        <span>Data Penggunaan</span>
                    </a>
                </li>
                <!-- Tagihan & Pembayaran (Hanya untuk Administrator) -->
                <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                    <li class="nav-heading">Tagihan & Pembayaran</li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('backend/tagihan') ? 'active' : '' ?>" href="<?= base_url('backend/tagihan'); ?>">
                            <i class="bi bi-receipt"></i> <!-- Bootstrap Icons: Receipt -->
                            <span>Tagihan Pelanggan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= is_active('backend/pembayaran') ? 'active' : '' ?>" href="<?= base_url('backend/pembayaran'); ?>">
                            <i class="bi bi-cash-stack"></i> <!-- Bootstrap Icons: Cash Stack -->
                            <span>Riwayat Pembayaran</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-heading">Manajemen Akun</li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('backend/pengaturan_akun') ? 'active' : '' ?>" href="<?= base_url('backend/pengaturan_akun'); ?>">
                        <i class="bi bi-gear"></i> <!-- Bootstrap Icons: Gear -->
                        <span>Pengaturan Akun</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= is_active('backend/logout') ? 'active' : '' ?>" href="<?= base_url('backend/logout'); ?>">
                        <i class="bi bi-box-arrow-right"></i> <!-- Bootstrap Icons: Box Arrow Right -->
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </aside>
                <!-- Data Utama -->
                <!-- <li class="nav-item <?= is_parent_active(['backend/tarif', 'backend/pelanggan']) ? '' : '' ?>">
                    <a class="nav-link <?= is_parent_active(['backend/tarif', 'backend/pelanggan']) ? 'active' : '' ?>" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#" aria-expanded="<?= is_parent_active(['backend/tarif', 'backend/pelanggan']) ? 'true' : 'false' ?>">
                        <i class="bi bi-layout-text-window-reverse"></i>
                        <span>Data Utama</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="tables-nav" class="nav-content collapse <?= is_parent_active(['backend/tarif', 'backend/pelanggan']) ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="<?= base_url('backend/tarif'); ?>" class="<?= is_active('backend/tarif') ? 'active' : '' ?>">
                                <i class="bi bi-circle"></i>
                                <span>Harga Tarif</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('backend/pelanggan'); ?>" class="<?= is_active('backend/pelanggan') ? 'active' : '' ?>">
                                <i class="bi bi-circle"></i>
                                <span>Pelanggan</span>
                            </a>
                        </li>
                    </ul>
                </li> -->

                <script>
                    
                </script>
