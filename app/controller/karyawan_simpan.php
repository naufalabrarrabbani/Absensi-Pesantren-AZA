<?php
include '../include/koneksi.php';

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$job_title = $_POST['job_title'];
$no_telp = $_POST['no_telp'];
$nama_ayah = $_POST['nama_ayah'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$agama = $_POST['agama'];
$lokasi = $_POST['lokasi'];
$area = $_POST['area'];
$sub_area = $_POST['sub_area'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$photo =  "file_".date("YmdHis").".". basename( $_FILES['file']['name']); //ubah nama file
$target = "../images/$photo"; //Tempat file

//This code writes the photo to the server//
//--------------------------------Photo 1----------------------------
 move_uploaded_file($_FILES['file']['tmp_name'], $target);
//identitas file asli


$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where nik='$nik'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek==0){
$s_p ="INSERT into karyawan (nik,nama, job_title,no_telp, nama_ayah, jenis_kelamin, agama, lokasi, area, sub_area, start_date, end_date,foto) VALUES('$nik','$nama','$job_title','$no_telp', '$nama_ayah', '$jenis_kelamin','$agama','$lokasi', '$area','$sub_area','$start_date','$end_date', '$photo')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
		header('location:../karyawan?sukses='.base64_encode('data karyawan dengan nik '.$nik.' telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
} else {
	
		header('location:../karyawan?error='.base64_encode('data karyawan dengan nik '.$nik.' sebelumnya sudah ada, Terimakasih'));
	} 

?>