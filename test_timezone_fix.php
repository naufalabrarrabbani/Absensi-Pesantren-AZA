<?php
include 'include/koneksi.php';

echo "<h2>Timezone Test Results</h2>";
echo "<p><strong>PHP Timezone:</strong> " . date_default_timezone_get() . "</p>";
echo "<p><strong>Current PHP Time:</strong> " . date('Y-m-d H:i:s T') . "</p>";

// Test database timezone
$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT NOW() as mysql_time, @@global.time_zone as global_tz, @@session.time_zone as session_tz");
$row = mysqli_fetch_assoc($result);

echo "<p><strong>MySQL Global Timezone:</strong> " . $row['global_tz'] . "</p>";
echo "<p><strong>MySQL Session Timezone:</strong> " . $row['session_tz'] . "</p>";
echo "<p><strong>MySQL Current Time:</strong> " . $row['mysql_time'] . "</p>";

echo "<hr>";
echo "<h3>Test Attendance Entry</h3>";
$test_time = date('Y-m-d H:i:s');
echo "<p>Test attendance time that would be saved: <strong>$test_time</strong></p>";
echo "<p>Formatted for display: <strong>" . date('H:i', strtotime($test_time)) . "</strong></p>";

echo "<hr>";
echo "<h3>JavaScript Time (Browser)</h3>";
echo "<script>
document.write('<p>Browser Current Time: <strong>' + new Date().toString() + '</strong></p>');
document.write('<p>Browser Local Time: <strong>' + new Date().toLocaleString('id-ID', {timeZone: 'Asia/Jakarta'}) + '</strong></p>');
</script>";
?>
