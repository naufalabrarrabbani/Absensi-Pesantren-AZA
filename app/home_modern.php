<?php
include '../include/koneksi.php';
// memulai session

session_start();
error_reporting(0);
/**
 * Jika Tidak login atau sudah login tapi bukan sebagai admin
 * maka akan dibawa kembali kehalaman login atau menuju halaman yang seharusnya.
 */
if ( !isset($_SESSION['username'])) {
	header('location:../login.php');
	exit();
}

// Query untuk data siswa
$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan");
$t_karyawan = mysqli_num_rows($s_karyawan);

$skr = date('Y-m-d');
$s_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi where tanggal='$skr' and ijin is NULL and masuk IS NOT NULL and status_tidak_masuk IS NULL order by masuk DESC");
$t_absen = mysqli_num_rows($s_absen);

$s_pulang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi where tanggal='$skr' AND pulang !='0' AND masuk IS NOT NULL AND status_tidak_masuk IS NULL order by pulang DESC");
$t_pulang = mysqli_num_rows($s_pulang);

// Query untuk data guru
$s_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from guru");
$t_guru = mysqli_num_rows($s_guru);

$s_guru_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi_guru where tanggal='$skr' and ijin is NULL and masuk IS NOT NULL and status_tidak_masuk IS NULL order by masuk DESC");
$t_guru_absen = mysqli_num_rows($s_guru_absen);

