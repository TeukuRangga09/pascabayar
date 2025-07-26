<?php
if (!function_exists('encrypt_id_tagihan')) {
    /**
     * Fungsi untuk mengenkripsi ID tagihan menjadi angka tetap
     *
     * @param int $id_tagihan ID tagihan asli
     * @return string Nomor invoice numerik tetap
     */
    function encrypt_id_tagihan($id_tagihan) {
        // Kunci enkripsi (harus dirahasiakan dan cukup kuat)
        $encryption_key = 'rahasia1234567890abcdefghijklmnopqrstuv'; // 32 karakter

        // Hash ID tagihan menggunakan HMAC-SHA256
        $hashed = hash_hmac('sha256', (string)$id_tagihan, $encryption_key);

        // Ambil 8 karakter pertama dari hash dan konversi ke angka
        $numeric_hash = hexdec(substr($hashed, 0, 8));

        // Tambahkan padding jika diperlukan untuk memastikan panjang tetap
        return str_pad($numeric_hash, 10, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('decrypt_id_tagihan')) {
    /**
     * Fungsi untuk mendekripsi nomor invoice numerik tetap menjadi ID tagihan asli
     *
     * @param string $numeric_invoice Nomor invoice numerik tetap
     * @return int|null ID tagihan asli atau null jika gagal
     */
    function decrypt_id_tagihan($numeric_invoice) {
        // Kunci enkripsi (harus sama dengan yang digunakan saat enkripsi)
        $encryption_key = 'rahasia1234567890abcdefghijklmnopqrstuv'; // 32 karakter

        // Cari ID tagihan asli berdasarkan numeric hash
        for ($id = 1; $id <= 1000000; $id++) { // Sesuaikan batas pencarian
            $encrypted = encrypt_id_tagihan($id);
            if ($encrypted === $numeric_invoice) {
                return $id; // Cocok, kembalikan ID tagihan asli
            }
        }

        return null; // Tidak ditemukan
    }
}
?>
<!-- Section Halaman Riwayat Pembayaran -->
<section class="section-pembayaran">
    <div class="container my-5 pt-5">
        <div class="row justify-content-center">
            <!-- Judul Section -->
            <div class="text-center">
                <h2 class="section-title fw-bold text-pc">Riwayat Pembayaran Listrik</h2>
                <p class="section-subtitle text-muted">Berikut adalah daftar riwayat pembayaran listrik Anda sebagai pelanggan.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 order-1 order-lg-0">
                <!-- Cards Container -->
                <div id="card-container">
                    <?php if (empty($riwayat_pembayaran)): ?>
                        <!-- Tampilan jika tidak ada data -->
                        <div class="card rounded-4 border-0 py-5">
                            <div class="d-flex flex-column justify-content-center align-items-center text-center">
                                <!-- Ikon Ilustrasi -->
                                <i class="bi bi-receipt-cutoff display-1 text-pc mb-3"></i>
                                <!-- Judul -->
                                <h5 class="fw-bold text-pc mb-2">Riwayat Pembayaran Kosong</h5>
                                <!-- Deskripsi -->
                                <p class="text-muted mb-4" style="max-width: 350px;">
                                    Saat ini belum ada riwayat pembayaran listrik yang tersedia, Jika anda baru saja melakukan pendaftaran silahkan klik 
                                    <a class="text-decoration-underline" target="_blank" href="https://api.whatsapp.com/send?phone=1234567890&text=Hello I need help!%0AApp Name: PayListrik%0A">Dukungan</a> untuk penyambungan listrik baru.
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Loop untuk menampilkan data -->
                        <?php foreach ($riwayat_pembayaran as $item): ?>
                            <div class="card border-0 rounded-4 overflow-hidden card-item mb-4" data-status="<?= $item->status_pembayaran ?>" data-bulan="<?= $item->bulan_bayar ?>" data-tahun="<?= date('Y', strtotime($item->tanggal_pembayaran)) ?>">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                        <h5 class="fw-bold mb-0"><?= $item->bulan_bayar ?> <?= date('Y', strtotime($item->tanggal_pembayaran)) ?></h5>
                                        <div class="position-absolute end-0 d-flex gap-3" style="top:-33%!important;">
                                            <div class="card rounded-3 shadow-none bg-bc p-1 ">
                                                <i class="bi bi-calendar2-event-fill text-primary fs-5 mx-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-nowrap overflow-auto">
                                        <div class="d-flex">
                                            <!-- Kolom 1: Informasi Meter -->
                                            <div class="col-6 col-md-4 mb-3">
                                                <div class="text-muted">
                                                    <p class="mb-1">Invoice</p>
                                                    <p class="fw-semibold mb-0">#<?= encrypt_id_tagihan($item->id_tagihan) ?></p>
                                                </div>
                                                <div class="mt-3 text-muted">
                                                    <p class="mb-1">Nomor KWH</p>
                                                    <p class="fw-semibold mb-0"><?= $item->nomor_kwh ?></p>
                                                </div>
                                                <div class="mt-3 text-muted">
                                                    <p class="mb-1">Jumlah Meter</p>
                                                    <p class="fw-semibold mb-0"><?= format_kwh($item->jumlah_meter) ?> kWh</p>
                                                </div>
                                            </div>

                                            <!-- Kolom 2: Detail Pembayaran -->
                                            <div class="col-6 col-md-4 mb-3">
                                                <div class="text-muted">
                                                    <p class="mb-1">Metode Pembayaran</p>
                                                    <p class="fw-semibold mb-0"><?= $item->metode_pembayaran ?></p>
                                                </div>
                                                <div class="mt-3 text-muted">
                                                    <p class="mb-1">Biaya Admin</p>
                                                    <p class="fw-semibold mb-0"><?= rupiah($item->biaya_admin) ?></p>
                                                </div>
                                                <div class="mt-3 text-muted">
                                                    <p class="mb-1">Total Bayar</p>
                                                    <p class="fw-bold text-primary mb-0"><?= rupiah($item->total_bayar) ?></p>
                                                </div>
                                            </div>

                                            <!-- Kolom 3: Status dan Aksi -->
                                            <div class="col-6 col-md-4 mb-3">
                                                <div class="text-muted">
                                                    <p class="mb-1">Status Pembayaran</p>
                                                    <p class="fw-bold <?= ($item->status_pembayaran == 'Lunas') ? 'text-success-new' : 'text-danger' ?> mb-0">
                                                        <?= $item->status_pembayaran ?> 
                                                        <span class="text-muted small fw-normal">- Terverifikasi <i class="bi bi-check-circle"></i></span>
                                                    </p>
                                                </div>
                                                <div class="mt-3 text-muted">
                                                    <a data-bs-toggle="modal" data-bs-target="#buktiModal" target="_blank" class="btn btn-outline-primary d-flex flex-column">
                                                        Bukti Upload
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="buktiModalLabel">Bukti Upload Pembayaran</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <?php if (!empty($item->bukti_pembayaran)) : ?>
                                                                        <img src="<?= base_url('assets/img/bukti_pembayaran_pelanggan/' . $item->bukti_pembayaran) ?>" alt="Bukti Pembayaran" class="img-fluid rounded">
                                                                    <?php else : ?>
                                                                        <p class="text-muted">Bukti Upload pembayaran tidak tersedia.</p>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3 text-muted">
                                                    <a href="<?= site_url('riwayat_pembayaran/struk/' . $item->id_tagihan); ?>" target="_blank" class="btn btn-primary d-flex flex-column">
                                                        Unduh Struk
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <!-- Mobile Chart -->
                <div class="card border-0 rounded-4 overflow-hidden d-lg-none">
                    <div class="card-body text-center p-4 pt-1">
                        <h5 class="card-title text-start mb-0 pb-0 ms-1 text-body">Grafik Pembayaran</h5>
                        <div class="chart-container" style="position: relative; height: 300px; width: 100%">
                            <canvas id="paymentChartMobile"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart & Filter Section -->
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 mb-4 order-0 order-lg-1 overflow-hidden">
                    <div class="card-header d-flex justify-content-start border-bottom-0 py-0 my-0 pt-3 ms-1">
                        <h5 class="card-title text-body py-0 my-0">Filter Riwayat Pembayaran</h5>
                    </div>
                    <div class="card-body p-3 text-center d-flex justify-content-between gap-3">
                        <select id="filter-bulan" class="form-select text-muted">
                            <option value="all">Semua Bulan</option>
                            <?php foreach (array_unique(array_column($riwayat_pembayaran, 'bulan_bayar')) as $bulan): ?>
                                <option value="<?= $bulan ?>"><?= $bulan ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select id="filter-tahun" class="form-select text-muted">
                            <option value="all">Semua Tahun</option>
                            <?php foreach (array_unique(array_map(function($item) {
                                return date('Y', strtotime($item->tanggal_pembayaran));
                            }, $riwayat_pembayaran)) as $tahun): ?>
                                <option value="<?= $tahun ?>"><?= $tahun ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card border-0 rounded-4 overflow-hidden d-none d-lg-block">
                    <div class="card-body text-center p-4 pt-1">
                        <h5 class="card-title text-start mb-0 pb-0 ms-1 text-body">Grafik Pembayaran</h5>
                        <div class="chart-container" style="position: relative; height: 300px; width: 100%">
                            <canvas id="paymentChartDesktop"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sertakan Chart.js -->
<script src="<?= base_url('assets/vendor/chart.js/chart.umd.js') ?>"></script>
<script>
    function formatRupiah(value) {
        // Bulatkan ke bawah dan hilangkan desimal
        const formattedValue = Math.floor(value);
        return 'Rp ' + formattedValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.addEventListener("DOMContentLoaded", function () {
        const paymentData = <?= json_encode(array_map(function ($item) {
            return [
                'bulan_bayar' => $item->bulan_bayar,
                'total_bayar' => $item->total_bayar
            ];
        }, $riwayat_pembayaran)) ?>;

        const labels = paymentData.map(item => item.bulan_bayar);
        const data = paymentData.map(item => item.total_bayar);

        function createChart(canvasId) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Pembayaran (Rp)',
                        data: data,
                        backgroundColor: '#0D6EFD',
                        borderColor: '#fff',
                        borderWidth: 2,
                        borderRadius: 7,
                        barThickness: 'flex'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            font: { size: 16, weight: 'bold' }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return ` Total: ${formatRupiah(context.raw)}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value =>formatRupiah(value),
                                font: { size: 12 }
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 12 }
                            }
                        }
                    }
                }
            });
        }

        createChart('paymentChartMobile');
        createChart('paymentChartDesktop');

        document.querySelectorAll('#filter-bulan, #filter-tahun').forEach(element => {
            element.addEventListener('change', function () {
                const bulan = document.getElementById('filter-bulan').value;
                const tahun = document.getElementById('filter-tahun').value;

                document.querySelectorAll('.card-item').forEach(card => {
                    const cardBulan = card.getAttribute('data-bulan');
                    const cardTahun = card.getAttribute('data-tahun');

                    if ((bulan === 'all' || cardBulan === bulan) && (tahun === 'all' || cardTahun === tahun)) {
                        card.classList.remove('d-none');
                    } else {
                        card.classList.add('d-none');
                    }
                });
            });
        });
    });
</script>
