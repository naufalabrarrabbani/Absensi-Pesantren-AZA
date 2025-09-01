<?php
include '../../include/koneksi.php';

$id = $_GET['id'];

// Get student info before deleting for better feedback
$student_info = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama, foto FROM karyawan WHERE id = '$id'"));

$sql = "DELETE FROM karyawan WHERE id = '$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);

if ($proses) {
    // Delete photo file if exists
    if ($student_info && $student_info['foto'] && file_exists("../images/" . $student_info['foto'])) {
        unlink("../images/" . $student_info['foto']);
    }
    
    $success_message = 'Siswa ' . ($student_info['nama'] ?? '') . ' berhasil dihapus';
    header('location:../karyawan_modern.php?success=' . base64_encode($success_message));
} else { 
    header('location:../karyawan_modern.php?error=' . base64_encode('Data siswa gagal dihapus. Silakan coba lagi'));
}
?>