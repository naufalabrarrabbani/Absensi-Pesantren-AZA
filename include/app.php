<?php
include 'koneksi.php';
$app = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

?>