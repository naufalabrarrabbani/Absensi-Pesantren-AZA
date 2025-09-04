<?php
echo "Current PHP timezone: " . date_default_timezone_get() . "\n";
echo "Current time: " . date('Y-m-d H:i:s T') . "\n";
echo "Current timestamp: " . time() . "\n";

// Set to Jakarta timezone
date_default_timezone_set('Asia/Jakarta');
echo "\nAfter setting to Asia/Jakarta:\n";
echo "PHP timezone: " . date_default_timezone_get() . "\n";
echo "Current time: " . date('Y-m-d H:i:s T') . "\n";
echo "Current timestamp: " . time() . "\n";
?>
