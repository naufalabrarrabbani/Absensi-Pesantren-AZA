<?php
include '../include/koneksi.php';

echo "<h3>Debug Test - Data Guru</h3>";

// Test 1: Lihat semua guru
echo "<h4>1. Semua Guru:</h4>";
$all_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nip, nama, mata_pelajaran FROM guru ORDER BY nama");
echo "<table border='1'>";
echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th></tr>";
while ($row = mysqli_fetch_array($all_guru)) {
    echo "<tr><td>{$row['nip']}</td><td>{$row['nama']}</td><td>{$row['mata_pelajaran']}</td></tr>";
}
echo "</table>";

// Test 5: Check absensi guru untuk tanggal 31 Agustus 2025
echo "<h4>5. Data Absensi Guru 31 Agustus 2025:</h4>";
$absensi_check = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM absensi_guru WHERE tanggal = '2025-08-31'");
if (mysqli_num_rows($absensi_check) == 0) {
    echo "<p style='color: orange;'>Tidak ada data absensi guru untuk tanggal 31 Agustus 2025.</p>";
    
    // Insert sample data untuk testing
    echo "<h4>6. Membuat Sample Data:</h4>";
    $sample_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nip FROM guru LIMIT 3");
    while ($guru = mysqli_fetch_array($sample_guru)) {
        $insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO absensi_guru (nip, tanggal, masuk) VALUES ('{$guru['nip']}', '2025-08-31', '07:30:00')");
        if ($insert) {
            echo "<p style='color: green;'>Sample data ditambahkan untuk guru NIP: {$guru['nip']}</p>";
        }
    }
} else {
    echo "<table border='1'>";
    echo "<tr><th>NIP</th><th>Tanggal</th><th>Masuk</th><th>Pulang</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_array($absensi_check)) {
        echo "<tr>";
        echo "<td>{$row['nip']}</td>";
        echo "<td>{$row['tanggal']}</td>";
        echo "<td>{$row['masuk']}</td>";
        echo "<td>{$row['pulang']}</td>";
        echo "<td>" . ($row['ijin'] ?: ($row['status_tidak_masuk'] ?: 'Normal')) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test 2: Lihat guru dengan mata pelajaran Akidah Akhlak
echo "<h4>2. Guru Akidah Akhlak:</h4>";
$akidah_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nip, nama, mata_pelajaran FROM guru WHERE mata_pelajaran = 'Akidah Akhlak'");
if (mysqli_num_rows($akidah_guru) == 0) {
    echo "Tidak ada guru dengan mata pelajaran 'Akidah Akhlak'";
} else {
    echo "<table border='1'>";
    echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th></tr>";
    while ($row = mysqli_fetch_array($akidah_guru)) {
        echo "<tr><td>{$row['nip']}</td><td>{$row['nama']}</td><td>{$row['mata_pelajaran']}</td></tr>";
    }
    echo "</table>";
}

// Test 3: Lihat mata pelajaran yang tersedia
echo "<h4>3. Mata Pelajaran yang Tersedia:</h4>";
$mapel_list = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT mata_pelajaran FROM guru WHERE mata_pelajaran IS NOT NULL AND mata_pelajaran != '' ORDER BY mata_pelajaran");
echo "<ul>";
while ($row = mysqli_fetch_array($mapel_list)) {
    echo "<li>{$row['mata_pelajaran']}</li>";
}
echo "</ul>";

// Test 4: Test query yang sama seperti di sistem
echo "<h4>4. Test Query Sistem (31 Agustus 2025):</h4>";
$mapel_filter = 'Akidah Akhlak';
$selected_date = '2025-08-31';
$mapel_filter_escaped = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $mapel_filter);
$mapel_condition = " AND g.mata_pelajaran = '$mapel_filter_escaped'";

$query = "
    SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
    FROM guru g 
    LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$selected_date'
    WHERE 1=1 $mapel_condition
    ORDER BY g.nama ASC
";

echo "<p><strong>Query:</strong> $query</p>";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
if (!$result) {
    echo "<p style='color: red;'>Error: " . mysqli_error($GLOBALS["___mysqli_ston"]) . "</p>";
} else {
    $count = mysqli_num_rows($result);
    echo "<p><strong>Rows found:</strong> $count</p>";
    
    if ($count > 0) {
        echo "<table border='1'>";
        echo "<tr><th>NIP</th><th>Nama</th><th>Mata Pelajaran</th><th>Tanggal</th><th>Masuk</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>{$row['nip']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['mata_pelajaran']}</td>";
            echo "<td>{$row['tanggal']}</td>";
            echo "<td>{$row['masuk']}</td>";
            echo "<td>" . ($row['masuk'] ? 'Hadir' : ($row['ijin'] ? 'Izin' : ($row['status_tidak_masuk'] ? $row['status_tidak_masuk'] : 'Tidak ada data'))) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

// Test tanpa filter mata pelajaran
echo "<h4>7. Test Query Tanpa Filter Mata Pelajaran:</h4>";
$query_no_filter = "
    SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
    FROM guru g 
    LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$selected_date'
    WHERE 1=1
    ORDER BY g.nama ASC
";

$result_no_filter = mysqli_query($GLOBALS["___mysqli_ston"], $query_no_filter);
$count_no_filter = mysqli_num_rows($result_no_filter);
echo "<p><strong>Rows found (no filter):</strong> $count_no_filter</p>";
?>