$s_guru_pulang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi_guru where tanggal='$skr' AND pulang !='0' AND masuk IS NOT NULL AND status_tidak_masuk IS NULL order by pulang DESC");
$t_guru_pulang = mysqli_num_rows($s_guru_pulang);

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

        .statistics-card {
            width: 100%;
            padding: 27px;
            background: #fff;
            border-radius: 26px;
            margin-bottom: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .statistics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .statistics-card.simple {
            padding: 24px;
        }
        @media (min-width: 1200px) {
            .statistics-card {
                margin-bottom: 10px;
            }
        }
        
        .statistics-value {
            font-weight: 700;
            font-size: 32px;
            line-height: 48px;
            color: #121F3E;
        }
        
        .statistics-desc {
            font-weight: 400;
            font-size: 14px;
            color: #ABB3C4;
            margin-bottom: 20px;
        }
        
        .statistics-list {
            margin-top: 20px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
        
        .statistics-image {
            border: 2px solid white;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            object-fit: cover;
        }
        .statistics-image:not(:last-child) {
            margin-right: -12px;
        }
        
        .statistics-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid white;
            border-radius: 50%;
            width: 36px;
            height: 36px;
        }
        .statistics-icon i {
            font-size: 14px;
        }
        .statistics-icon span {
            font-weight: 600;
            font-size: 12px;
            line-height: 18px;
            text-align: center;
        }
        .statistics-icon:not(:last-child) {
            margin-right: -12px;
        }
        .statistics-icon.plus {
            background: #F4F9EC;
            color: #4CAF50;
        }

        .document-card {
            padding: 24px;
            background: #fff;
            border-radius: 26px;
            margin-bottom: 56px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .document-card .document-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            padding: 15px;
            border-radius: 12px;
        }
        
        .document-card .document-item:hover {
            background: #f8f9fa;
        }
        
        .document-card .document-item .document-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 60px;
            margin-right: 16px;
            border-radius: 50%;
        }
        .document-card .document-item .document-icon.students {
            background: #E3F2FD;
            color: #2196F3;
        }
        .document-card .document-item .document-icon.present {
            background: #E8F5E8;
            color: #4CAF50;
        }
        .document-card .document-item .document-icon.absent {
            background: #FFEBEE;
            color: #F44336;
        }
        .document-card .document-item .document-icon i {
            font-size: 24px;
        }
        .document-card .document-item:not(:last-child) {
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #F7F7FA;
        }
        
        .document-title {
            font-weight: 600;
            font-size: 16px;
            line-height: 14px;
            margin-top: 2px;
            color: #121F3E;
        }
        .document-desc {
            font-weight: 400;
            font-size: 16px;
            color: #ABB3C4;
            margin: 0;
        }

        .btn-statistics {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #F8F8FA;
        }

        /* Custom colors for different statistics */
        .stats-active {
            background: #fff;
            color: #121F3E;
        }
        
        .stats-present {
            background: #fff;
            color: #121F3E;
        }
        
        .stats-absent {
            background: #fff;
            color: #121F3E;
        }
        
        .stats-home {
            background: #fff;
            color: #121F3E;
        }
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Dashboard</title>
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

                <a href="./home_modern.php" class="sidebar-item active" onclick="toggleActive(this)">
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

                <h5 class="sidebar-title">Others</h5>

                <a href="setting_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <a href="../controllers/logout.php" class="sidebar-item">
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
                        <h2 class="nav-title">Dashboard</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <div class="nav-input-group">
                        <input type="text" class="nav-input" placeholder="Search students, class, reports">
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
                        <h2 class="content-title">Statistics</h2>
                        <h5 class="content-desc mb-4">Student attendance overview</h5>
                    </div>

                    <!-- Siswa Aktif -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-active">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <h5 class="statistics-value"><?= $t_karyawan; ?></h5>
                                    <p class="statistics-desc">Siswa Aktif</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-users" style="color: #4640DE;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $students_active = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT foto FROM karyawan ORDER BY id DESC LIMIT 4");
                                $count = 0;
                                while ($peg = mysqli_fetch_array($students_active)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/<?= $peg['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Student" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($t_karyawan > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $t_karyawan - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Siswa Masuk -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-present">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <h5 class="statistics-value"><?= $t_absen; ?></h5>
                                    <p class="statistics-desc">Siswa Masuk</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-check" style="color: #4CAF50;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $students_present = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT k.foto FROM absensi a JOIN karyawan k ON a.nik = k.nik WHERE a.tanggal='$skr' AND a.ijin IS NULL AND a.masuk IS NOT NULL AND a.status_tidak_masuk IS NULL ORDER BY a.masuk DESC LIMIT 4");
                                $count = 0;
                                while ($peg = mysqli_fetch_array($students_present)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/<?= $peg['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Student" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($t_absen > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $t_absen - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Siswa Tidak Masuk -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-absent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <?php
                                    // Count students who are absent (no attendance record or marked as sakit/izin/alpha)
                                    $total_tidak_masuk_query = mysqli_query($GLOBALS["___mysqli_ston"], "
                                        SELECT COUNT(*) as total FROM karyawan k 
                                        LEFT JOIN absensi a ON k.nik = a.nik AND a.tanggal = '$skr'
                                        WHERE a.nik IS NULL OR (a.masuk IS NULL AND a.ijin IS NULL) OR a.status_tidak_masuk IS NOT NULL
                                    ");
                                    $total_tidak_masuk = mysqli_fetch_array($total_tidak_masuk_query)['total'];
                                    ?>
                                    <h5 class="statistics-value"><?= $total_tidak_masuk; ?></h5>
                                    <p class="statistics-desc">Tidak Masuk</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-times" style="color: #F44336;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $students_absent = mysqli_query($GLOBALS["___mysqli_ston"], "
                                    SELECT k.foto FROM karyawan k 
                                    LEFT JOIN absensi a ON k.nik = a.nik AND a.tanggal = '$skr'
                                    WHERE a.nik IS NULL OR (a.masuk IS NULL AND a.ijin IS NULL) OR a.status_tidak_masuk IS NOT NULL
                                    ORDER BY k.id DESC LIMIT 4
                                ");
                                $count = 0;
                                while ($peg = mysqli_fetch_array($students_absent)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/<?= $peg['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Student" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($total_tidak_masuk > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $total_tidak_masuk - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Siswa Pulang -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-home">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <h5 class="statistics-value"><?= $t_pulang; ?></h5>
                                    <p class="statistics-desc">Siswa Pulang</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-home" style="color: #FF9800;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $students_home = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT k.foto FROM absensi a JOIN karyawan k ON a.nik = k.nik WHERE a.tanggal='$skr' AND a.pulang != '0' AND a.masuk IS NOT NULL AND a.status_tidak_masuk IS NULL ORDER BY a.pulang DESC LIMIT 4");
                                $count = 0;
                                while ($peg = mysqli_fetch_array($students_home)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/<?= $peg['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Student" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($t_pulang > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $t_pulang - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Teacher Statistics Section -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h2 class="content-title">Teacher Statistics</h2>
                        <h5 class="content-desc mb-4">Teacher attendance overview</h5>
                    </div>

                    <!-- Guru Aktif -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-active">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <h5 class="statistics-value"><?= $t_guru; ?></h5>
                                    <p class="statistics-desc">Guru Aktif</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-chalkboard-teacher" style="color: #4640DE;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $teachers_active = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT foto FROM guru ORDER BY id DESC LIMIT 4");
                                $count = 0;
                                while ($guru = mysqli_fetch_array($teachers_active)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/guru/<?= $guru['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Teacher" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($t_guru > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $t_guru - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Guru Masuk -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-present">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <h5 class="statistics-value"><?= $t_guru_absen; ?></h5>
                                    <p class="statistics-desc">Guru Masuk</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-check" style="color: #4CAF50;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $teachers_present = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT g.foto FROM absensi_guru a JOIN guru g ON a.nip = g.nip WHERE a.tanggal='$skr' AND a.ijin IS NULL AND a.masuk IS NOT NULL AND a.status_tidak_masuk IS NULL ORDER BY a.masuk DESC LIMIT 4");
                                $count = 0;
                                while ($guru = mysqli_fetch_array($teachers_present)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/guru/<?= $guru['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Teacher" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($t_guru_absen > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $t_guru_absen - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Guru Tidak Masuk -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-absent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <?php
                                    // Count teachers who are absent (no attendance record or marked as sakit/izin/alpha)
                                    $total_guru_tidak_masuk_query = mysqli_query($GLOBALS["___mysqli_ston"], "
                                        SELECT COUNT(*) as total FROM guru g 
                                        LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$skr'
                                        WHERE a.nip IS NULL OR (a.masuk IS NULL AND a.ijin IS NULL) OR a.status_tidak_masuk IS NOT NULL
                                    ");
                                    $total_guru_tidak_masuk = mysqli_fetch_array($total_guru_tidak_masuk_query)['total'];
                                    ?>
                                    <h5 class="statistics-value"><?= $total_guru_tidak_masuk; ?></h5>
                                    <p class="statistics-desc">Tidak Masuk</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-times" style="color: #F44336;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $teachers_absent = mysqli_query($GLOBALS["___mysqli_ston"], "
                                    SELECT g.foto FROM guru g 
                                    LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$skr'
                                    WHERE a.nip IS NULL OR (a.masuk IS NULL AND a.ijin IS NULL) OR a.status_tidak_masuk IS NOT NULL
                                    ORDER BY g.id DESC LIMIT 4
                                ");
                                $count = 0;
                                while ($guru = mysqli_fetch_array($teachers_absent)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/guru/<?= $guru['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Teacher" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($total_guru_tidak_masuk > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $total_guru_tidak_masuk - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- Guru Pulang -->
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="statistics-card stats-home">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-between align-items-start">
                                    <h5 class="statistics-value"><?= $t_guru_pulang; ?></h5>
                                    <p class="statistics-desc">Guru Pulang</p>
                                </div>
                                <button class="btn-statistics" style="background: #f8f9fa;">
                                    <i class="fas fa-home" style="color: #FF9800;"></i>
                                </button>
                            </div>

                            <div class="statistics-list">
                                <?php
                                $teachers_home = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT g.foto FROM absensi_guru a JOIN guru g ON a.nip = g.nip WHERE a.tanggal='$skr' AND a.pulang != '0' AND a.masuk IS NOT NULL AND a.status_tidak_masuk IS NULL ORDER BY a.pulang DESC LIMIT 4");
                                $count = 0;
                                while ($guru = mysqli_fetch_array($teachers_home)) {
                                    if ($count >= 4) break;
                                    $count++;
                                ?>
                                <img src="images/guru/<?= $guru['foto'] ?: 'default-avatar.png'; ?>" 
                                     alt="Teacher" 
                                     class="statistics-image"
                                     onerror="this.src='images/default-avatar.png'">
                                <?php } ?>
                                <?php if ($t_guru_pulang > 4) { ?>
                                <div class="statistics-icon plus">
                                    <span>+<?= $t_guru_pulang - 4; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row mt-5">
                    <div class="col-12 col-lg-6">
                        <h2 class="content-title">Attendance by Area</h2>
                        <h5 class="content-desc mb-4">Students present by area</h5>

                        <div class="document-card">
                            <?php
                            $s_area = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from area");
                            while ($d_area = mysqli_fetch_array($s_area)) {
                                $d_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi,karyawan where absensi.nik= karyawan.nik AND karyawan.area='$d_area[kode_area]' AND absensi.tanggal='$skr' AND absensi.ijin is NULL"));
                            ?>
                            <div class="document-item">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="document-icon present">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="document-title"><?= $d_area['area']; ?></h6>
                                        <p class="document-desc"><?= $d_masuk; ?> students present</p>
                                    </div>
                                </div>
                                <span class="badge bg-success"><?= $d_masuk; ?></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <h2 class="content-title">Absent by Area</h2>
                        <h5 class="content-desc mb-4">Students absent by area</h5>

                        <div class="document-card">
                            <?php
                            $s_area1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from area");
                            while ($d_area1 = mysqli_fetch_array($s_area1)) {
                                $d_masuk1 = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi,karyawan where absensi.nik= karyawan.nik AND karyawan.area='$d_area1[kode_area]' AND absensi.tanggal='$skr' AND absensi.ijin is NULL"));
                                $d_total = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where area='$d_area1[kode_area]'"));
                                $absent_count = $d_total - $d_masuk1;
                            ?>
                            <div class="document-item">
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="document-icon absent">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="document-title"><?= $d_area1['area']; ?></h6>
                                        <p class="document-desc"><?= $absent_count; ?> students absent</p>
                                    </div>
                                </div>
                                <span class="badge bg-danger"><?= $absent_count; ?></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div> -->

                <!-- Recent Activity -->
                <div class="row mt-4">
                    <div class="col-12 col-lg-6">
                        <h2 class="content-title">Recent Student Activity</h2>
                        <h5 class="content-desc mb-4">Latest student check-ins</h5>

                        <div class="document-card">
                            <?php
                            $recent_activity = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT a.*, k.nama, k.foto FROM absensi a JOIN karyawan k ON a.nik = k.nik WHERE a.tanggal='$skr' AND a.masuk IS NOT NULL AND a.status_tidak_masuk IS NULL ORDER BY a.masuk DESC LIMIT 8");
                            while ($activity = mysqli_fetch_array($recent_activity)) {
                            ?>
                            <div class="document-item">
                                <div class="d-flex justify-content-start align-items-center">
                                    <img src="images/<?= $activity['foto'] ?: 'default-avatar.png'; ?>" 
                                         alt="<?= $activity['nama']; ?>" 
                                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px;"
                                         onerror="this.src='images/default-avatar.png'">
                                    <div>
                                        <h6 class="document-title"><?= $activity['nama']; ?></h6>
                                        <p class="document-desc">
                                            <?php if ($activity['masuk']) { ?>
                                                Check in at <?= date('H:i', strtotime($activity['masuk'])); ?>
                                            <?php } ?>
                                            <?php if ($activity['pulang'] && $activity['pulang'] != '0') { ?>
                                                • Check out at <?= date('H:i', strtotime($activity['pulang'])); ?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="badge bg-primary">
                                    <?= $activity['masuk'] ? date('H:i', strtotime($activity['masuk'])) : '-'; ?>
                                </span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <h2 class="content-title">Recent Teacher Activity</h2>
                        <h5 class="content-desc mb-4">Latest teacher check-ins</h5>

                        <div class="document-card">
                            <?php
                            $recent_teacher_activity = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT a.*, g.nama, g.foto FROM absensi_guru a JOIN guru g ON a.nip = g.nip WHERE a.tanggal='$skr' AND a.masuk IS NOT NULL AND a.status_tidak_masuk IS NULL ORDER BY a.masuk DESC LIMIT 8");
                            while ($teacher_activity = mysqli_fetch_array($recent_teacher_activity)) {
                            ?>
                            <div class="document-item">
                                <div class="d-flex justify-content-start align-items-center">
                                    <img src="images/guru/<?= $teacher_activity['foto'] ?: 'default-avatar.png'; ?>" 
                                         alt="<?= $teacher_activity['nama']; ?>" 
                                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px;"
                                         onerror="this.src='images/default-avatar.png'">
                                    <div>
                                        <h6 class="document-title"><?= $teacher_activity['nama']; ?></h6>
                                        <p class="document-desc">
                                            <?php if ($teacher_activity['masuk']) { ?>
                                                Check in at <?= date('H:i', strtotime($teacher_activity['masuk'])); ?>
                                            <?php } ?>
                                            <?php if ($teacher_activity['pulang'] && $teacher_activity['pulang'] != '0') { ?>
                                                • Check out at <?= date('H:i', strtotime($teacher_activity['pulang'])); ?>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="badge bg-success">
                                    <?= $teacher_activity['masuk'] ? date('H:i', strtotime($teacher_activity['masuk'])) : '-'; ?>
                                </span>
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

        // Auto refresh every 30 seconds for real-time updates
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
</body>

</html>
