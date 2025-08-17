<?php
include '../include/koneksi.php';

$id_subarea = $_POST['id_subarea'];
$kode_subarea = $_POST['kode_subarea'];
$subarea =$_POST['subarea'];

$s_p ="UPDATE sub_area set kode_subarea='$kode_subarea', subarea='$subarea' WHERE id='$id_subarea'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../subarea?sukses='.base64_encode('data subarea dengan kode '.$kode_subarea.' telah diedit, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
 

?>