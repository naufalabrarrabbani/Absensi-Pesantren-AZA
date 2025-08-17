<?php
include '../include/koneksi.php';

$id_user = $_POST['id_user'];
$password = $_POST['password'];

$s_p ="UPDATE user set password='$password' WHERE id='$id_user'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../setting?sukses='.base64_encode('password telah diganti, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
 

?>