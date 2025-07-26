<?php

$nomor_kwha = 1213123123312;
$tagihana = [
        (object) [
        'id_tagihan' => 'TGH-2689402130',
        'nama_pelanggan' => 'Budi Santoso',
        'bulan' => 'Januari',
        'tahun' => '2024',
        'jumlah_meter' => 120,
        'status' => 'Lunas',
        'tanggal_tagihan' => '2024-01-10',
    ],
    (object) [
        'id_tagihan' => 'TGH002',
        'nama_pelanggan' => 'Siti Aminah',
        'bulan' => 'Februari',
        'tahun' => '2024',
        'jumlah_meter' => 150,
        'status' => 'Ditolak',
        'tanggal_tagihan' => '2024-02-12',
    ],
    (object) [
        'id_tagihan' => 'TGH003',
        'nama_pelanggan' => 'Andi Pratama',
        'bulan' => 'Maret',
        'tahun' => '2024',
        'jumlah_meter' => 180,
        'status' => 'Menunggu Verifikasi',
        'tanggal_tagihan' => '2024-03-15',
    ],
    (object) [
        'id_tagihan' => 'TGH004',
        'nama_pelanggan' => 'Rina Wijaya',
        'bulan' => 'April',
        'tahun' => '2024',
        'jumlah_meter' => 200,
        'status' => 'Belum Lunas',
        'tanggal_tagihan' => '2024-04-18',
    ],
    (object) [
        'id_tagihan' => 'TGH005',
        'nama_pelanggan' => 'Dian Permana',
        'bulan' => 'Mei',
        'tahun' => '2024',
        'jumlah_meter' => 170,
        'status' => 'Menunggu Verifikasi',
        'tanggal_tagihan' => '2024-05-20',
    ],
    (object) [
        'id_tagihan' => 'TGH006',
        'nama_pelanggan' => 'Eka Saputra',
        'bulan' => 'Juni',
        'tahun' => '2024',
        'jumlah_meter' => 140,
        'status' => 'Belum Lunas',
        'tanggal_tagihan' => '2024-06-22',
    ],

];

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

