<?php
include '../../include/koneksi.php';
session_start();
error_reporting(0);

// Set header untuk JSON response
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    echo json_encode(['success' => false, 'message' => 'Session expired']);
    exit();
}

// Check if POST data exists
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
    exit();
}

// Get form data
$nip = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nip']);
$status = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['status']);
$tanggal = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tanggal']);

// Validate required fields
if (empty($nip) || empty($status) || empty($tanggal)) {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit();
}

// Validate status
$allowed_status = ['alpha', 'sakit', 'izin'];
if (!in_array($status, $allowed_status)) {
    echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
    exit();
}

// Validate if teacher exists
$check_teacher = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE nip='$nip'");
if (mysqli_num_rows($check_teacher) == 0) {
    echo json_encode(['success' => false, 'message' => 'Data guru tidak ditemukan']);
    exit();
}

// Check if attendance record already exists for this date
$check_attendance = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM absensi_guru WHERE nip='$nip' AND tanggal='$tanggal'");

if (mysqli_num_rows($check_attendance) > 0) {
    // Update existing record
    $update_query = "UPDATE absensi_guru SET status_tidak_masuk = '$status' WHERE nip = '$nip' AND tanggal = '$tanggal'";
    
    if (mysqli_query($GLOBALS["___mysqli_ston"], $update_query)) {
        echo json_encode(['success' => true, 'message' => 'Status ketidakhadiran berhasil diupdate']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengupdate status: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
    }
} else {
    // Insert new record for absent teacher
    $insert_query = "INSERT INTO absensi_guru (nip, tanggal, status_tidak_masuk) VALUES ('$nip', '$tanggal', '$status')";
    
    if (mysqli_query($GLOBALS["___mysqli_ston"], $insert_query)) {
        echo json_encode(['success' => true, 'message' => 'Status ketidakhadiran berhasil disimpan']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan status: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
    }
}
?>
