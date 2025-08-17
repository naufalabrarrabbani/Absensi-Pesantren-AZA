<?php
include '../include/koneksi.php';

$nama_aplikasi = $_POST['nama_aplikasi'];
$nama_perusahaan = $_POST['nama_perusahaan'];
$id =$_POST['id'];
$alamat =$_POST['alamat'];

$photo =  "file_".date("YmdHis").".". basename( $_FILES['file']['name']); //ubah nama file
$target = "../images/$photo"; //Tempat file

//This code writes the photo to the server//
//--------------------------------Photo 1----------------------------
 move_uploaded_file($_FILES['file']['tmp_name'], $target);
//identitas file asli


$s_p ="UPDATE aplikasi set nama_aplikasi='$nama_aplikasi', nama_perusahaan='$nama_perusahaan', logo='$photo',alamat='$alamat' WHERE id='$id'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../setting?sukses='.base64_encode('data jobtitle dengan kode '.$kode_jobtitle.' telah diedit, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
 

?>