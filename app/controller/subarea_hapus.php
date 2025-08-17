<?php
include '../include/koneksi.php';

$id = $_GET['id'];
$sql = "delete from sub_area where id = '$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../subarea?hapus='.base64_encode('data subarea telah dihapus'));
	} else { echo "Data belum dapat di hapus!!"; 
	}
?>