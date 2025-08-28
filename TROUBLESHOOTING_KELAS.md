# Troubleshooting Kelas Modern

## Problem: kelas_modern.php belum terbaca

### Langkah Troubleshooting:

### 1. **Test Basic Functionality**
Akses file-file test ini secara berurutan:

1. **Test Server & PHP**: 
   ```
   http://localhost/Absensi-Pesantren-AZA/test_kelas.php
   ```

2. **Debug Database & Tabel**: 
   ```
   http://localhost/Absensi-Pesantren-AZA/debug_kelas.php
   ```

3. **Setup Tabel Kelas** (jika belum ada):
   ```
   http://localhost/Absensi-Pesantren-AZA/setup_kelas.php
   ```

### 2. **Check Prerequisites**

**Database:**
- ✅ Pastikan database MySQL/MariaDB berjalan
- ✅ Pastikan tabel `kelas` sudah dibuat
- ✅ Pastikan tabel `aplikasi` ada dan berisi data

**Session:**
- ✅ Pastikan sudah login sebagai admin
- ✅ Session `$_SESSION['username']` harus ada

**Files:**
- ✅ Pastikan file `include/koneksi.php` ada dan benar
- ✅ Pastikan `app/kelas_modern.php` ada dan tidak corrupt

### 3. **Manual Database Setup**

Jika setup otomatis gagal, jalankan SQL ini manual:

```sql
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

INSERT INTO `kelas` VALUES
(1,'7A','VII A','7','Umum','Ahmad Sari, S.Pd',32,'aktif',NOW(),NOW()),
(2,'7B','VII B','7','Umum','Siti Nurhaliza, S.Pd',30,'aktif',NOW(),NOW()),
(3,'7C','VII C','7','Umum','Budi Santoso, S.Pd',31,'aktif',NOW(),NOW()),
(4,'8A','VIII A','8','Umum','Rina Kartika, S.Pd',29,'aktif',NOW(),NOW()),
(5,'8B','VIII B','8','Umum','Dedi Mulyadi, S.Pd',28,'aktif',NOW(),NOW()),
(6,'8C','VIII C','8','Umum','Maya Sari, S.Pd',30,'aktif',NOW(),NOW()),
(7,'9A','IX A','9','IPA','Dr. Hendra, S.Pd',27,'aktif',NOW(),NOW()),
(8,'9B','IX B','9','IPS','Lina Marlina, S.Pd',26,'aktif',NOW(),NOW()),
(9,'9C','IX C','9','IPA','Rudi Hermawan, S.Pd',28,'aktif',NOW(),NOW());
```

### 4. **Access Methods**

**Cara 1 - Via Dashboard:**
1. Login ke admin: `http://localhost/Absensi-Pesantren-AZA/login.php`
2. Masuk dashboard: `http://localhost/Absensi-Pesantren-AZA/app/home_modern.php`
3. Klik menu "Kelas" di sidebar

**Cara 2 - Direct Access:**
```
http://localhost/Absensi-Pesantren-AZA/app/kelas_modern.php
```

### 5. **Common Issues & Solutions**

| Issue | Solution |
|-------|----------|
| Error 404 | Check file path and existence |
| Database Error | Run `debug_kelas.php` first |
| Access Denied | Login sebagai admin dulu |
| Blank Page | Check PHP error log |
| Table doesn't exist | Run `setup_kelas.php` |

### 6. **Error Checking**

**PHP Error Log:**
- Check: `xampp/php/logs/php_error_log`
- Enable error display: Add `ini_set('display_errors', 1);` di top file PHP

**MySQL Error:**
- Check connection in `include/koneksi.php`
- Test query manual di phpMyAdmin

### 7. **Alternative Access**

Jika masih bermasalah, coba akses via:

1. **Direct File Management**: 
   - phpMyAdmin untuk database
   - File manager untuk cek file

2. **Alternative Path**:
   ```
   http://127.0.0.1/Absensi-Pesantren-AZA/app/kelas_modern.php
   ```

### 8. **Success Indicators**

Jika berhasil, Anda akan melihat:
- ✅ Halaman dengan header "Master Data Kelas"
- ✅ Statistik cards (Total Kelas, Kelas Aktif, dll)
- ✅ Tabel data kelas
- ✅ Tombol "Tambah Kelas"
- ✅ Sidebar dengan menu navigation

---

**Quick Start:**
1. Akses `test_kelas.php` → `debug_kelas.php` → `setup_kelas.php`
2. Login sebagai admin
3. Akses `app/kelas_modern.php`
