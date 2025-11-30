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
$skr = date('Y-m-d');

// Get selected filters
$export_mode = isset($_GET['mode']) ? $_GET['mode'] : 'monthly';
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selected_class = isset($_GET['kelas']) ? $_GET['kelas'] : '';
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

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .modern-table th {
            background: #f8f9fa;
            color: #121F3E;
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border: none;
            font-size: 14px;
        }
        
        .modern-table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            color: #121F3E;
            vertical-align: middle;
        }
        
        .modern-table tr:hover {
            background: #f8f9fa;
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

        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f0f0f0;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-present {
            background: #E8F5E8;
            color: #4CAF50;
        }
        
        .status-absent {
            background: #FFEBEE;
            color: #F44336;
        }
        
        .status-permission {
            background: #FFF3E0;
            color: #FF9800;
        }

        .time-badge {
            background: #E3F2FD;
            color: #2196F3;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 500;
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .filter-tab {
            padding: 10px 20px;
            border-radius: 25px;
            border: 2px solid #E0E0E0;
            background: white;
            color: #666;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .filter-tab.active {
            background: #4640DE;
            color: white;
            border-color: #4640DE;
        }
        
        .filter-tab:hover {
            border-color: #4640DE;
            color: #4640DE;
        }

        .period-selector {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .form-modern {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            background: white;
            color: #121F3E;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-modern:focus {
            outline: none;
            border-color: #4640DE;
            box-shadow: 0 0 0 3px rgba(70, 64, 222, 0.1);
        }

        .period-stats {
            display: flex;
            gap: 30px;
            align-items: center;
            margin-top: 10px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-label {
            font-size: 12px;
            color: #ABB3C4;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 700;
            color: #121F3E;
        }

        @media (max-width: 768px) {
            .period-stats {
                flex-direction: column;
                gap: 15px;
                margin-top: 15px;
            }
        }

        .btn-group-actions {
            display: flex;
            gap: 4px;
            margin-top: 8px;
        }
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Data Absensi</title>
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

                <a href="guru_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Guru</span>
                </a>

                <a href="absensi_modern.php" class="sidebar-item active" onclick="toggleActive(this)">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Absensi Siswa</span>
                </a>

                <a href="absensi_guru_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-calendar-check"></i>
                    <span>Absensi Guru</span>
                </a>

                <a href="area_modern.php" class="sidebar-item" onclick="toggleActive(this)">
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
                        <h2 class="nav-title">Data Absensi</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <div class="nav-input-group">
                        <input type="text" class="nav-input" placeholder="Search attendance...">
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
                                    <h3 class="content-title mb-0">Data Absensi</h3>
                                    <p class="content-desc mb-0">
                                        <?php if ($export_mode == 'daily'): ?>
                                            Monitor dan kelola data absensi siswa tanggal <strong><?= date('d F Y', strtotime($selected_date)); ?></strong>
                                        <?php else: ?>
                                            Monitor dan kelola data absensi siswa bulan <strong><?= date('F Y', strtotime($selected_month . '-01')); ?></strong>
                                        <?php endif; ?>
                                        <?php if ($selected_class): ?>
                                            <?php
                                            $kelas_name = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama_kelas FROM kelas WHERE kode_kelas = '$selected_class'"));
                                            ?>
                                            <br><small style="color: #4640DE; font-weight: 600;">
                                                <i class="fas fa-filter me-1"></i>
                                                Filter: <?= $kelas_name ? $kelas_name['nama_kelas'] : $selected_class; ?>
                                            </small>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn-modern success" onclick="exportData('excel')">
                                        <i class="fas fa-file-excel"></i>
                                        Export Excel
                                    </button>
                                    <button class="btn-modern danger" onclick="exportData('pdf')">
                                        <i class="fas fa-file-pdf"></i>
                                        Export PDF
                                    </button>
                                    <div class="dropdown">
                                        <button class="btn-modern warning dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: linear-gradient(135deg, #ffc107, #e0a800); border: none; color: white;">
                                            <i class="fas fa-download"></i>
                                            Download Options
                                        </button>
                                        <ul class="dropdown-menu" style="border-radius: 12px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                                            <li><h6 class="dropdown-header"><i class="fas fa-calendar-month me-1"></i>Laporan Bulanan</h6></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportData('excel')"><i class="fas fa-file-excel me-2 text-success"></i>Excel Bulanan</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportData('pdf')"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF Bulanan</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><h6 class="dropdown-header"><i class="fas fa-calendar-day me-1"></i>Laporan Harian</h6></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportDailyData('excel')"><i class="fas fa-file-excel me-2 text-success"></i>Excel Harian</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportDailyData('pdf')"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF Harian</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Period Selector -->
                            <div class="period-selector">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <label class="form-label">Mode Export:</label>
                                        <select class="form-modern" id="exportMode" onchange="toggleExportMode()">
                                            <option value="monthly" <?= $export_mode == 'monthly' ? 'selected' : ''; ?>>Per Bulan</option>
                                            <option value="daily" <?= $export_mode == 'daily' ? 'selected' : ''; ?>>Per Hari</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="monthlySelector">
                                        <label class="form-label">Pilih Periode:</label>
                                        <select class="form-modern" id="monthYear" onchange="loadPeriodData()">
                                            <?php
                                            for ($i = 0; $i < 12; $i++) {
                                                $date = date('Y-m', strtotime("-$i month"));
                                                $display = date('F Y', strtotime("-$i month"));
                                                $selected = ($date == $selected_month) ? 'selected' : '';
                                                echo "<option value='$date' $selected>$display</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="dailySelector" style="display: <?= $export_mode == 'daily' ? 'block' : 'none'; ?>;">
                                        <label class="form-label">Pilih Tanggal:</label>
                                        <input type="date" class="form-modern" id="selectedDate" value="<?= $selected_date; ?>" onchange="loadDailyData()">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Filter Kelas:</label>
                                        <select class="form-modern" id="kelasFilter" onchange="loadPeriodData()">
                                            <option value="">-- Semua Kelas --</option>
                                            <?php
                                            $query_kelas = "SELECT DISTINCT k.kode_kelas, k.nama_kelas FROM kelas k 
                                                           INNER JOIN karyawan kar ON kar.job_title = k.kode_kelas 
                                                           ORDER BY k.nama_kelas ASC";
                                            $result_kelas = mysqli_query($GLOBALS["___mysqli_ston"], $query_kelas);
                                            while ($kelas = mysqli_fetch_array($result_kelas)) {
                                                $selected = ($kelas['kode_kelas'] == $selected_class) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($kelas['kode_kelas']) . "' $selected>" . htmlspecialchars($kelas['nama_kelas']) . " (" . htmlspecialchars($kelas['kode_kelas']) . ")</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="period-stats">
                                            <div class="stat-item">
                                                <span class="stat-label">Total Masuk</span>
                                                <span class="stat-value" id="totalMasuk">
                                                    <?php
                                                    $class_filter = $selected_class ? " AND k.job_title = '$selected_class'" : "";
                                                    
                                                    if ($export_mode == 'daily') {
                                                        // Query untuk mode harian
                                                        $total_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi a INNER JOIN karyawan k ON a.nik = k.nik 
                                                             WHERE a.tanggal = '$selected_date' AND a.masuk IS NOT NULL AND a.ijin IS NULL AND a.status_tidak_masuk IS NULL $class_filter"));
                                                    } else {
                                                        // Query untuk mode bulanan
                                                        $total_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi a INNER JOIN karyawan k ON a.nik = k.nik 
                                                             WHERE DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month' AND a.masuk IS NOT NULL AND a.ijin IS NULL AND a.status_tidak_masuk IS NULL $class_filter"));
                                                    }
                                                    echo $total_masuk;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Total Sakit/Izin/Alpha</span>
                                                <span class="stat-value" id="totalTidakMasuk">
                                                    <?php
                                                    if ($export_mode == 'daily') {
                                                        // Query untuk mode harian
                                                        $total_tidak_masuk_all = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi a INNER JOIN karyawan k ON a.nik = k.nik 
                                                             WHERE a.tanggal = '$selected_date' AND (a.ijin IS NOT NULL OR a.status_tidak_masuk IS NOT NULL) $class_filter"));
                                                    } else {
                                                        // Query untuk mode bulanan
                                                        $total_tidak_masuk_all = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi a INNER JOIN karyawan k ON a.nik = k.nik 
                                                             WHERE DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month' AND (a.ijin IS NOT NULL OR a.status_tidak_masuk IS NOT NULL) $class_filter"));
                                                    }
                                                    echo $total_tidak_masuk_all;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Persentase Kehadiran</span>
                                                <span class="stat-value" id="persentaseKehadiran">
                                                    <?php
                                                    $total_siswa_filter = $selected_class ? " WHERE job_title = '$selected_class'" : "";
                                                    $total_siswa = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan $total_siswa_filter"));
                                                    
                                                    // Simplified calculation without working days
                                                    $total_all_attendance = $total_masuk + $total_tidak_masuk_all;
                                                    $persentase = $total_all_attendance > 0 ? round(($total_masuk / $total_all_attendance) * 100, 1) : 0;
                                                    echo $persentase . '%';
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Tabs -->
                            <div class="filter-tabs">
                                <button class="filter-tab active" onclick="filterAttendance('all', this)">
                                    <i class="fas fa-list"></i>
                                    Semua
                                </button>
                                <button class="filter-tab" onclick="filterAttendance('present', this)">
                                    <i class="fas fa-check-circle"></i>
                                    Hadir
                                </button>
                                <button class="filter-tab" onclick="filterAttendance('absent', this)">
                                    <i class="fas fa-times-circle"></i>
                                    Tidak Hadir
                                </button>
                                <button class="filter-tab" onclick="filterAttendance('permission', this)">
                                    <i class="fas fa-clock"></i>
                                    Izin
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $today = date('Y-m-d'); // Today's date for checking attendance
                                        
                                        // Add class filter to query
                                        $class_filter = $selected_class ? " AND k.job_title = '$selected_class'" : "";
                                        
                                        // Query untuk data absensi berdasarkan mode
                                        if ($export_mode == 'daily') {
                                            // Query untuk mode harian - hanya tampilkan data tanggal yang dipilih
                                            $attendance = mysqli_query($GLOBALS["___mysqli_ston"], "
                                                SELECT k.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
                                                FROM karyawan k 
                                                LEFT JOIN absensi a ON k.nik = a.nik AND a.tanggal = '$selected_date'
                                                WHERE 1=1 $class_filter
                                                ORDER BY k.nama ASC
                                            ");
                                        } else {
                                            // Query untuk mode bulanan
                                            $attendance = mysqli_query($GLOBALS["___mysqli_ston"], "
                                                SELECT k.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
                                                FROM karyawan k 
                                                LEFT JOIN absensi a ON k.nik = a.nik AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
                                                WHERE 1=1 $class_filter
                                                ORDER BY k.nama ASC, a.tanggal DESC
                                            ");
                                        }
                                        
                                        $student_data = array();
                                        while ($data = mysqli_fetch_array($attendance)) {
                                            if (!isset($student_data[$data['nik']])) {
                                                $student_data[$data['nik']] = array(
                                                    'info' => $data,
                                                    'attendance' => array()
                                                );
                                            }
                                            if ($data['tanggal']) {
                                                $student_data[$data['nik']]['attendance'][] = $data;
                                            }
                                        }
                                        
                                        foreach ($student_data as $nik => $student) {
                                            $data = $student['info'];
                                            $attendance_records = $student['attendance'];
                                            
                                            $total_hadir = 0;
                                            $total_ijin = 0;
                                            $total_alpha = 0;
                                            $total_sakit = 0;
                                            $last_attendance = null;
                                            
                                            foreach ($attendance_records as $record) {
                                                if ($record['ijin']) {
                                                    $total_ijin++;
                                                } elseif ($record['masuk']) {
                                                    $total_hadir++;
                                                } elseif ($record['status_tidak_masuk']) {
                                                    if ($record['status_tidak_masuk'] == 'alpha') $total_alpha++;
                                                    elseif ($record['status_tidak_masuk'] == 'sakit') $total_sakit++;
                                                    elseif ($record['status_tidak_masuk'] == 'izin') $total_ijin++;
                                                }
                                                if (!$last_attendance || $record['tanggal'] > $last_attendance['tanggal']) {
                                                    $last_attendance = $record;
                                                }
                                            }
                                            
                                            // Check if student has attendance today
                                            $check_date = ($export_mode == 'daily') ? $selected_date : $today;
                                            $today_attendance = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                "SELECT * FROM absensi WHERE nik = '$nik' AND tanggal = '$check_date'"));
                                            
                                            // Determine overall status for the month
                                            if ($total_hadir > ($total_ijin + $total_alpha + $total_sakit)) {
                                                $status = 'present';
                                                $status_text = "Hadir ($total_hadir hari)";
                                                $status_class = 'status-present';
                                            } elseif (($total_ijin + $total_sakit + $total_alpha) > 0) {
                                                $status = 'permission';
                                                $absence_details = [];
                                                if ($total_ijin > 0) $absence_details[] = "Izin: $total_ijin";
                                                if ($total_sakit > 0) $absence_details[] = "Sakit: $total_sakit";
                                                if ($total_alpha > 0) $absence_details[] = "Alpha: $total_alpha";
                                                $status_text = implode(", ", $absence_details);
                                                $status_class = 'status-permission';
                                            } else {
                                                $status = 'absent';
                                                $status_text = "Tidak Ada Data";
                                                $status_class = 'status-absent';
                                            }
                                        ?>
                                        <tr data-status="<?= $status; ?>">
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <img src="images/<?= $data['foto'] ?: 'default-avatar.png'; ?>" 
                                                     alt="<?= $data['nama']; ?>" 
                                                     class="student-avatar"
                                                     onerror="this.src='images/default-avatar.png'">
                                            </td>
                                            <td>
                                                <strong><?= $data['nama']; ?></strong>
                                                <br>
                                                <small class="text-muted"><?= $data['nik']; ?></small>
                                            </td>
                                            <td>
                                                <?php
                                                // Ambil nama kelas dari tabel kelas berdasarkan kode_kelas
                                                $kelas_info = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama_kelas, kode_kelas FROM kelas WHERE kode_kelas = '{$data['job_title']}'"));
                                                if ($kelas_info) {
                                                    echo $kelas_info['nama_kelas'] . ' (' . $kelas_info['kode_kelas'] . ')';
                                                } else {
                                                    echo $data['job_title']; // fallback jika tidak ditemukan
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($last_attendance && $last_attendance['masuk']) { ?>
                                                    <span class="time-badge"><?= date('H:i', strtotime($last_attendance['masuk'])); ?></span>
                                                    <br><small class="text-muted"><?= date('d/m', strtotime($last_attendance['tanggal'])); ?></small>
                                                <?php } else { ?>
                                                    <span class="text-muted">-</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($last_attendance && $last_attendance['pulang'] && $last_attendance['pulang'] != '0') { ?>
                                                    <span class="time-badge"><?= date('H:i', strtotime($last_attendance['pulang'])); ?></span>
                                                    <br><small class="text-muted"><?= date('d/m', strtotime($last_attendance['tanggal'])); ?></small>
                                                <?php } else { ?>
                                                    <span class="text-muted">-</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <span class="status-badge <?= $status_class; ?>">
                                                    <?= $status_text; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div style="font-size: 12px;">
                                                    <div>Hadir: <?= $total_hadir; ?> hari</div>
                                                    <?php if ($total_ijin > 0) { ?>
                                                        <div>Izin: <?= $total_ijin; ?> hari</div>
                                                    <?php } ?>
                                                    <?php if ($total_sakit > 0) { ?>
                                                        <div>Sakit: <?= $total_sakit; ?> hari</div>
                                                    <?php } ?>
                                                    <?php if ($total_alpha > 0) { ?>
                                                        <div>Alpha: <?= $total_alpha; ?> hari</div>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if (!$today_attendance || (!$today_attendance['masuk'] && !$today_attendance['ijin'] && !$today_attendance['status_tidak_masuk'])) { ?>
                                                    <button class="btn-modern warning" onclick="markAbsent('<?= $data['nik']; ?>', '<?= $data['nama']; ?>')">
                                                        <i class="fas fa-user-times"></i>
                                                        Tandai Tidak Masuk
                                                    </button>
                                                <?php } elseif ($today_attendance && $today_attendance['status_tidak_masuk']) { ?>
                                                    <span class="status-badge status-permission">
                                                        <?= ucfirst($today_attendance['status_tidak_masuk']); ?>
                                                    </span>
                                                    <div class="btn-group-actions">
                                                        <button class="btn-modern primary" style="font-size: 10px; padding: 4px 8px;" onclick="markAbsent('<?= $data['nik']; ?>', '<?= $data['nama']; ?>', '<?= $today_attendance['status_tidak_masuk']; ?>')">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </button>
                                                        <button class="btn-modern danger" style="font-size: 10px; padding: 4px 8px;" onclick="cancelAbsent('<?= $data['nik']; ?>', '<?= $data['nama']; ?>')">
                                                            <i class="fas fa-times"></i>
                                                            Batal
                                                        </button>
                                                    </div>
                                                <?php } else { ?>
                                                    <span class="text-muted">-</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for marking absent students -->
    <div class="modal fade" id="absentModal" tabindex="-1" aria-labelledby="absentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header" style="border-bottom: 1px solid #f0f0f0;">
                    <h5 class="modal-title" id="absentModalLabel">
                        <i class="fas fa-user-times me-2"></i>
                        Tandai Siswa Tidak Masuk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Siswa: <strong id="studentName"></strong></p>
                        <p class="text-muted">Tanggal: <?= date('d F Y'); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Pilih Status Ketidakhadiran:</label>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-check" style="padding: 10px; border: 2px solid #E0E0E0; border-radius: 8px;">
                                    <input class="form-check-input" type="radio" name="absentStatus" id="statusAlpha" value="alpha">
                                    <label class="form-check-label" for="statusAlpha">
                                        <strong>Alpha</strong><br>
                                        <small class="text-muted">Tidak masuk tanpa keterangan</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-check" style="padding: 10px; border: 2px solid #E0E0E0; border-radius: 8px;">
                                    <input class="form-check-input" type="radio" name="absentStatus" id="statusSakit" value="sakit">
                                    <label class="form-check-label" for="statusSakit">
                                        <strong>Sakit</strong><br>
                                        <small class="text-muted">Tidak masuk karena sakit</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-check" style="padding: 10px; border: 2px solid #E0E0E0; border-radius: 8px;">
                                    <input class="form-check-input" type="radio" name="absentStatus" id="statusIzin" value="izin">
                                    <label class="form-check-label" for="statusIzin">
                                        <strong>Izin</strong><br>
                                        <small class="text-muted">Tidak masuk dengan izin</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0;">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="button" class="btn-modern success" onclick="saveAbsentStatus()">
                        <i class="fas fa-save"></i>
                        Simpan Status
                    </button>
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

        function filterAttendance(status, element) {
            const rows = document.querySelectorAll('tbody tr');
            const tabs = document.querySelectorAll('.filter-tab');
            
            // Update active tab
            tabs.forEach(tab => tab.classList.remove('active'));
            element.classList.add('active');
            
            // Filter rows
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function toggleExportMode() {
            const mode = document.getElementById('exportMode').value;
            const monthlySelector = document.getElementById('monthlySelector');
            const dailySelector = document.getElementById('dailySelector');
            
            if (mode === 'daily') {
                monthlySelector.style.display = 'none';
                dailySelector.style.display = 'block';
            } else {
                monthlySelector.style.display = 'block';
                dailySelector.style.display = 'none';
            }
        }

        function loadDailyData() {
            const selectedDate = document.getElementById('selectedDate').value;
            const selectedClass = document.getElementById('kelasFilter').value;
            
            let url = `?date=${selectedDate}&mode=daily`;
            if (selectedClass) {
                url += `&kelas=${selectedClass}`;
            }
            
            window.location.href = url;
        }

        function exportDailyData(format) {
            const selectedDate = document.getElementById('selectedDate').value || '<?= date('Y-m-d'); ?>';
            const selectedClass = document.getElementById('kelasFilter').value;
            
            let url = '';
            if (format === 'excel') {
                url = `absensi_export_daily.php?format=excel&date=${selectedDate}`;
                if (selectedClass) {
                    url += `&kelas=${selectedClass}`;
                }
                window.open(url, '_blank');
            } else if (format === 'pdf') {
                url = `absensi_export_daily_pdf.php?date=${selectedDate}&download=1`;
                if (selectedClass) {
                    url += `&kelas=${selectedClass}`;
                }
                window.open(url, '_blank');
            }
        }

        function loadPeriodData() {
            const selectedMonth = document.getElementById('monthYear').value;
            const selectedClass = document.getElementById('kelasFilter').value;
            
            let url = `?month=${selectedMonth}&mode=monthly`;
            if (selectedClass) {
                url += `&kelas=${selectedClass}`;
            }
            
            window.location.href = url;
        }

        function exportData(format) {
            const selectedMonth = document.getElementById('monthYear').value;
            const selectedClass = document.getElementById('kelasFilter').value;
            
            let url = '';
            if (format === 'excel') {
                url = `absensi_export.php?format=excel&month=${selectedMonth}`;
                if (selectedClass) {
                    url += `&kelas=${selectedClass}`;
                }
                window.open(url, '_blank');
            } else if (format === 'pdf') {
                // Direct PDF export with better approach
                url = `absensi_export_pdf_direct.php?month=${selectedMonth}&download=1`;
                if (selectedClass) {
                    url += `&kelas=${selectedClass}`;
                }
                window.open(url, '_blank');
            }
        }

        function testPDFExport() {
            const selectedMonth = document.getElementById('monthYear').value;
            const selectedClass = document.getElementById('kelasFilter').value;
            
            // Show options to user
            const choice = confirm('Pilih PDF Export:\nOK = Direct PDF View\nCancel = Force Download');
            
            let url = '';
            if (choice) {
                // Direct PDF view
                url = `absensi_export_pdf_direct.php?month=${selectedMonth}`;
                if (selectedClass) {
                    url += `&kelas=${selectedClass}`;
                }
                window.open(url, '_blank');
            } else {
                // Force download
                url = `absensi_export_pdf_force.php?month=${selectedMonth}`;
                if (selectedClass) {
                    url += `&kelas=${selectedClass}`;
                }
                window.open(url, '_blank');
            }
        }

        // Variables for absent modal
        let currentStudentNik = '';
        let currentStudentName = '';

        function markAbsent(nik, name, currentStatus = '') {
            currentStudentNik = nik;
            currentStudentName = name;
            
            document.getElementById('studentName').textContent = name;
            
            // Clear previous selections
            document.querySelectorAll('input[name="absentStatus"]').forEach(radio => {
                radio.checked = false;
            });
            
            // If editing existing status, select the current one
            if (currentStatus) {
                document.getElementById('status' + currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1)).checked = true;
            }
            
            const modal = new bootstrap.Modal(document.getElementById('absentModal'));
            modal.show();
        }

        function cancelAbsent(nik, name) {
            if (confirm(`Yakin ingin membatalkan status tidak masuk untuk siswa ${name}?\n\nStatus akan dihapus dan siswa dapat ditandai hadir kembali.`)) {
                const formData = new FormData();
                formData.append('nik', nik);
                formData.append('action', 'cancel');
                formData.append('tanggal', '<?= date('Y-m-d'); ?>');
                
                fetch('controller/cancel_absent.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status tidak masuk berhasil dibatalkan');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membatalkan status');
                });
            }
        }

        function saveAbsentStatus() {
            const selectedStatus = document.querySelector('input[name="absentStatus"]:checked');
            
            if (!selectedStatus) {
                alert('Mohon pilih status ketidakhadiran');
                return;
            }
            
            const formData = new FormData();
            formData.append('nik', currentStudentNik);
            formData.append('status', selectedStatus.value);
            formData.append('tanggal', '<?= date('Y-m-d'); ?>');
            
            fetch('controller/mark_absent.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Status ketidakhadiran berhasil disimpan');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data');
            });
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('absentModal'));
            modal.hide();
        }

        // Add styles for checked radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="absentStatus"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    document.querySelectorAll('.form-check').forEach(check => {
                        check.style.borderColor = '#E0E0E0';
                        check.style.backgroundColor = 'white';
                    });
                    
                    if (this.checked) {
                        this.closest('.form-check').style.borderColor = '#4640DE';
                        this.closest('.form-check').style.backgroundColor = 'rgba(70, 64, 222, 0.05)';
                    }
                });
            });
        });
    </script>
</body>

</html>
