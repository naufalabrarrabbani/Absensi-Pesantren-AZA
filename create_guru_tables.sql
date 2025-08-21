-- SQL untuk membuat tabel guru dan absensi_guru

-- Tabel untuk data guru
CREATE TABLE IF NOT EXISTS `guru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` char(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `mata_pelajaran` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `agama` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `sub_area` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabel untuk absensi guru
CREATE TABLE IF NOT EXISTS `absensi_guru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(30) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `masuk` datetime DEFAULT NULL,
  `pulang` datetime DEFAULT NULL,
  `ijin` varchar(25) DEFAULT NULL,
  `status_tidak_masuk` enum('alpha','sakit','izin') DEFAULT NULL,
  `update_by` varchar(10) DEFAULT NULL,
  `tw` datetime DEFAULT NULL,
  `shif` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabel untuk mata pelajaran (mirip seperti jobtitle untuk kelas)
CREATE TABLE IF NOT EXISTS `mata_pelajaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Insert beberapa mata pelajaran default
INSERT INTO `mata_pelajaran` (`kode_mapel`, `nama_mapel`) VALUES
('MTK', 'Matematika'),
('IPA', 'Ilmu Pengetahuan Alam'),
('IPS', 'Ilmu Pengetahuan Sosial'),
('BIND', 'Bahasa Indonesia'),
('BING', 'Bahasa Inggris'),
('PJOK', 'Pendidikan Jasmani'),
('SBK', 'Seni Budaya'),
('PKN', 'Pendidikan Kewarganegaraan'),
('PAI', 'Pendidikan Agama Islam'),
('PAK', 'Pendidikan Agama Kristen'),
('PJOK', 'Prakarya'),
('BK', 'Bimbingan Konseling');
