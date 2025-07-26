<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tarif Listrik</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url('backend/dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Tarif Listrik</li>
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
                        <!-- Informasi Daftar Tarif Listrik -->
                        <h5 class="card-title pb-0">Daftar Tarif Listrik</h5>
                        <p class="text-muted">
                            Berikut adalah daftar tarif listrik PLN berdasarkan daya yang berlaku pada tahun 2024.
                            Data ini bersumber dari PLN Indonesia dan dapat berubah sewaktu-waktu. 
                            <i>&ndash; Sumber: 
                                <a href="https://www.aslinews.id/ekonomi/98843265/desember-2024-ini-besar-tarif-listrik-pln-sejak-oktober-desember-2024-dari-tarif-rumah-tangga-bisnis-industri-hingga-kantor-pemerintahan" target="_blank">
                                    Aslinews - Tarif Listrik PLN 2024
                                </a>
                            </i>
                        </p>

                        <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                            <!-- Tombol Tambah Tarif (Hanya untuk Administrator) -->
                            <button type="button" class="btn btn-primary btn-sm mb-3 rounded-2" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="bi bi-plus" aria-hidden="true"></i>
                                <span class="ms-1">Tambah Tarif Baru</span>
                            </button>
                        <?php endif; ?>

                        <!-- Table with stripped rows -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-start text-nowrap">Daya</th>
                                        <th class="text-start text-nowrap">Tarif/kWh</th>
                                        <th class="text-start text-nowrap">Deskripsi</th>
                                        <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                                            <th id="export-none" class="text-center">Aksi</th>
                                        <?php endif;?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tarif_list)) : ?>
                                        <?php $no = 1; foreach ($tarif_list as $tarif) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-start"><?= htmlspecialchars($tarif->daya); ?></td>
                                                <td class="text-start"><?= rupiah($tarif->tarifperkwh); ?></td>
                                                <td class="text-start"><?= htmlspecialchars($tarif->deskripsi ?? '-'); ?></td>
                                                <?php if (($user['level'] ?? '') === 'Administrator'): ?>
                                                    <td id="export-none" class="text-center p-0">
                                                        <button type="button" class="btn btn-primary btn-sm mt-lg-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $tarif->id_tarif ?>">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm mt-lg-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $tarif->id_tarif ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                <?php endif;?>
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
                <h5 class="modal-title" id="addModalLabel">Tambah Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('backend/tarif_listrik_backend/add'); ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="daya" class="form-label">Daya</label>
                        <input type="text" class="form-control" id="daya" name="daya" required />
                    </div>
                    <div class="mb-3">
                        <label for="tarifperkwh" class="form-label">Tarif per kWh</label>
                        <input type="number" step="0.01" class="form-control" id="tarifperkwh" name="tarifperkwh" required />
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
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

<?php foreach ($tarif_list as $tarif) : ?>
    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal<?= $tarif->id_tarif ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $tarif->id_tarif ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $tarif->id_tarif ?>">Edit Tarif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('backend/tarif_listrik_backend/update/' . $tarif->id_tarif); ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="daya" class="form-label">Daya</label>
                            <input type="text" class="form-control" id="daya" name="daya" value="<?= htmlspecialchars($tarif->daya); ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="tarifperkwh" class="form-label">Tarif per kWh</label>
                            <input type="number" step="0.01" class="form-control" id="tarifperkwh" name="tarifperkwh" value="<?= $tarif->tarifperkwh; ?>" required />
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi"><?= htmlspecialchars($tarif->deskripsi); ?></textarea>
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
    <div class="modal fade" id="deleteModal<?= $tarif->id_tarif ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $tarif->id_tarif ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel<?= $tarif->id_tarif ?>">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus tarif dengan daya <strong><?= htmlspecialchars($tarif->daya); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('backend/tarif_listrik_backend/delete/' . $tarif->id_tarif); ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>