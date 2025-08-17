<?php
include '../koneksi/koneksi.php';

$hp = $_POST['no_hp'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_nota = $_POST['nota'];
$kilogram = $_POST['kilogram'];
$total = $_POST['total'];
$tgl_masuk = $_POST['tgl_masuk'];
$tgl_selesai = $_POST['tgl_selesai'];

$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from pelanggan where no_hp='$hp'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek==0){
$s_p =mysqli_query($GLOBALS["___mysqli_ston"], "INSERT into pelanggan (no_hp,nama,alamat) VALUES('$hp','$nama','$alamat')");
$sql = "INSERT INTO orderan (no_hp, tgl_masuk, tgl_selesai, no_nota, kilogram, total) VALUES ('$hp','$tgl_masuk','$tgl_selesai','$no_nota','$kilogram','$total')";
$proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	if ($proses) {
		header('location:../laundry_in?sukses='.base64_encode('data laundry telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}
} else {
	
$sql1 = "INSERT INTO orderan (no_hp, tgl_masuk, tgl_selesai, no_nota, kilogram, total) VALUES ('$hp','$tgl_masuk','$tgl_selesai','$no_nota','$kilogram','$total')";
$proses1 = mysqli_query($GLOBALS["___mysqli_ston"], $sql1);
	if ($proses1) {
		header('location:../laundry_in?sukses='.base64_encode('data laundry telah tersimpan, Terimakasih'));
	} else { echo "Data belum dapat di simpan!!"; 
	}	
}
?>