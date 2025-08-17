<?php
include '../include/koneksi.php';

$kode_area = $_POST['kode_area'];
$area = $_POST['area'];

$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from area where kode_area='$kode_area'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek==0){
$s_p ="INSERT into area (kode_area, area)VALUES('$kode_area','$area')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../area?sukses='.base64_encode('data area dengan kode '.$kode_area.' telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
} else {
	
		header('location:../area?error='.base64_encode('data area dengan kode '.$kode_area.' sebelumnya sudah ada, Terimakasih'));
	} 

?>