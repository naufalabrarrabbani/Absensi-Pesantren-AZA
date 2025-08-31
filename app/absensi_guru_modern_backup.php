<?php
include '../include/koneksi.php';
include '../sync_guru_photos.php';

// memulai session
session_start();
error_reporting(0);

// Auto sync foto guru
syncGuruPhotos();
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

        /* Improved page margins and spacing */
        .main-content {
            padding: 30px !important;
            margin: 20px auto !important;
            max-width: 95%;
        }

        .card {
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 12px;
        }

        .card-header {
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }

        .card-body {
            padding: 25px;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            padding: 15px 12px;
            background-color: #f8f9fa;
            border-top: none;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
        }

        .btn-statistics, .nav-input, .nav-input-group .btn-nav-input, .nav .btn-notif, #toggle-navbar {
            background-color: transparent;
            border: none;
            outline: none;
        }

        /* Enhanced page margins and spacing */
        .container-fluid {
            padding: 30px !important;
            margin: 20px auto !important;
            max-width: 95%;
        }

        .card {
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none;
            border-radius: 12px;
        }

        .card-header {
            padding: 20px 25px;
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-body {
            padding: 25px;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            padding: 15px 12px;
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        /* Filter controls spacing */
        .filter-controls {
            gap: 15px;
        }

        .filter-controls .form-group {
            margin-bottom: 15px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4640DE;
            box-shadow: 0 0 0 0.2rem rgba(70, 64, 222, 0.25);
        }

        /* Button styling */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
        }

        .btn-primary {
            background-color: #4640DE;
            border-color: #4640DE;
        }

        .btn-primary:hover {
            background-color: #3730b8;
            border-color: #3730b8;
        }

        /* Statistics cards margin and styling */
        .stats-container .col-md-3 {
            margin-bottom: 15px;
        }

        .card-stats {
            border-left: 4px solid;
            transition: transform 0.2s ease-in-out;
        }

        .card-stats:hover {
            transform: translateY(-2px);
        }

        .card-stats.total { border-left-color: #6c757d; }
        .card-stats.present { border-left-color: #28a745; }
        .card-stats.permission { border-left-color: #ffc107; }
        .card-stats.absent { border-left-color: #dc3545; }

        /* Period toggle styling */
        .period-toggle .btn {
            border-radius: 20px;
            margin-right: 8px;
            font-size: 14px;
            padding: 6px 20px;
        }

        .period-toggle .btn.active {
            background-color: #4640DE;
            border-color: #4640DE;
            color: white;
        }

        /* Table responsive improvements */
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .badge {
            font-size: 0.85em;
            padding: 6px 12px;
            border-radius: 20px;
        }

        /* Teacher avatar styling */
        .teacher-avatar img {
            border: 2px solid #e9ecef;
            transition: border-color 0.2s ease;
        }

        .teacher-avatar img:hover {
            border-color: #4640DE;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 15px !important;
                margin: 10px auto !important;
            }
            
            .card-body {
                padding: 15px;
            }

            .filter-controls {
                flex-direction: column;
            }

            .period-toggle {
                margin-bottom: 15px;
            }

            .stats-container .col-md-3 {
                margin-bottom: 10px;
            }
        }

        /* Print styles for better PDF export */
        @media print {
            .container-fluid {
                padding: 20px !important;
                margin: 0 !important;
                max-width: 100%;
            }
            
            .btn, .filter-controls, .export-btn, .sidebar, .navbar {
                display: none !important;
            }
            
            .card {
                box-shadow: none;
                border: 1px solid #ddd;
                break-inside: avoid;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .table {
                font-size: 12px;
            }

            .table th, .table td {
                padding: 8px 6px;
            }
        }

        /* Loading spinner */
        .spinner-border {
            width: 2rem;
            height: 2rem;
        }

        /* Filter tabs styling */
        .filter-tab {
            border-radius: 6px;
            margin-right: 8px;
            transition: all 0.2s ease;
        }

        .filter-tab.active {
            background-color: #4640DE !important;
            border-color: #4640DE !important;
            color: white !important;
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
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Data Absensi Guru</title>
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

                <a href="absensi_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Absensi Siswa</span>
                </a>

                <a href="absensi_guru_modern.php" class="sidebar-item active" onclick="toggleActive(this)">
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
                        <h2 class="nav-title">Data Absensi Guru</h2>
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
                                    <h3 class="content-title mb-0">Data Absensi Guru</h3>
                                    <p class="content-desc mb-0">Monitor dan kelola data absensi guru per hari atau bulan</p>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- Mode Toggle -->
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="viewMode" id="dailyMode" value="daily" checked>
                                        <label class="btn btn-outline-primary" for="dailyMode">
                                            <i class="fas fa-calendar-day"></i> Harian
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="viewMode" id="monthlyMode" value="monthly">
                                        <label class="btn btn-outline-primary" for="monthlyMode">
                                            <i class="fas fa-calendar"></i> Bulanan
                                        </label>
                                    </div>
                                    
                                    <!-- Export Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn-modern success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-download"></i> Export Data
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- Daily Export Options -->
                                            <li class="daily-export">
                                                <a class="dropdown-item" href="#" onclick="exportDailyData('excel')">
                                                    <i class="fas fa-file-excel text-success"></i> Excel (Harian)
                                                </a>
                                            </li>
                                            <li class="daily-export">
                                                <a class="dropdown-item" href="#" onclick="exportDailyData('pdf')">
                                                    <i class="fas fa-file-pdf text-danger"></i> PDF (Harian)
                                                </a>
                                            </li>
                                            <li class="daily-export"><hr class="dropdown-divider"></li>
                                            <!-- Monthly Export Options -->
                                            <li class="monthly-export" style="display: none;">
                                                <a class="dropdown-item" href="#" onclick="exportData('excel')">
                                                    <i class="fas fa-file-excel text-success"></i> Excel (Bulanan)
                                                </a>
                                            </li>
                                            <li class="monthly-export" style="display: none;">
                                                <a class="dropdown-item" href="#" onclick="exportData('pdf')">
                                                    <i class="fas fa-file-pdf text-danger"></i> PDF (Bulanan)
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Daily Period Selector -->
                            <div class="period-selector mb-4" id="dailyPeriodSelector">
                                <div class="row align-items-end g-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Pilih Tanggal:</label>
                                        <input type="date" class="form-modern" id="dailyDate" value="<?= date('Y-m-d') ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Filter Mata Pelajaran:</label>
                                        <select class="form-modern" id="filterMapel">
                                            <option value="">Semua Mata Pelajaran</option>
                                            <?php
                                            $mapel_query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT mata_pelajaran FROM guru WHERE mata_pelajaran IS NOT NULL AND mata_pelajaran != '' ORDER BY mata_pelajaran");
                                            while ($mapel = mysqli_fetch_array($mapel_query)) {
                                                echo "<option value='".$mapel['mata_pelajaran']."'>".$mapel['mata_pelajaran']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <span class="stat-label">Guru Hadir</span>
                                                    <span class="stat-value text-success" id="dailyTotalMasuk">
                                                        <?php
                                                        $today = date('Y-m-d');
                                                        $hadir_today = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi_guru WHERE tanggal = '$today' AND masuk IS NOT NULL AND ijin IS NULL AND status_tidak_masuk IS NULL"));
                                                        echo $hadir_today;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <span class="stat-label">Tidak Hadir</span>
                                                    <span class="stat-value text-danger" id="dailyTotalTidakMasuk">
                                                        <?php
                                                        $tidak_hadir_today = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi_guru WHERE tanggal = '$today' AND (ijin IS NOT NULL OR status_tidak_masuk IS NOT NULL)"));
                                                        echo $tidak_hadir_today;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <span class="stat-label">Persentase</span>
                                                    <span class="stat-value text-primary" id="dailyPersentaseKehadiran">
                                                        <?php
                                                        $total_guru = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru"));
                                                        $persentase_today = $total_guru > 0 ? round(($hadir_today / $total_guru) * 100, 1) : 0;
                                                        echo $persentase_today . '%';
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Monthly Period Selector (hidden by default) -->
                            <div class="period-selector mb-4" id="monthlyPeriodSelector" style="display: none;">
                                <div class="row align-items-end g-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Pilih Periode:</label>
                                        <?php
                                        $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
                                        ?>
                                        <select class="form-modern" id="monthYear">
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
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Filter Mata Pelajaran:</label>
                                        <select class="form-modern" id="filterMapelMonthly">
                                            <option value="">Semua Mata Pelajaran</option>
                                            <?php
                                            mysqli_data_seek($mapel_query, 0);
                                            while ($mapel = mysqli_fetch_array($mapel_query)) {
                                                echo "<option value='".$mapel['mata_pelajaran']."'>".$mapel['mata_pelajaran']."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <span class="stat-label">Total Masuk</span>
                                                    <span class="stat-value text-success" id="totalMasuk">
                                                        <?php
                                                        $total_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi_guru WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$selected_month' AND masuk IS NOT NULL AND ijin IS NULL AND status_tidak_masuk IS NULL"));
                                                        echo $total_masuk;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <span class="stat-label">Tidak Hadir</span>
                                                    <span class="stat-value text-danger" id="totalTidakMasuk">
                                                        <?php
                                                        $total_tidak_masuk_all = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT * FROM absensi_guru WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$selected_month' AND (ijin IS NOT NULL OR status_tidak_masuk IS NOT NULL)"));
                                                        echo $total_tidak_masuk_all;
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-item">
                                                    <span class="stat-label">Persentase</span>
                                                    <span class="stat-value text-primary" id="persentaseKehadiran">
                                                        <?php
                                                        $total_guru = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru"));
                                                        $total_hari_kerja = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT DISTINCT tanggal FROM absensi_guru WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$selected_month'"));
                                                        $total_expected = $total_guru * $total_hari_kerja;
                                                        $persentase = $total_expected > 0 ? round(($total_masuk / $total_expected) * 100, 1) : 0;
                                                        echo $persentase . '%';
                                                        ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Tabs -->
                            <div class="filter-tabs mb-3">
                                <button class="filter-tab active" onclick="filterAttendance('all', this)">
                                    <i class="fas fa-list"></i> Semua
                                </button>
                                <button class="filter-tab" onclick="filterAttendance('present', this)">
                                    <i class="fas fa-check-circle"></i> Hadir
                                </button>
                                <button class="filter-tab" onclick="filterAttendance('absent', this)">
                                    <i class="fas fa-times-circle"></i> Tidak Hadir
                                </button>
                                <button class="filter-tab" onclick="filterAttendance('permission', this)">
                                    <i class="fas fa-clock"></i> Izin/Sakit
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="modern-table" id="guruTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama Guru</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th id="statusHeader">Status</th>
                                            <th id="lastAttendanceHeader">Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="attendanceTableBody">
                                        <?php
                                        $no = 1;
                                        $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
                                        $selected_date = date('Y-m-d'); // Today's date for checking attendance
                                        
                                        // Debug: Check if we have any teachers in database
                                        $guru_count = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) as total FROM guru");
                                        $guru_total = mysqli_fetch_array($guru_count);
                                        
                                        // If no teachers, show message
                                        if ($guru_total['total'] == 0) {
                                            echo '<tr><td colspan="9" class="text-center">Tidak ada data guru di database</td></tr>';
                                        } else {
                                            // Query untuk data absensi guru per bulan
                                            $attendance = mysqli_query($GLOBALS["___mysqli_ston"], "
                                                SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
                                                FROM guru g 
                                                LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
                                                ORDER BY g.nama ASC, a.tanggal DESC
                                            ");
                                            
                                            if (!$attendance) {
                                                echo '<tr><td colspan="9" class="text-center text-danger">Error query: ' . mysqli_error($GLOBALS["___mysqli_ston"]) . '</td></tr>';
                                            } else {
                                            $teacher_data = array();
                                            echo "<!-- Starting to process teacher data -->";
                                            $count = 0;
                                            while ($data = mysqli_fetch_array($attendance)) {
                                                $count++;
                                                echo "<!-- Teacher $count: " . $data['nama'] . " (NIP: " . $data['nip'] . ") -->";
                                                if (!isset($teacher_data[$data['nip']])) {
                                                    $teacher_data[$data['nip']] = array(
                                                        'info' => $data,
                                                        'attendance' => array()
                                                    );
                                                }
                                                if ($data['tanggal']) {
                                                    $teacher_data[$data['nip']]['attendance'][] = $data;
                                                }
                                            }
                                            echo "<!-- Total teacher data processed: " . count($teacher_data) . " -->";
                                            
                                            if (empty($teacher_data)) {
                                                echo '<tr><td colspan="9" class="text-center">Tidak ada data guru untuk periode ini</td></tr>';
                                            } else {
                                                foreach ($teacher_data as $nip => $teacher) {
                                                        $data = $teacher['info'];
                                                        $attendance_records = $teacher['attendance'];
                                            
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
                                            
                                            // Check if teacher has attendance today
                                            $today_attendance = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                "SELECT * FROM absensi_guru WHERE nip = '{$data['nip']}' AND tanggal = '$selected_date'"));
                                            
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
                                                <img src="../images/foto_guru/<?= $data['foto_guru'] ?: 'default.png'; ?>" 
                                                     alt="<?= $data['nama']; ?>" 
                                                     class="rounded-circle"
                                                     style="width: 40px; height: 40px; object-fit: cover;"
                                                     onerror="this.src='../images/foto_guru/default.png'">
                                            </td>
                                            <td>
                                                <div class="fw-bold"><?= $data['nama']; ?></div>
                                                <small class="text-muted">NIP: <?= $data['nip']; ?></small>
                                            </td>
                                            <td><?= $data['mata_pelajaran'] ?: '-'; ?></td>
                                            <td>
                                                <?php if ($last_attendance && $last_attendance['masuk']) { ?>
                                                    <span class="text-success">
                                                        <i class="fas fa-clock"></i>
                                                        <?= date('H:i', strtotime($last_attendance['masuk'])); ?>
                                                    </span>
                                                    <br>
                                                    <small class="text-muted"><?= date('d/m/Y', strtotime($last_attendance['tanggal'])); ?></small>
                                                <?php } else { ?>
                                                    <span class="text-muted">-</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($last_attendance && $last_attendance['pulang']) { ?>
                                                    <span class="text-primary">
                                                        <i class="fas fa-clock"></i>
                                                        <?= date('H:i', strtotime($last_attendance['pulang'])); ?>
                                                    </span>
                                                    <br>
                                                    <small class="text-muted"><?= date('d/m/Y', strtotime($last_attendance['tanggal'])); ?></small>
                                                <?php } else { ?>
                                                    <span class="text-muted">-</span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <span class="badge <?= $status_class == 'status-present' ? 'bg-success' : ($status_class == 'status-permission' ? 'bg-warning text-dark' : 'bg-danger'); ?>">
                                                    <?= $status_text; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="attendance-details">
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
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <?php if (!$today_attendance || (!$today_attendance['masuk'] && !$today_attendance['ijin'] && !$today_attendance['status_tidak_masuk'])) { ?>
                                                        <button type="button" class="btn btn-outline-warning" onclick="markAbsent('<?= $data['nip']; ?>', '<?= $data['nama']; ?>')">
                                                            <i class="fas fa-user-times"></i>
                                                        </button>
                                                    <?php } ?>
                                                    <button type="button" class="btn btn-outline-primary" onclick="viewDetail('<?= $data['nip']; ?>')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success" onclick="exportIndividual('<?= $data['nip']; ?>')">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                                    
                                    <!-- Export Buttons with Dropdown -->
                                    <div class="dropdown">
                                        <button class="btn-modern success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-download"></i>
                                            Export Data
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- Monthly Export Options -->
                                            <li class="monthly-export">
                                                <a class="dropdown-item" href="#" onclick="exportData('excel')">
                                                    <i class="fas fa-file-excel text-success"></i> Excel (Bulanan)
                                                </a>
                                            </li>
                                            <li class="monthly-export">
                                                <a class="dropdown-item" href="#" onclick="exportData('pdf')">
                                                    <i class="fas fa-file-pdf text-danger"></i> PDF (Bulanan)
                                                </a>
                                            </li>
                                            <li class="monthly-export"><hr class="dropdown-divider"></li>
                                            <!-- Daily Export Options -->
                                            <li class="daily-export" style="display: none;">
                                                <a class="dropdown-item" href="#" onclick="exportDailyData('excel')">
                                                    <i class="fas fa-file-excel text-success"></i> Excel (Harian)
                                                </a>
                                            </li>
                                            <li class="daily-export" style="display: none;">
                                                <a class="dropdown-item" href="#" onclick="exportDailyData('pdf')">
                                                    <i class="fas fa-file-pdf text-danger"></i> PDF (Harian)
                                                </a>
                                            </li>
                                            <li class="daily-export" style="display: none;"><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="testPDFExport()">
                                                    <i class="fas fa-vial text-warning"></i> Test PDF
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for marking absent students -->
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label">Pilih Periode:</label>
                                        <?php
                                        $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
                                        ?>
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
                                    <div class="col-md-8">
                                        <div class="period-stats">
                                            <div class="stat-item">
                                                <span class="stat-label">Total Masuk</span>
                                                <span class="stat-value" id="totalMasuk">
                                                    <?php
                                                    $total_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                        "SELECT * FROM absensi_guru WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$selected_month' AND masuk IS NOT NULL AND ijin IS NULL AND status_tidak_masuk IS NULL"));
                                                    echo $total_masuk;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Total Sakit/Izin/Alpha</span>
                                                <span class="stat-value" id="totalTidakMasuk">
                                                    <?php
                                                    $total_tidak_masuk_all = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                        "SELECT * FROM absensi_guru WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$selected_month' AND (ijin IS NOT NULL OR status_tidak_masuk IS NOT NULL)"));
                                                    echo $total_tidak_masuk_all;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Persentase Kehadiran</span>
                                                <span class="stat-value" id="persentaseKehadiran">
                                                    <?php
                                                    $total_guru = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru"));
                                                    $total_hari_kerja = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                        "SELECT DISTINCT tanggal FROM absensi_guru WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$selected_month'"));
                                                    $total_expected = $total_guru * $total_hari_kerja;
                                                    $persentase = $total_expected > 0 ? round(($total_masuk / $total_expected) * 100, 1) : 0;
                                                    echo $persentase . '%';
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

    <!-- Modal for marking absent students -->
    <div class="modal fade" id="absentModal" tabindex="-1" aria-labelledby="absentModalLabel" aria-hidden="true">
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
                                        $selected_date = date('Y-m-d'); // Today's date for checking attendance
                                        
                                        // Query untuk data absensi guru per bulan
                                            $attendance = mysqli_query($GLOBALS["___mysqli_ston"], "
                                                SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
                                                FROM guru g 
                                                LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
                                                ORDER BY g.nama ASC, a.tanggal DESC
                                            ");
                                            
                                            // Debug query
                                            if (!$attendance) {
                                                echo "<!-- Database Error: " . mysqli_error($GLOBALS["___mysqli_ston"]) . " -->";
                                            }
                                            
                                            echo "<!-- Total rows: " . mysqli_num_rows($attendance) . " -->";                                        $teacher_data = array();
                                        while ($data = mysqli_fetch_array($attendance)) {
                                            if (!isset($teacher_data[$data['nip']])) {
                                                $teacher_data[$data['nip']] = array(
                                                    'info' => $data,
                                                    'attendance' => array()
                                                );
                                            }
                                            if ($data['tanggal']) {
                                                $teacher_data[$data['nip']]['attendance'][] = $data;
                                            }
                                        }
                                        
                                        foreach ($teacher_data as $nip => $teacher) {
                                            $data = $teacher['info'];
                                            $attendance_records = $teacher['attendance'];
                                            
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
                                            
                                            // Check if teacher has attendance today
                                            $today_attendance = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                "SELECT * FROM absensi_guru WHERE nip = '{$data['nip']}' AND tanggal = '$selected_date'"));
                                            
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
                                                    <img src="../images/guru/<?= $data['foto'] ?: 'default-avatar.png'; ?>" 
                                                         alt="<?= $data['nama']; ?>" 
                                                         class="student-avatar"
                                                         onerror="this.src='../images/default-avatar.png'">
                                                </td>
                                                <td>
                                                    <strong><?= $data['nama']; ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?= $data['nip']; ?></small>
                                                </td>
                                                <td><?= $data['mata_pelajaran'] ?: 'Belum ditentukan'; ?></td>
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
                                                        <button class="btn-modern warning" onclick="markAbsent('<?= $data['nip']; ?>', '<?= $data['nama']; ?>')">
                                                            <i class="fas fa-user-times"></i>
                                                            Tandai Tidak Masuk
                                                        </button>
                                                    <?php } elseif ($today_attendance && $today_attendance['status_tidak_masuk']) { ?>
                                                        <span class="status-badge status-permission">
                                                            <?= ucfirst($today_attendance['status_tidak_masuk']); ?>
                                                        </span>
                                                        <br>
                                                        <button class="btn-modern primary" style="font-size: 10px; padding: 4px 8px; margin-top: 5px;" onclick="markAbsent('<?= $data['nip']; ?>', '<?= $data['nama']; ?>', '<?= $today_attendance['status_tidak_masuk']; ?>')">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </button>
                                                    <?php } else { ?>
                                                        <span class="text-muted">-</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php 
                                        } // End foreach
                                        } // End if-else for empty teacher_data
                                        } // End if-else for attendance query
                                        } // End if-else for guru count
                                        ?>
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
                        Tandai Guru Tidak Masuk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Guru: <strong id="studentName"></strong></p>
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
    
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        // Enhanced Filter System for Attendance
        $(document).ready(function() {
            let currentMode = 'daily';
            
            // Initialize filters
            initializeFilters();
            loadData();
            
            // Period toggle handlers
            $('.period-toggle .btn').click(function() {
                $('.period-toggle .btn').removeClass('active');
                $(this).addClass('active');
                currentMode = $(this).data('mode');
                loadData();
            });
            
            // Filter change handlers
            $('#filterDate, #filterSubject').change(function() {
                loadData();
            });
            
            // Export button handler
            $('.export-btn').click(function() {
                const date = $('#filterDate').val();
                const subject = $('#filterSubject').val();
                
                let exportUrl = 'absensi_guru_export_daily_pdf.php?date=' + date;
                if (subject && subject !== 'all') {
                    exportUrl += '&subject=' + encodeURIComponent(subject);
                }
                
                window.open(exportUrl, '_blank');
            });
            
            function initializeFilters() {
                // Set today as default date
                const today = new Date().toISOString().split('T')[0];
                $('#filterDate').val(today);
                
                // Load subjects for filter
                loadSubjects();
            }
            
            function loadSubjects() {
                $.ajax({
                    url: 'load_guru_data.php',
                    method: 'GET',
                    data: { action: 'get_subjects' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.subjects) {
                            const subjectSelect = $('#filterSubject');
                            subjectSelect.empty();
                            subjectSelect.append('<option value="all">Semua Mata Pelajaran</option>');
                            
                            response.subjects.forEach(function(subject) {
                                subjectSelect.append(`<option value="${subject}">${subject}</option>`);
                            });
                        }
                    },
                    error: function() {
                        console.error('Failed to load subjects');
                    }
                });
            }
            
            function loadData() {
                const date = $('#filterDate').val();
                const subject = $('#filterSubject').val();
                
                // Show loading state
                $('#attendanceTableBody').html(`
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="mt-2">Memuat data absensi...</div>
                        </td>
                    </tr>
                `);
                
                $.ajax({
                    url: 'load_guru_data.php',
                    method: 'GET',
                    data: {
                        mode: currentMode,
                        date: date,
                        subject: subject !== 'all' ? subject : ''
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            updateStatistics(response.statistics);
                            updateAttendanceTable(response.data);
                            updateTableHeaders();
                        } else {
                            showError('Gagal memuat data: ' + (response.message || 'Unknown error'));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        showError('Terjadi kesalahan saat memuat data');
                    }
                });
            }
            
            function updateStatistics(stats) {
                $('#totalGuru').text(stats.total || 0);
                $('#guruHadir').text(stats.hadir || 0);
                $('#guruIjin').text(stats.ijin || 0);
                $('#guruAlpha').text(stats.alpha || 0);
            }
            
            function updateTableHeaders() {
                if (currentMode === 'daily') {
                    $('#statusHeader').text('Status Hari Ini');
                    $('#lastAttendanceHeader').text('Waktu Absen');
                } else {
                    $('#statusHeader').text('Status Bulan Ini');
                    $('#lastAttendanceHeader').text('Absen Terakhir');
                }
            }
            
            function updateAttendanceTable(data) {
                const tbody = $('#attendanceTableBody');
                tbody.empty();
                
                if (!data || data.length === 0) {
                    tbody.html(`
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="fas fa-info-circle me-2"></i>
                                Tidak ada data absensi untuk filter yang dipilih
                            </td>
                        </tr>
                    `);
                    return;
                }
                
                let no = 1;
                data.forEach(function(teacher) {
                    const row = createTableRow(teacher, no++);
                    tbody.append(row);
                });
            }
            
            function createTableRow(teacher, no) {
                const statusClass = getStatusClass(teacher.status);
                const statusText = getStatusText(teacher);
                
                return `
                    <tr data-status="${teacher.status}">
                        <td>${no}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="teacher-avatar me-3">
                                    <img src="../images/foto_guru/${teacher.photo || 'default.png'}" 
                                         alt="${teacher.nama}" class="rounded-circle" 
                                         style="width: 40px; height: 40px; object-fit: cover;"
                                         onerror="this.src='../images/foto_guru/default.png'">
                                </div>
                                <div>
                                    <div class="fw-bold">${teacher.nama}</div>
                                    <small class="text-muted">NIP: ${teacher.nip}</small>
                                </div>
                            </div>
                        </td>
                        <td>${teacher.mata_pelajaran}</td>
                        <td>
                            <span class="badge ${statusClass}">${statusText}</span>
                        </td>
                        <td>${teacher.jam_masuk || '-'}</td>
                        <td>${teacher.jam_keluar || '-'}</td>
                        <td>${teacher.last_attendance || '-'}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-primary" 
                                        onclick="viewDetail('${teacher.nip}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-outline-success" 
                                        onclick="exportIndividual('${teacher.nip}')">
                                    <i class="fas fa-download"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            
            function getStatusClass(status) {
                switch(status) {
                    case 'present': return 'bg-success';
                    case 'permission': return 'bg-warning text-dark';
                    case 'absent': return 'bg-danger';
                    case 'late': return 'bg-warning text-dark';
                    default: return 'bg-secondary';
                }
            }
            
            function getStatusText(teacher) {
                if (currentMode === 'daily') {
                    if (teacher.jam_masuk) {
                        return teacher.is_late ? 'Terlambat' : 'Hadir';
                    } else if (teacher.ijin) {
                        return 'Ijin';
                    } else {
                        return 'Alpha';
                    }
                } else {
                    return teacher.status_text || 'Tidak Ada Data';
                }
            }
            
            function showError(message) {
                $('#attendanceTableBody').html(`
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            ${message}
                        </td>
                    </tr>
                `);
            }
            
            // Global functions for button actions
            window.viewDetail = function(nip) {
                const date = $('#filterDate').val();
                window.open(`guru_detail.php?nip=${nip}&date=${date}`, '_blank');
            };
            
            window.exportIndividual = function(nip) {
                const date = $('#filterDate').val();
                window.open(`absensi_guru_export_daily_pdf.php?nip=${nip}&date=${date}`, '_blank');
            };
        });

        // Original navbar and filter functions
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

        function loadPeriodData() {
            const selectedMonth = document.getElementById('monthYear').value;
            window.location.href = `?month=${selectedMonth}`;
        }

        function exportData(format) {
            const selectedMonth = document.getElementById('monthYear').value;
            
            if (format === 'excel') {
                window.open(`absensi_export.php?format=excel&month=${selectedMonth}`, '_blank');
            } else if (format === 'pdf') {
                window.open(`absensi_export.php?format=pdf&month=${selectedMonth}`, '_blank');
            }
        }
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

        function loadPeriodData() {
            const selectedMonth = document.getElementById('monthYear').value;
            window.location.href = `?month=${selectedMonth}`;
        }

        function exportData(format) {
            const selectedMonth = document.getElementById('monthYear').value;
            
            if (format === 'excel') {
                window.open(`absensi_export.php?format=excel&month=${selectedMonth}`, '_blank');
            } else if (format === 'pdf') {
                // Direct PDF export with better approach
                window.open(`absensi_export_pdf_direct.php?month=${selectedMonth}&download=1`, '_blank');
            }
        }

        function testPDFExport() {
            const selectedMonth = document.getElementById('monthYear').value;
            
            // Show options to user
            const choice = confirm('Pilih PDF Export:\nOK = Direct PDF View\nCancel = Force Download');
            
            if (choice) {
                // Direct PDF view
                window.open(`absensi_export_pdf_direct.php?month=${selectedMonth}`, '_blank');
            } else {
                // Force download
                window.open(`absensi_export_pdf_force.php?month=${selectedMonth}`, '_blank');
            }
        }

        // Daily export functions
        function exportDailyData(format) {
            const selectedDate = document.getElementById('dailyDate').value;
            
            if (format === 'excel') {
                window.open(`absensi_guru_export_daily.php?format=excel&date=${selectedDate}`, '_blank');
            } else if (format === 'pdf') {
                window.open(`absensi_guru_export_daily_pdf.php?date=${selectedDate}`, '_blank');
            }
        }

        function loadDailyData() {
            const selectedDate = document.getElementById('dailyDate').value;
            
            // Update daily statistics via AJAX
            fetch(`absensi_guru_daily_stats.php?date=${selectedDate}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('dailyTotalMasuk').textContent = data.total_hadir;
                    document.getElementById('dailyTotalTidakMasuk').textContent = data.total_tidak_hadir;
                    document.getElementById('dailyPersentaseKehadiran').textContent = data.persentase + '%';
                })
                .catch(error => {
                    console.error('Error loading daily stats:', error);
                });
        }

        // Toggle between monthly and daily mode
        document.addEventListener('DOMContentLoaded', function() {
            const monthlyMode = document.getElementById('monthlyMode');
            const dailyMode = document.getElementById('dailyMode');
            const monthlySelector = document.querySelector('.period-selector');
            const dailySelector = document.getElementById('dailyPeriodSelector');
            const monthlyExports = document.querySelectorAll('.monthly-export');
            const dailyExports = document.querySelectorAll('.daily-export');

            function toggleExportMode() {
                if (dailyMode.checked) {
                    // Show daily controls, hide monthly
                    monthlySelector.style.display = 'none';
                    dailySelector.style.display = 'block';
                    monthlyExports.forEach(item => item.style.display = 'none');
                    dailyExports.forEach(item => item.style.display = 'block');
                    loadDailyData();
                } else {
                    // Show monthly controls, hide daily
                    monthlySelector.style.display = 'block';
                    dailySelector.style.display = 'none';
                    monthlyExports.forEach(item => item.style.display = 'block');
                    dailyExports.forEach(item => item.style.display = 'none');
                }
            }

            monthlyMode.addEventListener('change', toggleExportMode);
            dailyMode.addEventListener('change', toggleExportMode);
        });

        // Variables for absent modal
        let currentTeacherNip = '';
        let currentTeacherName = '';

        function markAbsent(nip, name, currentStatus = '') {
            currentTeacherNip = nip;
            currentTeacherName = name;
            
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

        function saveAbsentStatus() {
            const selectedStatus = document.querySelector('input[name="absentStatus"]:checked');
            
            if (!selectedStatus) {
                alert('Mohon pilih status ketidakhadiran');
                return;
            }
            
            const formData = new FormData();
            formData.append('nip', currentTeacherNip);
            formData.append('status', selectedStatus.value);
            formData.append('tanggal', '<?= date('Y-m-d'); ?>');
            
            fetch('controller/mark_absent_guru.php', {
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
