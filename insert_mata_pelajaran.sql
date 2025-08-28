-- Script untuk menambahkan data mata pelajaran default
USE absenaza;

INSERT INTO mata_pelajaran (kode_mapel, nama_mapel) VALUES
('MTK', 'Matematika'),
('IPA', 'Ilmu Pengetahuan Alam'),
('IPS', 'Ilmu Pengetahuan Sosial'),
('BIND', 'Bahasa Indonesia'),
('BARA', 'Bahasa Arab'),
('BING', 'Bahasa Inggris'),
('SKI', 'Sejarah Kebudayaan Islam'),
('FIQIH', 'Fiqih'),
('AQIDAH', 'Aqidah Akhlak'),
('QURAN', 'Al-Quran Hadits');

-- Tampilkan hasil
SELECT * FROM mata_pelajaran;
