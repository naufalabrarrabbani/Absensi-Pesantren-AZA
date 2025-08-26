<?php
// Test file untuk cek URL rewriting di hosting
echo "Test URL Rewriting<br>";
echo "Current file: " . $_SERVER['PHP_SELF'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Script name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Query string: " . $_SERVER['QUERY_STRING'] . "<br>";
?>
