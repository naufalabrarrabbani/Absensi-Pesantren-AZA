<?php
include '../include/koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
    
    // Get guru data first to delete photo
    $query = "SELECT foto FROM guru WHERE id = '$id'";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    $guru = mysqli_fetch_assoc($result);
    
    if ($guru) {
        // Delete photo file if exists
        if ($guru['foto'] && file_exists('../app/images/guru/' . $guru['foto'])) {
            unlink('../app/images/guru/' . $guru['foto']);
        }
        
        // Delete from database
        $delete_query = "DELETE FROM guru WHERE id = '$id'";
        if (mysqli_query($GLOBALS["___mysqli_ston"], $delete_query)) {
            header('Location: ../app/guru_modern.php?pesan=delete_berhasil');
        } else {
            header('Location: ../app/guru_modern.php?pesan=delete_gagal');
        }
    } else {
        header('Location: ../app/guru_modern.php?pesan=data_not_found');
    }
} else {
    header('Location: ../app/guru_modern.php');
}
?>
