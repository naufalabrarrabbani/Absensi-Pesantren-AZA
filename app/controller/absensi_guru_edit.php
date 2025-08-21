<?php
include '../../include/koneksi.php';
session_start();

$nip = $_POST['nip'];
$tanggal = $_POST['tanggal'];
$masuk = $_POST['masuk'];
$pulang = $_POST['pulang'];

// Format tanggal dan waktu
$masuk_full = $tanggal . ' ' . $masuk;
$pulang_full = $tanggal . ' ' . $pulang;

$sql = "UPDATE absensi_guru SET masuk='$masuk_full', pulang='$pulang_full', update_by='{$_SESSION['nama']}', tw=NOW() 
        WHERE nip='$nip' AND tanggal='$tanggal'";

if (mysqli_query($GLOBALS["___mysqli_ston"], $sql)) {
    $redirect_params = "start_date={$_GET['start_date']}&end_date={$_GET['end_date']}&area={$_GET['area']}";
    header("location:../absensi_guru?{$redirect_params}&sukses=".base64_encode('Absensi guru berhasil diupdate'));
} else {
    $redirect_params = "start_date={$_GET['start_date']}&end_date={$_GET['end_date']}&area={$_GET['area']}";
    header("location:../absensi_guru?{$redirect_params}&error=".base64_encode('Gagal mengupdate absensi guru'));
}
?>
