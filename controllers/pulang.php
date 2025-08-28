<?php
include '../include/koneksi.php';

$nik = $_POST['nik'];
$tanggal = date('Y-m-d');
$pulang = date('Y-m-d H:i:s');
$cek = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nik from karyawan where nik ='$nik'"));

if ($cek == 1) {
    // Ambil data siswa
    $data_siswa = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan WHERE nik='$nik'"));
    
    $cekdata = "select * from absensi where nik ='$nik' AND tanggal ='$tanggal' ";
    $ada = mysqli_query($GLOBALS["___mysqli_ston"], $cekdata) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    
    if(mysqli_num_rows($ada) > 0) { 
        $data_absen = mysqli_fetch_array($ada);
        
        // Cek apakah sudah absen masuk
        if($data_absen['masuk'] == null) {
            header('location:../pulang.php?status=gagal&pesan='.base64_encode('Anda belum melakukan absen masuk hari ini!').'&nama='.base64_encode($data_siswa['nama']));
            exit();
        }
        
        // Cek apakah sudah absen pulang
        if($data_absen['pulang'] != null && $data_absen['pulang'] != '0') {
            header('location:../pulang.php?status=sudah&pesan='.base64_encode('Anda sudah melakukan absen pulang hari ini pada pukul '.date('H:i', strtotime($data_absen['pulang']))).'&nama='.base64_encode($data_siswa['nama']));
            exit();
        }

        $sql = "UPDATE absensi set pulang='$pulang' WHERE nik='$nik' AND tanggal='$tanggal'";
        $proses = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
        
        if ($proses) {
            header('location:../pulang.php?status=berhasil&pesan='.base64_encode('Absen pulang berhasil!').'&nama='.base64_encode($data_siswa['nama']));
        } else { 
            header('location:../pulang.php?status=gagal&pesan='.base64_encode('Gagal melakukan absen pulang!'));
        }
    } else {
        header('location:../pulang.php?status=gagal&pesan='.base64_encode('Anda belum melakukan absen masuk hari ini!').'&nama='.base64_encode($data_siswa['nama']));
    }
} else {
    header('location:../pulang.php?status=gagal&pesan='.base64_encode('NIK tidak ditemukan!'));
}
?>