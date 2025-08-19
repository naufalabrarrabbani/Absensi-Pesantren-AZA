<?php
include '../../include/koneksi.php';
session_start();
error_reporting(0);

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../../login');
    exit();
}

// Check if POST data exists
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../karyawan_modern.php?error=' . base64_encode('Method tidak diizinkan'));
    exit();
}

// Get form data
$nik = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nik']);
$nama = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama']);
$job_title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['job_title']);
$no_telp = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['no_telp']);
$jenis_kelamin = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jenis_kelamin']);
$agama = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['agama']);
$lokasi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lokasi']);
$nama_ayah = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama_ayah']);
$start_date = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['start_date']);
$end_date = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['end_date']);

// Validate required fields
if (empty($nik) || empty($nama) || empty($job_title)) {
    header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode('Data NISN, Nama, dan Kelas wajib diisi'));
    exit();
}

// Validate if student exists
$check_student = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan WHERE nik='$nik'");
if (mysqli_num_rows($check_student) == 0) {
    header('location:../karyawan_modern.php?error=' . base64_encode('Data siswa tidak ditemukan'));
    exit();
}

$current_data = mysqli_fetch_array($check_student);

// Handle file upload if exists
$foto_filename = $current_data['foto']; // Keep current photo by default

if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $upload_dir = "../images/";
    
    // Create directory if not exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validate file extension
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($file_ext, $allowed_extensions)) {
        header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode('Format file tidak didukung. Gunakan JPG, PNG, atau GIF'));
        exit();
    }
    
    // Validate file size (2MB max)
    if ($file_size > 2097152) {
        header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode('Ukuran file terlalu besar. Maksimal 2MB'));
        exit();
    }
    
    // Generate unique filename
    $foto_filename = $nik . '_' . time() . '.' . $file_ext;
    $target_file = $upload_dir . $foto_filename;
    
    // Move uploaded file
    if (move_uploaded_file($file_tmp, $target_file)) {
        // Delete old photo if exists and different from new one
        if (!empty($current_data['foto']) && $current_data['foto'] != $foto_filename && file_exists($upload_dir . $current_data['foto'])) {
            unlink($upload_dir . $current_data['foto']);
        }
    } else {
        header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode('Gagal mengupload foto'));
        exit();
    }
}

// Update student data
$update_query = "UPDATE karyawan SET 
    nama = '$nama',
    job_title = '$job_title',
    no_telp = '$no_telp',
    jenis_kelamin = '$jenis_kelamin',
    agama = '$agama',
    lokasi = '$lokasi',
    nama_ayah = '$nama_ayah',
    start_date = '$start_date',
    end_date = '$end_date',
    foto = '$foto_filename'
    WHERE nik = '$nik'";

if (mysqli_query($GLOBALS["___mysqli_ston"], $update_query)) {
    header('location:../karyawan_modern.php?success=' . base64_encode('Data siswa berhasil diupdate'));
} else {
    header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode('Gagal mengupdate data siswa: ' . mysqli_error($GLOBALS["___mysqli_ston"])));
}
exit();
?>
