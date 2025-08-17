<?php
include '../include/koneksi.php';

$id_area = $_POST['id_area'];
$kode_area = $_POST['kode_area'];
$area =$_POST['area'];

$s_p ="UPDATE area set kode_area='$kode_area', area='$area' WHERE id='$id_area'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../area?sukses='.base64_encode('data area dengan kode '.$kode_area.' telah diedit, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
 

?>