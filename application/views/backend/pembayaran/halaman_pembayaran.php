<main id="main" class="main">
    <div class="pagetitle">
        <h1>Riwayat Pembayaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('backend/dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Pembayaran</li>
            </ol>
        </nav>
    </div>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= str_replace('<p>', '', str_replace('</p>', '', $this->session->flashdata('error'))); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Section Filter -->
    <section class="section-filter">
        <div class="row align-items-stretch mb-4">
            <div class="col-md-7 order-md-0 order-1">
                <div class="card h-100">
                    <div class="card-body pb-0">
                        <h5 class="card-title mb-0 pb-1">Filter Riwayat Pembayaran</h5>
                        <p class="text-muted mt-0 p-0">Gunakan filter ini untuk menampilkan riwayat pembayaran berdasarkan bulan dan tahun tertentu.</p>

                        <form method="get" action="<?= base_url('backend/pembayaran'); ?>" class="row g-3">
                            <?php
                            $tahun_sekarang = date('Y');
                            $bulan_sekarang = date('n');
                            $filter_tahun = $filter_tahun ?? $tahun_sekarang;
                            $filter_bulan = $filter_bulan ?? $bulan_sekarang;
                            ?>

                            <div class="col-md-4">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="form-control"
                                value="<?= htmlspecialchars($filter_tahun); ?>" 
                                min="2000" max="<?= $tahun_sekarang; ?>" 
                                placeholder="Masukkan Tahun">
                            </div>

                            <div class="col-md-4">
                                <label for="bulan" class="form-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select">
                                    <option value="">-- Pilih Bulan --</option>
                                    <?php
                                    $nama_bulan = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    foreach ($nama_bulan as $num => $nama) {
                                        $selected = ($filter_bulan == $num) ? 'selected' : '';
                                        echo "<option value=\"$num\" $selected>$nama</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4 align-self-end">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-5 order-md-1 order-0 mb-4 mb-md-0">
                <div class="card info-card sales-card h-100">
                    <div class="dashboard">
                        <div class="sales-card">
                            <div class="card-body">
                                <h5 class="card-title mb-0 pb-1">Pemasukan</h5>
                                <p class="text-muted mt-0 p-0">Pemasukan akan ditampilkan berdasarkan filter bulan dan tahun yang dipilih.</p>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                    <div class="ps-3">
                                        <div class="dashboard">
                                            <div class="info-card pb-0">
                                                <?php 
                                                function hitungTotalPembayaran($pembayarans) {
                                                    $total_pembayaran = array_sum(array_column($pembayarans, 'total_bayar'));
                                                    $total_record = count($pembayarans);

                                                    return [
                                                        'total_pembayaran' => $total_pembayaran,
                                                        'total_record' => $total_record
                                                    ];
                                                }

                                                $hasil = hitungTotalPembayaran($pembayarans);
                                                $total_pembayaran = $hasil['total_pembayaran'];
                                                $total_record = $hasil['total_record'];

                                                ?>
                                                <h6><?= rupiah($total_pembayaran); ?></h6>
                                            </div>
                                        </div>
                                        <span class="text-success small pt-1 fw-bold"><?=$total_record;?> Transaksi</span> <span class="text-muted small pt-2 ps-1">pada Tabel</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title pb-0">Daftar Riwayat Pembayaran</h5>
            <p class="text-muted mt-0 p-0">Tabel ini menampilkan daftar riwayat pembayaran pelanggan, termasuk bulan, tahun, jumlah pembayaran, dan statusnya. Gunakan filter di atas untuk melihat data berdasarkan periode tertentu.</p>

            <div class="table-responsive">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th class="text-nowrap text-center">#</th>
                            <th class="text-nowrap text-start">Nama Pelanggan</th>
                            <th class="text-nowrap text-start">Periode Tagihan</th>
                            <th class="text-nowrap text-start">Tanggal Pembayaran</th>
                            <th class="text-nowrap text-start">Total Bayar</th>
                            <th class="text-nowrap text-start">Metode Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pembayarans)) : ?>
                            <?php $no = 1; foreach ($pembayarans as $pembayaran) : ?>
                                <tr>
                                    <td class="text-nowrap text-start"><?= $no++; ?></td>
                                    <td class="text-nowrap text-start"><?= htmlspecialchars($pembayaran['nama_pelanggan']); ?></td>
                                    <td class="text-nowrap text-start"><?= htmlspecialchars($pembayaran['bulan_bayar']); ?> - <?= htmlspecialchars($pembayaran['tahun']); ?></td>
                                    <td class="text-nowrap text-start"><?= format_tanggal_id($pembayaran['tanggal_pembayaran']); ?></td>
                                    <td class="text-nowrap text-start"><?= rupiah($pembayaran['total_bayar']); ?></td>
                                    <td class="text-nowrap text-start"><?= htmlspecialchars($pembayaran['metode_pembayaran']); ?></td>
                                    <td class="text-center text-nowrap p-0">
                                        <!-- Tombol Hapus -->
                                        <button type="button" class="btn btn-danger btn-sm mt-md-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $pembayaran['id_pembayaran']; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade" id="deleteModal<?= $pembayaran['id_pembayaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus pembayaran untuk pelanggan <strong><?= htmlspecialchars($pembayaran['nama_pelanggan']); ?></strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <a href="<?= base_url('backend/Pembayaran_Backend/delete/' . $pembayaran['id_pembayaran']); ?>" class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>