<?php if ($this->session->flashdata('error')) : ?>
    <div class="position-fixed d-flex justify-content-center translate-middle-x start-50 w-100" style="z-index: 9999 !important;top: 15%;">
        <div class="alert alert-danger bg-danger text-white border-0 rounded-4 shadow alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= strip_tags($this->session->flashdata('error')); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<section class="section-ct py-5 mt-5">
    <div class="container">

        <div class="text-center">
            <h2 class="section-title fw-bold text-pc">Cek Tagihan Listrik</h2>
            <p class="section-subtitle d-none d-lg-block">Periksa tagihan listrik Anda dengan mudah dan cepat. Masukkan nomor KWH Anda untuk melihat detail tagihan. <br>(Hanya tersedia untuk melihat informasi, pembayaran memerlukan akun terdaftar.)</p>
            <p class="section-subtitle d-block d-lg-none fs-6">Periksa tagihan listrik Anda dengan mudah dan cepat. Masukkan nomor KWH Anda untuk melihat detail tagihan. (Hanya tersedia untuk melihat informasi, pembayaran memerlukan akun terdaftar.)</p>
        </div>

        <form action="<?= site_url('frontend/cek_tagihan_guest/cari'); ?>" method="post" id="formCekTagihan" class="mb-0 mb-md-4">
            <div class="row justify-content-center align-items-center mb-4">

                    <div class="input-group d-flex justify-content-between align-content-stretch w-100 gap-4">

                        <div class="d-flex justify-content-center align-items-center align-self-stretch d-none d-md-block">
                            <div class="input-group d-flex justify-content-center align-items-center border-0 card bg-white p-0 m-0 rounded-3 h-100 overflow-hidden">
                                <div class="d-flex justify-content-between overflow-hidden">
                                    <div class="d-flex fw-semibold text-body">
                                        <p class="text-nowrap my-0 z-0 mx-5">Pencarian</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-0 m-0 d-flex position-relative flex-fill">
                            <input type="text" id="nomor_kwh" name="nomor_kwh" class="form-control form-control-lg card bg-white text-body rounded-3 p-0 m-0 z-0" 
                            placeholder="Masukkan nomor kWh" 
                            required minlength="10" maxlength="12" pattern="\d{10,12}">
                                <div class="valid-feedback tetx-nowrap mt-5 bg-success text-white rounded-2 position-absolute start-50 translate-middle-x z-3">
                                    <p class="p-2 m-0">
                                        Format Nomor kWh valid.
                                    </p>
                                </div>
                                <div class="invalid-feedback tetx-nowrap mt-5 bg-danger text-white rounded-2 position-absolute start-50 translate-middle-x z-3">
                                    <p class="p-2 m-0">
                                        Nomor kWh harus terdiri dari 10-12 digit angka.
                                    </p>
                                </div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center align-self-stretch w-25 p-0 m-0">
                            <button type="submit" class="card bg-primary p-0 m-0 rounded-3 justify-content-center align-content-center w-100 h-100">
                                <span class="fw-semibold text-white">Cari Tagihan</span>
                            </button>
                        </div>
                    </div>
            </div>
        </form>

        <?php if (($tagihan)) : ?>
            <div id="result-section" class="result-section p-0 m-0">
                <div class="card rounded-4 p-0 m-0 overflow-hidden mb-4">
                    <div class="card-body position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-body mb-0 pb-2">
                                Hasil Pencarian Tagihan
                            </h5>
                            <span class="position-absolute end-0 top-0 badge bg-bc p-2 p-md-3 mt-2 mt-md-3 me-2 me-md-3">
                                <i class="bi bi-receipt fs-4 m-0 text-primary"></i>
                            </span>
                        </div>
                        <p class="card-text text-muted mb-0">
                            Berikut Daftar Tagihan dari Nomor kWh <span class="fs-6 fw-semibold text-body"><?= htmlspecialchars($nomor_kwh); ?></span>
                        </p>
                    </div>
                </div>
                <style>#format-input-tagihan{display: none}</style>
                <div class="row g-4 mb-4">
                    <?php foreach ($tagihan as $t) : ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card rounded-4 overflow-hidden position-relative h-100" style="transition: transform 0.3s ease;">

                                <div class="card-header bg-gradient text-white rounded-top d-flex justify-content-between align-items-center py-1">
                                    <h5 class="card-title text-body text-nowrap mb-0 ms-2"><?= htmlspecialchars($t->bulan) ?> <?= htmlspecialchars($t->tahun) ?></h5>
                                    <div class="">
                                        <i class="bi bi-calendar2-fill fs-4 p-1 text-bc"></i>
                                    </div>
                                </div>

                                <div class="card-body mb-0 p-4 pb-0">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <div class="card rounded-3 shadow-none bg-bc position-relative d-flex align-items-center">
                                                    <i class="bi bi-lightning-fill text-primary fs-3 p-2 mx-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="align-items-center mb-3">
                                                <div>
                                                    <p class="mb-0 fw-bold">#<?= encrypt_id_tagihan($t->id_tagihan) ?></p>
                                                    <small class="text-muted">No.Invoice</small>
                                                </div>
                                            </div>
                                            <div class="align-items-center mb-3 pb-0">
                                                <div>
                                                    <p class="mb-0 fw-bold"><?= htmlspecialchars($t->nama_pelanggan) ?></p>
                                                    <small class="text-muted">Pelanggan</small>
                                                </div>
                                            </div>
                                            <div class="align-items-center mb-0 pb-0">
                                                <?php
                                                $statusClass = '';
                                                $statusText = '';

                                                switch ($t->status) {
                                                    case 'Lunas':
                                                    $statusClass = 'text-success-new';
                                                    $statusText = 'Sudah Lunas';
                                                    break;
                                                    case 'Belum Lunas':
                                                    $statusClass = 'text-danger-new';
                                                    $statusText = 'Belum Lunas';
                                                    break;
                                                    case 'Menunggu Verifikasi':
                                                    $statusClass = 'text-warning-new';
                                                    $statusText = 'Menunggu Verifikasi';
                                                    break;
                                                    default:
                                                    $statusClass = 'text-muted';
                                                    $statusText = 'Tidak Diketahui';
                                                    break;
                                                }
                                                ?>
                                                <div class="position-relative">
                                                    <p class="d-inline p-2 px-3 mb-0 fw-bold rounded-3 <?= $statusClass ?>" style="border:2px dotted;!important;"><?= $statusText ?></p>
                                                    <small class="d-block text-muted mt-3">Status Pembayaran</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div id="format-input-tagihan" class="card rounded-4 p-0 m-0 overflow-hidden">
            <div class="card-body">
                <h5 class="card-title text-body mb-0 pb-2">
                    Format Nomor kWh
                </h5>
                <p class="card-text text-muted mb-sm-3 mb-md-0">
                    Pastikan nomor kWh yang Anda masukkan sesuai dengan format berikut:
                </p>
                <div class="row">
                    <div class="col-lg-8">
                        <ul class="list-unstyled mb-0">
                            <li class="row">
                                <div class="col-2 col-md-2 d-flex text-nowrap">
                                    <i class="bi bi-check-circle-fill text-success-new me-2"></i>
                                    <p class="m-0 ms-lg-2 fw-semibold">Panjang</p>
                                </div>
                                <div class="col-12 col-md-9 col-lg-10">
                                    <p class="text-muted mb-md-0">10 hingga 12 digit angka.</p>
                                </div>
                            </li>
                            <li class="row">
                                <div class="col-2 col-md-2 d-flex text-nowrap">
                                    <i class="bi bi-check-circle-fill text-success-new me-2"></i>
                                    <p class="m-0 ms-lg-2 fw-semibold">Karakter</p>
                                </div> 
                                <div class="col-12 col-md-9 col-lg-10">
                                    <p class="text-muted mb-md-0">Hanya angka (tidak boleh huruf atau simbol).</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="mt-3">
            <p class="fw-bold">Contoh Nomor kWh:</p>
            <ul class="list-unstyled">
                <li><code>607855556446</code></li>
                <li><code>828807156228</code></li>
            </ul>
        </div>


    </div>
</section>


<script>
    const inputKwh = document.getElementById("nomor_kwh");
    const formCekTagihan = document.getElementById("formCekTagihan");

    // Validasi input live
    inputKwh.addEventListener("input", function () {
        const pattern = /^\d{10,12}$/;
        if (inputKwh.value === "") {
            inputKwh.classList.remove("is-valid", "is-invalid");
        } else {
            inputKwh.classList.toggle("is-valid", pattern.test(inputKwh.value));
            inputKwh.classList.toggle("is-invalid", !pattern.test(inputKwh.value));

            if (pattern.test(inputKwh.value)) {
                setTimeout(() => {
                    inputKwh.classList.remove("is-valid");
                }, 2000);
            }
        }
    });
</script>