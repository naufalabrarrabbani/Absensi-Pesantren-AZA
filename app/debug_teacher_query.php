<?php
require_once '../include/koneksi.php';

echo "<h2>Debug Teacher Query</h2>";

// Check total guru
$guru_count = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) as total FROM guru");
$guru_total = mysqli_fetch_array($guru_count);
echo "<p><strong>Total Guru di Database: " . $guru_total['total'] . "</strong></p>";

// Show all guru
echo "<h3>Data Guru:</h3>";
$all_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru ORDER BY nama");
if (mysqli_num_rows($all_guru) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th><th>Foto</th></tr>";
    while ($row = mysqli_fetch_assoc($all_guru)) {
        echo "<tr>";
        echo "<td>" . $row['nip'] . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . ($row['mata_pelajaran'] ?: '-') . "</td>";
        echo "<td>" . ($row['foto'] ?: 'default.png') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada data guru di database!</p>";
}

// Test the exact query from absensi_guru_modern.php
echo "<h3>Test Query dengan LEFT JOIN:</h3>";
$selected_month = date('Y-m');
$test_query = "
    SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
    FROM guru g 
    LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
    ORDER BY g.nama ASC, a.tanggal DESC
";

echo "<p><strong>Query:</strong><br><code>$test_query</code></p>";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $test_query);
if (!$result) {
    echo "<p style='color: red;'>Error: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "</p>";
} else {
    echo "<p><strong>Total rows: " . mysqli_num_rows($result) . "</strong></p>";
    
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th><th>Tanggal</th><th>Masuk</th><th>Status</th></tr>";
        $count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $count++;
            echo "<tr>";
            echo "<td>" . $row['nip'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . ($row['mata_pelajaran'] ?: '-') . "</td>";
            echo "<td>" . ($row['tanggal'] ?: '-') . "</td>";
            echo "<td>" . ($row['masuk'] ?: '-') . "</td>";
            echo "<td>" . ($row['status_tidak_masuk'] ?: '-') . "</td>";
            echo "</tr>";
            if ($count >= 10) break; // Limit to 10 rows for testing
        }
        echo "</table>";
    }
}

echo "<br><br><a href='absensi_guru_modern.php'>Back to Absensi Guru</a>";
?>
