<?php
include '../include/koneksi.php';

$nik = $_POST['nik'];
$tanggal = date('Y-m-d');
$masuk = date('Y-m-d H:i:s');
$cek =mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nik from karyawan where nik ='$nik'"));

if ($cek==1){
	
$cekdata ="select * from absensi where nik ='$nik' AND tanggal ='$tanggal' ";
$ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($ada)>0)
{ 
header('location:../masuk?sukses='.base64_encode('Anda sudah absen hari ini'));
} else {
	
$sql = "INSERT INTO absensi (nik, tanggal, masuk) VALUES ('$nik','$tanggal','$masuk')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../sukses?nik='.$nik.'');
	} else { echo "Data belum dapat di simpan!!"; 
	}
}

} else {
header('location:../masuk?gagal='.base64_encode('Maaf No NIK tidak ditemukan'));

}

?>