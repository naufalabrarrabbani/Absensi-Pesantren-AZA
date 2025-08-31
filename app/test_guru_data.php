<?php
require_once '../include/koneksi.php';

echo "<h2>Test Data Guru</h2>";

// Check database connection
if (!$GLOBALS["___mysqli_ston"]) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h3>1. Check Guru Table</h3>";
$guru_query = "SELECT * FROM guru ORDER BY nama LIMIT 10";
$guru_result = mysqli_query($GLOBALS["___mysqli_ston"], $guru_query);

if (!$guru_result) {
    echo "Error query guru: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "<br>";
} else {
    echo "Total guru found: " . mysqli_num_rows($guru_result) . "<br><br>";
    
    if (mysqli_num_rows($guru_result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th><th>Foto</th></tr>";
        while ($row = mysqli_fetch_assoc($guru_result)) {
            echo "<tr>";
            echo "<td>" . $row['nip'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . ($row['mata_pelajaran'] ?: 'Belum ditentukan') . "</td>";
            echo "<td>" . ($row['foto_guru'] ?: 'default.png') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data guru di database";
    }
}

echo "<h3>2. Check Absensi Guru Table</h3>";
$absensi_query = "SELECT * FROM absensi_guru ORDER BY tanggal DESC LIMIT 5";
$absensi_result = mysqli_query($GLOBALS["___mysqli_ston"], $absensi_query);

if (!$absensi_result) {
    echo "Error query absensi: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "<br>";
} else {
    echo "Total absensi records: " . mysqli_num_rows($absensi_result) . "<br><br>";
    
    if (mysqli_num_rows($absensi_result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>NIP</th><th>Tanggal</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($absensi_result)) {
            echo "<tr>";
            echo "<td>" . $row['nip'] . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "<td>" . ($row['jam_masuk'] ?: '-') . "</td>";
            echo "<td>" . ($row['jam_keluar'] ?: '-') . "</td>";
            echo "<td>" . ($row['status_tidak_masuk'] ?: 'Normal') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

echo "<h3>3. Test Query from absensi_guru_modern.php</h3>";
$selected_month = date('Y-m');
$test_query = "
    SELECT g.*, a.tanggal, a.jam_masuk, a.jam_keluar, a.ijin, a.status_tidak_masuk 
    FROM guru g 
    LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
    ORDER BY g.nama ASC, a.tanggal DESC
    LIMIT 10
";

$test_result = mysqli_query($GLOBALS["___mysqli_ston"], $test_query);

if (!$test_result) {
    echo "Error test query: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "<br>";
} else {
    echo "Test query results for month $selected_month: " . mysqli_num_rows($test_result) . " rows<br><br>";
    
    if (mysqli_num_rows($test_result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th><th>Tanggal</th><th>Jam Masuk</th></tr>";
        while ($row = mysqli_fetch_assoc($test_result)) {
            echo "<tr>";
            echo "<td>" . $row['nip'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . ($row['mata_pelajaran'] ?: '-') . "</td>";
            echo "<td>" . ($row['tanggal'] ?: '-') . "</td>";
            echo "<td>" . ($row['jam_masuk'] ?: '-') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

echo "<br><br><a href='absensi_guru_modern.php'>Back to Absensi Guru</a>";
?>
