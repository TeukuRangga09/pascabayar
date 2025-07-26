<main id="main" class="main">
    <div class="pagetitle">
        <h1>Pengaturan Akun</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Beranda</a></li>
                <li class="breadcrumb-item active">Pengaturan Akun</li>
            </ol>
        </nav>
    </div>

    <!-- Pesan Flash -->
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= str_replace('<p>', '', str_replace('</p>', '', $this->session->flashdata('error'))); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <section class="section profile">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card d-flex flex-column align-items-center overflow-hidden">
                        <?php if (!empty($user_settings['foto_profil'])): ?>
                            <img src="<?= base_url('./assets/img/foto_profil/' . $user_settings['foto_profil']) ?>" alt="Foto Profil" class="rounded-circle mt-4" width="150">
                        <?php else: ?>
                            <img src="<?= base_url('assets/img/foto_profil/default.png') ?>" alt="Foto Profil Default" class="rounded-circle mt-4" width="150">
                        <?php endif; ?>
                        <h2 class="text-center mb-3"><?= $user_settings['nama_admin'] ?></h2>
                        <span class="badge bg-danger px-3 mb-3 " style="font-family: 'Poppins'; font-weight: 500;"><?= $user['level'] ?? 'Pekerjaan Tidak Diketahui' ?></span>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kolom Kanan -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Navigasi Tab -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link <?= empty($this->session->flashdata('active_tab')) || $this->session->flashdata('active_tab') === 'profile-edit' ? 'active' : '' ?>" 
                                        data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profil
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link <?= $this->session->flashdata('active_tab') === 'profile-change-password' ? 'active' : '' ?>" 
                                        data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Kata Sandi
                                </button>
                            </li>
                        </ul>
                        <!-- Konten Tab -->
                        <div class="tab-content pt-2">
                            <!-- Edit Profil -->
                            <div class="tab-pane fade <?= empty($this->session->flashdata('active_tab')) || $this->session->flashdata('active_tab') === 'profile-edit' ? 'show active' : '' ?>" id="profile-edit">
                                <form action="<?= base_url('backend/pengaturan_akun_backend/update_profile') ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="full_name" class="col-form-label">Nama Lengkap</label>
                                        <div class="col-12">
                                            <input type="text" name="nama_admin" class="form-control" value="<?= $user_settings['nama_admin'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-form-label">Email</label>
                                        <div class="col-12">
                                            <input type="email" name="email" class="form-control" value="<?= $user_settings['email'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="foto_profil" class="col-form-label">Foto Profil</label>
                                        <div class="col-12">
                                            <input type="file" name="foto_profil" class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>

                            <!-- Ubah Kata Sandi -->
                            <div class="tab-pane fade <?= $this->session->flashdata('active_tab') === 'profile-change-password' ? 'show active' : '' ?>" id="profile-change-password">
                                <form action="<?= base_url('backend/pengaturan_akun_backend/update_password') ?>" method="POST">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <div class="row mb-3">
                                        <label for="current_password" class="col-form-label">Kata Sandi Saat Ini</label>
                                        <div class="col-12">
                                            <input type="password" name="current_password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="new_password" class="col-form-label">Kata Sandi Baru</label>
                                        <div class="col-12">
                                            <input type="password" name="new_password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="retype_password" class="col-form-label">Ulangi Kata Sandi Baru</label>
                                        <div class="col-12">
                                            <input type="password" name="retype_password" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary text-center">Ubah Kata Sandi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>