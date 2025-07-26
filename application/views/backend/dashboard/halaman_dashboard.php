<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!--  -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-lg-6 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Penggunaan Listrik <span>| Tahun ini</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-plug-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= format_kwh($penggunaan_statistics['total_kwh'] ?? 0) ?> kWh</h6>
                                        <span class="text-success small pt-1 fw-bold"><?= number_format($penggunaan_statistics['total_record'] ?? 0) ?></span> <span class="text-muted small pt-2 ps-1">Pemakaian Listrik</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Sales Card -->

                    <!-- Pelanggan Card -->
                    <div class="col-lg-6 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Pelanggan <span>| Tahun ini</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 class="fw-bold"><?= $total_pelanggan_tahun_ini['total_pelanggan'] ?? 0 ?></h6>
                                        <!-- <span class="text-danger small pt-1 fw-bold">12%</span> -->
                                        <span class="text-muted small">Total Pelanggan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Pelanggan Card -->

                    <!-- Revenue Card -->
                    <div class="col-lg-12 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Pemasukan <span>| Tahun ini</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <span class="fs-4 fw-bold mb-1">Rp</span>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= rupiah($pembayaran_statistics['total_pembayaran'] ?? 0) ?></h6>
                                        <span class="text-success small pt-1 fw-bold"><?= $pembayaran_statistics['total_record'] ?? 0 ?>
                                            <!-- <i class="ri ri-record-circle-line text-danger"></i> -->
                                        </span>
                                        <span class="text-muted small pt-2 ps-1">Transaksi Pembayaran</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Revenue Card -->

                    <!-- <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Pembayaran Tahun <?= date('Y') ?></h5>
                            <p class="card-text">   Total Pembayaran    Rp <?= number_format($pembayaran_statistics['total_pembayaran'] ?? 0, 2) ?></p>
                            <p class="card-text">   Total Record Pembayaran     <?= $pembayaran_statistics['total_record'] ?? 0 ?> record</p>
                        </div>
                    </div> -->

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <h5 class="card-title">Penggunaan Listrik <span>| Tahun ini</span></h5>
                                <!-- Line Chart -->
                                <div id="reportsChart"></div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const monthlyUsage = <?php echo json_encode($monthly_usage); ?>;
                                        // Parsing data untuk grafik
                                        const categories = monthlyUsage.map(item => item.bulan);
                                        const totalUsage = monthlyUsage.map(item => parseFloat(item.total_usage));
                                        const averageUsage = totalUsage.map((val, index, arr) => {
                                            const sum = arr.slice(0, index + 1).reduce((a, b) => a + b, 0);
                                            return (sum / (index + 1)).toFixed(2);
                                        });
                                        new ApexCharts(document.querySelector("#reportsChart"), {
                                            series: [
                                                {
                                                    name: "Total Penggunaan (kWh)",
                                                    data: totalUsage,
                                                },
                                                {
                                                    name: "Rata-rata Penggunaan (kWh)",
                                                    data: averageUsage,
                                                }
                                            ],
                                            chart: {
                                                height: 350,
                                                type: "line",
                                                toolbar: {
                                                    show: true,
                                                    tools: {
                                                        download: true,
                                                        selection: true,
                                                        zoom: true,
                                                        zoomin: true,
                                                        zoomout: true,
                                                        pan: true,
                                                        reset: true,
                                                    },
                                                },
                                                animations: {
                                                    enabled: true,
                                                    easing: 'easeinout',
                                                    speed: 800,
                                                }
                                            },
                                            markers: {
                                                size: 5,
                                                hover: {
                                                    size: 8,
                                                }
                                            },
                                            colors: ["#4154f1", "#ff4560"],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                    shadeIntensity: 1,
                                                    opacityFrom: 0.8,
                                                    opacityTo: 0.5,
                                                    stops: [0, 90, 100],
                                                },
                                            },
                                            dataLabels: {
                                                enabled: true,
                                                formatter: (val) => val + " kWh",
                                            },
                                            stroke: {
                                                curve: "smooth",
                                                width: 3,
                                            },
                                            xaxis: {
                                                categories: categories,
                                                title: {
                                                    text: "Bulan",
                                                },
                                            },
                                            yaxis: {
                                                title: {
                                                    text: "Penggunaan (kWh)",
                                                },
                                                labels: {
                                                    formatter: (val) => val.toFixed(0) + " kWh",
                                                }
                                            },
                                            tooltip: {
                                                shared: true,
                                                intersect: false,
                                                y: {
                                                    formatter: (val) => val + " kWh",
                                                },
                                            },
                                            legend: {
                                                position: "top",
                                            },
                                            grid: {
                                                borderColor: "#e7e7e7",
                                                strokeDashArray: 4,
                                            }
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <!-- End Reports -->
                </div>
            </div>
            <!-- End Left side columns -->

            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Status Tagihan <span>| Tahun ini </span></h5>

                                <!-- Chart Container -->
                                <div id="trafficChart" style="min-height: 256px" class="echart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const billStatusSummary = <?php echo json_encode($bill_status_summary); ?>;

                                        // Validasi jika data kosong
                                        if (!Array.isArray(billStatusSummary) || billStatusSummary.length === 0) {
                                            document.getElementById('trafficChart').innerHTML = `
                                                <div class="text-center mt-5">
                                                    <i class="bi bi-exclamation-circle" style="font-size: 48px; color: #ccc;"></i>
                                                    <p class="mt-3 text-muted">Tidak ada data tagihan</p>
                                                </div>
                                            `;
                                            return;
                                        }

                                        // Hitung total tagihan
                                        const totalTagihan = billStatusSummary.reduce((acc, item) => acc + parseInt(item.total), 0);

                                        const colors = {
                                            'Lunas': 'rgba(25, 135, 84, 0.8)', 
                                            'Belum Lunas': 'rgba(220, 53, 69, 0.8)', 
                                            'Menunggu Verifikasi': 'rgba(255, 193, 7, 0.8)' 
                                        };

                                        // Inisialisasi ECharts
                                        const chart = echarts.init(document.getElementById('trafficChart'));

                                        const options = {
                                            color: Object.values(colors),
                                            tooltip: {
                                                trigger: 'item',
                                                formatter: ({ data }) => `
                                                    <div class="p-2">
                                                        <b>${data.name || 'Unknown'}</b><br>
                                                        Jumlah: ${data.value} tagihan<br>
                                                        Persentase: ${((data.value / totalTagihan) * 100).toFixed(1)}%
                                                    </div>
                                                `
                                            },
                                            legend: {
                                                bottom: 0,
                                                orient: 'horizontal',
                                                itemHeight: 12,
                                                itemWidth: 12,
                                                textStyle: {
                                                    fontSize: 12
                                                },
                                                formatter: (name) => {
                                                    const item = billStatusSummary.find(d => d.status === name);
                                                    return item ? `${name} (${item.total})` : name;
                                                }
                                            },
                                            series: [{
                                                type: 'pie',
                                                radius: ['35%', '65%'],
                                                center: ['50%', '45%'],
                                                avoidLabelOverlap: true,
                                                
                                                label: {
                                                    show: true,
                                                    position: 'outer',
                                                    alignTo: 'edge',
                                                    margin: 20,
                                                    formatter: ({ percent }) => `${percent.toFixed(0)}%`,
                                                    fontSize: 12,
                                                    fontWeight: 'bold'
                                                },
                                                labelLine: {
                                                    length: 15,
                                                    length2: 5,
                                                    smooth: 0.2
                                                },
                                                emphasis: {
                                                    scale: true,
                                                    scaleSize: 5,
                                                },
                                                data: billStatusSummary.map(item => ({
                                                    ...item,
                                                    value: parseInt(item.total),
                                                    name: item.status,
                                                    itemStyle: { color: colors[item.status] || '#ccc' } // Fallback warna
                                                }))
                                            }],
                                            graphic: [{
                                                type: 'text',
                                                left: 'center',
                                                top: '40%',
                                                style: {
                                                    text: totalTagihan.toString(),
                                                    fontSize: 24,
                                                    fontWeight: 'bold',
                                                    fill: '#34495e'
                                                }
                                            }, {
                                                type: 'text',
                                                left: 'center',
                                                top: '50%',
                                                style: {
                                                    text: 'Total Tagihan',
                                                    fontSize: 12,
                                                    fill: '#7f8c8d'
                                                }
                                            }]
                                        };
                                        chart.setOption(options);

                                        // Responsive Handler
                                        window.addEventListener('resize', () => chart.resize());
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <!-- <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

                                <div class="news">
                                    <div class="post-item clearfix">
                                        <img src="<?= base_url ('assets/img/news-1.jpg');?>" alt="">
                                        <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                                        <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                                    </div>

                                    <div class="post-item clearfix">
                                        <img src="<?= base_url ('assets/img/news-2.jpg');?>" alt="">
                                        <h4><a href="#">Quidem autem et impedit</a></h4>
                                        <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="card position-relative overflow-hidden position-relative">
                            <div class="card-body">
                                <h5 class="card-title mb-0">Cuaca Saat Ini</h5>
                                
                                <?php if (!empty($weather) && isset($weather['main'])): ?>
                                <?php
                                    function getWeatherCondition($weatherMain, $weatherDescription) {
                                        $conditions = [
                                            'clear sky' => 'Cerah',
                                            'few clouds' => 'Sedikit Berawan',
                                            'scattered clouds' => 'Berawan Sebagian',
                                            'broken clouds' => 'Berawan Tebal',
                                            'overcast clouds' => 'Mendung',
                                            'drizzle' => 'Gerimis',
                                            'rain' => 'Hujan',
                                            'shower rain' => 'Hujan Lebat',
                                            'thunderstorm' => 'Badai Petir',
                                            'snow' => 'Salju',
                                            'mist' => 'Berkabut',
                                            'haze' => 'Berkabut'
                                        ];
                                        return $conditions[strtolower($weatherDescription)] ?? 
                                               $conditions[strtolower($weatherMain)] ?? 
                                               ucfirst($weatherDescription);
                                    }
                                    ?>
                                    <!-- Suhu dan Ikon Cuaca -->
                                    <div class="d-flex ">
                                        <h2 class="fw-bold mt-1">
                                            <?= number_format($weather['main']['temp'], 1) ?> °C
                                        </h2>
                                        <h6 class="ms-3 mt-2 mt-md-3 text-muted">(<?= getWeatherCondition($weather['weather'][0]['main'] ?? 'Unknown',$weather['weather'][0]['description'] ?? '') ?>)</h6>
                                        <img src="https://openweathermap.org/img/wn/<?= $weather['weather'][0]['icon'] ?? '01d' ?>@2x.png" 
                                        alt="<?= htmlspecialchars($weather['weather'][0]['description'] ?? 'Cuaca', ENT_QUOTES, 'UTF-8') ?>" 
                                        class="position-absolute end-0" style="top: -10px; width: 25%;">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="d-flex mb-0">
                                            <div class="col-6">
                                                <p class="text-muted mb-2">Terasa Seperti</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="fw-bold mb-2 ms-3">
                                                    <?= number_format($weather['main']['feels_like'], 1) ?> °C
                                                </p>
                                            </div>    
                                        </div>
                                        <div class="d-flex mb-0">
                                            <div class="col-6">
                                                <p class="text-muted mb-2">Kecepatan Angin</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="fw-bold mb-2 ms-3">
                                                    <?= number_format($weather['wind']['speed'], 1) ?> m/s
                                                </p>
                                            </div>    
                                        </div>
                                        <div class="d-flex mb-0">
                                            <div class="col-6">
                                                <p class="text-muted mb-2">Arah Angin</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="fw-bold mb-2 ms-3">
                                                    <?= isset($weather['wind']['deg']) ? $weather['wind']['deg'] . '°' : 'N/A' ?>
                                                </p>
                                            </div>    
                                        </div>
                                        <div class="d-flex mb-0">
                                            <div class="col-6">
                                                <p class="text-muted mb-2">Kelembapan</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="fw-bold mb-2 ms-3">
                                                    <?= $weather['main']['humidity'] ?>%
                                                </p>
                                            </div>    
                                        </div>
                                        <div class="d-flex mb-0">
                                            <div class="col-6">
                                                <p class="text-muted mb-2">Awan</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="fw-bold mb-2 ms-3">
                                                    <?= $weather['clouds']['all'] ?>%
                                                </p>
                                            </div>    
                                        </div>
                                        <div class="d-flex mb-0">
                                            <div class="col-6">
                                                <p class="text-muted mb-2">Tekanan Udara</p>
                                            </div>
                                            <div class="col-6">
                                                <p class="fw-bold mb-2 ms-3">
                                                    <?= $weather['main']['pressure'] ?> hPa
                                                </p>
                                            </div>    
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="text-danger">Data cuaca tidak tersedia. Silakan coba lagi nanti.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                </div>
            </div>

        </div>
        <div class="col-lg-12"></div>

    </div>
</section>
</main>
<!-- End #main -->
