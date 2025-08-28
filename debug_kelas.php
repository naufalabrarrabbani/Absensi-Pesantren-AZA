<?php
// Debug script untuk mengecek kelas_modern.php
include 'include/koneksi.php';

echo "<h2>Debug Kelas Modern</h2>";

// Test koneksi database
if ($GLOBALS["___mysqli_ston"]) {
    echo "<p style='color: green;'>✅ Koneksi database berhasil</p>";
} else {
    echo "<p style='color: red;'>❌ Koneksi database gagal: " . mysqli_connect_error() . "</p>";
    exit;
}

// Check if kelas table exists
$check_table = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'kelas'");
if (mysqli_num_rows($check_table) > 0) {
    echo "<p style='color: green;'>✅ Tabel kelas ada</p>";
    
    // Check table structure
    $structure = mysqli_query($GLOBALS["___mysqli_ston"], "DESCRIBE kelas");
    echo "<h3>Struktur Tabel Kelas:</h3>";
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = mysqli_fetch_assoc($structure)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check data count
    $count = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) as total FROM kelas");
    $total = mysqli_fetch_assoc($count)['total'];
    echo "<p>📊 Total data kelas: <strong>$total</strong></p>";
    
    if ($total > 0) {
        // Show sample data
        $sample = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas LIMIT 3");
        echo "<h3>Sample Data:</h3>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>ID</th><th>Kode</th><th>Nama</th><th>Tingkat</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($sample)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['kode_kelas'] . "</td>";
            echo "<td>" . $row['nama_kelas'] . "</td>";
            echo "<td>" . $row['tingkat'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Tabel kelas tidak ada</p>";
    echo "<p><a href='setup_kelas.php' style='background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Setup Tabel Kelas</a></p>";
}

// Check session
session_start();
if (isset($_SESSION['username'])) {
    echo "<p style='color: green;'>✅ Session username: " . $_SESSION['username'] . "</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Session belum login</p>";
}

// Check aplikasi table
$app_check = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM aplikasi LIMIT 1");
if ($app_check && mysqli_num_rows($app_check) > 0) {
    echo "<p style='color: green;'>✅ Tabel aplikasi ada dan berisi data</p>";
} else {
    echo "<p style='color: red;'>❌ Tabel aplikasi bermasalah</p>";
}

echo "<hr>";
echo "<h3>Links:</h3>";
echo "<p><a href='app/kelas_modern.php'>🔗 Test Akses Kelas Modern</a></p>";
echo "<p><a href='login.php'>🔗 Login Page</a></p>";
echo "<p><a href='app/home_modern.php'>🔗 Dashboard Admin</a></p>";
?>
