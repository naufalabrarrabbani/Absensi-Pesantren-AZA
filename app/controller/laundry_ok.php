<?php
include "../include/smsGateway.php";
include "../koneksi/koneksi.php";
$id=$_GET['id'];
$d_order = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from orderan where id='$id'"));
$hp = $d_order['no_hp'];
$nota = $d_order['no_nota'];
$d_pelanggan = mysqli_fetch_assoc(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from pelanggan where no_hp='$hp'"));
$nama = $d_pelanggan['nama'];
$date = $d_order['tgl_selesai'];

$smsGateway = new SmsGateway('gendhislaundryku@gmail.com', 'gendhis321891');

$deviceID = 65730;
$number = ''.$hp.'';
$message = 'Yth '.$nama.', Cucian anda No.Nota '.$nota.' sdh selesai dan sdh bisa diambil '.$date.'  saran&kritik : 081252141441 [Gendhis Laundry]' ;

//Please note options is no required and can be left out
$result = $smsGateway->sendMessageToNumber($number, $message, $deviceID);
$sql = "UPDATE orderan set status ='1' where id = '$id' ";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../laundry_ok?edit='.base64_encode('SMS notifikasi telah terkirim, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}

?>