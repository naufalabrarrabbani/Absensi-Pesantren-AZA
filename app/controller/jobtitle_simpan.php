<?php
include '../include/koneksi.php';

$kode_jobtitle = $_POST['kode_jobtitle'];
$jobtitle = $_POST['jobtitle'];

$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from jobtitle where kode_jobtitle='$kode_jobtitle'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek==0){
$s_p ="INSERT into jobtitle (kode_jobtitle, jobtitle)VALUES('$kode_jobtitle','$jobtitle')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../job_title?sukses='.base64_encode('data job_title dengan kode '.$kode_jobtitle.' telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
} else {
	
		header('location:../job_title?error='.base64_encode('data job_title dengan kode '.$kode_jobtitle.' sebelumnya sudah ada, Terimakasih'));
	} 

?>