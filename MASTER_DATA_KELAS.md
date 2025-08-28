# Master Data Kelas - Dokumentasi

## Overview
Fitur Master Data Kelas memungkinkan admin untuk mengelola data kelas di sekolah dengan sistem CRUD (Create, Read, Update, Delete) yang lengkap.

## Fitur Utama

### 1. Dashboard Statistik
- **Total Kelas**: Menampilkan jumlah total kelas yang terdaftar
- **Kelas Aktif**: Menampilkan jumlah kelas dengan status aktif
- **Kelas Nonaktif**: Menampilkan jumlah kelas dengan status nonaktif

### 2. Tabel Data Kelas
- **Kode Kelas**: Kode unik untuk setiap kelas (contoh: 7A, 8B, 9C)
- **Nama Kelas**: Nama lengkap kelas (contoh: VII A, VIII B, IX C)
- **Tingkat**: Tingkat kelas (7, 8, atau 9)
- **Jurusan**: Jurusan kelas (IPA, IPS, Umum)
- **Wali Kelas**: Nama wali kelas
- **Kapasitas**: Jumlah maksimal siswa per kelas
- **Status**: Aktif atau Nonaktif

### 3. Form Tambah Kelas
- Input validation untuk semua field
- Dropdown tingkat dengan pilihan (Kelas 7, 8, 9)
- Auto-suggest untuk wali kelas dari data guru
- Setting kapasitas dengan default 30 siswa

### 4. Form Edit Kelas
- Memungkinkan update semua data kelas
- Mengubah status aktif/nonaktif
- Validasi untuk mencegah duplikasi kode kelas

### 5. Fitur Pencarian
- Real-time search untuk semua field
- Filter berdasarkan kode kelas, nama kelas, tingkat, jurusan, dan wali kelas

### 6. Hapus Kelas
- Konfirmasi sebelum menghapus
- Soft delete dengan mengubah status menjadi nonaktif (opsional)

## Struktur Database

```sql
CREATE TABLE `kelas` (
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
```

## Integrasi dengan Sistem Lain

### 1. Form Siswa
- Field "Lokasi" di form siswa sekarang menggunakan data dari tabel kelas
- Dropdown menampilkan format: "Nama Kelas (Kode Kelas)"
- Hanya menampilkan kelas dengan status aktif

### 2. Sidebar Navigation
- Menu "Kelas" ditambahkan ke sidebar di bagian "Master Data"
- Konsisten di semua halaman admin

### 3. User Experience
- Design modern dengan Bootstrap 5
- Responsive untuk semua ukuran layar
- Animasi hover dan transisi yang smooth
- Icon Font Awesome untuk visual yang menarik

## File yang Dibuat/Dimodifikasi

### File Baru:
1. `app/kelas_modern.php` - Halaman utama master data kelas
2. `create_kelas_table.sql` - Script SQL untuk membuat tabel dan data awal

### File yang Dimodifikasi:
1. `app/home_modern.php` - Menambahkan menu "Kelas" di sidebar
2. `app/karyawan_modern.php` - 
   - Update sidebar dengan menu "Kelas"
   - Update form tambah siswa menggunakan data kelas
3. `app/karyawan_edit_modern.php` - Update form edit siswa menggunakan data kelas

## Cara Menggunakan

### 1. Setup Database
```bash
# Jalankan SQL script untuk membuat tabel kelas
mysql -u username -p database_name < create_kelas_table.sql
```

### 2. Akses Halaman
- Buka halaman admin
- Klik menu "Kelas" di sidebar bagian "Master Data"

### 3. Menambah Kelas Baru
- Klik tombol "Tambah Kelas"
- Isi form dengan data yang diperlukan
- Klik "Simpan"

### 4. Mengedit Kelas
- Klik icon edit (pensil) di kolom aksi
- Update data yang diperlukan
- Klik "Update"

### 5. Menghapus Kelas
- Klik icon hapus (tong sampah) di kolom aksi
- Konfirmasi penghapusan

### 6. Mencari Kelas
- Gunakan kotak pencarian di atas tabel
- Hasil akan difilter secara real-time

## Keamanan
- Semua query menggunakan prepared statements
- Validasi input di sisi server
- Session management untuk akses admin
- XSS protection pada output

## Responsive Design
- Mobile-first approach
- Optimal di desktop, tablet, dan mobile
- Touch-friendly untuk perangkat mobile

## Notifikasi
- Success message saat operasi berhasil
- Error message saat operasi gagal
- Auto-hide alerts setelah 5 detik

Fitur Master Data Kelas ini menyediakan solusi lengkap untuk mengelola data kelas di sistem absensi sekolah dengan interface yang modern dan user-friendly.
