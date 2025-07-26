<!-- Main Content -->
<main id="main" class="main">
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Data Penggunaan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('backend/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Data Penggunaan</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

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

    <!-- Section Filter -->
    <section class="row section-filter align-items-stretch">
        <div class="col-lg-8 mb-4 order-lg-0 order-1">
            <div class="card h-100">
                <div class="card-body pb-0">
                    <h5 class="card-title pb-0">Filter Penggunaan Listrik</h5>
                    <p class="text-muted">
                        Gunakan fitur pencarian dan filter berikut untuk menampilkan data penggunaan listrik sesuai dengan status pembayaran atau nomor KWH pelanggan.
                    </p>

                    <form method="GET" action="<?= base_url('backend/penggunaan'); ?>" class="row g-3 align-items-center pb-0" id="filter-form">

                        <div class="col-md-3">
                            <label for="status" class="form-label text-nowrap">Status Pembayaran</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">-- Semua --</option>
                                <option value="Lunas" <?= ($this->input->get('status') == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                                <option value="Belum Lunas" <?= ($this->input->get('status') == 'Belum Lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label for="nomor_kwh" class="form-label">Nomor KWH</label>
                            <input type="text" name="nomor_kwh" id="nomor_kwh" class="form-control" placeholder="Masukkan Nomor KWH" value="<?= htmlspecialchars($this->input->get('nomor_kwh')); ?>">
                        </div>

                        <div class="col-md-2">
                            <label for="terapkan" class="form-label d-none d-md-block">&nbsp;</label>
                            <button id="terapkan" type="submit" class="btn btn-primary w-100 text-nowrap">Terapkan</button>
                        </div>

                        <div class="col-md-2">
                            <span for="reset" class="form-label d-none d-md-block">&nbsp;</span>
                            <a href="<?= base_url('backend/penggunaan'); ?>" class="btn btn-secondary w-100 text-nowrap">Reset</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4 order-lg-1 order-0">
            <div class="card h-100">
                <div class="card-body pb-0">
                    <h5 class="card-title pb-0">Tambah Penggunaan Listrik</h5>
                    <p class="p-0 text-muted">
                        Tambahkan data penggunaan listrik baru untuk periode tertentu.
                    </p>
                    <label for="tambah-data" class="form-label d-none d-md-block">Tombol Tambah</label>
                    <button id="tambah-data" type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addModal">
                        <div class="d-flex justify-content-center gap-3">
                            <i class="bi bi-plus-square-dotted"></i>
                            <span class=""> Tambah Penggunaan Baru</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

    </section>

    <!-- Section Table-->
    <section class="section-table">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Card Title and Description -->
                        <h5 class="card-title pb-0">Tabel Data Penggunaan Listrik</h5>
                        <p class="text-muted mb-0">
                            Berikut adalah daftar penggunaan listrik yang tercatat dalam sistem. Gunakan tabel ini untuk melihat riwayat penggunaan, melakukan analisis, atau mengunduh data.  
                        </p>

                        <!-- Button Tambah Penggunaan Baru -->
                        <!-- <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="bi bi-plus" aria-hidden="true"></i>
                            <span class="ms-1">Tambah Penggunaan Baru</span>
                        </button> -->

                        <!-- Table with Stripped Rows -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-start text-nowrap">Nama Pelanggan</th>
                                        <th class="text-start text-nowrap">Bulan</th>
                                        <th class="text-start text-nowrap">Tahun</th>
                                        <th class="text-start text-nowrap">Meter Awal</th>
                                        <th class="text-start text-nowrap">Meter Akhir</th>
                                        <?php if (($user['level'] ?? '') === 'Administrator' || ($user['level'] ?? '') === 'Petugas'): ?>
                                            <th id="export-none" scope="col" class="text-center">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($penggunas)) : ?>
                                        <?php $no = 1; foreach ($penggunas as $pengguna) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pengguna['nama_pelanggan']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pengguna['bulan']); ?></td>
                                                <td class="text-start text-nowrap"><?= htmlspecialchars($pengguna['tahun']); ?></td>
                                                <td class="text-start text-nowrap"><?= format_kwh($pengguna['meter_awal']); ?> kWh</td>
                                                <td class="text-start text-nowrap"><?= format_kwh($pengguna['meter_akhir']); ?> kWh</td>
                                                <?php if (($user['level'] ?? '') === 'Administrator' || ($user['level'] ?? '') === 'Petugas'): ?>
                                                    <td id="export-none" class="text-center p-0">
                                                        <button type="button" class="btn btn-primary btn-sm mt-md-1" data-bs-toggle="modal" data-bs-target="#editModal<?= $pengguna['id_penggunaan'] ?>">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm mt-md-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $pengguna['id_penggunaan'] ?>">
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
                        <!-- End Table with Stripped Rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('backend/Penggunaan_Backend/create'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Penggunaan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Pelanggan Field -->
                    <div class="mb-3">
                        <label for="id_pelanggan" class="form-label">Pelanggan</label>
                        <select id="id_pelanggan" name="id_pelanggan" class="form-control" required>
                            <option value="">Pilih Pelanggan</option>
                            <?php foreach ($pelanggans as $pelanggan) : ?>
                                <option value="<?= $pelanggan['id_pelanggan']; ?>"><?= htmlspecialchars($pelanggan['nama_pelanggan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Bulan Field -->
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select id="bulan" name="bulan" class="form-control" required>
                            <option value="">Pilih Bulan</option>
                            <?php foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan) : ?>
                                <option value="<?= $bulan; ?>"><?= $bulan; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tahun Field -->
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" id="tahun" name="tahun" class="form-control" required />
                        <div id="error-message" class="text-danger small mt-1 d-none">Tahun tidak boleh lebih dari tahun saat ini.</div>
                    </div>
                    <script>
                        // Mendapatkan tahun saat ini
                        const currentYear = new Date().getFullYear();

                        // Mengisi nilai default input dengan tahun saat ini
                        const tahunInput = document.getElementById("tahun");
                        tahunInput.value = currentYear;

                        // Menambahkan atribut max untuk membatasi input tidak lebih dari tahun saat ini
                        tahunInput.setAttribute("max", currentYear);

                        // Menambahkan validasi tambahan menggunakan JavaScript
                        tahunInput.addEventListener("input", function () {
                            const errorMessage = document.getElementById("error-message");

                            if (parseInt(tahunInput.value) > currentYear) {
                                errorMessage.classList.remove("d-none"); // Menampilkan pesan error
                                tahunInput.setCustomValidity("Tahun tidak boleh lebih dari tahun saat ini.");
                            } else {
                                errorMessage.classList.add("d-none"); // Menyembunyikan pesan error
                                tahunInput.setCustomValidity(""); // Menghapus pesan validasi custom
                            }
                        });
                    </script>

                    <!-- Meter Awal Field -->
                    <div class="mb-3">
                        <label for="meter_awal" class="form-label">Meter Awal</label>
                        <input type="number" step="1" id="meter_awal" name="meter_awal" class="form-control" required>
                    </div>

                    <!-- Meter Akhir Field -->
                    <div class="mb-3">
                        <label for="meter_akhir" class="form-label">Meter Akhir</label>
                        <input type="number" step="1" id="meter_akhir" name="meter_akhir" class="form-control" required>
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

<!-- Modal Edit -->
<?php foreach ($penggunas as $pengguna) : ?>
    <div class="modal fade" id="editModal<?= $pengguna['id_penggunaan']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url('backend/Penggunaan_Backend/update/' . $pengguna['id_penggunaan']); ?>" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Perbaharui Penggunaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_pelanggan" class="form-label">Pelanggan</label>
                            <select name="id_pelanggan" class="form-control" disabled required>
                                <option value="">Pilih Pelanggan</option>
                                <?php foreach ($pelanggans as $pelanggan) : ?>
                                    <option value="<?= $pelanggan['id_pelanggan']; ?>" <?= ($pelanggan['id_pelanggan'] == $pengguna['id_pelanggan']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($pelanggan['nama_pelanggan']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" class="form-control" disabled required>
                                <option value="">Pilih Bulan</option>
                                <?php foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan) : ?>
                                    <option value="<?= $bulan; ?>" <?= ($bulan == $pengguna['bulan']) ? 'selected' : ''; ?>>
                                        <?= $bulan; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($pengguna['tahun']); ?>" disabled required>
                        </div>
                        <div class="mb-3">
                            <label for="meter_awal" class="form-label">Meter Awal</label>
                            <input name="meter_awal" class="form-control" value="<?=($pengguna['meter_awal']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="meter_akhir" class="form-label">Meter Akhir</label>
                            <input name="meter_akhir" class="form-control" value="<?=($pengguna['meter_akhir']); ?>" required>
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
<?php endforeach; ?>

<!-- Modal Hapus -->
<?php foreach ($penggunas as $pengguna) : ?>
    <div class="modal fade" id="deleteModal<?= $pengguna['id_penggunaan']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data penggunaan untuk pelanggan <strong><?= htmlspecialchars($pengguna['nama_pelanggan']); ?></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('backend/Penggunaan_Backend/delete/' . $pengguna['id_penggunaan']); ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>