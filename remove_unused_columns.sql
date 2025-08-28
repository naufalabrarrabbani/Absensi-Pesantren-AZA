-- Script untuk menghapus kolom yang tidak diperlukan dari tabel karyawan
-- Backup data terlebih dahulu sebelum menjalankan script ini

USE absenaza;

-- Hapus kolom no_telp, nama_ayah, dan agama dari tabel karyawan
ALTER TABLE karyawan 
DROP COLUMN no_telp,
DROP COLUMN nama_ayah,
DROP COLUMN agama;

-- Tampilkan struktur tabel setelah perubahan
DESCRIBE karyawan;
