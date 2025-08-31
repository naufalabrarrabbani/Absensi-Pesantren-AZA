<?php
// Test file untuk memverifikasi API filter guru
require_once '../include/koneksi.php';

echo "<h2>Test API Filter Guru</h2>";

// Test 1: Get subjects
echo "<h3>1. Test Get Subjects</h3>";
$query = "SELECT DISTINCT mata_pelajaran FROM guru WHERE mata_pelajaran IS NOT NULL AND mata_pelajaran != '' ORDER BY mata_pelajaran";
$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

$subjects = [];
while ($row = mysqli_fetch_assoc($result)) {
    $subjects[] = $row['mata_pelajaran'];
}

echo "Subjects found: " . count($subjects) . "<br>";
foreach ($subjects as $subject) {
    echo "- " . $subject . "<br>";
}

// Test 2: Daily data
echo "<h3>2. Test Daily Data</h3>";
$date = date('Y-m-d');
$query = "
    SELECT 
        g.nip,
        g.nama,
        g.mata_pelajaran,
        g.foto_guru as photo,
        a.jam_masuk,
        a.jam_keluar,
        a.ijin,
        a.status_tidak_masuk,
        a.keterangan,
        a.tanggal
    FROM guru g
    LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$date'
    ORDER BY g.nama
    LIMIT 5
";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
echo "Daily data query result: " . mysqli_num_rows($result) . " rows<br>";

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th><th>Jam Masuk</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['nip'] . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['mata_pelajaran'] . "</td>";
        echo "<td>" . $row['jam_masuk'] . "</td>";
        echo "<td>" . ($row['jam_masuk'] ? 'Hadir' : ($row['ijin'] ? 'Ijin' : 'Alpha')) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test 3: Statistics
echo "<h3>3. Test Statistics</h3>";
$query = "
    SELECT 
        COUNT(g.nip) as total,
        COUNT(CASE WHEN a.jam_masuk IS NOT NULL THEN 1 END) as hadir,
        COUNT(CASE WHEN a.ijin = 1 OR a.status_tidak_masuk IN ('izin', 'sakit') THEN 1 END) as ijin,
        COUNT(CASE WHEN a.status_tidak_masuk = 'alpha' OR (a.jam_masuk IS NULL AND a.ijin IS NULL AND a.status_tidak_masuk IS NULL) THEN 1 END) as alpha
    FROM guru g
    LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$date'
";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
$stats = mysqli_fetch_assoc($result);

echo "Statistics for date: $date<br>";
echo "Total: " . $stats['total'] . "<br>";
echo "Hadir: " . $stats['hadir'] . "<br>";
echo "Ijin: " . $stats['ijin'] . "<br>";
echo "Alpha: " . $stats['alpha'] . "<br>";

// Test 4: Database connection
echo "<h3>4. Database Connection Test</h3>";
if ($GLOBALS["___mysqli_ston"]) {
    echo "✅ Database connection successful<br>";
    echo "MySQL version: " . mysqli_get_server_info($GLOBALS["___mysqli_ston"]) . "<br>";
} else {
    echo "❌ Database connection failed<br>";
}

// Test 5: Table structure
echo "<h3>5. Table Structure Test</h3>";
$tables = ['guru', 'absensi_guru'];
foreach ($tables as $table) {
    $query = "DESCRIBE $table";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    
    echo "<strong>Table: $table</strong><br>";
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "- " . $row['Field'] . " (" . $row['Type'] . ")<br>";
        }
    } else {
        echo "❌ Table $table not found<br>";
    }
    echo "<br>";
}

echo "<hr>";
echo "<p><a href='load_guru_data.php?action=get_subjects' target='_blank'>Test Get Subjects API</a></p>";
echo "<p><a href='load_guru_data.php?mode=daily&date=$date' target='_blank'>Test Daily Data API</a></p>";
echo "<p><a href='absensi_guru_modern.php'>Back to Guru Attendance</a></p>";
?>
