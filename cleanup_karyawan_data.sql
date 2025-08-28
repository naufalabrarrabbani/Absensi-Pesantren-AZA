-- Script untuk membersihkan data karyawan yang sudah ada
-- Menghapus field yang tidak diperlukan dari data existing

USE absenaza;

-- Update data karyawan yang sudah ada untuk menghilangkan referensi field yang sudah dihapus
UPDATE karyawan SET
    password = COALESCE(password, ''),
    lokasi = COALESCE(lokasi, ''),
    area = COALESCE(area, ''),
    sub_area = COALESCE(sub_area, '');

-- Tampilkan struktur tabel yang sudah diperbarui
DESCRIBE karyawan;
