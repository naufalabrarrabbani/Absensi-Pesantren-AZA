<?php
// Simple test untuk kelas_modern.php
echo "<h1>Test Kelas Modern</h1>";
echo "<p>File ini adalah test sederhana</p>";
echo "<p>Jika Anda melihat halaman ini, berarti:</p>";
echo "<ul>";
echo "<li>✅ Web server berjalan dengan baik</li>";
echo "<li>✅ PHP dapat dieksekusi</li>";
echo "<li>✅ Path file sudah benar</li>";
echo "</ul>";

echo "<h3>Informasi Server:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";

echo "<hr>";
echo "<h3>Testing Links:</h3>";
echo "<p><a href='debug_kelas.php'>🔍 Debug Kelas</a></p>";
echo "<p><a href='setup_kelas.php'>⚙️ Setup Kelas</a></p>";
echo "<p><a href='app/kelas_modern.php'>📚 Kelas Modern (Original)</a></p>";
echo "<p><a href='login.php'>🔐 Login</a></p>";
?>
