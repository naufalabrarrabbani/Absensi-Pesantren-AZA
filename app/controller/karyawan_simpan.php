<?php
include '../include/koneksi.php';

$nik = $_POST['nik'];
$nama = $_POST['nama'];
$job_title = $_POST['job_title'];
$jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
$lokasi = $_POST['lokasi'];
$start_date = $_POST['start_date'] ?? date('Y-m-d');
$end_date = $_POST['end_date'] ?? date('Y-m-d', strtotime('+1 year'));

// Handle file upload
$photo = '';
if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $file_type = $_FILES['file']['type'];
    
    if (in_array($file_type, $allowed_types)) {
        $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $photo = "student_" . $nik . "_" . date("YmdHis") . "." . $file_extension;
        $target = "../images/$photo";
        
        // Create images directory if it doesn't exist
        if (!file_exists('../images')) {
            mkdir('../images', 0755, true);
        }
        
        move_uploaded_file($_FILES['file']['tmp_name'], $target);
    } else {
        header('location:../karyawan_modern.php?error=' . base64_encode('Format file tidak didukung. Gunakan JPG, PNG, atau GIF'));
        exit();
    }
}

// Check if NIK already exists
$s_pelanggan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where nik='$nik'");
$cek = mysqli_num_rows($s_pelanggan);

if ($cek == 0) {
    $s_p = "INSERT into karyawan (nik, nama, job_title, jenis_kelamin, lokasi, start_date, end_date, foto) 
            VALUES('$nik', '$nama', '$job_title', '$jenis_kelamin', '$lokasi', '$start_date', '$end_date', '$photo')";
    
    $proses = mysqli_query($GLOBALS["___mysqli_ston"], $s_p);
    
    if ($proses) {
        header('location:../karyawan_modern.php?success=' . base64_encode('Siswa dengan NISN ' . $nik . ' berhasil ditambahkan'));
    } else { 
        header('location:../karyawan_modern.php?error=' . base64_encode('Data gagal disimpan. Silakan coba lagi'));
    }
} else {
    header('location:../karyawan_modern.php?error=' . base64_encode('NISN ' . $nik . ' sudah terdaftar'));
} 

?>