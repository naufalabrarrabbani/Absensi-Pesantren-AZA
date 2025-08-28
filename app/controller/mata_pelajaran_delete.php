<?php
include '../../include/koneksi.php';
session_start();
error_reporting(0);

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../../login.php');
    exit();
}

// Check if GET data exists
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('ID mata pelajaran tidak valid'));
    exit();
}

$id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);

// Check if mata pelajaran exists
$check_exists = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id = '$id'");
if (mysqli_num_rows($check_exists) == 0) {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Data mata pelajaran tidak ditemukan'));
    exit();
}

$mapel_data = mysqli_fetch_array($check_exists);

// Check if mata pelajaran is being used by guru
$check_usage = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) as count FROM guru WHERE mata_pelajaran = '" . $mapel_data['nama_mapel'] . "'");
$usage_data = mysqli_fetch_array($check_usage);

if ($usage_data['count'] > 0) {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Mata pelajaran tidak dapat dihapus karena masih digunakan oleh ' . $usage_data['count'] . ' guru'));
    exit();
}

// Delete mata pelajaran
$query = "DELETE FROM mata_pelajaran WHERE id = '$id'";

if (mysqli_query($GLOBALS["___mysqli_ston"], $query)) {
    header('location:../mata_pelajaran_modern.php?success=' . base64_encode('Mata pelajaran berhasil dihapus'));
} else {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Gagal menghapus mata pelajaran: ' . mysqli_error($GLOBALS["___mysqli_ston"])));
}

exit();
?>
