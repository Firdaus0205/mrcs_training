-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 03:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mrcs_training`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `emel` varchar(100) NOT NULL,
  `katalaluan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `emel`, `katalaluan`) VALUES
(1, 'Admin MRCS', 'admin@redcrescent.org', 'MRCS@2025!@#');

-- --------------------------------------------------------

--
-- Table structure for table `jadual_latihan`
--

CREATE TABLE `jadual_latihan` (
  `id` int(11) NOT NULL,
  `latihan_id` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keputusan_latihan`
--

CREATE TABLE `keputusan_latihan` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `introduction` int(11) DEFAULT NULL,
  `basic` int(11) DEFAULT NULL,
  `advanced` int(11) DEFAULT NULL,
  `psychological` int(11) DEFAULT NULL,
  `bls` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `id` int(11) NOT NULL,
  `nama_kursus` varchar(255) DEFAULT NULL,
  `yuran` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `latihan`
--

CREATE TABLE `latihan` (
  `id` int(11) NOT NULL,
  `nama_kursus` varchar(150) DEFAULT NULL,
  `yuran` decimal(10,2) DEFAULT NULL,
  `tarikh_kursus` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `latihan`
--

INSERT INTO `latihan` (`id`, `nama_kursus`, `yuran`, `tarikh_kursus`) VALUES
(1, 'Introduction First Aid & CPR', 230.00, NULL),
(2, 'Basic First Aid & CPR + AED', 350.00, NULL),
(3, 'Advanced First Aid & CPR', 420.00, NULL),
(4, 'Basic Life Support (BLS)', 280.00, NULL),
(5, 'Psychological First Aid', 500.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `login_peserta`
--

CREATE TABLE `login_peserta` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) DEFAULT NULL,
  `katalaluan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) DEFAULT NULL,
  `amaun` decimal(10,2) DEFAULT NULL,
  `tarikh_bayar` date DEFAULT NULL,
  `kaedah_bayar` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_ic` varchar(20) NOT NULL,
  `kata_laluan` varchar(255) NOT NULL,
  `syarikat` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `nama_kursus` varchar(255) DEFAULT NULL,
  `tarikh_kursus` varchar(100) DEFAULT NULL,
  `kategori` varchar(100) NOT NULL,
  `bulan` varchar(100) NOT NULL,
  `emel` varchar(100) NOT NULL,
  `tarikh_daftar` datetime NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0,
  `markah` int(11) DEFAULT NULL,
  `keputusan` varchar(10) DEFAULT NULL,
  `latihan_id` int(11) DEFAULT NULL,
  `yuran` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `nama`, `no_ic`, `kata_laluan`, `syarikat`, `alamat`, `telefon`, `nama_kursus`, `tarikh_kursus`, `kategori`, `bulan`, `emel`, `tarikh_daftar`, `verified`, `markah`, `keputusan`, `latihan_id`, `yuran`) VALUES
(7, 'SHAHRIN BIN SALAMAT', '910209105667', '$2y$10$k11FviJSWdV5UNvhOk0OEOehdEs31zu1dKeR6d9m3Oi6BIvJbkQMC', 'Good Job Enterprise', 'kampung sebelah rumah', '0122656734', 'Basic First Aid', 'SEPT 22-23 (BM)', 'Basic First Aid', 'SEPT 22-23 (BM)', 'firdaus050213@gmail.com', '2025-07-31 17:18:11', 0, NULL, NULL, NULL, 0.00),
(8, 'HAMBALI KANUBI', '980912-03-9870', '$2y$10$30d71A/mAaOZ.Gu0jdodvOctUcD844f6c9SH6bRdZF7.ggEBbgWq.', 'SYARIKAT BISKUT AWAM', 'KG. SEBELAH\r\nRUMAH', '0199293233', 'Basic First Aid', 'SEPT 22-23 (BM)', 'Basic First Aid', 'SEPT 22-23 (BM)', 'adliabu@gmail.com', '2025-07-31 17:24:29', 0, NULL, NULL, NULL, 0.00),
(9, 'MAMAT TELUR', 'CIPAN KUNUT', '$2y$10$qe9CndD2.nzl1CaKHi0KbuEXPGtez5T9j8aTfY4D5aDMgpTobLmzy', '09233099479', 'KEPALA BATAS, SINGAPORE', 'LIBAT URUT', 'Psychological First Aid', 'APR 28-30 (DWI)', 'Psychological First Aid', 'APR 28-30 (DWI)', 'tuah@13456', '2025-07-31 17:29:01', 0, NULL, NULL, 5, 0.00),
(10, 'Ahmad Firdaus Bin Hang Tuah', '050213140265', '$2y$10$O1WeQXk1mrBqXz8cOdjUxeKng7Gl4QHnrv6dRAG88ahTeY7/eLSpK', 'MRCS KL', 'Bangsar', '0173716946', 'Basic First Aid', 'JAN 20-21 (BM)', 'Basic First Aid', 'JAN 20-21 (BM)', 'firdaus.hangtuah@redcrescent.org.my', '2025-08-04 12:46:52', 0, NULL, NULL, NULL, 0.00),
(11, 'Ahmad Firdaus Bin Hang Tuah', '050213140265', '$2y$10$nJ5oi9u47q.nXGsGryKB0OYnRy/sLithTqXeh6xmBplX/zpX.JHy.', 'MRCS KL', 'Km36,Belakang Klinik Desa Lama, Tanjung Bidara', '0173716946', 'Basic Life Support', 'MAY 5.5.25 (DWI)', 'Basic Life Support', 'MAY 5.5.25 (DWI)', 'firdaus.hangtuah@redcrescent.org.my', '2025-08-04 16:46:39', 0, NULL, NULL, NULL, 0.00),
(12, 'Ali Bin Abu', '050213140265', '$2y$10$U7.5iYktsd.VOlR0cEFKh..ucIM5FjXVNMBun1PncXVbOb5YhlBy2', 'Tampar kang', 'Singapore', '01789992434', 'Introduction First Aid', 'OCT 13.10.25 (BM)', 'Introduction First Aid', 'OCT 13.10.25 (BM)', 'Aliabu@gmail.com', '2025-08-05 11:40:11', 0, NULL, NULL, NULL, 0.00),
(13, 'Ali Bin Abu', '050607141479', '$2y$10$4OS/5W1ygEaPvHPfxaoJw.IYY0QQpN8rBD9UnxqBrisdHF/q9Xb7q', 'Baling Kang', 'Km36,Belakang Klinik Desa Lama, Tanjung Bidara', '01766738493', 'Advanced First Aid', 'APR 28-30 (DWI)', 'Advanced First Aid', 'APR 28-30 (DWI)', 'Aliabu@emel.com', '2025-08-05 11:47:00', 0, NULL, NULL, NULL, 0.00),
(14, 'adli effenddy bin abu', '982306141405', '$2y$10$xbqHccft3u/noPQtIzd.rO7iwmY/X0shhV6PoGRJMnddsLxKYZ2WC', 'Ampang', 'ampang jaya', '01987654321', 'Introduction First Aid', 'JAN 13.1.25 (BI)', 'Introduction First Aid', 'JAN 13.1.25 (BI)', 'adlieffendyabu@gmail.com', '2025-08-06 10:24:09', 0, NULL, NULL, NULL, 0.00),
(15, 'Ahmad Firdaus Bin Hang Tuah', '050213140265', '$2y$10$HCydH9HHolscW/ubYp52A.HNCGbyYC9mxd4hZe8NbJ9rdu3RGbPZy', 'MRCS KL', 'Block 90-09-06 Apartment Abdullah Hukum Putra Ria Bangsar', '0173716946', 'Basic Life Support', 'NOV 3.11.25 (DWI)', 'Basic Life Support', 'NOV 3.11.25 (DWI)', 'firdaus.hangtuah@redcrescent.org.my', '2025-08-06 17:32:42', 0, NULL, NULL, NULL, 0.00),
(16, 'ALI BIN EHSAN', '040513141403', '$2y$10$S1AwJPWEZymH805bWYujBePLccOw6ckLU89pujptCdlPeg8P7Om7y', 'MRCS Durian Runtuh', 'Durian Runtuh Melaka', '0189234245', 'Advanced First Aid', 'APR 28-30 (DWI)', 'Advanced First Aid', 'APR 28-30 (DWI)', 'intanpayung@emel.com', '2025-08-07 16:43:00', 0, NULL, NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `resit`
--

CREATE TABLE `resit` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_ic` varchar(20) NOT NULL,
  `amaun` decimal(10,2) NOT NULL,
  `tarikh_bayar` date NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Menunggu Sahkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resit_invoice`
--

CREATE TABLE `resit_invoice` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) DEFAULT NULL,
  `jenis` enum('Resit','Invois') DEFAULT NULL,
  `nombor_dokumen` varchar(50) DEFAULT NULL,
  `tarikh_terbit` date DEFAULT NULL,
  `amaun` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_bank`
