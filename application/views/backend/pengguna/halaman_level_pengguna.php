<main id="main" class="main">
    <div class="pagetitle">
        <h1>Level Pengguna</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('backend/dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Level Pengguna</li>
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
                        <h5 class="card-title pb-0">Manajemen Level Pengguna</h5>
                        <p class="text-muted">
                            Kelola level akses pengguna dalam sistem. Anda dapat menambahkan level baru, mengubah detail level yang ada, atau menghapus level yang tidak lagi diperlukan.
                        </p>

                        <!-- Tombol Tambah Data (Modal) -->
                        <button type="button" class="btn btn-primary btn-sm mb-3 rounded-2" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus" aria-hidden="true"></i>
                            <span class="ms-1">Tambah Level Baru</span>
                        </button>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-start">ID Level</th>
                                        <th class="text-start">Nama Level</th>
                                        <th id="export-none" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($levels)) : ?>
                                        <?php $no = 1; foreach ($levels as $level) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-start"><?= htmlspecialchars($level['id_level']); ?></td>
                                                <td class="text-start"><?= htmlspecialchars($level['nama_level']); ?></td>
                                                <td id="export-none" class="text-center p-0">
                                                    <!-- Tombol Edit (Modal) -->
                                                    <button type="button" class="btn btn-primary btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $level['id_level'] ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <!-- Tombol Hapus (Modal) -->
                                                    <button type="button" class="btn btn-danger btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $level['id_level'] ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('backend/Level_Pengguna_Backend/create'); ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_level" class="form-label">Nama Level</label>
                        <input type="text" class="form-control" id="nama_level" name="nama_level" required />
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

<?php foreach ($levels as $level) : ?>
    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal<?= $level['id_level'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $level['id_level'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $level['id_level'] ?>">Edit Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('backend/Level_Pengguna_Backend/update/' . $level['id_level']); ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_level" class="form-label">Nama Level</label>
                            <input type="text" class="form-control" id="nama_level" name="nama_level" value="<?= htmlspecialchars($level['nama_level']); ?>" required />
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
    <div class="modal fade" id="deleteModal<?= $level['id_level'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $level['id_level'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $level['id_level'] ?>">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus level dengan nama <strong><?= htmlspecialchars($level['nama_level']); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('backend/Level_Pengguna_Backend/delete/' . $level['id_level']); ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>