-- Update database structure
USE absenaza;

-- Add status column for tracking absence reasons
ALTER TABLE absensi ADD COLUMN status_tidak_masuk ENUM('alpha', 'sakit', 'izin') NULL AFTER ijin;

-- Add comments for clarity
ALTER TABLE absensi MODIFY COLUMN status_tidak_masuk ENUM('alpha', 'sakit', 'izin') NULL COMMENT 'Status untuk siswa yang tidak masuk: alpha (tanpa keterangan), sakit, izin';
