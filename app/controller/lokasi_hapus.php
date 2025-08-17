<?php
include '../include/koneksi.php';

$id = $_GET['id'];
$sql = "delete from lokasi where id = '$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../lokasi?hapus='.base64_encode('data lokasi telah dihapus'));
	} else { echo "Data belum dapat di hapus!!"; 
	}
?>