<?php
include '../include/koneksi.php';

$id = $_GET['id'];
$sql = "delete from area where id = '$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../area?hapus='.base64_encode('data area telah dihapus'));
	} else { echo "Data belum dapat di hapus!!"; 
	}
?>