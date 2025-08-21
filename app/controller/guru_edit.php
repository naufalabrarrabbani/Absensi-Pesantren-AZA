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

// Check if new file is uploaded
if($_FILES["file"]["name"] != "") {
    // Upload foto
    $target_dir = "../../images/guru/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
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
        $sql = "UPDATE guru SET nama='$nama', mata_pelajaran='$mata_pelajaran', no_telp='$no_telp', 
                jenis_kelamin='$jenis_kelamin', agama='$agama', lokasi='$lokasi', area='$area', sub_area='$sub_area' 
                WHERE nip='$nip'";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $foto = basename($_FILES["file"]["name"]);
            $sql = "UPDATE guru SET nama='$nama', mata_pelajaran='$mata_pelajaran', no_telp='$no_telp', 
                    jenis_kelamin='$jenis_kelamin', agama='$agama', lokasi='$lokasi', area='$area', sub_area='$sub_area', foto='$foto' 
                    WHERE nip='$nip'";
        } else {
            $sql = "UPDATE guru SET nama='$nama', mata_pelajaran='$mata_pelajaran', no_telp='$no_telp', 
                    jenis_kelamin='$jenis_kelamin', agama='$agama', lokasi='$lokasi', area='$area', sub_area='$sub_area' 
                    WHERE nip='$nip'";
        }
    }
} else {
    $sql = "UPDATE guru SET nama='$nama', mata_pelajaran='$mata_pelajaran', no_telp='$no_telp', 
            jenis_kelamin='$jenis_kelamin', agama='$agama', lokasi='$lokasi', area='$area', sub_area='$sub_area' 
            WHERE nip='$nip'";
}

if (mysqli_query($GLOBALS["___mysqli_ston"], $sql)) {
    header('location:../guru?sukses='.base64_encode('Data guru berhasil diupdate'));
} else {
    header('location:../guru?error='.base64_encode('Gagal mengupdate data guru'));
}
?>
