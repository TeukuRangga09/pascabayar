<main id="main" class="main">
    <div class="pagetitle">
        <h1>Data Pelanggan</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('backend/dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Pelanggan</li>
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
    <section class="section-table">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                            <!-- Administrator View -->
                            <h5 class="card-title pb-0">Kelola Data Pelanggan Terdaftar</h5>
                            <p class="text-muted">
                                Anda memiliki kendali penuh atas data pelanggan. Tambah data baru, edit informasi yang ada, dan atur akses ke data sesuai kebutuhan.
                            </p>

                            <button type="button" class="btn btn-primary btn-sm mb-3 rounded-2" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="bi bi-plus" aria-hidden="true"></i>
                                <span class="ms-1">Tambah Pelanggan Baru</span>
                            </button>
                        <?php elseif (($user['level'] ?? '') === 'Petugas'): ?>
                            <!-- Petugas View -->
                            <h5 class="card-title pb-0">Pelanggan Terdaftar</h5>
                            <p class="text-muted">
                                Berikut adalah daftar data pelanggan. Petugas dapat melihat informasi detail pelanggan untuk keperluan pelayanan dan informasi.
                            </p>
                        <?php endif; ?>


                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center text-nowrap">#</th>
                                        <th class="text-start text-nowrap">Username</th>
                                        <th class="text-start text-nowrap">Nomor KWH</th>
                                        <th class="text-start text-nowrap">Nama Pelanggan</th>
                                        <th class="text-start text-nowrap">Telepon</th>
                                        <th class="text-start text-nowrap">Alamat</th>
                                        <th class="text-start text-nowrap">Email</th>
                                        <th class="text-start text-nowrap">Daya</th>
                                        <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                                            <th id="export-none" class="text-center">Aksi</th>
                                        <?php endif;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pelanggans)) : ?>
                                        <?php $no = 1; foreach ($pelanggans as $pelanggan) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pelanggan['username']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pelanggan['nomor_kwh']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pelanggan['nama_pelanggan']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pelanggan['telepon'] ?? '-'); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pelanggan['alamat']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pelanggan['email'] ?? '-'); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pelanggan['daya']); ?> (<?= rupiah($pelanggan['tarifperkwh']); ?>/kWh)</td>
                                                <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                                                    <td id="export-none" class="text-center p-0">
                                                            <!-- Tombol Edit (Modal) -->
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $pelanggan['id_pelanggan'] ?>">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <!-- Tombol Hapus (Modal) -->
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $pelanggan['id_pelanggan'] ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                    </td>
                                                <?php endif; ?>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('backend/Pelanggan_Backend/create'); ?>" method="POST">
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
                        <label for="nomor_kwh" class="form-label">Nomor KWH</label>
                        <input type="text" class="form-control" id="nomor_kwh" name="nomor_kwh" value="<?= isset($nomor_kwh) ? $nomor_kwh : ''; ?>" required readonly />
                    </div>
                    <div class="mb-3">
                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required />
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" />
                    </div>
                    <div class="mb-3">
                        <label for="id_tarif" class="form-label">Tarif</label>
                        <select class="form-select" id="id_tarif" name="id_tarif" required>
                            <option value="">Pilih Tarif</option>
                            <?php foreach ($tarifs as $tarif) : ?>
                                <option value="<?= $tarif['id_tarif']; ?>">
                                    <?= $tarif['daya']; ?> (<?= rupiah($tarif['tarifperkwh']); ?>/kWh)
                                </option>
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

<?php foreach ($pelanggans as $pelanggan) : ?>
    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal<?= $pelanggan['id_pelanggan'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $pelanggan['id_pelanggan'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $pelanggan['id_pelanggan'] ?>">Edit Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('backend/Pelanggan_Backend/update/' . $pelanggan['id_pelanggan']); ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username_<?= $pelanggan['id_pelanggan'] ?>" name="username" value="<?= htmlspecialchars($pelanggan['username']); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="password_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password_<?= $pelanggan['id_pelanggan'] ?>" name="password" />
                        </div>
                        <div class="mb-3">
                            <label for="nomor_kwh_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Nomor KWH</label>
                            <input type="text" class="form-control" id="nomor_kwh_<?= $pelanggan['id_pelanggan'] ?>" name="nomor_kwh" value="<?= htmlspecialchars($pelanggan['nomor_kwh']); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="nama_pelanggan_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="nama_pelanggan_<?= $pelanggan['id_pelanggan'] ?>" name="nama_pelanggan" value="<?= htmlspecialchars($pelanggan['nama_pelanggan']); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="alamat_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat_<?= $pelanggan['id_pelanggan'] ?>" name="alamat" required><?= htmlspecialchars($pelanggan['alamat']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="telepon_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon_<?= $pelanggan['id_pelanggan'] ?>" name="telepon" value="<?= htmlspecialchars($pelanggan['telepon']); ?>" />
                        </div>
                        <div class="mb-3">
                            <label for="email_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_<?= $pelanggan['id_pelanggan'] ?>" name="email" value="<?= htmlspecialchars($pelanggan['email']); ?>" />
                        </div>
                        <div class="mb-3">
                            <label for="id_tarif_<?= $pelanggan['id_pelanggan'] ?>" class="form-label">Tarif</label>
                            <select class="form-select" id="id_tarif_<?= $pelanggan['id_pelanggan'] ?>" name="id_tarif" required>
                                <option value="">Pilih Tarif</option>
                                <?php foreach ($tarifs as $tarif) : ?>
                                    <option value="<?= $tarif['id_tarif']; ?>" <?= ($tarif['id_tarif'] == $pelanggan['id_tarif']) ? 'selected' : ''; ?>>
                                        <?= $tarif['daya']; ?> (<?= rupiah($tarif['tarifperkwh']); ?>/kWh)
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
    <div class="modal fade" id="deleteModal<?= $pelanggan['id_pelanggan'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $pelanggan['id_pelanggan'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $pelanggan['id_pelanggan'] ?>">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus pelanggan dengan nama <strong><?= htmlspecialchars($pelanggan['nama_pelanggan']); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('backend/Pelanggan_Backend/delete/' . $pelanggan['id_pelanggan']); ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>