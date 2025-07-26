<!-- Main Content -->
<main id="main" class="main">
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Data Tagihan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('backend/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Data Tagihan</li>
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
    <?php if ($this->session->flashdata('struk')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('struk'); ?>
            <?php if ($this->session->flashdata('cetak_struk_url')): ?>
                <a href="<?= $this->session->flashdata('cetak_struk_url'); ?>" target="_blank">
                    Cetak Struk Pembayaran!
                </a>
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Section -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card h-100">
                    <div class="card-body pb-0">
                        <h5 class="card-title pb-0">Filter Tagihan Pelanggan</h5>
                        <p class="text-muted">
                            Gunakan fitur pencarian dan filter berikut untuk menampilkan data tagihan pelanggan sesuai dengan status pembayaran atau nomor kWh yang telah terdaftar dalam sistem.
                        </p>

                        <?= form_open('backend/tagihan', ['method' => 'GET', 'class' => '']) ?>
                        <div class="row g-3 align-items-center">

                            <!-- Filter Status -->
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status Pembayaran</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">-- Semua --</option>
                                    <option value="Menunggu Verifikasi" <?= set_select('status', 'Menunggu Verifikasi', isset($_GET['status']) && $_GET['status'] == 'Menunggu Verifikasi') ?>>Menunggu Verifikasi</option>
                                    <option value="Lunas" <?= set_select('status', 'Lunas', isset($_GET['status']) && $_GET['status'] == 'Lunas') ?>>Lunas</option>
                                    <option value="Belum Lunas" <?= set_select('status', 'Belum Lunas', isset($_GET['status']) && $_GET['status'] == 'Belum Lunas') ?>>Belum Lunas</option>
                                    <option value="Ditolak" <?= set_select('status', 'Ditolak', isset($_GET['status']) && $_GET['status'] == 'Ditolak') ?>>Ditolak</option>
                                </select>
                            </div>

                            <!-- Pencarian Nomor kWh -->
                            <div class="col-md-5">
                                <label for="nomor_kwh" class="form-label">Nomor kWh</label>
                                <input type="text" name="nomor_kwh" id="nomor_kwh" class="form-control" 
                                placeholder="Masukkan Nomor kWh"
                                value="<?= htmlspecialchars(set_value('nomor_kwh', $_GET['nomor_kwh'] ?? '')) ?>">
                            </div>

                            <!-- Tombol Submit & Reset -->
                            <div class="col-md-2">

                                <label for="nomor_kwh" class="form-label d-none d-md-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                            </div>

                            <div class="col-md-2">

                                <label for="nomor_kwh" class="form-label d-none d-md-block">&nbsp;</label>
                                <a href="<?= base_url('backend/tagihan') ?>" class="btn btn-secondary w-100">Reset</a>
                            </div>

                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title pb-0">Daftar Tagihan Pelanggan</h5>
                        <p class="text-muted ">Berikut adalah daftar tagihan pelanggan yang telah dimasukkan ke dalam sistem, mencakup informasi seperti nama pelanggan, periode tagihan, jumlah penggunaan listrik (kWh), dan status pembayaran.</p>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center text-nowrap">#</th>
                                        <th class="text-start text-nowrap">Nama Pelanggan</th>
                                        <th class="text-start text-nowrap">Periode Tagihan</th>
                                        <th class="text-start text-nowrap">Jumlah Meter</th>
                                        <th class="text-start text-nowrap">Status</th>
                                        <th id="export-none" class="text-center text-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tagihans)) : ?>
                                        <?php $no = 1; foreach ($tagihans as $tagihan) : ?>
                                            <tr>
                                                <td class="text-center text-nowrap"><?= $no++; ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($tagihan['nama_pelanggan']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($tagihan['bulan']); ?> - <?= htmlspecialchars($tagihan['tahun']); ?></td>
                                                <td class="text-start text-nowrap"><?= format_kwh($tagihan['jumlah_meter']); ?> kWh</td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($tagihan['status']); ?></td>
                                                <td id="export-none" class="text-center text-nowrap p-0">
                                                <!-- Tombol Bayar -->
                                                    <?php if ($tagihan['status'] === 'Belum Lunas') : ?>
                                                        <a href="#" class="btn btn-sm btn-success mt-md-1" data-bs-toggle="modal" data-bs-target="#detailTagihanModal<?= $tagihan['id_tagihan']; ?>">
                                                            <i class="bi bi-wallet2"></i>
                                                        </a>
                                                    <?php elseif ($tagihan['status'] === 'Lunas') : ?>
                                                        <!-- Tombol Cetak Struk -->
                                                        <a href="<?= site_url('backend/Tagihan_Backend/cetak_struk/' . $tagihan['id_tagihan']); ?>" class="btn btn-sm btn-primary mt-md-1" target="_blank">
                                                            <i class="bi bi-printer"></i>
                                                        </a>
                                                    <?php elseif ($tagihan['status'] === 'Menunggu Verifikasi') : ?>
                                                        <!-- Tombol Verifikasi -->
                                                        <!-- Tombol Verifikasi -->
                                                        <button type="button" class="btn btn-sm btn-warning mt-md-1" data-bs-toggle="modal" data-bs-target="#verifikasiModal<?= $tagihan['id_tagihan']; ?>">
                                                            <i class="bi bi-check-circle"></i>
                                                        </button>
                                                    <?php else : ?>
                                                        <!-- Tombol Detail -->
                                                        <a href="<?= site_url('backend/tagihan/detail/' . $tagihan['id_tagihan']); ?>" class="btn btn-sm btn-info mt-md-1">
                                                            <i class="bi bi-info-circle"></i> Detail
                                                        </a>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-sm btn-danger mt-md-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $tagihan['id_tagihan']; ?>">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal Hapus -->
<?php foreach ($tagihans as $tagihan) : ?>
    <div class="modal fade" id="deleteModal<?= $tagihan['id_tagihan']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus tagihan untuk pelanggan <strong><?= htmlspecialchars($tagihan['nama_pelanggan']); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('backend/Tagihan_Backend/delete/' . $tagihan['id_tagihan']); ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>



<div class="modal fade" id="detailTagihanModal<?= $tagihan['id_tagihan']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailTagihanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="detailTagihanModalLabel">
                    <i class="bi bi-receipt me-2"></i> Detail Tagihan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <!-- Informasi Pelanggan -->
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold mb-3">Informasi Pelanggan</h6>
                        <div class="mb-3">
                            <p class="small text-muted mb-1">Nama Pelanggan</p>
                            <p class="fw-bold"><?= htmlspecialchars($tagihan['nama_pelanggan']); ?></p>
                        </div>
                        <div class="mb-3">
                            <p class="small text-muted mb-1">Nomor kWh</p>
                            <p class="fw-bold"><?= htmlspecialchars($tagihan['nomor_kwh']); ?></p>
                        </div>
                        <div class="mb-3">
                            <p class="small text-muted mb-1">Alamat</p>
                            <p class="fw-bold"><?= htmlspecialchars($tagihan['alamat']); ?></p>
                        </div>
                        <!-- <div class="mb-3">
                            <p class="small text-muted mb-1">Periode Tagihan</p>
                            <p class="fw-bold"><?= htmlspecialchars($tagihan['bulan']); ?> - <?= htmlspecialchars($tagihan['tahun']); ?></p>
                        </div> -->
                    </div>

                    <!-- Rincian Tagihan -->
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold mb-3">Rincian Tagihan</h6>
                        <div class="mb-3">
                            <p class="small text-muted mb-1">Jumlah Meter</p>
                            <p class="fw-bold"><?= format_kwh($tagihan['jumlah_meter']); ?> kWh</p>
                        </div>
                        <div class="mb-3">
                            <p class="small text-muted mb-1">Tarif per kWh</p>
                            <p class="fw-bold"><?= rupiah($tagihan['tarifperkwh']); ?></p>
                        </div>
                        <div class="mb-3">
                            <p class="small text-muted mb-1">Biaya Admin</p>
                            <p class="fw-bold"><?= rupiah($biaya_admin); ?></p>
                        </div>
                        <div class="mb-3">
                            <p class="small text-muted mb-1">Total Bayar</p>
                            <p class="fw-bold text-primary"><?= rupiah(($tagihan['jumlah_meter'] * $tagihan['tarifperkwh']) + $biaya_admin); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i> Tutup
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#metodePembayaranModal<?= $tagihan['id_tagihan']; ?>">
                    <i class="bi bi-credit-card me-2"></i> Lanjut Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="metodePembayaranModal<?= $tagihan['id_tagihan']; ?>" tabindex="-1" role="dialog" aria-labelledby="metodePembayaranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="metodePembayaranModalLabel">
                    <i class="bi bi-wallet2 me-2"></i> Metode Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="<?= base_url('backend/Tagihan_Backend/bayar/' . $tagihan['id_tagihan']); ?>" method="POST">
                    <!-- Pilih Metode Pembayaran -->
                    <div class="mb-4">
                        <label for="metode_pembayaran" class="form-label fw-bold">
                            <i class="bi bi-credit-card me-2"></i> Pilih Metode Pembayaran
                        </label>
                        <select id="metode_pembayaran" name="metode_pembayaran" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Metode --</option>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                        <div class="invalid-feedback">Harap pilih metode pembayaran.</div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#detailTagihanModal<?= $tagihan['id_tagihan']; ?>">
                            <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i> Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade" id="verifikasiModal<?= $tagihan['id_tagihan']; ?>" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Tagihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($tagihan['nama_pelanggan']); ?></p>
                <p><strong>Periode Tagihan:</strong> <?= htmlspecialchars($tagihan['bulan']) . ' ' . htmlspecialchars($tagihan['tahun']); ?></p>
                <p><strong>Jumlah Meter (kWh):</strong> <?= number_format($tagihan['jumlah_meter'], 2); ?> kWh</p>
                <p><strong>Total Bayar:</strong> Rp <?= number_format(($tagihan['jumlah_meter'] * $tagihan['tarifperkwh']) + $biaya_admin, 2); ?></p>

                <!-- Bukti Pembayaran -->
                <?php if (!empty($tagihan['bukti_pembayaran'])) : ?>
                    <img src="<?= base_url('assets/img/bukti_pembayaran_pelanggan/' . $tagihan['bukti_pembayaran']); ?>" alt="Bukti Pembayaran" class="img-fluid mb-3">
                <?php else : ?>
                    <p>Tidak ada bukti pembayaran yang diunggah.</p>
                <?php endif; ?>

                <!-- Pilihan Metode Pembayaran -->
                <div class="mb-3">
                    <label for="metode_pembayaran_<?= $tagihan['id_tagihan']; ?>" class="form-label">Metode Pembayaran</label>
                    <select id="metode_pembayaran_<?= $tagihan['id_tagihan']; ?>" class="form-select">
                        <option value="Tunai">Tunai</option>
                        <option value="Transfer">Transfer</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Tombol Setujui -->
                <button class="btn btn-success" onclick="verifikasiTagihan(<?= $tagihan['id_tagihan']; ?>)">
                    <i class="bi bi-check-circle"></i> Setujui
                </button>
                <!-- Tombol Tolak -->
                <a href="<?= site_url('backend/tagihan_backend/verifikasi/' . $tagihan['id_tagihan'] . '/Belum Lunas'); ?>" class="btn btn-danger">
                    <i class="bi bi-x-circle"></i> Tolak
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function verifikasiTagihan(id_tagihan) {
    let metodePembayaran = document.getElementById('metode_pembayaran_' + id_tagihan).value;
    window.location.href = "<?= site_url('backend/tagihan_backend/verifikasi/') ?>" + id_tagihan + "/Lunas/" + encodeURIComponent(metodePembayaran);
}
</script>

<?php endforeach; ?>