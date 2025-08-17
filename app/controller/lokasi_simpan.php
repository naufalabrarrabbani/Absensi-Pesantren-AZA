<?php
include '../include/koneksi.php';

$kode = $_POST['kode'];
$lokasi = $_POST['lokasi'];

$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from lokasi where kode='$kode'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek==0){
$s_p ="INSERT into lokasi (kode, lokasi)VALUES('$kode','$lokasi')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../lokasi?sukses='.base64_encode('data lokasi dengan kode '.$kode.' telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
} else {
	
		header('location:../lokasi?error='.base64_encode('data lokasi dengan kode '.$kode.' sebelumnya sudah ada, Terimakasih'));
	} 

?>