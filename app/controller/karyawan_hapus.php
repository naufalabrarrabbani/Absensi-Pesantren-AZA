<?php
include '../include/koneksi.php';

$id = $_GET['id'];
$sql = "delete from karyawan where id = '$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../karyawan?hapus='.base64_encode('data karyawan telah dihapus'));
	} else { echo "Data belum dapat di hapus!!"; 
	}
?>