<?php
include 'include/koneksi.php';

echo "=== DATA GURU ===\n";
$result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, nama, nip, foto FROM guru LIMIT 5");
while($row = mysqli_fetch_assoc($result)) {
    echo "ID: " . $row['id'] . ", Nama: " . $row['nama'] . ", NIP: " . $row['nip'] . ", Foto: " . ($row['foto'] ?: 'NULL') . "\n";
}

echo "\n=== FOTO FILES IN APP/IMAGES/GURU ===\n";
$guru_dir = "app/images/guru/";
if (is_dir($guru_dir)) {
    $files = scandir($guru_dir);
    foreach($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "File: " . $file . " (Size: " . filesize($guru_dir . $file) . " bytes)\n";
        }
    }
} else {
    echo "Directory does not exist\n";
}

echo "\n=== FOTO FILES IN IMAGES/GURU ===\n";
$guru_dir = "images/guru/";
if (is_dir($guru_dir)) {
    $files = scandir($guru_dir);
    foreach($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "File: " . $file . " (Size: " . filesize($guru_dir . $file) . " bytes)\n";
        }
    }
} else {
    echo "Directory does not exist\n";
}
?>
