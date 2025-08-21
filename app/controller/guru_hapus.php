<?php
include '../../include/koneksi.php';
session_start();

$id = $_GET['id'];

// Get photo filename before deleting
$get_foto = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT foto FROM guru WHERE id='$id'");
$data_foto = mysqli_fetch_array($get_foto);
$foto = $data_foto['foto'];

// Delete record
$sql = "DELETE FROM guru WHERE id='$id'";

if (mysqli_query($GLOBALS["___mysqli_ston"], $sql)) {
    // Delete photo file if not default
    if($foto != "default-avatar.png" && $foto != "") {
        $file_path = "../../images/guru/" . $foto;
        if(file_exists($file_path)) {
            unlink($file_path);
        }
    }
    header('location:../guru?sukses='.base64_encode('Data guru berhasil dihapus'));
} else {
    header('location:../guru?error='.base64_encode('Gagal menghapus data guru'));
}
?>
