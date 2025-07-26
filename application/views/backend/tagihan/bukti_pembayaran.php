<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran Listrik PLN</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px auto;
            width: 210mm; /* Format A4 */
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #0047ab;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 18px;
            color: #0047ab;
            margin: 10px 0;
            text-transform: uppercase;
        }

        .transaction-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        .info-label {
            color: #666;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .info-value {
            font-size: 13px;
            color: #333;
        }

        .payment-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .payment-table th,
        .payment-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .payment-table th {
            background-color: #0047ab;
            color: white;
        }

        .legal-note {
            border-top: 2px solid #0047ab;
            padding-top: 15px;
            margin-top: 20px;
            font-size: 11px;
            color: #666;
            line-height: 1.5;
        }

        .watermark {
            position: fixed;
            opacity: 0.1;
            font-size: 80px;
            transform: rotate(-45deg);
            top: 30%;
            left: 20%;
            color: #0047ab;
            pointer-events: none;
        }

        @media print {
            body {
                box-shadow: none;
                width: 100%;
                padding: 15px;
            }
            
            .print-hide {
                display: none;
            }
            
            .watermark {
                opacity: 0.15;
            }
        }
    </style>
</head>
<body>
    <div class="watermark">BAYAR LUNAS</div>
    
    <div class="header">
        <img src="<?= base_url('assets/pln_logo.png') ?>" class="logo" alt="PLN Logo">
        <h2 class="title">Bukti Pembayaran Tagihan Listrik</h2>
        <div>PT. PLN (PERSERO) AREA OPERASI<br>
        Jl. Jenderal Sudirman Kav. 18, Jakarta 10220<br>
        Contact Center: 123 | Email: pln123@pln.co.id</div>
    </div>

    <div class="transaction-info">
        <div class="info-box">
            <div class="info-label">INFORMASI PELANGGAN</div>
            <div class="info-value">
                ID Pelanggan: <?= htmlspecialchars($tagihan['id_pelanggan']) ?><br>
                Nama: <?= htmlspecialchars($tagihan['nama_pelanggan']) ?><br>
                Alamat: <?= htmlspecialchars($tagihan['alamat']) ?><br>
                Daya: <?= htmlspecialchars($tagihan['daya']) ?> VA
            </div>
        </div>
        
        <div class="info-box">
            <div class="info-label">INFORMASI PEMBAYARAN</div>
            <div class="info-value">
                No. Transaksi: <?= htmlspecialchars($pembayaran['id_pembayaran']) ?><br>
                Tanggal Bayar: <?= date('d/m/Y H:i', strtotime($pembayaran['tanggal_pembayaran'])) ?><br>
                Metode Pembayaran: <?= htmlspecialchars($pembayaran['metode_pembayaran']) ?><br>
                Channel: <?= htmlspecialchars($pembayaran['channel_pembayaran'] ?? 'Offline') ?>
            </div>
        </div>
    </div>

    <div class="payment-details">
        <table class="payment-table">
            <thead>
                <tr>
                    <th>DESKRIPSI</th>
                    <th>PERIODE</th>
                    <th>PEMAKAIAN</th>
                    <th>TARIF</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tagihan Listrik</td>
                    <td><?= htmlspecialchars($tagihan['bulan']) ?>/<?= htmlspecialchars($tagihan['tahun']) ?></td>
                    <td><?= format_kwh($tagihan['jumlah_meter']) ?> kWh</td>
                    <td><?= rupiah($tagihan['tarifperkwh']) ?>/kWh</td>
                    <td><?= rupiah($tagihan['jumlah_meter'] * $tagihan['tarifperkwh']) ?></td>
                </tr>
                <tr>
                    <td colspan="4">Biaya Administrasi</td>
                    <td><?= rupiah($pembayaran['biaya_admin']) ?></td>
                </tr>
                <tr style="background-color: #e9f7ef;">
                    <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL PEMBAYARAN</td>
                    <td style="font-weight: bold;"><?= rupiah($pembayaran['total_bayar']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="legal-note">
        <strong>CATATAN HUKUM:</strong><br>
        1. Dokumen ini merupakan bukti pembayaran yang sah<br>
        2. Simpan dokumen ini sebagai arsip pembayaran<br>
        3. Keluhan dapat disampaikan melalui Contact Center PLN<br>
        4. Validasi keaslian dokumen melalui QR code di sistem aplikasi PLN
    </div>

    <div class="print-hide" style="text-align: center; margin-top: 25px;">
        <button onclick="window.print()" style="
            background: #0047ab;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;">
            Cetak Bukti Pembayaran
        </button>
    </div>
</body>
</html>