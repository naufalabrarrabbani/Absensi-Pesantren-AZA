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

// Query untuk data siswa
$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan");
$t_karyawan = mysqli_num_rows($s_karyawan);

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

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Data Siswa</title>
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

                <a href="karyawan_modern.php" class="sidebar-item active" onclick="toggleActive(this)">
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
                        <h2 class="nav-title">Data Siswa</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <div class="nav-input-group">
                        <input type="text" class="nav-input" placeholder="Search students..." id="searchInput" onkeyup="searchStudents()">
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
                                    <h3 class="content-title mb-0">Daftar Siswa</h3>
                                    <p class="content-desc mb-0">Kelola data siswa di sistem absensi</p>
                                </div>
                                <a href="#" class="btn-modern primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                    <i class="fas fa-plus"></i>
                                    Tambah Siswa
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="modern-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $students = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan ORDER BY nama ASC");
                                        while ($student = mysqli_fetch_array($students)) {
                                            $status = ($student['end_date'] > date('Y-m-d')) ? 'active' : 'inactive';
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <img src="images/<?= $student['foto'] ?: 'default-avatar.png'; ?>" 
                                                     alt="<?= $student['nama']; ?>" 
                                                     class="student-avatar"
                                                     onerror="this.src='images/default-avatar.png'">
                                            </td>
                                            <td><?= $student['nik']; ?></td>
                                            <td>
                                                <strong><?= $student['nama']; ?></strong>
                                                <br>
                                                <small class="text-muted"><?= $student['no_telp']; ?></small>
                                            </td>
                                            <td><?= $student['job_title']; ?></td>
                                            <td>
                                                <span class="status-badge <?= $status == 'active' ? 'status-active' : 'status-inactive'; ?>">
                                                    <?= $status == 'active' ? 'Aktif' : 'Tidak Aktif'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="karyawan_detail.php?id=<?= $student['id']; ?>" class="btn-modern primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="karyawan_edit_modern.php?id=<?= $student['nik']; ?>" class="btn-modern warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="karyawan_delete.php?id=<?= $student['id']; ?>" class="btn-modern danger" onclick="return confirm('Yakin ingin menghapus?')">
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
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-modern">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">
                        <i class="fas fa-user-plus me-2"></i>
                        Tambah Siswa Baru
                    </h5>
                    <button type="button" class="btn-close-modern" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="controller/karyawan_simpan.php" method="POST" enctype="multipart/form-data" id="addStudentForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="nik" class="form-label-modern">
                                        <i class="fas fa-id-card me-1"></i>
                                        NISN
                                    </label>
                                    <input type="text" class="form-modern" id="nik" name="nik" placeholder="Masukkan NISN" required>
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
                                    <label for="job_title" class="form-label-modern">
                                        <i class="fas fa-graduation-cap me-1"></i>
                                        Kelas
                                    </label>
                                    <select class="form-modern" id="job_title" name="job_title" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <?php
                                        $sql_jt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jobtitle");
                                        if(mysqli_num_rows($sql_jt) != 0){
                                            while($d_jt = mysqli_fetch_assoc($sql_jt)){
                                                echo '<option value="'.$d_jt['kode_jobtitle'].'">'.$d_jt['jobtitle'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="no_telp" class="form-label-modern">
                                        <i class="fas fa-phone me-1"></i>
                                        No. Telepon
                                    </label>
                                    <input type="text" class="form-modern" id="no_telp" name="no_telp" placeholder="Masukkan nomor telepon">
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
                                    <label for="agama" class="form-label-modern">
                                        <i class="fas fa-pray me-1"></i>
                                        Agama
                                    </label>
                                    <select class="form-modern" id="agama" name="agama" required>
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="lokasi" class="form-label-modern">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        Lokasi
                                    </label>
                                    <select class="form-modern" id="lokasi" name="lokasi" required>
                                        <?php
                                        $sql_l = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM lokasi");
                                        if(mysqli_num_rows($sql_l) != 0){
                                            while($d_l = mysqli_fetch_assoc($sql_l)){
                                                echo '<option value="'.$d_l['lokasi'].'">'.$d_l['lokasi'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="nama_ayah" class="form-label-modern">
                                        <i class="fas fa-male me-1"></i>
                                        Nama Ayah
                                    </label>
                                    <input type="text" class="form-modern" id="nama_ayah" name="nama_ayah" placeholder="Masukkan nama ayah">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="start_date" class="form-label-modern">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-modern" id="start_date" name="start_date" value="<?= date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-modern">
                                    <label for="end_date" class="form-label-modern">
                                        <i class="fas fa-calendar-check me-1"></i>
                                        Tanggal Selesai
                                    </label>
                                    <input type="date" class="form-modern" id="end_date" name="end_date" value="<?= date('Y-m-d', strtotime('+1 year')); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-modern">
                            <label for="file" class="form-label-modern">
                                <i class="fas fa-camera me-1"></i>
                                Foto Siswa
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
                            Simpan Siswa
                        </button>
                    </div>
                </form>
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
        document.getElementById('addStudentForm').addEventListener('submit', function(e) {
            const nik = document.getElementById('nik').value;
            const nama = document.getElementById('nama').value;
            const job_title = document.getElementById('job_title').value;
            
            if (!nik || !nama || !job_title) {
                e.preventDefault();
                alert('Mohon lengkapi data NISN, Nama, dan Kelas');
                return false;
            }
            
            // Validate NISN format (hanya angka)
            if (!/^\d+$/.test(nik)) {
                e.preventDefault();
                alert('NISN harus berupa angka');
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
                
                // Search in NIK, Name, Class columns
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
