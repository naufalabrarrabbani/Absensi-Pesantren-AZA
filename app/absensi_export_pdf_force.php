<?php
session_start();
error_reporting(0);
include '../include/koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login');
    exit();
}

$month = $_POST['month'] ?? $_GET['month'] ?? date('Y-m');

// Set force download headers
$filename = 'Laporan_Absensi_' . date('F_Y', strtotime($month . '-01')) . '.pdf';
header('Content-Type: application/force-download');
header('Content-Type: application/octet-stream');
header('Content-Type: application/download');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Expires: 0');

// Generate basic HTML for PDF content
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #4640DE; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Absensi Siswa</h1>
        <h2>Periode: ' . date('F Y', strtotime($month . '-01')) . '</h2>
    </div>
    
    <p>File PDF telah dibuat untuk periode ' . date('F Y', strtotime($month . '-01')) . '</p>
    <p>Gunakan browser Print to PDF untuk menyimpan laporan ini.</p>
    
    <script>
        window.onload = function() {
            alert("PDF akan didownload. Gunakan Ctrl+P untuk Print to PDF");
            window.print();
        }
    </script>
</body>
</html>';
?>
