<?php
// Set timezone to Indonesia (GMT+7)
date_default_timezone_set('Asia/Jakarta');

$srvr="localhost"; //SESUAIKAN DENGAN WEBSERVER ANDA
$db="absenaza"; //SESUAIKAN DENGAN WEBSERVER ANDA
$usr="root"; //SESUAIKAN DENGAN WEBSERVER ANDA
$pwd="";//SESUAIKAN DENGAN WEBSERVER ANDA

($GLOBALS["___mysqli_ston"] = mysqli_connect($srvr, $usr, $pwd));
mysqli_select_db($GLOBALS["___mysqli_ston"], $db);

// Set MySQL timezone to Asia/Jakarta as well
mysqli_query($GLOBALS["___mysqli_ston"], "SET time_zone = '+07:00'");
?>