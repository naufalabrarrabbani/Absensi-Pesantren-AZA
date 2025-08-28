<?php
include '../include/koneksi.php';

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$job_title = $_POST['job_title'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$photo = $_FILES['file']['name']; //ubah nama file

if(empty($photo)){
    $s_p = "UPDATE karyawan SET nama='$nama', job_title='$job_title', jenis_kelamin='$jenis_kelamin', start_date='$start_date', end_date='$end_date' WHERE nik='$nik'";
} elseif (!empty($photo)) {
    $cek_foto = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT foto FROM karyawan WHERE nik='$nik'")) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    $nama_foto = $cek_foto['foto'];
    
    // Hapus foto lama jika ada
    if(!empty($nama_foto)) {
        $target_delete = "../images/$nama_foto";
        if(file_exists($target_delete)) {
            unlink($target_delete);
        }
    }

    $new_foto = "student_" . $nik . "_" . date("YmdHis") . "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $target = "../images/$new_foto";

    //Upload foto baru
    if(move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $s_p = "UPDATE karyawan SET nama='$nama', job_title='$job_title', jenis_kelamin='$jenis_kelamin', start_date='$start_date', end_date='$end_date', foto='$new_foto' WHERE nik='$nik'";
    } else {
        header('location:../karyawan_modern.php?error='.base64_encode('Gagal mengupload foto'));
        exit();
    }
}

$proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
if ($proses) {
    header('location:../karyawan_modern.php?success='.base64_encode('Data siswa dengan NISN '.$nik.' telah berhasil diperbarui'));
} else { 
    header('location:../karyawan_modern.php?error='.base64_encode('Data gagal diperbarui: ' . mysqli_error($GLOBALS["___mysqli_ston"])));
}

?>