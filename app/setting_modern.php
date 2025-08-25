<?php
include '../include/koneksi.php';
// memulai session

session_start();
error_reporting(0);
/**
 * Jika Tidak login atau sudah login tapi bukan sebagai admin
 * maka akan dibawa kembali kehalaman login atau menuju halaman yang seharusnya.
 */
if ( !isset($_SESSION['level'])) {
	header('location:../login.php');
	exit();
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
        
        html, body {
            font-family: "Poppins";
            font-style: normal;
            background-color: #F8F8FA;
            overflow-x: hidden;
            position: relative;
        }

        .btn-statistics, .nav-input, .nav-input-group .btn-nav-input, .nav .btn-notif, #toggle-navbar {
            background-color: transparent;
            border: none;
            outline: none;
        }

        .screen-cover {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.4);
            display: block;
        }

        #toggle-navbar {
            margin-right: 15px;
            display: block;
        }
        @media (min-width: 1200px) {
            #toggle-navbar {
                display: none;
            }
        }

        aside {
            background-color: #fff;
            padding: 50px 20px;
            padding-bottom: 250px;
            height: 100vh;
            overflow-y: scroll;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
            width: 260px;
        }
        aside #toggle-navbar {
            margin-left: 20px;
        }

        .sidebar-logo {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            text-decoration: none;
            margin-bottom: 30px;
            padding: 0 8px;
        }
        @media (min-width: 1200px) {
            .sidebar-logo {
                padding: 0 16px;
                justify-content: center;
            }
        }
        .sidebar-logo span {
            font-weight: 700;
            font-size: 16px;
            line-height: 22px;
            color: #121F3E;
            margin-top: 8px;
            white-space: nowrap;
            text-align: center;
        }
        
        .sidebar-logo img {
            flex-shrink: 0;
        }
        
        .sidebar-logo .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            min-width: 0;
        }
        
        .sidebar-title {
            font-weight: 400;
            font-size: 14px;
            line-height: 21px;
            color: #ABB3C4;
            margin-top: 40px;
            margin-bottom: 12px;
        }
        
        .sidebar-item {
            text-decoration: none;
            display: block;
            background: transparent;
            height: 46px;
            border-radius: 16px;
            padding: 0 11px;
            margin-bottom: 8px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-item.active {
            background: #4640DE;
        }
        .sidebar-item.active span {
            color: #fff;
        }
        .sidebar-item.active svg path,
        .sidebar-item.active i {
            color: #fff;
        }
        .sidebar-item i {
            width: 18px;
            height: 18px;
            margin-right: 20px;
            color: #ABB3C4;
            font-size: 18px;
        }
        .sidebar-item span {
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #121F3E;
        }

        .sidebar-item:hover {
            background: #f8f9fa;
            text-decoration: none;
        }

        .col-navbar {
            transition: 1s;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 50px 14px 24px 14px;
        }
        @media (min-width: 768px) {
            .nav {
                flex-wrap: nowrap;
            }
        }
        @media (min-width: 1200px) {
            .nav {
                padding: 50px 64px 24px 0px;
            }
        }
        .nav .btn-notif {
            width: 46px;
            height: 46px;
            background: #fff;
            border-radius: 50%;
            margin-left: 20px;
        }
        .nav .btn-notif i {
            font-size: 20px;
            color: #121F3E;
        }
        @media (min-width: 992px) {
            .nav .btn-notif {
                width: 52px;
                height: 52px;
            }
        }

        .nav-title {
            font-weight: 600;
            font-size: 32px;
            line-height: 48px;
            color: #121F3E;
        }
        
        .nav-input-container {
            width: 100%;
        }
        @media (min-width: 768px) {
            .nav-input-container {
                width: auto;
            }
        }
        
        .nav-input-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 46px;
            padding: 0 18px;
            width: 100%;
            background: #fff;
            border-radius: 100px;
        }
        .nav-input-group .btn-nav-input {
            width: auto;
        }
        @media (min-width: 768px) {
            .nav-input-group {
                width: 400px !important;
            }
        }
        @media (min-width: 992px) {
            .nav-input-group {
                width: 400px;
            }
        }
        @media (min-width: 1200px) {
            .nav-input-group {
                width: 500px;
            }
        }
        
        .nav-input {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            font-style: italic;
            font-weight: 300;
            font-size: 12px;
            line-height: 18px;
            color: #ABB3C4;
            width: 100%;
            border: none;
            outline: none;
        }
        @media (min-width: 576px) {
            .nav-input {
                font-weight: 300;
                font-size: 16px;
                line-height: 24px;
            }
        }

        .content {
            padding: 10px 14px 24px 14px;
        }
        @media (min-width: 1200px) {
            .content {
                padding: 0px 64px 0px 0px;
            }
        }

        .content-title {
            font-weight: 500;
            font-size: 20px;
            line-height: 30px;
            color: #121F3E;
        }
        .content-title:first-of-type {
            margin-top: 5px;
        }
        .content-desc {
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #ABB3C4;
        }

        .modern-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        
        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.1);
        }

        .setting-group {
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 25px;
            margin-bottom: 25px;
        }

        .setting-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .setting-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .setting-info {
            flex: 1;
        }

        .setting-title {
            font-size: 16px;
            font-weight: 600;
            color: #121F3E;
            margin-bottom: 4px;
        }

        .setting-desc {
            font-size: 14px;
            color: #ABB3C4;
            margin: 0;
        }

        .setting-control {
            margin-left: 20px;
        }

        .form-modern {
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-modern:focus {
            border-color: #4640DE;
            outline: none;
            box-shadow: 0 0 0 3px rgba(70, 64, 222, 0.1);
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 24px;
            background: #ddd;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-switch.active {
            background: #4640DE;
        }

        .toggle-switch::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: white;
            top: 2px;
            left: 2px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch.active::after {
            transform: translateX(26px);
        }

        .btn-modern {
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .btn-modern.primary {
            background: #4640DE;
            color: white;
        }
        
        .btn-modern.success {
            background: #4CAF50;
            color: white;
        }
        
        .btn-modern.warning {
            background: #FF9800;
            color: white;
        }
        
        .btn-modern.danger {
            background: #F44336;
            color: white;
        }
        
        .btn-modern.secondary {
            background: #f8f9fa;
            color: #121F3E;
            border: 2px solid #e0e0e0;
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .app-logo-preview {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            object-fit: cover;
            border: 3px solid #f0f0f0;
        }

        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #4640DE;
            background: #f8f9ff;
        }

        .upload-area.dragover {
            border-color: #4640DE;
            background: #f0f0ff;
        }
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Pengaturan</title>
</head>

<body>

    <div class="screen-cover d-none d-xl-none"></div>

    <div class="row">
        <div class="col-12 col-lg-3 col-navbar d-none d-xl-block">

            <aside class="sidebar">
                <a href="#" class="sidebar-logo">
                    <div class="logo-container">
                        <img src="../images/logo smp.png" alt="Logo" style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover;">
                        <span><?= $d_aplikasi['nama_aplikasi']; ?></span>
                    </div>

                    <button id="toggle-navbar" onclick="toggleNavbar()">
                        <i class="fas fa-times"></i>
                    </button>
                </a>

                <h5 class="sidebar-title">Daily Use</h5>

                <a href="./home_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-th"></i>
                    <span>Overview</span>
                </a>

                <a href="karyawan_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-users"></i>
                    <span>Siswa</span>
                </a>

                <a href="absensi_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Absensi</span>
                </a>

                <a href="area_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Area</span>
                </a>

                <a href="generate_qr.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-qrcode"></i>
                    <span>Generate QR</span>
                </a>

                <h5 class="sidebar-title">Others</h5>

                <a href="setting_modern.php" class="sidebar-item active" onclick="toggleActive(this)">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <a href="../controllers/logout.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>

            </aside>

        </div>

        <div class="col-12 col-xl-9">
            <div class="nav">
                <div class="d-flex justify-content-between align-items-center w-100 mb-3 mb-md-0">
                    <div class="d-flex justify-content-start align-items-center">
                        <button id="toggle-navbar" onclick="toggleNavbar()">
                            <i class="fas fa-bars" style="font-size: 20px; color: #121F3E;"></i>
                        </button>
                        <h2 class="nav-title">Pengaturan</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <div class="nav-input-group">
                        <input type="text" class="nav-input" placeholder="Search settings...">
                        <button class="btn-nav-input">
                            <i class="fas fa-search" style="color: #ABB3C4;"></i>
                        </button>
                    </div>

                    <button class="btn-notif d-none d-md-block">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>
            </div>

            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="modern-card">
                            <h3 class="content-title mb-2">Pengaturan Aplikasi</h3>
                            <p class="content-desc mb-4">Kelola pengaturan sistem absensi sekolah</p>

                            <form method="POST" action="setting_update.php" enctype="multipart/form-data">
                                <!-- App Information -->
                                <div class="setting-group">
                                    <h4 class="content-title mb-3">Informasi Aplikasi</h4>
                                    
                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Nama Aplikasi</div>
                                            <div class="setting-desc">Nama yang akan ditampilkan di seluruh sistem</div>
                                        </div>
                                        <div class="setting-control">
                                            <input type="text" name="nama_aplikasi" class="form-modern" 
                                                   value="<?= $d_aplikasi['nama_aplikasi']; ?>" 
                                                   style="width: 300px;">
                                        </div>
                                    </div>

                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Logo Aplikasi</div>
                                            <div class="setting-desc">Upload logo sekolah (recommended: 512x512px)</div>
                                        </div>
                                        <div class="setting-control d-flex align-items-center gap-3">
                                            <img src="../images/logo smp.png" alt="Current Logo" class="app-logo-preview">
                                            <div>
                                                <input type="file" name="logo" accept="image/*" class="form-modern" style="width: 200px;">
                                                <small class="text-muted d-block mt-1">PNG, JPG max 2MB</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Alamat Sekolah</div>
                                            <div class="setting-desc">Alamat lengkap institusi</div>
                                        </div>
                                        <div class="setting-control">
                                            <textarea name="alamat" class="form-modern" rows="3" style="width: 300px;"><?= $d_aplikasi['alamat'] ?? ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Settings -->
                                <div class="setting-group">
                                    <h4 class="content-title mb-3">Pengaturan Absensi</h4>
                                    
                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Jam Masuk</div>
                                            <div class="setting-desc">Batas waktu untuk absen masuk</div>
                                        </div>
                                        <div class="setting-control">
                                            <input type="time" name="jam_masuk" class="form-modern" 
                                                   value="<?= $d_aplikasi['jam_masuk'] ?? '07:00'; ?>">
                                        </div>
                                    </div>

                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Jam Pulang</div>
                                            <div class="setting-desc">Batas waktu untuk absen pulang</div>
                                        </div>
                                        <div class="setting-control">
                                            <input type="time" name="jam_pulang" class="form-modern" 
                                                   value="<?= $d_aplikasi['jam_pulang'] ?? '15:00'; ?>">
                                        </div>
                                    </div>

                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Toleransi Keterlambatan</div>
                                            <div class="setting-desc">Batas toleransi terlambat (dalam menit)</div>
                                        </div>
                                        <div class="setting-control">
                                            <input type="number" name="toleransi" class="form-modern" 
                                                   value="<?= $d_aplikasi['toleransi'] ?? '15'; ?>" min="0" max="60">
                                        </div>
                                    </div>

                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Notifikasi Email</div>
                                            <div class="setting-desc">Kirim notifikasi absensi via email</div>
                                        </div>
                                        <div class="setting-control">
                                            <div class="toggle-switch" onclick="toggleSetting(this, 'email_notification')">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Settings -->
                                <div class="setting-group">
                                    <h4 class="content-title mb-3">Keamanan</h4>
                                    
                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Radius Absensi</div>
                                            <div class="setting-desc">Jarak maksimal untuk absen (dalam meter)</div>
                                        </div>
                                        <div class="setting-control">
                                            <input type="number" name="radius" class="form-modern" 
                                                   value="<?= $d_aplikasi['radius'] ?? '100'; ?>" min="10" max="1000">
                                        </div>
                                    </div>

                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Wajib Foto Selfie</div>
                                            <div class="setting-desc">Mengharuskan selfie saat absen</div>
                                        </div>
                                        <div class="setting-control">
                                            <div class="toggle-switch active" onclick="toggleSetting(this, 'require_selfie')">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Auto Backup</div>
                                            <div class="setting-desc">Backup otomatis data harian</div>
                                        </div>
                                        <div class="setting-control">
                                            <div class="toggle-switch active" onclick="toggleSetting(this, 'auto_backup')">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-end gap-3 mt-4">
                                    <button type="button" class="btn-modern secondary">
                                        <i class="fas fa-undo"></i>
                                        Reset
                                    </button>
                                    <button type="submit" class="btn-modern primary">
                                        <i class="fas fa-save"></i>
                                        Simpan Pengaturan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- System Info Card -->
                        <div class="modern-card">
                            <h3 class="content-title mb-3">Informasi Sistem</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Versi Aplikasi</div>
                                            <div class="setting-desc">v2.0.0 - Modern Edition</div>
                                        </div>
                                    </div>
                                    
                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Total Siswa</div>
                                            <div class="setting-desc"><?= mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan")); ?> siswa terdaftar</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Database Size</div>
                                            <div class="setting-desc">~2.5 MB</div>
                                        </div>
                                    </div>
                                    
                                    <div class="setting-item">
                                        <div class="setting-info">
                                            <div class="setting-title">Last Backup</div>
                                            <div class="setting-desc"><?= date('d M Y, H:i'); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start gap-3 mt-4">
                                <button class="btn-modern warning">
                                    <i class="fas fa-download"></i>
                                    Backup Manual
                                </button>
                                <button class="btn-modern danger">
                                    <i class="fas fa-trash"></i>
                                    Clear Cache
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>
        const navbar = document.querySelector('.col-navbar')
        const cover = document.querySelector('.screen-cover')
        const sidebar_items = document.querySelectorAll('.sidebar-item')

        function toggleNavbar() {
            navbar.classList.toggle('d-none')
            cover.classList.toggle('d-none')
        }

        function toggleActive(e) {
            sidebar_items.forEach(function(v, k) {
                v.classList.remove('active')
            })
            e.closest('.sidebar-item').classList.add('active')
        }

        function toggleSetting(element, setting) {
            element.classList.toggle('active')
            // Here you can add AJAX call to save setting
            console.log(`Toggle ${setting}:`, element.classList.contains('active'))
        }

        // File upload preview
        document.querySelector('input[name="logo"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.app-logo-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
