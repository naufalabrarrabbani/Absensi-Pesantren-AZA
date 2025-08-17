<?php
include '../include/koneksi.php';

$username = $_POST['username'];
$nama = $_POST['nama'];
$password = $_POST['password'];
$area = $_POST['area'];
$level = $_POST['level'];

$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from user where username='$username'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek==0){
$s_p ="INSERT into user (username, nama, password, area, level)VALUES('$username','$nama','$password','$area','$level')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../setting?sukses='.base64_encode('data user  telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
} else {
	
		header('location:../setting?error='.base64_encode('data user dengan kode '.$username.' sebelumnya sudah ada, Terimakasih'));
	} 

?>