<?php
include '../include/koneksi.php';

$nik = $_POST['nik'];
$tanggal = date('Y-m-d');
$pulang = date('Y-m-d H:i:s');
$cek =mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nik from karyawan where nik ='$nik'"));

if ($cek==1){
	
$cekdata ="select * from absensi where nik ='$nik' AND tanggal ='$tanggal' ";
$ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($ada)>0)
{ 

$sql = "UPDATE absensi set pulang='$pulang' WHERE nik='$nik' AND tanggal='$tanggal'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../suksesp?nik='.$nik.'');
	} else { echo "Data belum dapat di simpan!!"; 
	}

} else {
	
$sql = "INSERT INTO absensi (nik, tanggal, pulang) VALUES ('$nik','$tanggal','$pulang'";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../suksesp?nik='.$nik.'');
	} else { echo "Data belum dapat di simpan!!"; 
	}
}

} else {
header('location:../pulang?gagal='.base64_encode('Maaf No NIK tidak ditemukan'));

}

?>