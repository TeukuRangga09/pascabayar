<?php
// Cek apakah ada error atau pesan sukses dari controller
if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <h3 class="text-center">Detail Tagihan</h3>
    <div class="card">
        <div class="card-body">
            <!-- Informasi Tagihan -->
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Bulan/Tahun:</strong> <?= $tagihan->bulan . ' ' . $tagihan->tahun; ?></p>
                    <p><strong>Jumlah Meter:</strong> <?= number_format($tagihan->jumlah_meter, 2); ?> kWh</p>
                    <p><strong>Tarif per kWh:</strong> Rp <?= number_format($tagihan->tarifperkwh, 0, ',', '.'); ?></p>
                    <p><strong>Biaya Admin:</strong> Rp <?= number_format($biaya_admin, 0, ',', '.'); ?></p>
                    <p><strong>Total Tagihan:</strong> Rp <?= number_format($total_bayar, 0, ',', '.'); ?></p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>Batas Waktu Pembayaran:</strong> <?= date('d F Y', strtotime('+7 days')); ?></p>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <hr>
            <h5>Pilih Metode Pembayaran</h5>
            <div class="row">
                <div class="col-md-6">
                    <h6>Transfer Bank</h6>
                    <?php foreach ($rekening_tujuan['bank'] as $bank) : ?>
                        <div class="card mb-2">
                            <div class="card-body">
                                <img src="<?= base_url('assets/img/' . $bank['logo']); ?>" alt="<?= $bank['nama_bank']; ?>" width="50">
                                <span><?= $bank['nama_bank']; ?></span><br>
                                <small>No. Rekening: <?= $bank['nomor_rekening']; ?> a.n <?= $bank['atas_nama']; ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-6">
                    <h6>E-Wallet</h6>
                    <?php foreach ($rekening_tujuan['e_wallet'] as $ewallet) : ?>
                        <div class="card mb-2">
                            <div class="card-body">
                                <img src="<?= base_url('assets/img/' . $ewallet['logo']); ?>" alt="<?= $ewallet['nama']; ?>" width="50">
                                <span><?= $ewallet['nama']; ?></span><br>
                                <small>No. <?= $ewallet['nama']; ?>: <?= $ewallet['nomor']; ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Form Konfirmasi Pembayaran -->
            <hr>
            <h5>Konfirmasi Pembayaran</h5>
            <form action="<?= site_url('cek_tagihan/p/proses_pembayaran'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_tagihan" value="<?= $tagihan->id_tagihan; ?>">
                <div class="mb-3">
                    <label for="bukti_pembayaran" class="form-label">Unggah Bukti Pembayaran</label>
                    <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" required>
                    <small class="text-muted">
                        Pastikan bukti pembayaran jelas terbaca dengan ketentuan:<br>
                        - Format file: JPG, PNG, PDF (maks. 2MB)<br>
                        - Nama file tidak mengandung karakter khusus<br>
                        - Waktu transaksi terlihat jelas
                    </small>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pembayaran</button>
                <a href="<?= site_url('cek_tagihan/p'); ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>