--

CREATE TABLE `transaksi_bank` (
  `id` int(11) NOT NULL,
  `tarikh` date DEFAULT NULL,
  `masa` time DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `amaun` decimal(10,2) DEFAULT NULL,
  `no_rujukan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `no_ic` varchar(20) NOT NULL,
  `peranan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emel` (`emel`);

--
-- Indexes for table `jadual_latihan`
--
ALTER TABLE `jadual_latihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `latihan_id` (`latihan_id`);

--
-- Indexes for table `keputusan_latihan`
--
ALTER TABLE `keputusan_latihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `latihan`
--
ALTER TABLE `latihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_peserta`
--
ALTER TABLE `login_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resit`
--
ALTER TABLE `resit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `resit_invoice`
--
ALTER TABLE `resit_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `transaksi_bank`
--
ALTER TABLE `transaksi_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jadual_latihan`
--
ALTER TABLE `jadual_latihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keputusan_latihan`
--
ALTER TABLE `keputusan_latihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `latihan`
--
ALTER TABLE `latihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_peserta`
--
ALTER TABLE `login_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `resit`
--
ALTER TABLE `resit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resit_invoice`
--
ALTER TABLE `resit_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_bank`
--
ALTER TABLE `transaksi_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadual_latihan`
--
ALTER TABLE `jadual_latihan`
  ADD CONSTRAINT `jadual_latihan_ibfk_1` FOREIGN KEY (`latihan_id`) REFERENCES `latihan` (`id`);

--
-- Constraints for table `keputusan_latihan`
--
ALTER TABLE `keputusan_latihan`
  ADD CONSTRAINT `keputusan_latihan_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_peserta`
--
ALTER TABLE `login_peserta`
  ADD CONSTRAINT `login_peserta_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`);

--
-- Constraints for table `resit`
--
ALTER TABLE `resit`
  ADD CONSTRAINT `resit_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`);

--
-- Constraints for table `resit_invoice`
--
ALTER TABLE `resit_invoice`
  ADD CONSTRAINT `resit_invoice_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
