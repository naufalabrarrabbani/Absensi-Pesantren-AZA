<?php
include '../../include/koneksi.php';
session_start();

$nip = $_POST['nip'];
$nama = $_POST['nama'];
$mata_pelajaran = $_POST['mata_pelajaran'];
$no_telp = $_POST['no_telp'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$agama = $_POST['agama'];
$lokasi = $_POST['lokasi'];
$area = $_POST['area'];
$sub_area = $_POST['sub_area'];

// Upload foto
$target_dir = "../../images/guru/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["file"]["size"] > 500000) {
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $foto = "default-avatar.png";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $foto = basename($_FILES["file"]["name"]);
    } else {
        $foto = "default-avatar.png";
    }
}

// Cek apakah NIP sudah ada
$cek_nip = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE nip='$nip'");
if(mysqli_num_rows($cek_nip) > 0) {
    header('location:../guru?error='.base64_encode('NIP sudah terdaftar'));
    exit();
}

// Insert data guru
$sql = "INSERT INTO guru (nip, nama, mata_pelajaran, no_telp, jenis_kelamin, agama, lokasi, area, sub_area, foto, start_date) 
        VALUES ('$nip', '$nama', '$mata_pelajaran', '$no_telp', '$jenis_kelamin', '$agama', '$lokasi', '$area', '$sub_area', '$foto', NOW())";

if (mysqli_query($GLOBALS["___mysqli_ston"], $sql)) {
    header('location:../guru?sukses='.base64_encode('Data guru berhasil disimpan'));
} else {
    header('location:../guru?error='.base64_encode('Gagal menyimpan data guru'));
}
?>
