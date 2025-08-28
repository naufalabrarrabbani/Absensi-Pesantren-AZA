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

        .area-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .area-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 4px solid #4640DE;
        }

        .area-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        .area-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4640DE, #7C3AED);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .area-icon i {
            color: white;
            font-size: 20px;
        }

        .area-name {
            font-size: 18px;
            font-weight: 600;
            color: #121F3E;
            margin-bottom: 8px;
        }

        .area-code {
            font-size: 12px;
            color: #ABB3C4;
            background: #F8F9FA;
            padding: 4px 8px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .area-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 20px;
            font-weight: 700;
            color: #121F3E;
            display: block;
        }

        .stat-label {
            font-size: 11px;
            color: #ABB3C4;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .area-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-modern {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            font-size: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
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
        
        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #ABB3C4;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Data Area</title>
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

                <a href="area_modern.php" class="sidebar-item active" onclick="toggleActive(this)">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Area</span>
                </a>

                <a href="generate_qr.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-qrcode"></i>
                    <span>Generate QR</span>
                </a>

                <h5 class="sidebar-title">Master Data</h5>

                <a href="kelas_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-school"></i>
                    <span>Kelas</span>
                </a>

                <h5 class="sidebar-title">Others</h5>

                <a href="setting_modern.php" class="sidebar-item" onclick="toggleActive(this)">
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
                        <h2 class="nav-title">Data Area</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <div class="nav-input-group">
                        <input type="text" class="nav-input" placeholder="Search areas...">
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
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="content-title mb-0">Kelola Area</h3>
                                    <p class="content-desc mb-0">Daftar area dan lokasi untuk sistem absensi</p>
                                </div>
                                <a href="area_add.php" class="btn-modern primary">
                                    <i class="fas fa-plus"></i>
                                    Tambah Area
                                </a>
                            </div>

                            <?php
                            $areas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area ORDER BY area ASC");
                            $total_areas = mysqli_num_rows($areas);
                            
                            if ($total_areas > 0) {
                            ?>
                            <div class="area-grid">
                                <?php
                                while ($area = mysqli_fetch_array($areas)) {
                                    // Count students in this area
                                    $student_count = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan WHERE area = '".$area['kode_area']."'"));
                                    
                                    // Count present students today
                                    $present_today = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "
                                        SELECT * FROM absensi a 
                                        JOIN karyawan k ON a.nik = k.nik 
                                        WHERE k.area = '".$area['kode_area']."' 
                                        AND a.tanggal = '".date('Y-m-d')."' 
                                        AND a.ijin IS NULL
                                    "));
                                ?>
                                <div class="area-card">
                                    <div class="area-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    
                                    <div class="area-name"><?= $area['area']; ?></div>
                                    <div class="area-code">Kode: <?= $area['kode_area']; ?></div>
                                    
                                    <div class="area-stats">
                                        <div class="stat-item">
                                            <span class="stat-number"><?= $student_count; ?></span>
                                            <span class="stat-label">Total Siswa</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number"><?= $present_today; ?></span>
                                            <span class="stat-label">Hadir Hari Ini</span>
                                        </div>
                                        <div class="stat-item">
                                            <span class="stat-number"><?= $student_count - $present_today; ?></span>
                                            <span class="stat-label">Tidak Hadir</span>
                                        </div>
                                    </div>
                                    
                                    <div class="area-actions">
                                        <a href="area_view.php?id=<?= $area['id']; ?>" class="btn-modern primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="area_edit.php?id=<?= $area['id']; ?>" class="btn-modern warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="area_delete.php?id=<?= $area['id']; ?>" class="btn-modern danger" onclick="return confirm('Yakin ingin menghapus area ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } else { ?>
                            <div class="empty-state">
                                <i class="fas fa-map-marker-alt"></i>
                                <h4>Belum Ada Area</h4>
                                <p>Tambahkan area pertama untuk mulai mengorganisir siswa berdasarkan lokasi.</p>
                                <a href="area_add.php" class="btn-modern primary">
                                    <i class="fas fa-plus"></i>
                                    Tambah Area Pertama
                                </a>
                            </div>
                            <?php } ?>
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
    </script>
</body>

</html>
