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

// Get student data
$nik = isset($_GET['id']) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']) : '';
if (empty($nik)) {
    header('location:karyawan_modern.php?error=' . base64_encode('ID siswa tidak valid'));
    exit();
}

$detail = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where nik='$nik'"));
if (!$detail) {
    header('location:karyawan_modern.php?error=' . base64_encode('Data siswa tidak ditemukan'));
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

        .btn-modern {
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            background: #6c757d;
            color: white;
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
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

        .file-upload-area {
            border: 2px dashed #E0E0E0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .file-upload-area:hover {
            border-color: #4640DE;
            background: rgba(70, 64, 222, 0.02);
        }

        .file-upload-area.dragover {
            border-color: #4640DE;
            background: rgba(70, 64, 222, 0.05);
        }

        .current-photo {
            max-width: 150px;
            max-height: 150px;
            border-radius: 12px;
            margin-bottom: 15px;
            border: 3px solid #f0f0f0;
        }

        .breadcrumb-modern {
            background: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-modern .breadcrumb-item {
            color: #ABB3C4;
            font-size: 14px;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: #4640DE;
            font-weight: 500;
        }

        .breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: #ABB3C4;
        }
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Edit Siswa</title>
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
                        <h2 class="nav-title">Edit Siswa</h2>
                    </div>
                    <button class="btn-notif d-block d-md-none">
                        <i class="fas fa-bell"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center nav-input-container">
                    <div class="nav-input-group">
                        <input type="text" class="nav-input" placeholder="Search...">
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
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-modern">
                        <li class="breadcrumb-item"><a href="karyawan_modern.php">Data Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Siswa</li>
                    </ol>
                </nav>

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
                                    <h3 class="content-title mb-0">
                                        <i class="fas fa-user-edit me-2"></i>
                                        Edit Data Siswa
                                    </h3>
                                    <p class="content-desc mb-0">Update data siswa <?= $detail['nama']; ?></p>
                                </div>
                                <a href="karyawan_modern.php" class="btn-modern secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>

                            <form action="controller/karyawan_edit_modern.php" method="POST" enctype="multipart/form-data" id="editStudentForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="nik" class="form-label-modern">
                                                <i class="fas fa-id-card me-1"></i>
                                                NISN
                                            </label>
                                            <input type="text" class="form-modern" id="nik" name="nik" value="<?= $detail['nik']; ?>" readonly style="background-color: #f8f9fa;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="nama" class="form-label-modern">
                                                <i class="fas fa-user me-1"></i>
                                                Nama Lengkap
                                            </label>
                                            <input type="text" class="form-modern" id="nama" name="nama" value="<?= $detail['nama']; ?>" placeholder="Masukkan nama lengkap" required>
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
                                                $jt = $detail['job_title'];
                                                $sql_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE status='aktif' ORDER BY tingkat ASC, kode_kelas ASC");
                                                while($d_kelas = mysqli_fetch_assoc($sql_kelas)){
                                                    if($jt == $d_kelas['kode_kelas']){
                                                        echo '<option value="'.$d_kelas['kode_kelas'].'" selected>'.$d_kelas['nama_kelas'].' ('.$d_kelas['kode_kelas'].')</option>';
                                                    } else{
                                                        echo '<option value="'.$d_kelas['kode_kelas'].'">'.$d_kelas['nama_kelas'].' ('.$d_kelas['kode_kelas'].')</option>';			
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="jenis_kelamin" class="form-label-modern">
                                                <i class="fas fa-venus-mars me-1"></i>
                                                Jenis Kelamin
                                            </label>
                                            <select class="form-modern" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-laki" <?= ($detail['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= ($detail['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                            </select>
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
                                            <input type="date" class="form-modern" id="start_date" name="start_date" value="<?= $detail['start_date']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="end_date" class="form-label-modern">
                                                <i class="fas fa-calendar-check me-1"></i>
                                                Tanggal Selesai
                                            </label>
                                            <input type="date" class="form-modern" id="end_date" name="end_date" value="<?= $detail['end_date']; ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-modern">
                                    <label for="file" class="form-label-modern">
                                        <i class="fas fa-camera me-1"></i>
                                        Foto Siswa
                                    </label>
                                    
                                    <?php if (!empty($detail['foto']) && file_exists("images/".$detail['foto'])): ?>
                                    <div class="text-center mb-3">
                                        <p class="mb-2" style="color: #ABB3C4; font-size: 14px;">Foto Saat Ini:</p>
                                        <img src="images/<?= $detail['foto']; ?>" alt="Current Photo" class="current-photo">
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="file-upload-area" onclick="document.getElementById('file').click()">
                                        <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #ABB3C4; margin-bottom: 10px;"></i>
                                        <p class="mb-0" style="color: #ABB3C4;">Klik untuk upload foto baru atau drag & drop</p>
                                        <p class="mb-0" style="color: #ABB3C4; font-size: 12px;">Format: JPG, PNG, GIF (Max: 2MB) - Opsional</p>
                                        <img id="filePreview" style="display: none; max-width: 100px; max-height: 100px; border-radius: 8px; margin-top: 10px;">
                                    </div>
                                    <input type="file" class="d-none" id="file" name="file" accept="image/*" onchange="previewFile()">
                                </div>

                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="karyawan_modern.php" class="btn-modern secondary">
                                        <i class="fas fa-times me-1"></i>
                                        Batal
                                    </a>
                                    <button type="submit" class="btn-modern success">
                                        <i class="fas fa-save me-1"></i>
                                        Update Siswa
                                    </button>
                                </div>
                            </form>
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
        document.getElementById('editStudentForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value;
            const job_title = document.getElementById('job_title').value;
            
            if (!nama || !job_title) {
                e.preventDefault();
                alert('Mohon lengkapi data Nama dan Kelas');
                return false;
            }
        });

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
