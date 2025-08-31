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
            
            .period-selector .row {
                flex-direction: column;
            }
            
            .period-selector .col-md-2,
            .period-selector .col-md-3 {
                margin-bottom: 15px;
            }
        }

        .dropdown-menu {
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
            padding: 8px 0 !important;
        }

        .dropdown-item {
            padding: 8px 16px !important;
            transition: all 0.3s ease !important;
            border-radius: 8px !important;
            margin: 2px 8px !important;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa !important;
            transform: translateX(4px) !important;
        }

        .dropdown-header {
            color: #4640DE !important;
            font-weight: 600 !important;
            padding: 8px 16px 4px 16px !important;
            margin-bottom: 4px !important;
        }

        .dropdown-divider {
            margin: 8px 0 !important;
            opacity: 0.3 !important;
        }

        .badge {
            font-size: 0.75em;
            padding: 4px 8px;
            border-radius: 12px;
            margin-left: 4px;
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
                                    <p class="content-desc mb-0">
                                        Monitor dan kelola data absensi guru 
                                        <?php 
                                        $mapel_filter_display = isset($_GET['mata_pelajaran']) ? urldecode($_GET['mata_pelajaran']) : '';
                                        if ($mapel_filter_display): ?>
                                            <span class="badge bg-primary">📚 <?= htmlspecialchars($mapel_filter_display); ?></span>
                                        <?php endif; ?>
                                        <?php if (isset($_GET['date'])): ?>
                                            - <span class="badge bg-info">📅 <?= date('d F Y', strtotime($_GET['date'])); ?></span>
                                        <?php else: 
                                            $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
                                        ?>
                                            - <span class="badge bg-success">📊 <?= date('F Y', strtotime($selected_month . '-01')); ?></span>
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
                                            <li><a class="dropdown-item" href="#" onclick="exportMonthlyData('excel')"><i class="fas fa-file-excel me-2 text-success"></i>Excel Bulanan</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportMonthlyData('pdf')"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF Bulanan</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><h6 class="dropdown-header"><i class="fas fa-calendar-day me-1"></i>Laporan Harian</h6></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportDailyData('excel')"><i class="fas fa-file-excel me-2 text-success"></i>Excel Harian</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="exportDailyData('pdf')"><i class="fas fa-file-pdf me-2 text-danger"></i>PDF Harian</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><h6 class="dropdown-header"><i class="fas fa-vial me-1"></i>Test Export</h6></li>
                                            <li><a class="dropdown-item" href="#" onclick="testPDFExport()"><i class="fas fa-test-tube me-2 text-warning"></i>Test PDF Export</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Period Selector -->
                            <div class="period-selector">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <label class="form-label">Filter Periode:</label>
                                        <select class="form-modern" id="filterType" onchange="toggleFilterOptions()">
                                            <option value="daily" <?= isset($_GET['date']) ? 'selected' : ''; ?>>Harian</option>
                                            <option value="monthly" <?= isset($_GET['month']) && !isset($_GET['date']) ? 'selected' : ''; ?>>Bulanan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2" id="dateFilter" style="<?= isset($_GET['date']) ? '' : 'display: none;'; ?>">
                                        <label class="form-label">Pilih Tanggal:</label>
                                        <?php
                                        $selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
                                        ?>
                                        <input type="date" class="form-modern" id="filterDate" value="<?= $selected_date; ?>" onchange="loadPeriodData()">
                                    </div>
                                    <div class="col-md-2" id="monthFilter" style="<?= isset($_GET['date']) ? 'display: none;' : ''; ?>">
                                        <label class="form-label">Pilih Bulan:</label>
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
                                    <div class="col-md-3">
                                        <label class="form-label">
                                            <i class="fas fa-book me-1"></i>
                                            Filter Mata Pelajaran:
                                        </label>
                                        <?php
                                        $selected_mapel = isset($_GET['mata_pelajaran']) ? $_GET['mata_pelajaran'] : '';
                                        ?>
                                        <select class="form-modern" id="mapelFilter" onchange="loadPeriodData()">
                                            <option value="">🎯 Semua Mata Pelajaran</option>
                                            <?php
                                            $mapel_query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT mata_pelajaran FROM guru WHERE mata_pelajaran IS NOT NULL AND mata_pelajaran != '' ORDER BY mata_pelajaran ASC");
                                            while ($mapel = mysqli_fetch_array($mapel_query)) {
                                                $selected = ($mapel['mata_pelajaran'] == $selected_mapel) ? 'selected' : '';
                                                echo "<option value='{$mapel['mata_pelajaran']}' $selected>📚 {$mapel['mata_pelajaran']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="period-stats">
                                            <div class="stat-item">
                                                <span class="stat-label">Guru Hadir</span>
                                                <span class="stat-value text-success" id="totalMasuk">
                                                    <?php
                                                    $mapel_filter_stat = isset($_GET['mata_pelajaran']) ? urldecode($_GET['mata_pelajaran']) : '';
                                                    
                                                    // Build mata pelajaran condition with proper escaping
                                                    $mapel_condition_stat = "";
                                                    if ($mapel_filter_stat && $mapel_filter_stat != '') {
                                                        $mapel_filter_escaped_stat = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $mapel_filter_stat);
                                                        $mapel_condition_stat = " AND g.mata_pelajaran = '$mapel_filter_escaped_stat'";
                                                    }
                                                    
                                                    if (isset($_GET['date'])) {
                                                        // Daily filter
                                                        $filter_date = $_GET['date'];
                                                        $total_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT DISTINCT a.nip FROM absensi_guru a 
                                                             JOIN guru g ON a.nip = g.nip 
                                                             WHERE a.tanggal = '$filter_date' 
                                                             AND a.masuk IS NOT NULL 
                                                             AND a.ijin IS NULL 
                                                             AND a.status_tidak_masuk IS NULL 
                                                             $mapel_condition_stat"));
                                                    } else {
                                                        // Monthly filter
                                                        $filter_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
                                                        $total_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT a.* FROM absensi_guru a 
                                                             JOIN guru g ON a.nip = g.nip 
                                                             WHERE DATE_FORMAT(a.tanggal, '%Y-%m') = '$filter_month' 
                                                             AND a.masuk IS NOT NULL 
                                                             AND a.ijin IS NULL 
                                                             AND a.status_tidak_masuk IS NULL 
                                                             $mapel_condition_stat"));
                                                    }
                                                    echo $total_masuk;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Tidak Hadir</span>
                                                <span class="stat-value text-danger" id="totalTidakMasuk">
                                                    <?php
                                                    if (isset($_GET['date'])) {
                                                        // Daily filter
                                                        $total_tidak_masuk_all = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT DISTINCT a.nip FROM absensi_guru a 
                                                             JOIN guru g ON a.nip = g.nip 
                                                             WHERE a.tanggal = '$filter_date' 
                                                             AND (a.ijin IS NOT NULL OR a.status_tidak_masuk IS NOT NULL) 
                                                             $mapel_condition"));
                                                    } else {
                                                        // Monthly filter
                                                        $total_tidak_masuk_all = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT a.* FROM absensi_guru a 
                                                             JOIN guru g ON a.nip = g.nip 
                                                             WHERE DATE_FORMAT(a.tanggal, '%Y-%m') = '$filter_month' 
                                                             AND (a.ijin IS NOT NULL OR a.status_tidak_masuk IS NOT NULL) 
                                                             $mapel_condition"));
                                                    }
                                                    echo $total_tidak_masuk_all;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Persentase</span>
                                                <span class="stat-value text-primary" id="persentaseKehadiran">
                                                    <?php
                                                    $total_guru = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE 1=1 $mapel_condition"));
                                                    if (isset($_GET['date'])) {
                                                        // Daily calculation
                                                        $persentase = $total_guru > 0 ? round(($total_masuk / $total_guru) * 100, 1) : 0;
                                                    } else {
                                                        // Monthly calculation
                                                        $total_hari_kerja = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                                                            "SELECT DISTINCT a.tanggal FROM absensi_guru a 
                                                             JOIN guru g ON a.nip = g.nip 
                                                             WHERE DATE_FORMAT(a.tanggal, '%Y-%m') = '$filter_month' 
                                                             $mapel_condition"));
                                                        $total_expected = $total_guru * $total_hari_kerja;
                                                        $persentase = $total_expected > 0 ? round(($total_masuk / $total_expected) * 100, 1) : 0;
                                                    }
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
                                            <th>Nama Guru</th>
                                            <th>Mata Pelajaran</th>
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
                                        $is_daily_filter = isset($_GET['date']);
                                        $mapel_filter = isset($_GET['mata_pelajaran']) ? $_GET['mata_pelajaran'] : '';
                                        
                                        // Debug: Show received filter
                                        echo "<!-- DEBUG Received mapel_filter: '" . htmlspecialchars($mapel_filter) . "' -->";
                                        echo "<!-- DEBUG URL decoded: '" . urldecode($mapel_filter) . "' -->";
                                        
                                        // Decode URL encoding if needed
                                        $mapel_filter = urldecode($mapel_filter);
                                        
                                        // Build mata pelajaran condition
                                        $mapel_condition = "";
                                        if ($mapel_filter && $mapel_filter != '') {
                                            $mapel_filter_escaped = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $mapel_filter);
                                            $mapel_condition = " AND g.mata_pelajaran = '$mapel_filter_escaped'";
                                        }
                                        
                                        echo "<!-- DEBUG Final mapel_condition: '$mapel_condition' -->";
                                        
                                        if ($is_daily_filter) {
                                            // Daily filter
                                            $selected_date = $_GET['date'];
                                            $current_date = date('Y-m-d');
                                            
                                            // Query untuk data absensi guru per hari
                                            $query = "
                                                SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
                                                FROM guru g 
                                                LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$selected_date'
                                                WHERE 1=1 $mapel_condition
                                                ORDER BY g.nama ASC
                                            ";
                                            
                                            // Debug: uncomment line below to see query
                                            // echo "<!-- DEBUG Query: " . $query . " -->";
                                            // echo "<!-- DEBUG Mapel Filter: '$mapel_filter' -->";
                                            // echo "<!-- DEBUG Mapel Condition: '$mapel_condition' -->";
                                            
                                            $attendance = mysqli_query($GLOBALS["___mysqli_ston"], $query);
                                            
                                            if (!$attendance) {
                                                echo "<!-- DEBUG Error: " . mysqli_error($GLOBALS["___mysqli_ston"]) . " -->";
                                            }
                                            
                                            $row_count = 0;
                                            while ($data = mysqli_fetch_array($attendance)) {
                                                $row_count++;
                                                // Determine status for the selected day
                                                if ($data['ijin']) {
                                                    $status = 'permission';
                                                    $status_text = "Izin";
                                                    $status_class = 'status-permission';
                                                } elseif ($data['status_tidak_masuk']) {
                                                    $status = 'absent';
                                                    $status_text = ucfirst($data['status_tidak_masuk']);
                                                    $status_class = 'status-absent';
                                                } elseif ($data['masuk']) {
                                                    $status = 'present';
                                                    $status_text = "Hadir";
                                                    $status_class = 'status-present';
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
                                                        <?php if ($data['masuk']) { ?>
                                                            <span class="time-badge"><?= date('H:i', strtotime($data['masuk'])); ?></span>
                                                        <?php } else { ?>
                                                            <span class="text-muted">-</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($data['pulang'] && $data['pulang'] != '0') { ?>
                                                            <span class="time-badge"><?= date('H:i', strtotime($data['pulang'])); ?></span>
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
                                                        <?php if ($data['ijin']) { ?>
                                                            <small>Keterangan: <?= $data['ijin']; ?></small>
                                                        <?php } elseif ($data['status_tidak_masuk']) { ?>
                                                            <small>Status: <?= ucfirst($data['status_tidak_masuk']); ?></small>
                                                        <?php } else { ?>
                                                            <span class="text-muted">-</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($selected_date == $current_date && (!$data['masuk'] && !$data['ijin'] && !$data['status_tidak_masuk'])) { ?>
                                                            <button class="btn-modern warning" onclick="markAbsent('<?= $data['nip']; ?>', '<?= $data['nama']; ?>')">
                                                                <i class="fas fa-user-times"></i>
                                                                Tandai Tidak Masuk
                                                            </button>
                                                        <?php } elseif ($selected_date == $current_date && $data['status_tidak_masuk']) { ?>
                                                            <span class="status-badge status-permission">
                                                                <?= ucfirst($data['status_tidak_masuk']); ?>
                                                            </span>
                                                            <br>
                                                            <button class="btn-modern primary" style="font-size: 10px; padding: 4px 8px; margin-top: 5px;" onclick="markAbsent('<?= $data['nip']; ?>', '<?= $data['nama']; ?>', '<?= $data['status_tidak_masuk']; ?>')">
                                                                <i class="fas fa-edit"></i>
                                                                Edit
                                                            </button>
                                                        <?php } else { ?>
                                                            <span class="text-muted">-</span>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            
                                            // Debug: Show row count
                                            if ($row_count == 0) {
                                                echo "<!-- DEBUG: No rows found for daily filter. Query: SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk FROM guru g LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$selected_date' WHERE 1=1 $mapel_condition ORDER BY g.nama ASC -->";
                                                ?>
                                                <tr>
                                                    <td colspan="9" class="text-center text-muted">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Tidak ada data guru ditemukan untuk filter yang dipilih.
                                                        <br><small>Filter: <?= $mapel_filter ? "Mata Pelajaran: $mapel_filter, " : ""; ?>Tanggal: <?= $selected_date; ?></small>
                                                    </td>
                                                </tr>
                                                <?php
                                            } else {
                                                echo "<!-- DEBUG: Found $row_count rows for daily filter -->";
                                            }
                                        } else {
                                            // Monthly filter (original code)
                                            $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
                                            $selected_date = date('Y-m-d'); // Today's date for checking attendance
                                            
                                            // Query untuk data absensi guru per bulan
                                            $attendance = mysqli_query($GLOBALS["___mysqli_ston"], "
                                                SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
                                                FROM guru g 
                                                LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
                                                WHERE 1=1 $mapel_condition
                                                ORDER BY g.nama ASC, a.tanggal DESC
                                            ");
                                            
                                            $teacher_data = array();
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
                                            }
                                            
                                            // Debug: Show teacher count for monthly filter
                                            if (empty($teacher_data)) {
                                                echo "<!-- DEBUG: No teachers found for monthly filter. Mapel condition: $mapel_condition -->";
                                                ?>
                                                <tr>
                                                    <td colspan="9" class="text-center text-muted">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Tidak ada data guru ditemukan untuk filter yang dipilih.
                                                        <br><small>Filter: <?= $mapel_filter ? "Mata Pelajaran: $mapel_filter, " : ""; ?>Bulan: <?= date('F Y', strtotime($selected_month . '-01')); ?></small>
                                                    </td>
                                                </tr>
                                                <?php
                                            } else {
                                                echo "<!-- DEBUG: Found " . count($teacher_data) . " teachers for monthly filter -->";
                                            }
                                        }
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

        function loadPeriodData() {
            const filterType = document.getElementById('filterType').value;
            const selectedMapel = document.getElementById('mapelFilter').value;
            
            let url = '';
            if (filterType === 'daily') {
                const selectedDate = document.getElementById('filterDate').value;
                url = `?date=${selectedDate}`;
            } else {
                const selectedMonth = document.getElementById('monthYear').value;
                url = `?month=${selectedMonth}`;
            }
            
            if (selectedMapel) {
                url += `&mata_pelajaran=${encodeURIComponent(selectedMapel)}`;
            }
            
            window.location.href = url;
        }

        function toggleFilterOptions() {
            const filterType = document.getElementById('filterType').value;
            const dateFilter = document.getElementById('dateFilter');
            const monthFilter = document.getElementById('monthFilter');
            
            if (filterType === 'daily') {
                dateFilter.style.display = 'block';
                monthFilter.style.display = 'none';
            } else {
                dateFilter.style.display = 'none';
                monthFilter.style.display = 'block';
            }
        }

        function exportData(format) {
            // Export berdasarkan filter yang sedang aktif
            const filterType = document.getElementById('filterType').value;
            
            if (filterType === 'daily') {
                exportDailyData(format);
            } else {
                exportMonthlyData(format);
            }
        }

        function exportDailyData(format) {
            const selectedDate = document.getElementById('filterDate').value || '<?= date('Y-m-d'); ?>';
            const selectedMapel = document.getElementById('mapelFilter').value;
            
            let url = '';
            if (format === 'excel') {
                url = `absensi_guru_export.php?format=excel&date=${selectedDate}`;
                if (selectedMapel) {
                    url += `&mata_pelajaran=${encodeURIComponent(selectedMapel)}`;
                }
                window.open(url, '_blank');
            } else if (format === 'pdf') {
                url = `absensi_guru_export_pdf_direct.php?date=${selectedDate}&download=1`;
                if (selectedMapel) {
                    url += `&mata_pelajaran=${encodeURIComponent(selectedMapel)}`;
                }
                window.open(url, '_blank');
            }
        }

        function exportMonthlyData(format) {
            const selectedMonth = document.getElementById('monthYear').value || '<?= date('Y-m'); ?>';
            const selectedMapel = document.getElementById('mapelFilter').value;
            
            let url = '';
            if (format === 'excel') {
                url = `absensi_guru_export.php?format=excel&month=${selectedMonth}`;
                if (selectedMapel) {
                    url += `&mata_pelajaran=${encodeURIComponent(selectedMapel)}`;
                }
                window.open(url, '_blank');
            } else if (format === 'pdf') {
                url = `absensi_guru_export_pdf_direct.php?month=${selectedMonth}&download=1`;
                if (selectedMapel) {
                    url += `&mata_pelajaran=${encodeURIComponent(selectedMapel)}`;
                }
                window.open(url, '_blank');
            }
        }

        function testPDFExport() {
            const filterType = document.getElementById('filterType').value;
            const selectedMapel = document.getElementById('mapelFilter').value;
            let dateParam = '';
            
            if (filterType === 'daily') {
                dateParam = 'date=' + document.getElementById('filterDate').value;
            } else {
                dateParam = 'month=' + document.getElementById('monthYear').value;
            }
            
            if (selectedMapel) {
                dateParam += `&mata_pelajaran=${encodeURIComponent(selectedMapel)}`;
            }
            
            // Show options to user
            const choice = confirm('Pilih PDF Export:\nOK = Direct PDF View\nCancel = Force Download');
            
            if (choice) {
                // Direct PDF view
                window.open(`absensi_guru_export_pdf_direct.php?${dateParam}`, '_blank');
            } else {
                // Force download
                window.open(`absensi_guru_export_pdf_force.php?${dateParam}`, '_blank');
            }
        }

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
