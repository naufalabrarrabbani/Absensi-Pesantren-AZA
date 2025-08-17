<?php
include '../include/koneksi.php';

$id_jobtitle = $_POST['id_jobtitle'];
$kode_jobtitle = $_POST['kode_jobtitle'];
$jobtitle =$_POST['jobtitle'];

$s_p ="UPDATE jobtitle set kode_jobtitle='$kode_jobtitle', jobtitle='$jobtitle' WHERE id='$id_jobtitle'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../job_title?sukses='.base64_encode('data jobtitle dengan kode '.$kode_jobtitle.' telah diedit, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
 

?>