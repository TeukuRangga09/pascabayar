<section class="section-tarif pt-5 pb-1 mt-5 mb-1">
    <div class="container">

        <div class="text-center mb-3">
            <h2 class="section-title fw-bold text-pc">Daftar Tarif Listrik</h2>
            <p class="section-subtitle text-muted">Lihat tarif listrik yang tersedia untuk membantu Anda memilih paket yang tepat.</p>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <?php foreach ($tarif_listrik as $item): ?>
                        <div class="col-lg-6">
                            <div class="card rounded-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="bi bi-lightning-fill me-2"></i>
                                        <?php echo $item['daya']; ?>
                                    </h5>
                                    <h6 class="card-subtitle fw-semibold mb-2">
                                        <?php echo rupiah($item['tarifperkwh']); ?> / kWh
                                    </h6>
                                    <p class="card-text text-muted">
                                        <?php echo $item['deskripsi']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-4">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="bi bi-calculator me-2"></i> Kalkulator Pemakaian Listrik
                        </h4>
                        <form id="form-kalkulator">
                            <div class="mb-3">
                                <label for="selectTarif" class="form-label small">Pilih Tarif</label>
                                <select class="form-select" id="selectTarif" required>
                                    <option value="" disabled selected>-- Pilih Tarif --</option>
                                    <?php foreach ($tarif_listrik as $item): ?>
                                        <option value="<?php echo $item['tarifperkwh']; ?>">
                                            <?php echo $item['daya']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="inputPemakaian" class="form-label small">Pemakaian (kWh)</label>
                                <input type="number" class="form-control" id="inputPemakaian" placeholder="Masukkan jumlah kWh" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-calculator"></i> Hitung Biaya
                            </button>
                        </form>
                        <div class="mt-4">
                            <h5 class="card-title py-0 my-0">Hasil Perhitungan</h5>
                            <p id="hasilPerhitungan" class="py-0 my-0 mt-1">-</p>
                        </div>
                        <div class="mt-1">
                            <small class="my-0 py-4 text-muted">* Belum Termasuk Biaya Administrasi</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('form-kalkulator').addEventListener('submit', function(e) {
        e.preventDefault();
        var tarif = parseFloat(document.getElementById('selectTarif').value);
        var pemakaian = parseFloat(document.getElementById('inputPemakaian').value);

        // Validasi input
        if (isNaN(tarif) || isNaN(pemakaian)) {
            document.getElementById('hasilPerhitungan').textContent = 'Silakan isi data dengan benar.';
            return;
        }

        // Hitung total biaya
        var totalBiaya = tarif * pemakaian;

        // Format angka tanpa desimal
        totalBiaya = new Intl.NumberFormat('id-ID', {
            style: 'decimal', // Menggunakan gaya desimal
            minimumFractionDigits: 0, // Tidak ada digit desimal minimal
            maximumFractionDigits: 0 // Tidak ada digit desimal maksimal
        }).format(totalBiaya);

        // Tampilkan hasil
        document.getElementById('hasilPerhitungan').textContent = 'Rp '+ totalBiaya;
    });
</script>
