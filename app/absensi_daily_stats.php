<?php
include '../include/koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    http_response_code(401);
    exit('Unauthorized');
}

// Get parameters
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selected_class = isset($_GET['kelas']) ? $_GET['kelas'] : '';

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selected_date)) {
    $selected_date = date('Y-m-d');
}

// Build class filter
$class_filter = '';
if ($selected_class) {
    $class_filter = " AND k.job_title = '$selected_class'";
}

// Calculate daily statistics
$total_students_query = "SELECT COUNT(*) as total FROM karyawan k WHERE 1=1 $class_filter";
$total_students_result = mysqli_query($GLOBALS["___mysqli_ston"], $total_students_query);
$total_students = mysqli_fetch_array($total_students_result)['total'];

$total_hadir = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
    "SELECT * FROM karyawan k 
     LEFT JOIN absensi a ON k.nik = a.nik 
     WHERE a.tanggal = '$selected_date' AND a.masuk IS NOT NULL AND a.ijin IS NULL AND a.status_tidak_masuk IS NULL $class_filter"));

$total_tidak_hadir = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
    "SELECT * FROM karyawan k 
     LEFT JOIN absensi a ON k.nik = a.nik 
     WHERE a.tanggal = '$selected_date' AND (a.ijin IS NOT NULL OR a.status_tidak_masuk IS NOT NULL) $class_filter"));

// Handle case where there's no attendance data yet
if ($total_hadir == 0 && $total_tidak_hadir == 0) {
    $total_tidak_hadir = $total_students; // All students are considered not present if no data
}

$persentase = $total_students > 0 ? round(($total_hadir / $total_students) * 100, 1) : 0;

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'total_hadir' => $total_hadir,
    'total_tidak_hadir' => $total_tidak_hadir,
    'total_students' => $total_students,
    'persentase' => $persentase
]);
?>
