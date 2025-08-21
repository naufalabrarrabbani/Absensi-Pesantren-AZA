<?php
include '../include/koneksi.php';

$nip = $_POST['nip'];
$tanggal = date('Y-m-d');
$jam = date('Y-m-d H:i:s');

// Cek apakah NIP guru ada
$cek_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE nip='$nip'");
if(mysqli_num_rows($cek_guru) == 0) {
    header('location:../pulang_guru?status=gagal&pesan='.base64_encode('NIP Guru tidak terdaftar!'));
    exit();
}

$data_guru = mysqli_fetch_array($cek_guru);

// Cek apakah sudah ada record absensi hari ini
$cek_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM absensi_guru WHERE nip='$nip' AND tanggal='$tanggal'");

if(mysqli_num_rows($cek_absen) > 0) {
    $data_absen = mysqli_fetch_array($cek_absen);
    
    // Cek apakah sudah absen masuk
    if($data_absen['masuk'] == null) {
        header('location:../pulang_guru?status=gagal&pesan='.base64_encode('Anda belum melakukan absen masuk hari ini!').'&nama='.base64_encode($data_guru['nama']));
        exit();
    }
    
    // Cek apakah sudah absen pulang
    if($data_absen['pulang'] != null) {
        header('location:../pulang_guru?status=sudah&pesan='.base64_encode('Anda sudah melakukan absen pulang hari ini pada pukul '.date('H:i', strtotime($data_absen['pulang']))).'&nama='.base64_encode($data_guru['nama']));
        exit();
    }
    
    // Update jam pulang
    $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE absensi_guru SET pulang='$jam' WHERE nip='$nip' AND tanggal='$tanggal'");
    if($update) {
        header('location:../pulang_guru?status=berhasil&pesan='.base64_encode('Absen pulang berhasil!').'&nama='.base64_encode($data_guru['nama']));
    } else {
        header('location:../pulang_guru?status=gagal&pesan='.base64_encode('Gagal melakukan absen pulang!'));
    }
} else {
    // Belum ada record absensi sama sekali
    header('location:../pulang_guru?status=gagal&pesan='.base64_encode('Anda belum melakukan absen masuk hari ini!').'&nama='.base64_encode($data_guru['nama']));
}
?>
