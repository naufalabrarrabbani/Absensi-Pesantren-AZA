<?php
include 'include/koneksi.php';

// Update guru pertama dengan foto test
$result = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE guru SET foto = 'test_guru_123_1234567890.png' WHERE id = (SELECT id FROM (SELECT id FROM guru LIMIT 1) as subquery)");

if ($result) {
    echo "SUCCESS: Updated guru photo to test_guru_123_1234567890.png\n";
} else {
    echo "ERROR: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "\n";
}

// Check the update
$check = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id, nama, foto FROM guru WHERE foto = 'test_guru_123_1234567890.png'");
while($row = mysqli_fetch_assoc($check)) {
    echo "Found guru: ID=" . $row['id'] . ", Nama=" . $row['nama'] . ", Foto=" . $row['foto'] . "\n";
}
?>
