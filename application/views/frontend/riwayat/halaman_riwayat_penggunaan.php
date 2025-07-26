<section class="section-penggunaan">
    <div class="container my-5 pt-5">
        <div class="row justify-content-center">
            <!-- Judul Section -->
            <div class="text-center">
                <h2 class="section-title fw-bold text-pc">Riwayat Penggunaan Listrik</h2>
                <p class="section-subtitle text-muted">Berikut adalah daftar riwayat penggunaan listrik Anda sebagai pelanggan.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 order-1 order-lg-0">
                <!-- Cards Container -->
                <div id="card-container">
                    <?php if (empty($riwayat_penggunaan)): ?>
                        <!-- Tampilan jika tidak ada data -->
                        <div class="card rounded-4 border-0 py-5">
                            <div class="d-flex flex-column justify-content-center align-items-center text-center">
                                <!-- Ikon Ilustrasi -->
                                <i class="bi bi-clock-history display-1 text-pc mb-3"></i>
                                <!-- Judul -->
                                <h5 class="fw-bold text-pc mb-2">Riwayat Penggunaan Kosong</h5>
                                <!-- Deskripsi -->
                                <p class="text-muted mb-4" style="max-width: 350px;">
                                    Saat ini belum ada riwayat penggunaan listrik yang tersedia, Jika anda baru saja melakukan pendaftaran silahkan klik 
                                    <a class="text-decoration-underline" target="_blank" href="https://api.whatsapp.com/send?phone=1234567890&text=Hello I need help!%0AApp Name: PayListrik%0A">Dukungan</a> untuk penyambungan listrik baru.
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Loop untuk menampilkan data -->
                        <?php foreach ($riwayat_penggunaan as $item): ?>
                            <div class="card border-0 rounded-4 overflow-hidden card-item mb-4" data-status="<?= $item->status_pembayaran ?>" data-bulan="<?= $item->bulan ?>" data-tahun="<?= $item->tahun ?>">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3 position-relative">
                                        <h5 class="fw-bold mb-0"><?= $item->bulan ?> <?= $item->tahun ?></h5>
                                        <div class="position-absolute end-0 top-0">
                                            <div class="card rounded-3 shadow-none bg-bc p-1">
                                                <i class="bi bi-calendar2-event-fill text-primary fs-5 mx-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-muted">
                                        <div class="col">
                                            <p class="mb-1">Meter Awal - Akhir</p>
                                            <p class="fw-semibold mb-0"><?= $item->meter_awal ?> - <?= $item->meter_akhir ?></p>
                                        </div>
                                        <div class="col">
                                            <p class="mb-1">Jumlah Meter</p>
                                            <p class="fw-semibold mb-0"><?= $item->jumlah_meter ?> kWh</p>
                                        </div>
                                    </div>
                                    <div class="row text-muted mt-3">
                                        <div class="col">
                                            <p class="mb-1">Tarif per kWh</p>
                                            <p class="fw-semibold mb-0"><?= rupiah($item->tarifperkwh) ?></p>
                                        </div>
                                        <div class="col">
                                            <p class="mb-1">Daya Listrik</p>
                                            <p class="fw-bold text-primary mb-0"><?= ($item->tipe_daya) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="card border-0 rounded-4 overflow-hidden d-lg-none">
                    <div class="card-body text-center p-4 pt-1">
                        <h5 class="card-title text-start mb-0 pb-0 ms-1 text-body">Grafik Penggunaan</h5>
                        <div class="chart-container" style="position: relative; height: 300px; width: 100%">
                            <canvas id="usageChartMobile"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 mb-4 order-0 order-lg-1 overflow-hidden">
                    <div class="card-header d-flex justify-content-start border-bottom-0 py-0 my-0 pt-3 ms-1">
                        <h5 class="card-title text-body py-0 my-0">Filter Riwayat Penggunaan</h5>
                    </div>
                    <div class="card-body p-3 text-center d-flex justify-content-between gap-3">
                        <select id="filter-bulan" class="form-select text-muted">
                            <option value="all">Semua Bulan</option>
                            <?php foreach (array_unique(array_column($riwayat_penggunaan, 'bulan')) as $bulan): ?>
                                <option value="<?= $bulan ?>"><?= $bulan ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select id="filter-tahun" class="form-select text-muted">
                            <option value="all">Semua Tahun</option>
                            <?php foreach (array_unique(array_column($riwayat_penggunaan, 'tahun')) as $tahun): ?>
                                <option value="<?= $tahun ?>"><?= $tahun ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="card border-0 rounded-4 overflow-hidden d-none d-lg-block">
                    <div class="card-body text-center p-4 pt-1">
                        <h5 class="card-title text-start mb-0 pb-0 ms-1 text-body">Grafik Penggunaan</h5>
                        <div class="chart-container" style="position: relative; height: 300px; width: 100%">
                            <canvas id="usageChartDesktop"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url('assets/vendor/chart.js/chart.umd.js') ?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const usageData = <?= json_encode(array_map(function ($item) {
            return [
                'bulan' => $item->bulan,
                'jumlah_meter' => $item->jumlah_meter
            ];
        }, $riwayat_penggunaan)) ?>;

        const labels = usageData.map(item => item.bulan);
        const data = usageData.map(item => item.jumlah_meter);

        function createChart(canvasId) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Penggunaan Listrik (kWh)',
                        data: data,
                        backgroundColor: '#0D6EFD',
                        borderColor: '#fff',
                        borderWidth: 2,
                        borderRadius: 7,
                        barThickness: 'flex',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            // text: 'Grafik Penggunaan Listrik Bulanan',
                            font: { size: 16, weight: 'bold' } ,
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return ` Pemakaian: ${context.raw} kWh`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => value + ' kWh',
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

        createChart('usageChartMobile');
        createChart('usageChartDesktop');

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
