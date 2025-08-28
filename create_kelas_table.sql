-- SQL untuk membuat tabel kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(10) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` enum('7','8','9') NOT NULL,
  `jurusan` varchar(30) DEFAULT NULL,
  `wali_kelas` varchar(100) DEFAULT NULL,
  `kapasitas` int(3) DEFAULT 30,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_kelas` (`kode_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data contoh
INSERT INTO `kelas` (`kode_kelas`, `nama_kelas`, `tingkat`, `jurusan`, `wali_kelas`, `kapasitas`, `status`) VALUES
('7A', 'VII A', '7', 'Umum', 'Ahmad Sari, S.Pd', 32, 'aktif'),
('7B', 'VII B', '7', 'Umum', 'Siti Nurhaliza, S.Pd', 30, 'aktif'),
('7C', 'VII C', '7', 'Umum', 'Budi Santoso, S.Pd', 31, 'aktif'),
('8A', 'VIII A', '8', 'Umum', 'Rina Kartika, S.Pd', 29, 'aktif'),
('8B', 'VIII B', '8', 'Umum', 'Dedi Mulyadi, S.Pd', 28, 'aktif'),
('8C', 'VIII C', '8', 'Umum', 'Maya Sari, S.Pd', 30, 'aktif'),
('9A', 'IX A', '9', 'IPA', 'Dr. Hendra, S.Pd', 27, 'aktif'),
('9B', 'IX B', '9', 'IPS', 'Lina Marlina, S.Pd', 26, 'aktif'),
('9C', 'IX C', '9', 'IPA', 'Rudi Hermawan, S.Pd', 28, 'aktif');
