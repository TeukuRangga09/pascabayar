<?php
if (!function_exists('encrypt_id_tagihan')) {
    function encrypt_id_tagihan($id_tagihan) {
        $encryption_key = 'rahasia1234567890abcdefghijklmnopqrstuv'; 
        $hashed = hash_hmac('sha256', (string)$id_tagihan, $encryption_key);
        $numeric_hash = hexdec(substr($hashed, 0, 8));
        return str_pad($numeric_hash, 10, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('decrypt_id_tagihan')) {
    function decrypt_id_tagihan($numeric_invoice) {
        $encryption_key = 'rahasia1234567890abcdefghijklmnopqrstuv'; 
        for ($id = 1; $id <= 1000000; $id++) { 
            $encrypted = encrypt_id_tagihan($id);
            if ($encrypted === $numeric_invoice) {
                return $id; 
            }
        }
        return null; 
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

<?php if ($this->session->flashdata('success')) : ?>
    <div class="position-fixed d-flex justify-content-center translate-middle-x start-50 w-100" style="z-index: 9999 !important;top: 15%;">
        <div class="alert alert-success bg-success text-white border-0 rounded-4 shadow alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= strip_tags($this->session->flashdata('success')); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<section class="section-tagihan py-5 mt-5">
    <div class="container">
        <!-- Judul Section -->
        <div class="text-center">
            <h2 class="section-title fw-bold text-pc">Tagihan Listrik</h2>
            <p class="section-subtitle text-muted">Berikut adalah daftar tagihan listrik Anda.</p>
        </div>

        <!-- Filter dan Pencarian -->
        <div class="row mb-4">
            <div class="d-flex justify-content-start">
                <div class="col-12">
                    <div class="input-group align-content-stretch gap-3">
                        <div class="d-flex justify-content-center align-items-center align-self-stretch">
                            <div class="input-group d-flex justify-content-center align-items-center border-0 card bg-white p-0 m-0 rounded-3 h-100 overflow-hidden">
                                <div class="d-flex justify-content-between overflow-hidden">
                                    <!-- <i class="bi bi-funnel-fill text-body"></i> -->
                                    <div class="d-flex fw-semibold px-3 px-md-5">
                                        <p class="ms-0 ms-md-2 text-nowrap my-0 z-0">Filter</p>
                                        <span class="d-none d-md-block ms-1">Tagihan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <select id="statusFilter" class="form-select d-flex border-0 card my-0 rounded-3 z-3">
                            <option value="">Semua Status</option>
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                        <!-- Tombol Reset -->
                        <button id="resetFilter" class="card bg-transparent p-0 m-0 rounded-3 px-5 justify-content-center align-content-center">
                            <span class="fs-6 fw-semibold text-primary">Reset</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cek Apakah Ada Data Tagihan -->
        <?php if (!empty($tagihan) && is_array($tagihan)): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="transtition:.5;" id="tagihanContainer">
                <!-- Looping Data Tagihan -->
                <?php foreach ($tagihan as $item): ?>
                    <div class="col align-items-stretch tagihan-card" data-status="<?= htmlspecialchars($item->status) ?>">
                        <div class="card border-0 shadow rounded-4 overflow-hidden h-100">
                            <!-- Header Card -->
                            <div class="card-header bg-gradient text-white rounded-top d-flex justify-content-between align-items-center py-1">
                                <h5 class="card-title text-body text-nowrap mb-0 ms-2"><?= htmlspecialchars($item->bulan) ?> <?= htmlspecialchars($item->tahun) ?></h5>
                                <div class="">
                                    <i class="bi bi-calendar2-fill fs-4 p-1 text-bc"></i>
                                </div>
                            </div>

                            <!-- Body Card -->
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
                                                <p class="mb-0 fw-bold">#<?= encrypt_id_tagihan($item->id_tagihan) ?></p>
                                                <small class="text-muted">No.Invoice</small>
                                            </div>
                                        </div>
                                        <div class="align-items-center mb-3 pb-0">
                                            <div>
                                                <p class="mb-0 fw-bold"><?= htmlspecialchars($item->nama_pelanggan) ?></p>
                                                <small class="text-muted">Pelanggan</small>
                                            </div>
                                        </div>
                                        <div class="align-items-center mb-0 pb-0">
                                                <?php
                                                // Determine the CSS class and display text based on the status
                                                $statusClass = '';
                                                $statusText = '';

                                                switch ($item->status) {
                                                    case 'Lunas':
                                                        $statusClass = 'text-success-new';
                                                        $statusText = 'Lunas';
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
                                                        $statusText = 'Tidak Diketahui'; // Fallback for unknown statuses
                                                        break;
                                                }
                                                ?>
                                            <div>
                                                <p class="mb-0 fw-bold <?= $statusClass ?>"><?= $statusText ?></p>
                                                <small class="text-muted">Status Pembayaran</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                            <!-- Jumlah Bayar -->
                            <div class="pb-0" style="border-top:1px solid #EBEEF4;!important;">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="ms-3 overflow-visible">
                                        <p class="mb-0 fw-bold">Total Tagihan</p>
                                        <div class="position-relative pb-2">
                                            <small class="position-absolute top-0 start-0 text-muted text-nowrap">Sudah Termasuk Biaya Admin</small>
                                        </div>
                                    </div>
                                    <h4 class="text-primary text-nowrap fw-bold me-3"><?= rupiah($item->jumlah_meter * $item->tarifperkwh + $biaya_admin) ?></h4>
                                </div>
                            </div>

                            <!-- Footer Card -->
                            <div class="card-footer bg-white border-top-0 small text-muted d-flex justify-content-end mx-1 pt-3">
                                
                                <?php if ($item->status === 'Belum Lunas'): ?>
                                    <!-- Tombol Bayar Sekarang -->
                                    <a href="<?= site_url('cek_tagihan/p/bayar/' . $item->id_tagihan); ?>" 
                                       class="btn btn-primary fw-semibold pb-2 flex-fill rounded-pill rounded-3 shadow-sm px-5 text-nowrap"
                                       aria-label="Bayar Tagihan untuk <?= htmlspecialchars($item->nama_pelanggan) ?>"
                                       data-bs-toggle="tooltip" data-bs-placement="top" title="Klik untuk membayar tagihan">
                                        Bayar Sekarang
                                    </a>
                                <?php elseif ($item->status === 'Menunggu Verifikasi'): ?>
                                    <!-- Pesan Menunggu Verifikasi -->
                                    
                                <?php elseif ($item->status === 'Lunas'): ?>
                                    <!-- Pesan Lunas -->
                                    
                                <?php else: ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Tidak Ada Data Tagihan -->
            <div class="card rounded-4 border-0 py-5">
                <div class="d-flex flex-column justify-content-center align-items-center text-center">
                    <!-- Ikon Ilustrasi -->
                    <i class="bi bi-clipboard-x display-1 text-pc mb-3"></i>

                    <!-- Judul -->
                    <h5 class="fw-bold text-pc mb-2">Tidak Ada Tagihan</h5>

                    <!-- Deskripsi -->
                    <p class="text-muted mb-4" style="max-width: 350px;">
                        Saat ini tidak ada tagihan yang tersedia, Jika anda baru saja melakukan pendaftaran silahkan klik 
                        <a class="text-decoration-underline" target="_blank" href="https://api.whatsapp.com/send?phone=1234567890&text=Hello I need help!%0AApp Name: PayListrik%0A">Dukungan</a> untuk penyambungan listrik baru.
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Filter Tagihan
    const statusFilter = document.getElementById('statusFilter');
    const resetFilter = document.getElementById('resetFilter'); // Tombol reset
    const cards = document.querySelectorAll('.tagihan-card'); // Ambil semua kartu tagihan

    // Fungsi untuk menerapkan filter
    const applyFilter = () => {
        const selectedStatus = statusFilter.value; // Nilai status yang dipilih
        cards.forEach(card => {
            const cardStatus = card.getAttribute('data-status'); // Ambil data-status dari kartu
            const matchesStatus = selectedStatus === "" || cardStatus === selectedStatus; // Cek apakah cocok
            card.style.display = matchesStatus ? 'block' : 'none'; // Tampilkan atau sembunyikan kartu
        });
    };

    // Event listener untuk dropdown filter
    statusFilter.addEventListener('change', applyFilter);

    // Event listener untuk tombol reset
    resetFilter.addEventListener('click', () => {
        statusFilter.value = ""; // Kembalikan dropdown ke nilai awal (Semua Status)
        applyFilter(); // Terapkan filter ulang untuk menampilkan semua kartu
    });
});
</script>