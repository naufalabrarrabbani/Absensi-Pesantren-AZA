<?php
include '../../include/koneksi.php';
session_start();
error_reporting(0);

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../../login.php');
    exit();
}

// Check if POST data exists
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Method tidak diizinkan'));
    exit();
}

// Get form data
$id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
$kode_mapel = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], strtoupper(trim($_POST['kode_mapel'])));
$nama_mapel = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], trim($_POST['nama_mapel']));

// Validate required fields
if (empty($id) || empty($kode_mapel) || empty($nama_mapel)) {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Semua field wajib diisi'));
    exit();
}

// Check if mata pelajaran exists
$check_exists = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id = '$id'");
if (mysqli_num_rows($check_exists) == 0) {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Data mata pelajaran tidak ditemukan'));
    exit();
}

// Check if kode already exists (exclude current record)
$check_kode = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE kode_mapel = '$kode_mapel' AND id != '$id'");
if (mysqli_num_rows($check_kode) > 0) {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Kode mata pelajaran sudah digunakan'));
    exit();
}

// Update mata pelajaran
$query = "UPDATE mata_pelajaran SET kode_mapel = '$kode_mapel', nama_mapel = '$nama_mapel' WHERE id = '$id'";

if (mysqli_query($GLOBALS["___mysqli_ston"], $query)) {
    header('location:../mata_pelajaran_modern.php?success=' . base64_encode('Mata pelajaran berhasil diupdate'));
} else {
    header('location:../mata_pelajaran_modern.php?error=' . base64_encode('Gagal mengupdate mata pelajaran: ' . mysqli_error($GLOBALS["___mysqli_ston"])));
}

exit();
?>
