<main id="main" class="main">
    <div class="pagetitle">
        <h1>Kelola Pengguna</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('backend/dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= str_replace('<p>', '', str_replace('</p>', '', $this->session->flashdata('error'))); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title pb-0">Manajemen Pengguna</h5>
                        <p class="text-muted">
                            Kelola akun pengguna yang memiliki akses ke sistem. Anda dapat menambahkan, mengedit, atau menghapus pengguna sesuai kebutuhan.
                        </p>

                        <!-- Tombol Tambah Data (Modal) -->
                        <button type="button" class="btn btn-primary btn-sm mb-3 rounded-2" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus" aria-hidden="true"></i>
                            <span class="ms-1">Tambah Pengguna Baru</span>
                        </button>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-start text-nowrap">Username</th>
                                        <th class="text-start text-nowrap">Nama Admin</th>
                                        <th class="text-start text-nowrap">Email</th>
                                        <th class="text-start text-nowrap">Level</th>
                                        <th id="export-none" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)) : ?>
                                        <?php $no = 1; foreach ($users as $user) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($user['username']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($user['nama_admin']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($user['email']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($user['nama_level']); ?></td>
                                                <td id="export-none" class="text-center p-0">
                                                    <!-- Tombol Edit (Modal) -->
                                                    <button type="button" class="btn btn-primary btn-sm mt-lg-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['id_user'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <!-- Tombol Hapus (Modal) -->
                                                    <button type="button" class="btn btn-danger btn-sm mt-lg-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $user['id_user'] ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- End #main -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('backend/Kelola_Pengguna_Backend/create'); ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required />
                    </div>
                    <div class="mb-3">
                        <label for="nama_admin" class="form-label">Nama Admin</label>
                        <input type="text" class="form-control" id="nama_admin" name="nama_admin" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>
                    <div class="mb-3">
                        <label for="id_level" class="form-label">Level</label>
                        <select class="form-select" id="id_level" name="id_level" required>
                            <option value="">Pilih Level</option>
                            <?php foreach ($levels as $level) : ?>
                                <option value="<?= $level['id_level']; ?>"><?= $level['nama_level']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($users as $user) : ?>
    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal<?= $user['id_user'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $user['id_user'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $user['id_user'] ?>">Edit Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('backend/Kelola_Pengguna_Backend/update/' . $user['id_user']); ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username_<?= $user['id_user'] ?>" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username_<?= $user['id_user'] ?>" name="username" value="<?= htmlspecialchars($user['username']); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="password_<?= $user['id_user'] ?>" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password_<?= $user['id_user'] ?>" name="password" />
                        </div>
                        <div class="mb-3">
                            <label for="nama_admin_<?= $user['id_user'] ?>" class="form-label">Nama Admin</label>
                            <input type="text" class="form-control" id="nama_admin_<?= $user['id_user'] ?>" name="nama_admin" value="<?= htmlspecialchars($user['nama_admin']); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="email_<?= $user['id_user'] ?>" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_<?= $user['id_user'] ?>" name="email" value="<?= htmlspecialchars($user['email']); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="id_level_<?= $user['id_user'] ?>" class="form-label">Level</label>
                            <select class="form-select" id="id_level_<?= $user['id_user'] ?>" name="id_level" required>
                                <option value="">Pilih Level</option>
                                <?php foreach ($levels as $level) : ?>
                                    <option value="<?= $level['id_level']; ?>" <?= ($level['id_level'] == $user['id_level']) ? 'selected' : ''; ?>>
                                        <?= $level['nama_level']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Hapus Data -->
    <div class="modal fade" id="deleteModal<?= $user['id_user'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $user['id_user'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $user['id_user'] ?>">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pengguna dengan username <strong><?= htmlspecialchars($user['username']); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('backend/Kelola_Pengguna_Backend/delete/' . $user['id_user']); ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>