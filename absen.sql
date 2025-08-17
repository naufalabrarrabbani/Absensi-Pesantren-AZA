-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2021 at 04:49 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `nik` varchar(30) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `masuk` datetime DEFAULT NULL,
  `pulang` datetime DEFAULT NULL,
  `ijin` varchar(25) DEFAULT NULL,
  `update_by` varchar(10) DEFAULT NULL,
  `tw` datetime DEFAULT NULL,
  `shif` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `nik`, `tanggal`, `masuk`, `pulang`, `ijin`, `update_by`, `tw`, `shif`) VALUES
(14, '202016524434007', '2020-07-18', '2020-07-18 06:20:36', '2020-07-18 06:21:04', NULL, NULL, NULL, NULL),
(15, '202016524434011', '2020-07-19', '2020-07-19 22:26:25', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `aplikasi`
--

CREATE TABLE `aplikasi` (
  `id` int(11) NOT NULL,
  `nama_aplikasi` varchar(255) DEFAULT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aplikasi`
--

INSERT INTO `aplikasi` (`id`, `nama_aplikasi`, `nama_perusahaan`, `logo`, `alamat`) VALUES
(1, 'Sistem Absensi Siswa', 'Sistem Absensi Siswa SMP Islam Assholihiyah', 'file_20200707115819.', 'Jl. Desa Leuwibatu RT.01 RW.01 Kecamatan Rumpin Kabupaten Bogor');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `kode_area` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `kode_area`, `area`) VALUES
(1, 'Kota', 'BOGOR');

-- --------------------------------------------------------

--
-- Table structure for table `jobtitle`
--

CREATE TABLE `jobtitle` (
  `id` int(11) NOT NULL,
  `kode_jobtitle` varchar(255) DEFAULT NULL,
  `jobtitle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobtitle`
--

INSERT INTO `jobtitle` (`id`, `kode_jobtitle`, `jobtitle`) VALUES
(4, 'KELAS I', 'KELAS I'),
(5, 'KELAS II', 'KELAS II'),
(6, 'KELAS III', 'KELAS III');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nik` char(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `agama` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `sub_area` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nik`, `password`, `nama`, `job_title`, `no_telp`, `nama_ayah`, `jenis_kelamin`, `agama`, `lokasi`, `area`, `sub_area`, `start_date`, `end_date`, `foto`, `lat`, `lon`) VALUES
(1, '202016524434001', NULL, 'Anisa Putri', 'PENGABDIAN', 'Wiwin', 'Oman', 'Karyawan Swasta', 'Lajang', 'Bogor', 'Masjid', 'Nangkasari Pamijahan', '2020-07-07', '2031-07-31', 'file_20200707144748.2017165002.jpg', NULL, NULL),
(2, '202016524434002', NULL, 'Siti Khaerunnisa', 'PENGABDIAN', 'B', 'A', 'Wiraswasta', 'Lajang', 'Bogor', 'Masjid', 'Nangkasari Pamijahan', '2020-07-07', '2027-07-31', 'file_20200707150956.2017165012.jpg', NULL, NULL),
(3, '202016524434003', NULL, 'Linda Sofi Dirgantini', 'PENGABDIAN', 'B', 'A', 'Karyawan Swasta', 'Lajang', 'Bogor', 'Masjid', 'Nangkasari Pamijahan', '2020-07-07', '2024-07-31', 'file_20200707112449.z linda.jpg', NULL, NULL),
(6, '202016524434007', NULL, 'Lisna Wati', 'PENGABDIAN', 'D', 'C', 'Karyawan Swasta', 'Lajang', 'Bogor', 'Masjid', 'Nangkasari Pamijahan', '2020-07-18', '2025-07-18', 'file_20200718062026.1. LISNA.jpg', NULL, NULL),
(8, '202016524434011', NULL, 'Abdul Holik', 'PENGABDIAN', 'A', 'D', 'Wiraswasta', 'Lajang', 'Bogor', 'Masjid', 'Nangkasari Pamijahan', '2020-07-20', '2025-07-20', 'file_20200719222603.IMG-20200515-WA0013.jpg', NULL, NULL),
(9, '1234567890', NULL, 'TAUPIK NURUR RAHMAN', 'KELAS III', '', '', '', '', 'SMP Assholihiyah', 'Kota', 'Nangkasari Pamijahan', '0000-00-00', '0000-00-00', 'file_20210910043244.photo1626585122.jpeg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `kode`, `lokasi`) VALUES
(1, 'Sekolah', 'SMP Assholihiyah');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id` int(11) NOT NULL,
  `shift` varchar(255) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `shift`, `jam_masuk`, `jam_pulang`) VALUES
(1, 'Shift 1', '00:01:00', '08:00:00'),
(2, 'Shift 2', '08:01:00', '16:00:00'),
(3, 'Shift 3', '16:01:00', '23:59:00'),
(4, 'Non Shift', '08:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sub_area`
--

CREATE TABLE `sub_area` (
  `id` int(11) NOT NULL,
  `kode_subarea` varchar(255) DEFAULT NULL,
  `subarea` varchar(255) DEFAULT NULL,
  `latlong` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_area`
--

INSERT INTO `sub_area` (`id`, `kode_subarea`, `subarea`, `latlong`) VALUES
(1, 'Pamijahan', 'Nangkasari Pamijahan', '-6.208568169767049, 106.71735670712019');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `area`, `level`) VALUES
(1, 'admin', 'admin', 'Administrator', 'all', 'superadmin'),
(2, 'area1', 'area1', 'Admin Terminal 1', 'T1', 'adminarea'),
(3, 'area2', 'area2', 'Admin Terminal 2', 'T2', 'adminarea'),
(4, 'area3', 'area3', 'Admin Terminal 3', 'T3', 'adminarea'),
(5, 'supervisor', 'supervisor', 'Supervisor T1', 'T1', 'supervisor'),
(6, 'rully', 'ManjaddawajaddA', 'Rully Nasrullah', 'Masjid', 'adminarea');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `id` int(11) NOT NULL,
  `level` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`id`, `level`) VALUES
(1, 'superadmin'),
(2, 'adminarea'),
(3, 'supervisor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aplikasi`
--
ALTER TABLE `aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobtitle`
--
ALTER TABLE `jobtitle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_area`
--
ALTER TABLE `sub_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `aplikasi`
--
ALTER TABLE `aplikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobtitle`
--
ALTER TABLE `jobtitle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_area`
--
ALTER TABLE `sub_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
