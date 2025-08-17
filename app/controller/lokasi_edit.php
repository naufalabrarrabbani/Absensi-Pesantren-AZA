<?php
include '../include/koneksi.php';

$id = $_POST['id'];
$kode = $_POST['kode'];
$lokasi =$_POST['lokasi'];

$s_p ="UPDATE lokasi set kode='$kode', lokasi='$lokasi' WHERE id='$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../lokasi?sukses='.base64_encode('data lokasi dengan kode '.$kode.' telah diedit, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
 

?>