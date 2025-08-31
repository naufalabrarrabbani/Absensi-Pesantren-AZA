<?php
include '../include/koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    http_response_code(401);
    exit('Unauthorized');
}

// Get date parameter
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selected_date)) {
    $selected_date = date('Y-m-d');
}

// Calculate daily statistics
$total_guru = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru"));

$total_hadir = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
    "SELECT * FROM absensi_guru WHERE tanggal = '$selected_date' AND masuk IS NOT NULL AND ijin IS NULL AND status_tidak_masuk IS NULL"));

$total_tidak_hadir = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
    "SELECT * FROM absensi_guru WHERE tanggal = '$selected_date' AND (ijin IS NOT NULL OR status_tidak_masuk IS NOT NULL)"));

// Handle case where there's no attendance data yet
if ($total_hadir == 0 && $total_tidak_hadir == 0) {
    $total_tidak_hadir = $total_guru; // All teachers are considered not present if no data
}

$persentase = $total_guru > 0 ? round(($total_hadir / $total_guru) * 100, 1) : 0;

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'total_hadir' => $total_hadir,
    'total_tidak_hadir' => $total_tidak_hadir,
    'total_guru' => $total_guru,
    'persentase' => $persentase
]);
?>
