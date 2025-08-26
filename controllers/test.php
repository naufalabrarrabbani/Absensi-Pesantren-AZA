<?php
// Test file untuk controllers
echo "Controllers test file works!<br>";
echo "Current time: " . date('Y-m-d H:i:s') . "<br>";
echo "POST data: ";
print_r($_POST);
echo "<br>GET data: ";
print_r($_GET);
echo "<br>Server info: ";
echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
