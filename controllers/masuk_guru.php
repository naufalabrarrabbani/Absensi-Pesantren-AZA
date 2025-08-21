<?php
include '../include/koneksi.php';

$nip = $_POST['nip'];
$tanggal = date('Y-m-d');
$jam = date('Y-m-d H:i:s');

// Cek apakah NIP guru ada
$cek_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE nip='$nip'");
if(mysqli_num_rows($cek_guru) == 0) {
    header('location:../masuk_guru?status=gagal&pesan='.base64_encode('NIP Guru tidak terdaftar!'));
    exit();
}

$data_guru = mysqli_fetch_array($cek_guru);

// Cek apakah sudah absen masuk hari ini
$cek_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM absensi_guru WHERE nip='$nip' AND tanggal='$tanggal'");

if(mysqli_num_rows($cek_absen) > 0) {
    // Sudah ada record absensi hari ini
    $data_absen = mysqli_fetch_array($cek_absen);
    
    if($data_absen['masuk'] != null) {
        // Sudah absen masuk
        header('location:../masuk_guru?status=sudah&pesan='.base64_encode('Anda sudah melakukan absen masuk hari ini pada pukul '.date('H:i', strtotime($data_absen['masuk']))).'&nama='.base64_encode($data_guru['nama']));
    } else {
        // Update jam masuk
        $update = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE absensi_guru SET masuk='$jam' WHERE nip='$nip' AND tanggal='$tanggal'");
        if($update) {
            header('location:../masuk_guru?status=berhasil&pesan='.base64_encode('Absen masuk berhasil!').'&nama='.base64_encode($data_guru['nama']));
        } else {
            header('location:../masuk_guru?status=gagal&pesan='.base64_encode('Gagal melakukan absen masuk!'));
        }
    }
} else {
    // Belum ada record absensi, insert baru
    $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO absensi_guru (nip, tanggal, masuk) VALUES ('$nip', '$tanggal', '$jam')");
    
    if($insert) {
        header('location:../masuk_guru?status=berhasil&pesan='.base64_encode('Absen masuk berhasil!').'&nama='.base64_encode($data_guru['nama']));
    } else {
        header('location:../masuk_guru?status=gagal&pesan='.base64_encode('Gagal melakukan absen masuk!'));
    }
}
?>
