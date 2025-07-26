-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Jul 2025 pada 12.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pln_pascabayar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'Administrator'),
(2, 'Petugas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nomor_kwh` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_tarif` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `nomor_kwh`, `nama_pelanggan`, 
`alamat`, `telepon`, `email`, `id_tarif`, `created_at`, `updated_at`) VALUES
(2, 'pelanggan', '$2y$10$YEtqGUA6z1SvSSlDS.DTYuGrHKcH.FLiAEH55U5/9eXY9Kz/nrUJK', '607855556446', 'Jonathan Muller', 'Kompl Duta Garden G-7/45, Dki Jakarta, Jakarta, Kode Pos: 15124', '081234567890', 'jonmuller@gmail.com', 6, '2025-02-05 18:06:56', '2025-02-23 21:52:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_tagihan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL DEFAULT current_timestamp(),
  `bulan_bayar` enum('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') NOT NULL,
  `biaya_admin` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_bayar` decimal(10,2) NOT NULL,
  `metode_pembayaran` enum('Tunai','Transfer','E-Wallet') NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_tagihan`, `id_pelanggan`, `tanggal_pembayaran`, `bulan_bayar`, `biaya_admin`, `total_bayar`, `metode_pembayaran`, `id_user`) VALUES
(8, 16, 2, '2025-02-24 07:15:40', 'Januari', 2500.00, 427382.50, 'Transfer', 1),
(9, 17, 2, '2025-02-24 07:32:53', 'Februari', 2500.00, 257429.50, 'E-Wallet', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggunaan`
--

CREATE TABLE `penggunaan` (
  `id_penggunaan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `bulan` enum('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') NOT NULL,
  `tahun` year(4) NOT NULL,
  `meter_awal` int(11) NOT NULL,
  `meter_akhir` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data untuk tabel `penggunaan`
--

INSERT INTO `penggunaan` (`id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `meter_awal`, `meter_akhir`, `created_at`) VALUES
(16, 2, 'Januari', '2025', 0, 250, '2025-02-24 00:12:37'),
(17, 2, 'Februari', '2025', 250, 400, '2025-02-24 00:12:50'),
(18, 2, 'Maret', '2025', 400, 550, '2025-02-24 00:13:05'),
(19, 2, 'April', '2025', 550, 700, '2025-02-24 00:32:00');

--
-- Trigger `penggunaan`
--
DELIMITER $$
CREATE TRIGGER `after_penggunaan_insert` AFTER INSERT ON `penggunaan` FOR EACH ROW BEGIN
    -- Hitung jumlah meter
    DECLARE jumlah_meter DECIMAL(10, 2);
    SET jumlah_meter = NEW.meter_akhir - NEW.meter_awal;

    -- Masukkan data ke tabel tagihan
    INSERT INTO tagihan (
        id_penggunaan,
        id_pelanggan,
        bulan,
        tahun,
        jumlah_meter,
        status,
        tanggal_tagihan
    ) VALUES (
        NEW.id_penggunaan,
        NEW.id_pelanggan,
        NEW.bulan,
        NEW.tahun,
        jumlah_meter,
        'Belum Lunas', -- Status awal
        CURDATE()      -- Tanggal tagihan hari ini
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_penggunaan` AFTER UPDATE ON `penggunaan` FOR EACH ROW BEGIN
    -- Pastikan hanya update yang mengubah meter_awal atau meter_akhir yang akan mempengaruhi tagihan
    IF OLD.meter_awal <> NEW.meter_awal OR OLD.meter_akhir <> NEW.meter_akhir THEN
        UPDATE tagihan 
        SET jumlah_meter = (NEW.meter_akhir - NEW.meter_awal)
        WHERE id_penggunaan = NEW.id_penggunaan;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` int(11) NOT NULL,
  `id_penggunaan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `bulan` enum('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') NOT NULL,
  `tahun` year(4) NOT NULL,
  `jumlah_meter` decimal(10,2) NOT NULL,
  `status` enum('Belum Lunas','Menunggu Verifikasi','Lunas','Ditolak') NOT NULL DEFAULT 'Belum Lunas',
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_tagihan` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `id_penggunaan`, `id_pelanggan`, `bulan`, `tahun`, `jumlah_meter`, `status`, `bukti_pembayaran`, `tanggal_tagihan`) VALUES
(16, 16, 2, 'Januari', '2025', 250.00, 'Lunas', 'bukti_1740356019_67bbb9b37d43d.jpg', '2025-02-24'),
(17, 17, 2, 'Februari', '2025', 150.00, 'Lunas', 'bukti_1740356849_67bbbcf1a88d7.jpg', '2025-02-24'),
(18, 18, 2, 'Maret', '2025', 150.00, 'Belum Lunas', NULL, '2025-02-24'),
(19, 19, 2, 'April', '2025', 150.00, 'Menunggu Verifikasi', 'bukti_1740389011_67bc3a9310f28.jpg', '2025-02-24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(11) NOT NULL,
  `daya` varchar(50) NOT NULL,
  `tarifperkwh` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `daya`, `tarifperkwh`, `deskripsi`) VALUES
(1, '450 VA', 450.00, 'Kapasitas 450 VA ini cocok untuk instalasi dengan kebutuhan listrik minimal, mendukung peralatan dasar dengan beban rendah.'),
(2, '900 VA', 1352.00, 'Daya 900 VA menyediakan kapasitas yang cukup untuk instalasi dengan beban sedang, mendukung sejumlah perangkat standar.'),
(3, '1300 VA', 1444.70, 'Instalasi dengan kapasitas 1300 VA ideal untuk kebutuhan listrik yang lebih beragam, menyediakan ruang bagi perangkat dengan beban menengah.'),
(4, '2200 VA', 1444.70, 'Daya 2200 VA dirancang untuk mendukung instalasi dengan peningkatan beban listrik, memberikan performa stabil untuk perangkat tambahan.'),
(5, '3500-5500 VA', 1699.53, 'Rentang daya 3500-5500 VA sesuai untuk instalasi dengan kebutuhan listrik variatif, cocok bagi lingkungan dengan kapasitas menengah hingga tinggi.'),
(6, '6600 VA ke atas', 1699.53, 'Kategori 6600 VA ke atas dirancang untuk instalasi dengan beban listrik tinggi, memberikan dukungan optimal bagi penggunaan intensif.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `id_level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_admin`, `email`, `foto_profil`, `id_level`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$RBzAM9M/n../gZHFEfaWeeaOyrszhLLmodRZlgA441fOsXI9K.Z4C', 'Muhammad Rohman Syah', 'admin@gmail.com', 'profile-img.jpg', 1, '2025-02-03 13:19:18', '2025-02-24 00:34:16'),
(2, 'petugas', '$2y$10$eBGDuo2Cwi6llM9DusVoX.tUVr0k//fSBJIwxqYVoMPSPXjSmV4mK', 'Miselsa Anisdria Susanto', 'petugas@gmail.com', 'messages-2.jpg', 2, '2025-02-03 14:12:01', '2025-02-23 23:28:50');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`),
  ADD UNIQUE KEY `nama_level` (`nama_level`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nomor_kwh` (`nomor_kwh`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_tarif` (`id_tarif`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `unique_pembayaran` (`id_tagihan`,`id_pelanggan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD UNIQUE KEY `unique_penggunaan` (`id_pelanggan`,`bulan`,`tahun`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD UNIQUE KEY `unique_tagihan` (`id_pelanggan`,`bulan`,`tahun`),
  ADD KEY `id_penggunaan` (`id_penggunaan`);

--
-- Indeks untuk tabel `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`),
  ADD UNIQUE KEY `daya` (`daya`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  MODIFY `id_penggunaan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif` (`id_tarif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_tagihan`) REFERENCES `tagihan` (`id_tagihan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayaran_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penggunaan`
--
ALTER TABLE `penggunaan`
  ADD CONSTRAINT `penggunaan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan` (`id_penggunaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
