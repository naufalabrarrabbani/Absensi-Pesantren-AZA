# 📱 Sistem Absensi Sekolah - Modern Edition

Sistem absensi digital untuk sekolah dengan interface modern berbasis web. Project ini menggunakan PHP Native dengan database MySQL dan desain UI modern yang responsive.

## ✨ Features

### 🎨 Modern UI Design
- **Dashboard Modern**: Interface PowerHuman-inspired dengan cards dan statistik real-time
- **Responsive Design**: Optimized untuk desktop dan mobile
- **Modern Typography**: Menggunakan font Poppins
- **Consistent Design System**: Unified buttons, cards, dan color scheme

### 👥 Management Sistem
- **Student Management**: CRUD siswa dengan foto profil
- **Attendance Tracking**: Monitoring absensi dengan filter status
- **Area Management**: Manajemen lokasi absensi
- **Settings Panel**: Konfigurasi aplikasi lengkap

### 📋 Attendance Features
- **QR Code Scanning**: Absen menggunakan QR code scanner
- **Real-time Statistics**: Dashboard dengan data live
- **Time-based Control**: Pengaturan jam masuk/pulang
- **Location-based**: Radius control untuk absensi
- **Photo Verification**: Selfie requirement untuk validasi

## 🛠️ Tech Stack

- **Backend**: PHP Native
- **Database**: MySQL
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Icons**: Font Awesome 6.4.0
- **Fonts**: Google Fonts (Poppins)
- **Server**: XAMPP (Apache + MySQL)

## 📁 Project Structure

```
absen/
├── app/                          # Admin panel (Modern UI)
│   ├── home_modern.php          # Dashboard utama
│   ├── karyawan_modern.php      # Management siswa  
│   ├── absensi_modern.php       # Tracking absensi
│   ├── area_modern.php          # Management area
│   ├── setting_modern.php       # Pengaturan sistem
│   └── setting_update.php       # Handler pengaturan
├── controllers/                  # Business logic
│   ├── login_proses.php         # Authentication
│   ├── logout.php               # Session termination
│   ├── masuk.php                # Check-in process
│   └── pulang.php               # Check-out process
├── include/                      # Shared components
│   ├── koneksi.php              # Database connection
│   └── app.php                  # App configuration
├── css/                          # Stylesheets
├── images/                       # Assets dan uploaded files
├── masuk.php                    # Check-in interface
├── pulang.php                   # Check-out interface
├── login.php                    # Login interface
├── index.php                    # Landing page
└── absen.sql                    # Database schema
```

## 🚀 Installation

### Prerequisites
- XAMPP atau LAMP/WAMP stack
- PHP 7.4+
- MySQL 5.7+
- Modern web browser

### Setup Steps

1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd absen
   ```

2. **Database Setup**
   - Start XAMPP (Apache + MySQL)
   - Import `absen.sql` ke phpMyAdmin
   - Database name: `absenaza`

3. **Configuration**
   - Update `include/koneksi.php` sesuai database settings
   - Adjust `include/app.php` untuk app configuration

4. **File Permissions**
   ```bash
   chmod 755 app/images/
   chmod 755 uploads/
   ```

5. **Access Application**
   - Open browser: `http://localhost/absen`
   - Login admin: `http://localhost/absen/login.php`

## 👤 Default Login

**Admin Account:**
- Username: `admin`
- Password: `admin123`

## 📱 Usage

### For Students/Staff:
1. **Check-in**: Visit `/masuk.php` → Scan QR code
2. **Check-out**: Visit `/pulang.php` → Scan QR code

### For Administrators:
1. **Login**: `/login.php` with admin credentials
2. **Dashboard**: View real-time statistics and attendance data
3. **Student Management**: Add, edit, delete student records
4. **Attendance Tracking**: Monitor and filter attendance records
5. **Area Management**: Configure attendance locations
6. **Settings**: Customize app configuration

## 🎯 Key Features Details

### Modern Dashboard
- 📊 Real-time attendance statistics
- 👥 Student data overview with avatars
- 📈 Attendance by area breakdown
- 🕐 Recent activity tracking

### Student Management
- 📝 Full CRUD operations
- 📷 Photo profile management
- 🏷️ Status badges and filtering
- 🔍 Search and sort functionality

### Attendance System
- 📱 QR code integration
- 📍 GPS location verification
- 🕒 Time-based controls
- 📸 Selfie verification option

### Responsive Design
- 💻 Desktop-optimized layout
- 📱 Mobile-friendly interface
- 🎨 Consistent design language
- ⚡ Fast loading performance

## 🔧 Configuration

### Time Settings
- Jam masuk default: 07:00
- Jam pulang default: 15:00
- Toleransi keterlambatan: 15 menit

### Location Settings
- Radius absensi: 100 meter (configurable)
- GPS verification: Optional

### Photo Settings
- Selfie requirement: Configurable
- Photo upload: Max 2MB
- Supported formats: JPG, PNG, GIF

## 🤝 Contributing

1. Fork the project
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🐛 Bug Reports & Feature Requests

Jika menemukan bug atau ingin request feature baru, silakan buat issue di repository ini.

## 📞 Support

Untuk support dan pertanyaan, silakan contact:
- Email: [your-email]
- GitHub Issues: [repository-issues-url]

---

**Made with ❤️ for Indonesian Schools**

*Modern attendance system designed for efficiency and ease of use.*
