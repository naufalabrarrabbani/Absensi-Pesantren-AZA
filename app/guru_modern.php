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

// Query untuk data guru
$s_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from guru");
$t_guru = mysqli_num_rows($s_guru);

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
        
        .status-active {
            background: #E8F5E8;
            color: #4CAF50;
        }
        
        .status-inactive {
            background: #FFEBEE;
            color: #F44336;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .modal-modern {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-modern .modal-header {
            background: linear-gradient(135deg, #4640DE 0%, #5a52e8 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px 30px;
            border: none;
        }

        .modal-modern .modal-title {
            font-weight: 600;
            font-size: 20px;
        }

        .modal-modern .modal-body {
            padding: 30px;
        }

        .modal-modern .modal-footer {
            padding: 20px 30px;
            border: none;
            border-radius: 0 0 20px 20px;
        }

        .form-modern {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #E0E0E0;
            border-radius: 12px;
            background: white;
            color: #121F3E;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .form-modern:focus {
            outline: none;
            border-color: #4640DE;
            box-shadow: 0 0 0 3px rgba(70, 64, 222, 0.1);
        }

        .form-label-modern {
            font-weight: 500;
            color: #121F3E;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group-modern {
            margin-bottom: 20px;
        }

        .btn-close-modern {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            opacity: 0.8;
        }

        .btn-close-modern:hover {
            opacity: 1;
            color: white;
        }

        .file-upload-area {
            border: 2px dashed #E0E0E0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: #4640DE;
            background: rgba(70, 64, 222, 0.02);
        }

        .file-upload-area.dragover {
            border-color: #4640DE;
            background: rgba(70, 64, 222, 0.05);
        }

        #filePreview {
            max-width: 100px;
            max-height: 100px;
            border-radius: 8px;
            margin-top: 10px;
        }
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Data Guru</title>
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

                <a href="guru_modern.php" class="sidebar-item active" onclick="toggleActive(this)">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Guru</span>
                </a>

                <a href="karyawan_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-users"></i>
                    <span>Siswa</span>
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
                        <h2 class="nav-title">Data Guru</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <div class="nav-input-group">
                        <input type="text" class="nav-input" placeholder="Search teachers..." id="searchInput" onkeyup="searchStudents()">
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
                <?php
                if (isset($_GET['pesan'])) {
                    $pesan = $_GET['pesan'];
                    if ($pesan == 'berhasil') {
                        $debug_info = isset($_GET['debug']) ? '<br><small>Debug: ' . urldecode($_GET['debug']) . '</small>' : '';
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Berhasil!</strong> Data guru berhasil ditambahkan.' . $debug_info . '
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } elseif ($pesan == 'update_berhasil') {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Berhasil!</strong> Data guru berhasil diperbarui.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } elseif ($pesan == 'delete_berhasil') {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Berhasil!</strong> Data guru berhasil dihapus.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } elseif ($pesan == 'gagal') {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #F44336 0%, #e53935 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Gagal!</strong> Data guru gagal ditambahkan.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } elseif ($pesan == 'update_gagal') {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #F44336 0%, #e53935 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Gagal!</strong> Data guru gagal diperbarui.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } elseif ($pesan == 'delete_gagal') {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #F44336 0%, #e53935 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Gagal!</strong> Data guru gagal dihapus.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } elseif ($pesan == 'nip_exists') {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #FF9800 0%, #f57c00 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Peringatan!</strong> NIP sudah terdaftar. Gunakan NIP yang berbeda.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } elseif ($pesan == 'data_not_found') {
                        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #FF9800 0%, #f57c00 100%); color: white; margin-bottom: 20px;">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Peringatan!</strong> Data guru tidak ditemukan.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    }
                }
                ?>
                
                <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); color: white;">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> <?= base64_decode($_GET['success']); ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #F44336 0%, #e53935 100%); color: white;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong> <?= base64_decode($_GET['error']); ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-12">
                        <div class="modern-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="content-title mb-0">Daftar Guru</h3>
                                    <p class="content-desc mb-0">Kelola data guru di sistem absensi</p>
                                </div>
                                <a href="#" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                                    <i class="fas fa-plus"></i>
                                    Tambah Guru
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $teachers = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru ORDER BY nama ASC");
                                        while ($teacher = mysqli_fetch_array($teachers)) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <?php 
                                                // Logic foto guru - sama seperti siswa
                                                if ($teacher['foto'] && $teacher['foto'] != 'default-avatar.png' && !empty(trim($teacher['foto']))) {
                                                    $foto_path = "images/guru/" . $teacher['foto'];
                                                } else {
                                                    $foto_path = "images/default-avatar-proper.png";
                                                }
                                                ?>
                                                <img src="<?= $foto_path; ?>" 
                                                     alt="<?= $teacher['nama']; ?>" 
                                                     class="student-avatar"
                                                     onerror="this.src='images/default-avatar-proper.png';">
                                            </td>
                                            <td><?= $teacher['nip']; ?></td>
                                            <td>
                                                <strong><?= $teacher['nama']; ?></strong>
                                                <br>
                                                <small class="text-muted"><?= $teacher['no_telp']; ?></small>
                                            </td>
                                            <td><?= $teacher['mata_pelajaran'] ?: 'Belum ditentukan'; ?></td>
                                            <td>
                                                <span class="status-badge status-active">
                                                    Aktif
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button class="btn-modern secondary" onclick="viewTeacher(<?= $teacher['id']; ?>)" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn-modern warning" onclick="editTeacher(<?= $teacher['id']; ?>)" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="../controller/guru_delete.php?id=<?= $teacher['id']; ?>" class="btn-modern danger" onclick="return confirm('Yakin ingin menghapus guru <?= $teacher['nama']; ?>?')" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
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

    <!-- Add Student Modal -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-modern">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Tambah Guru Baru
                    </h5>
                    <button type="button" class="btn-close-modern" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="../controller/guru_simpan.php" method="POST" enctype="multipart/form-data" id="addTeacherForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="nip" class="form-label-modern">
                                        <i class="fas fa-id-card me-1"></i>
                                        NIP
                                    </label>
                                    <input type="text" class="form-modern" id="nip" name="nip" placeholder="Masukkan NIP" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="nama" class="form-label-modern">
                                        <i class="fas fa-user me-1"></i>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" class="form-modern" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="mata_pelajaran" class="form-label-modern">
                                        <i class="fas fa-book me-1"></i>
                                        Mata Pelajaran
                                    </label>
                                    <select class="form-modern" id="mata_pelajaran" name="mata_pelajaran" required>
                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                        <option value="Matematika">Matematika</option>
                                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                        <option value="Bahasa Inggris">Bahasa Inggris</option>
                                        <option value="IPA">IPA</option>
                                        <option value="IPS">IPS</option>
                                        <option value="PKN">PKN</option>
                                        <option value="Agama">Agama</option>
                                        <option value="Seni Budaya">Seni Budaya</option>
                                        <option value="Penjaskes">Penjaskes</option>
                                        <option value="TIK">TIK</option>
                                        <option value="Bahasa Arab">Bahasa Arab</option>
                                        <option value="Akidah Akhlak">Akidah Akhlak</option>
                                        <option value="Fiqih">Fiqih</option>
                                        <option value="Quran Hadist">Quran Hadist</option>
                                        <option value="SKI">SKI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="no_telp" class="form-label-modern">
                                        <i class="fas fa-phone me-1"></i>
                                        No. Telepon
                                    </label>
                                    <input type="text" class="form-modern" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="jenis_kelamin" class="form-label-modern">
                                        <i class="fas fa-venus-mars me-1"></i>
                                        Jenis Kelamin
                                    </label>
                                    <select class="form-modern" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="lokasi" class="form-label-modern">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Lokasi
                                    </label>
                                    <input type="text" class="form-modern" id="lokasi" name="lokasi" placeholder="Masukkan lokasi">
                                </div>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="file" class="form-label-modern">
                                <i class="fas fa-camera me-1"></i>
                                Foto Guru
                            </label>
                            <div class="file-upload-area" onclick="document.getElementById('file').click()">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #ABB3C4; margin-bottom: 10px;"></i>
                                <p class="mb-0" style="color: #ABB3C4;">Klik untuk upload foto atau drag & drop</p>
                                <p class="mb-0" style="color: #ABB3C4; font-size: 12px;">Format: JPG, PNG, GIF (Max: 2MB)</p>
                                <img id="filePreview" style="display: none;">
                            </div>
                            <input type="file" class="d-none" id="file" name="file" accept="image/*" onchange="previewFile()">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modern" style="background: #6c757d; color: white;" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn-modern success">
                            <i class="fas fa-save me-1"></i>
                            Simpan Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Teacher Modal -->
    <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modern-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="editTeacherModalLabel">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Data Guru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../controller/guru_update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="edit_nama" class="form-label-modern">
                                        <i class="fas fa-user me-1"></i>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" class="form-modern" id="edit_nama" name="nama" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="edit_nip" class="form-label-modern">
                                        <i class="fas fa-id-card me-1"></i>
                                        NIP
                                    </label>
                                    <input type="text" class="form-modern" id="edit_nip" name="nip" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="edit_mata_pelajaran" class="form-label-modern">
                                        <i class="fas fa-book me-1"></i>
                                        Mata Pelajaran
                                    </label>
                                    <select class="form-modern" id="edit_mata_pelajaran" name="mata_pelajaran" required>
                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                        <option value="Matematika">Matematika</option>
                                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                                        <option value="Bahasa Inggris">Bahasa Inggris</option>
                                        <option value="IPA">IPA</option>
                                        <option value="IPS">IPS</option>
                                        <option value="PKN">PKN</option>
                                        <option value="Agama">Agama</option>
                                        <option value="Seni Budaya">Seni Budaya</option>
                                        <option value="Penjaskes">Penjaskes</option>
                                        <option value="TIK">TIK</option>
                                        <option value="Bahasa Arab">Bahasa Arab</option>
                                        <option value="Akidah Akhlak">Akidah Akhlak</option>
                                        <option value="Fiqih">Fiqih</option>
                                        <option value="Quran Hadist">Quran Hadist</option>
                                        <option value="SKI">SKI</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="edit_no_telp" class="form-label-modern">
                                        <i class="fas fa-phone me-1"></i>
                                        No. Telepon
                                    </label>
                                    <input type="text" class="form-modern" id="edit_no_telp" name="no_telp" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="edit_jenis_kelamin" class="form-label-modern">
                                        <i class="fas fa-venus-mars me-1"></i>
                                        Jenis Kelamin
                                    </label>
                                    <select class="form-modern" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="edit_lokasi" class="form-label-modern">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Lokasi
                                    </label>
                                    <input type="text" class="form-modern" id="edit_lokasi" name="lokasi">
                                </div>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="edit_foto" class="form-label-modern">
                                <i class="fas fa-camera me-1"></i>
                                Foto Guru (Kosongkan jika tidak diubah)
                            </label>
                            <input type="file" class="form-modern" id="edit_foto" name="foto" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modern" style="background: #6c757d; color: white;" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </button>
                        <button type="submit" class="btn-modern primary">
                            <i class="fas fa-save me-1"></i>
                            Update Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Teacher Modal -->
    <div class="modal fade" id="viewTeacherModal" tabindex="-1" aria-labelledby="viewTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modern-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="viewTeacherModalLabel">
                        <i class="fas fa-user me-2"></i>
                        Detail Guru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img id="view_foto" src="" alt="Foto Guru" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama:</strong></td>
                                    <td id="view_nama"></td>
                                </tr>
                                <tr>
                                    <td><strong>NIP:</strong></td>
                                    <td id="view_nip"></td>
                                </tr>
                                <tr>
                                    <td><strong>Mata Pelajaran:</strong></td>
                                    <td id="view_mata_pelajaran"></td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kelamin:</strong></td>
                                    <td id="view_jenis_kelamin"></td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telepon:</strong></td>
                                    <td id="view_no_telp"></td>
                                </tr>
                                <tr>
                                    <td><strong>Lokasi:</strong></td>
                                    <td id="view_lokasi"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-modern secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Tutup
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

        // File preview function
        function previewFile() {
            const file = document.getElementById('file').files[0];
            const preview = document.getElementById('filePreview');
            const uploadArea = document.querySelector('.file-upload-area');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    uploadArea.innerHTML = `
                        <img src="${e.target.result}" style="max-width: 100px; max-height: 100px; border-radius: 8px;">
                        <p class="mb-0 mt-2" style="color: #4640DE; font-weight: 500;">${file.name}</p>
                        <p class="mb-0" style="color: #ABB3C4; font-size: 12px;">Klik untuk ganti foto</p>
                    `;
                }
                reader.readAsDataURL(file);
            }
        }

        // Drag and drop functionality
        const fileUploadArea = document.querySelector('.file-upload-area');
        const fileInput = document.getElementById('file');

        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                previewFile();
            }
        });

        // Form validation
        document.getElementById('addTeacherForm').addEventListener('submit', function(e) {
            const nip = document.getElementById('nip').value;
            const nama = document.getElementById('nama').value;
            const mata_pelajaran = document.getElementById('mata_pelajaran').value;
            const no_telp = document.getElementById('no_telp').value;
            
            if (!nip || !nama || !mata_pelajaran || !no_telp) {
                e.preventDefault();
                alert('Mohon lengkapi data NIP, Nama, Mata Pelajaran, dan No. Telepon');
                return false;
            }
            
            // Validate NIP format (hanya angka)
            if (!/^\d+$/.test(nip)) {
                e.preventDefault();
                alert('NIP harus berupa angka');
                return false;
            }

            // Validate phone number
            if (!/^[\d\-\+\(\)\s]+$/.test(no_telp)) {
                e.preventDefault();
                alert('Format nomor telepon tidak valid');
                return false;
            }
        });

        // Auto-fill end date when start date changes
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            endDate.setFullYear(endDate.getFullYear() + 1);
            
            document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
        });

        // Search functionality
        function searchStudents() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.modern-table tbody');
            const rows = table.querySelectorAll('tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let found = false;
                
                // Search in NIP, Name, Mata Pelajaran columns
                for (let i = 2; i <= 4; i++) {
                    if (cells[i] && cells[i].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                
                if (found || filter === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // View teacher function
        function viewTeacher(id) {
            fetch(`../controller/guru_get.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const teacher = data.data;
                        document.getElementById('view_nama').textContent = teacher.nama;
                        document.getElementById('view_nip').textContent = teacher.nip;
                        document.getElementById('view_mata_pelajaran').textContent = teacher.mata_pelajaran || 'Belum ditentukan';
                        document.getElementById('view_jenis_kelamin').textContent = teacher.jenis_kelamin || '-';
                        document.getElementById('view_no_telp').textContent = teacher.no_telp || '-';
                        document.getElementById('view_lokasi').textContent = teacher.lokasi || '-';
                        
                        let fotoSrc = 'images/default-avatar-proper.png';
                        if (teacher.foto && teacher.foto !== 'default-avatar.png' && teacher.foto.trim() !== '') {
                            fotoSrc = `images/guru/${teacher.foto}`;
                        }
                        document.getElementById('view_foto').src = fotoSrc;
                        
                        const modal = new bootstrap.Modal(document.getElementById('viewTeacherModal'));
                        modal.show();
                    } else {
                        alert('Gagal mengambil data guru!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data guru!');
                });
        }

        // Edit teacher function
        function editTeacher(id) {
            fetch(`../controller/guru_get.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const teacher = data.data;
                        document.getElementById('edit_id').value = teacher.id;
                        document.getElementById('edit_nama').value = teacher.nama;
                        document.getElementById('edit_nip').value = teacher.nip;
                        document.getElementById('edit_mata_pelajaran').value = teacher.mata_pelajaran;
                        document.getElementById('edit_no_telp').value = teacher.no_telp;
                        document.getElementById('edit_jenis_kelamin').value = teacher.jenis_kelamin;
                        document.getElementById('edit_lokasi').value = teacher.lokasi;
                        
                        const modal = new bootstrap.Modal(document.getElementById('editTeacherModal'));
                        modal.show();
                    } else {
                        alert('Gagal mengambil data guru!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data guru!');
                });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    </script>
</body>

</html>
