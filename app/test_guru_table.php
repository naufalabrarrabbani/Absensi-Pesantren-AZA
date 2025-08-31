<?php
// Test database guru table structure
include '../include/koneksi.php';

echo "Testing guru table structure...\n";

// Test query to check available columns in guru table
$test_query = "SHOW COLUMNS FROM guru";
$test_result = mysqli_query($GLOBALS["___mysqli_ston"], $test_query);

if ($test_result) {
    echo "Guru table columns:\n";
    while ($column = mysqli_fetch_array($test_result)) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }
} else {
    echo "Error checking guru table: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "\n";
}

echo "\nTesting sample guru data...\n";

// Test simple guru query
$guru_query = "SELECT nip, nama, mata_pelajaran FROM guru LIMIT 3";
$guru_result = mysqli_query($GLOBALS["___mysqli_ston"], $guru_query);

if ($guru_result) {
    echo "Sample guru data:\n";
    while ($guru = mysqli_fetch_array($guru_result)) {
        echo "- NIP: " . $guru['nip'] . ", Nama: " . $guru['nama'] . ", Mapel: " . $guru['mata_pelajaran'] . "\n";
    }
} else {
    echo "Error checking guru data: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "\n";
}

echo "\nTest completed!\n";
?>
