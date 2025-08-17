<?php

session_start();
include '../include/koneksi.php';

$nik = $_POST['nik'];
$tanggal = $_POST['tanggal'];
$masuk =$tanggal.' '.$_POST['masuk'];
$pulang =$tanggal.' '.$_POST['pulang'];
$tw = date('Y-m-d H:i:s');
// var_dump($masuk);exit;
if(strlen($masuk)>16){
    $masuk = $_POST['masuk'];
    

    
}

if(strlen($pulang)>16){
    $pulang = $_POST['pulang'];
    
}

$s_p ="UPDATE absensi set masuk='$masuk', pulang='$pulang', update_by='$_SESSION[id]', tw='$tw' WHERE nik='$nik' AND tanggal='$tanggal'";


$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
	if ($proses) {
	    //var_dump($proses);exit;
		header('location:../absensi?start_date='.$_GET[start_date].'&end_date='.$_GET[end_date].'&area='.$_GET[area].'&sukses='.base64_encode('data absen NIK '.$nik.', tanggal '.$tanggal.' telah diedit, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
 

?>