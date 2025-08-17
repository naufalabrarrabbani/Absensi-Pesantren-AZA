<?php
include '../include/koneksi.php';

$kode_subarea = $_POST['kode_subarea'];
$subarea = $_POST['subarea'];

$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from sub_area where kode_subarea='$kode_subarea'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek==0){
$s_p ="INSERT into sub_area (kode_subarea, subarea)VALUES('$kode_subarea','$subarea')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../subarea?sukses='.base64_encode('data sub area dengan kode '.$kode_subarea.' telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
} else {
	
		header('location:../subarea?error='.base64_encode('data sub area dengan kode '.$kode_subarea.' sebelumnya sudah ada, Terimakasih'));
	} 

?>