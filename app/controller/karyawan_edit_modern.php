<?php
include '../../include/koneksi.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Debug: Log POST data
error_log("POST data: " . print_r($_POST, true));

// Get form data
$nik = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nik']);
$nama = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama']);
$job_title = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['job_title']);
$jenis_kelamin = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jenis_kelamin']);
$start_date = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['start_date']);
$end_date = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['end_date']);

// Debug: Log processed data
error_log("Processed data - NIK: $nik, Nama: $nama, Job Title: $job_title");

// Validate required fields
if (empty($nik) || empty($nama) || empty($job_title)) {
    $error_msg = "Data NISN: '$nik', Nama: '$nama', Kelas: '$job_title' - ada yang kosong";
    error_log("Validation error: " . $error_msg);
    header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode($error_msg));
    exit();
}

// Validate if student exists
$check_student = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan WHERE nik='$nik'");
if (mysqli_num_rows($check_student) == 0) {
    error_log("Student not found: " . $nik);
    header('location:../karyawan_modern.php?error=' . base64_encode('Data siswa tidak ditemukan'));
    exit();
}

$current_data = mysqli_fetch_array($check_student);
error_log("Current data found: " . print_r($current_data, true));

// Handle file upload if exists
$foto_filename = $current_data['foto']; // Keep current photo by default

if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    error_log("File upload detected");
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
    $foto_filename = 'student_' . $nik . '_' . time() . '.' . $file_ext;
    $target_file = $upload_dir . $foto_filename;
    
    // Move uploaded file
    if (move_uploaded_file($file_tmp, $target_file)) {
        error_log("File uploaded successfully: " . $foto_filename);
        // Delete old photo if exists and different from new one
        if (!empty($current_data['foto']) && $current_data['foto'] != $foto_filename && file_exists($upload_dir . $current_data['foto'])) {
            unlink($upload_dir . $current_data['foto']);
        }
    } else {
        error_log("File upload failed");
        header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode('Gagal mengupload foto'));
        exit();
    }
}

// Update student data
$update_query = "UPDATE karyawan SET 
    nama = '$nama',
    job_title = '$job_title',
    jenis_kelamin = '$jenis_kelamin',
    start_date = '$start_date',
    end_date = '$end_date',
    foto = '$foto_filename'
    WHERE nik = '$nik'";

error_log("Update query: " . $update_query);

if (mysqli_query($GLOBALS["___mysqli_ston"], $update_query)) {
    error_log("Update successful for NIK: " . $nik);
    header('location:../karyawan_modern.php?success=' . base64_encode('Data siswa berhasil diupdate'));
} else {
    $error = mysqli_error($GLOBALS["___mysqli_ston"]);
    error_log("Update failed: " . $error);
    header('location:../karyawan_edit_modern.php?id=' . $nik . '&error=' . base64_encode('Gagal mengupdate data siswa: ' . $error));
}
exit();
?>
