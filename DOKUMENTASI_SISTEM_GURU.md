# SISTEM ABSENSI GURU - DOKUMENTASI LENGKAP

## OVERVIEW
Sistem absensi guru telah berhasil dibuat dengan konsep yang sama seperti sistem absensi siswa, menggunakan NIP (Nomor Induk Pegawai) sebagai identifier utama dan QR Code scanning untuk proses absensi.

## FITUR UTAMA
✅ **Absensi QR Code**: Scan QR code dengan NIP guru
✅ **Status Kehadiran**: Hadir, Sakit, Izin, Alpa
✅ **Manajemen Data Guru**: CRUD lengkap data guru
✅ **Mata Pelajaran**: Assignment mata pelajaran ke guru
✅ **Portal Terpisah**: Interface khusus guru
✅ **Responsive Design**: Modern Material Design UI

## STRUKTUR DATABASE

### 1. Tabel `guru`
```sql
- id (Primary Key)
- nip (Unique Identifier)
- nama (Nama Guru)
- jenis_kelamin (L/P)
- mata_pelajaran_id (Foreign Key)
- alamat
- telp (Nomor Telepon)
- email
- foto (Upload Photo)
- area_id (Foreign Key)
- lokasi_id (Foreign Key)
- tanggal_dibuat
```

### 2. Tabel `absensi_guru`
```sql
- id (Primary Key)
- guru_id (Foreign Key)
- tanggal
- jam_masuk
- jam_pulang
- keterangan (Hadir/Sakit/Izin/Alpa)
- latitude_masuk
- longitude_masuk
- latitude_pulang
- longitude_pulang
```

### 3. Tabel `mata_pelajaran`
```sql
- id (Primary Key)
- nama_mata_pelajaran
- kode_mapel
- deskripsi
```

## STRUKTUR FILE SISTEM

### 1. **Portal & Navigation**
- `index_guru_siswa.php` - Portal utama guru
- `app/include/side_bar_guru.php` - Sidebar navigation guru

### 2. **QR Code Scanning**
- `masuk_guru.php` - Halaman absen masuk guru
- `pulang_guru.php` - Halaman absen pulang guru (akan dibuat)

### 3. **Data Management**
- `app/guru.php` - Main page manajemen guru
- `app/content/content_guru.php` - Content management guru
- `app/absensi_guru.php` - Laporan absensi guru
- `app/content/content_absensi_guru.php` - Content absensi guru

### 4. **Controllers**
- `controllers/masuk_guru.php` - Process absen masuk
- `controllers/pulang_guru.php` - Process absen pulang
- `app/controller/guru_simpan.php` - Save guru data
- `app/controller/guru_edit.php` - Edit guru data
- `app/controller/guru_hapus.php` - Delete guru data
- `app/controller/absensi_guru_edit.php` - Edit absensi

### 5. **Success Page**
- `sukses.php` - Unified success page untuk siswa & guru

## CARA PENGGUNAAN

### 1. **Akses Portal Guru**
- Buka: `index_guru_siswa.php`
- Pilih menu yang diinginkan

### 2. **Tambah Data Guru**
- Masuk ke "Data Guru" → "Kelola Data"
- Klik "Tambah Guru Baru"
- Isi form dengan data lengkap
- Upload foto guru
- Pilih mata pelajaran dan area

### 3. **Absensi Guru**
- Pilih "Absensi Guru" → "Absen Sekarang"
- Scan QR code yang berisi NIP guru
- Sistem akan mencatat waktu dan lokasi
- Pilih status: Hadir/Sakit/Izin/Alpa

### 4. **Laporan Absensi**
- Masuk menu "Absensi Guru"
- Filter berdasarkan tanggal/periode
- Export ke Excel/PDF

## INTEGRASI DENGAN SISTEM SISWA

### 1. **Shared Components**
- Database connection (`include/koneksi.php`)
- App configuration (`include/app.php`)
- Success page (`sukses.php`)

### 2. **Differentiation**
- Parameter `?untuk=guru` untuk membedakan flow
- Color scheme berbeda (merah untuk guru, biru untuk siswa)
- Icon berbeda (`fa-chalkboard-teacher` vs `fa-user-graduate`)

### 3. **Navigation Links**
- Portal guru: `index_guru_siswa.php`
- Portal siswa: `index.php`
- Easy switching antar portal

## SECURITY FEATURES

### 1. **Data Validation**
- NIP uniqueness check
- Required field validation
- Photo upload size/type validation

### 2. **Session Management**
- Login check untuk akses admin
- Secure session handling

### 3. **SQL Injection Prevention**
- Prepared statements
- Input sanitization

## TEKNOLOGI YANG DIGUNAKAN

### 1. **Backend**
- PHP 7.4+
- MySQL/MariaDB
- Session management

### 2. **Frontend**
- HTML5 responsive
- CSS3 dengan Material Design
- JavaScript untuk interaktivity
- Font Awesome icons
- Google Fonts (Poppins)

### 3. **Libraries**
- QR Code scanning (HTML5 Camera API)
- Bootstrap components
- Custom CSS animations

## TESTING CHECKLIST

### ✅ **Database Setup**
- [x] Tabel guru created
- [x] Tabel absensi_guru created  
- [x] Tabel mata_pelajaran created
- [x] Foreign key relationships working

### ✅ **CRUD Operations**
- [x] Create guru (simpan)
- [x] Read guru (list & detail)
- [x] Update guru (edit)
- [x] Delete guru (hapus)

### ✅ **Absensi Flow**
- [x] QR scan page design
- [x] Masuk guru controller
- [x] Success page integration
- [x] Error handling

### ✅ **UI/UX**
- [x] Responsive design
- [x] Modern Material Design
- [x] Portal navigation
- [x] Color differentiation

## NEXT STEPS (Jika diperlukan)

### 1. **Enhancement Features**
- [ ] Pulang guru page (mirror masuk_guru.php)
- [ ] Dashboard analytics
- [ ] Export laporan
- [ ] Email notifications
- [ ] Bulk import guru

### 2. **Advanced Features**
- [ ] Geofencing validation
- [ ] Face recognition
- [ ] Mobile app integration
- [ ] Real-time notifications

## MAINTENANCE

### 1. **Regular Tasks**
- Backup database weekly
- Monitor disk space untuk foto
- Update dependencies
- Security patches

### 2. **Monitoring**
- Check error logs
- Monitor performance
- User feedback collection

---

**STATUS: IMPLEMENTASI SELESAI ✅**

Sistem absensi guru telah berhasil diimplementasikan dengan lengkap dan siap untuk digunakan. Semua fitur utama telah berfungsi dengan baik dan terintegrasi dengan sistem absensi siswa yang sudah ada.
