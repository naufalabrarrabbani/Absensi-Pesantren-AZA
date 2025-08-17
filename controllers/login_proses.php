<?php

session_start();
include '../include/koneksi.php';
$username = $_POST['username'];
$password = $_POST['password'];
// query untuk mendapatkan record dari username
$query = "SELECT * FROM user WHERE username = '$username'";
$hasil = mysqli_query($GLOBALS["___mysqli_ston"], $query);
$data = mysqli_fetch_array($hasil);
// cek kesesuaian password
if ($password == $data['password'])
{ 
    // menyimpan username dan level ke dalam session
    $_SESSION['username'] = $data['username'];
	$_SESSION['nama']     = $data['nama'];
	$_SESSION['level']     = $data['level'];
	$_SESSION['area']     = $data['area'];
    header('location:../app/home_modern.php');
	
}
else {
header('location: ../login?error='.base64_encode('Maaf Username dan Password Salah'));
        exit();
}
?>

