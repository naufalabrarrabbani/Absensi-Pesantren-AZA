<?php
include '../include/koneksi.php';

$id = $_GET['id'];
$sql = "delete from jobtitle where id = '$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../job_title?hapus='.base64_encode('data jobtitle telah dihapus'));
	} else { echo "Data belum dapat di hapus!!"; 
	}
?>