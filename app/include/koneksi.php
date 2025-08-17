<?php
$srvr="localhost"; //SESUAIKAN DENGAN WEBSERVER ANDA
$db="absenaza"; //SESUAIKAN DENGAN WEBSERVER ANDA
$usr="root"; //SESUAIKAN DENGAN WEBSERVER ANDA
$pwd="";//SESUAIKAN DENGAN WEBSERVER ANDA

($GLOBALS["___mysqli_ston"] = mysqli_connect($srvr, $usr, $pwd));
mysqli_select_db($GLOBALS["___mysqli_ston"], $db);
?>