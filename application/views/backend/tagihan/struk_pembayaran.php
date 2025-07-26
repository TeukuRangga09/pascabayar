<?php
if (!function_exists('encrypt_id_pelanggan')) {
    /**
     * Fungsi untuk mengenkripsi ID pelanggan dengan format PLG-[numeric]
     *
     * @param int $id_pelanggan ID pelanggan asli
     * @return string ID pelanggan yang dienkripsi
     */
    function encrypt_id_pelanggan($id_pelanggan) {
        // Kunci enkripsi (harus dirahasiakan)
        $encryption_key = 'rahasia123'; // Ganti dengan kunci rahasia Anda

        // Enkripsi ID pelanggan menggunakan AES-128-ECB
        $encrypted = openssl_encrypt($id_pelanggan, 'AES-128-ECB', $encryption_key);

        // Konversi hasil enkripsi ke angka menggunakan CRC32
        $numeric_hash = sprintf('%u', crc32($encrypted));

        // Tambahkan prefix "PLG-"
        return 'PLG-' . $numeric_hash;
    }
}

if (!function_exists('decrypt_id_pelanggan')) {
    /**
     * Fungsi untuk mendekripsi ID pelanggan dari format PLG-[numeric]
     *
     * @param string $hashed_id ID pelanggan yang dienkripsi
     * @return int|null ID pelanggan asli atau null jika gagal
     */
    function decrypt_id_pelanggan($hashed_id) {
        // Kunci enkripsi (harus sama dengan yang digunakan saat enkripsi)
        $encryption_key = 'rahasia123'; // Ganti dengan kunci rahasia Anda

        // Hapus prefix "PLG-"
        if (strpos($hashed_id, 'PLG-') !== 0) {
            return null; // Format salah
        }
        $numeric_hash = substr($hashed_id, 4); // Hilangkan "PLG-"

        // Cari ID pelanggan asli berdasarkan numeric hash
        // (Karena CRC32 tidak reversibel, Anda perlu mencocokkan secara manual)
        for ($id = 1; $id <= 1000000; $id++) { // Batas pencarian disesuaikan
            $encrypted = openssl_encrypt((string)$id, 'AES-128-ECB', $encryption_key);
            $test_hash = sprintf('%u', crc32($encrypted));
            if ($test_hash === $numeric_hash) {
                return $id; // Cocok, kembalikan ID pelanggan asli
            }
        }

        return null; // Tidak ditemukan
    }
}

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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Listrik PLN</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 14px;
            margin: 0;
            padding: 2mm;
            width: 81mm;
            margin: 0 auto;
            background-color: #fff;
        }

        .header {
            text-align: center;
            padding: 3px 0;
            border-bottom: 2px dashed #000;
            margin-bottom: 5px;
        }

        .logo {
            font-size: 35px;
            font-weight: bold;
            color: #0047ab;
            margin: 2px 0;
        }

        .sub-logo {
            font-size: 12px;
            color: #333;
        }

        .struk-info {
            margin: 5px 0;
        }

        .info-item {
            margin: 3px 0;
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            flex: 1;
            color: #666;
        }

        .info-value {
            flex: 2;
            text-align: right;
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .total-section {
            background-color: #f0f0f0;
            padding: 5px;
            margin: 5px 0;
            border-radius: 3px;
        }

        .payment-method {
            background-color: #e8f4ff;
            padding: 3px;
            border-radius: 3px;
            display: inline-block;
            margin: 3px 0;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            margin-top: 8px;
            color: #666;
        }

        @media print {
            * {
                color: inherit !important;
                background-color: transparent !important;
            }
        }

        @media print {
            .print-hide {
                display: none;
            }
            
            body {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">PayListrik</div>
        <div class="sub-logo">Penyaluran &amp; Pendistribusian Listrik</div>
    </div>

    <div class="struk-info">
        <div class="info-item">
            <div class="info-label">No Invoice</div>
            <div class="info-value">#<?= htmlspecialchars(encrypt_id_tagihan($tagihan['id_pelanggan'])) ?></div>
        </div>
    </div>

    <div class="struk-info">
        <div class="info-item">
            <div class="info-label">ID Pelanggan</div>
            <div class="info-value"><?= htmlspecialchars(encrypt_id_pelanggan($tagihan['id_pelanggan'])) ?></div>
        </div>
        <div class="info-item">
            <div class="info-label">Nama</div>
            <div class="info-value"><?= htmlspecialchars($tagihan['nama_pelanggan']) ?></div>
        </div>
        <div class="info-item">
            <div class="info-label">Alamat</div>
            <div class="info-value"><?= strip_tags($tagihan['alamat']) ?></div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="struk-info">
        <div class="info-item">
            <div class="info-label">Periode</div>
            <div class="info-value"><?= htmlspecialchars($tagihan['bulan']) ?>/<?= htmlspecialchars($tagihan['tahun']) ?></div>
        </div>
        <div class="info-item">
            <div class="info-label">Daya</div>
            <div class="info-value"><?= htmlspecialchars($tagihan['daya']) ?></div>
        </div>
        <div class="info-item">
            <div class="info-label">Stand Meter</div>
            <div class="info-value">
                <?= format_kwh($tagihan['stand_meter_awal']) ?> ➔ <?= format_kwh($tagihan['stand_meter_akhir']) ?>
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Pemakaian</div>
            <div class="info-value"><?= format_kwh($tagihan['jumlah_meter']) ?> kWh</div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="struk-info">
        <div class="info-item">
            <div class="info-label">Biaya Pemakaian</div>
            <div class="info-value"><?= rupiah($tagihan['jumlah_meter'] * $tagihan['tarifperkwh']) ?></div>
        </div>
        <div class="info-item">
            <div class="info-label">Biaya Admin</div>
            <div class="info-value"><?= rupiah($pembayaran['biaya_admin']) ?></div>
        </div>
    </div>

    <div class="total-section">
        <div class="info-item">
            <div class="info-label">TOTAL BAYAR</div>
            <div class="info-value"><?= rupiah($pembayaran['total_bayar']) ?></div>
        </div>
    </div>

    <div class="struk-info">
        <div class="payment-method">
            <?= htmlspecialchars($pembayaran['metode_pembayaran']) ?> • 
            <?= date('d/m/Y H:i', strtotime($pembayaran['tanggal_pembayaran'])) ?>
        </div>
    </div>

    <div class="footer">
        <div>Struk ini sebagai bukti pembayaran yang sah</div>
        <div>Terima kasih telah menggunakan layanan ini</div>
        <div>Call Center: 123 ♦ www.paylistrik.co.id</div>
    </div>

    <div class="print-hide" style="text-align: center; margin-top: 10px;">
        <button onclick="window.print()" style="
        background: #0047ab;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;">
        Cetak Struk
    </button>
</div>
</body>
</html>