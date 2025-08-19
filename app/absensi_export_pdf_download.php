<?php
session_start();
error_reporting(0);
include '../include/koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login');
    exit();
}

$month = $_GET['month'] ?? date('Y-m');
$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Get attendance data for the month
$attendance_query = "
    SELECT k.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
    FROM karyawan k 
    LEFT JOIN absensi a ON k.nik = a.nik AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$month'
    ORDER BY k.nama ASC, a.tanggal DESC
";

$attendance_result = mysqli_query($GLOBALS["___mysqli_ston"], $attendance_query);
$student_data = array();

while ($data = mysqli_fetch_array($attendance_result)) {
    if (!isset($student_data[$data['nik']])) {
        $student_data[$data['nik']] = array(
            'info' => $data,
            'attendance' => array()
        );
    }
    if ($data['tanggal']) {
        $student_data[$data['nik']]['attendance'][] = $data;
    }
}

// Generate HTML content for PDF
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0;
            color: #666;
            font-weight: normal;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }
        th {
            background-color: #4640DE;
            color: white;
            padding: 8px 5px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        .summary {
            margin-top: 20px;
        }
        .summary h3 {
            margin-top: 0;
            color: #333;
            font-size: 14px;
        }
        .summary table {
            border: none;
            width: 50%;
        }
        .summary td {
            border: none;
            padding: 3px 10px 3px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= $d_aplikasi['nama_aplikasi']; ?></h1>
        <h2>Laporan Absensi Siswa</h2>
        <h2>Periode: <?= date('F Y', strtotime($month . '-01')); ?></h2>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Total Hadir</th>
                <th>Total Izin</th>
                <th>Total Sakit</th>
                <th>Total Alpha</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $grand_total_hadir = 0;
            $grand_total_ijin = 0;
            $grand_total_sakit = 0;
            $grand_total_alpha = 0;
            $total_hari_kerja = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
                "SELECT DISTINCT tanggal FROM absensi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$month'"));
            
            foreach ($student_data as $nik => $student) {
                $data = $student['info'];
                $attendance_records = $student['attendance'];
                
                $total_hadir = 0;
                $total_ijin = 0;
                $total_sakit = 0;
                $total_alpha = 0;
                
                foreach ($attendance_records as $record) {
                    if ($record['ijin']) {
                        $total_ijin++;
                    } elseif ($record['masuk'] && !$record['status_tidak_masuk']) {
                        $total_hadir++;
                    } elseif ($record['status_tidak_masuk']) {
                        if ($record['status_tidak_masuk'] == 'izin') {
                            $total_ijin++;
                        } elseif ($record['status_tidak_masuk'] == 'sakit') {
                            $total_sakit++;
                        } elseif ($record['status_tidak_masuk'] == 'alpha') {
                            $total_alpha++;
                        }
                    }
                }
                
                $persentase = $total_hari_kerja > 0 ? round(($total_hadir / $total_hari_kerja) * 100, 1) : 0;
                
                $grand_total_hadir += $total_hadir;
                $grand_total_ijin += $total_ijin;
                $grand_total_sakit += $total_sakit;
                $grand_total_alpha += $total_alpha;
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nik']; ?></td>
                <td class="text-left"><?= $data['nama']; ?></td>
                <td><?= $data['job_title']; ?></td>
                <td><?= $total_hadir; ?></td>
                <td><?= $total_ijin; ?></td>
                <td><?= $total_sakit; ?></td>
                <td><?= $total_alpha; ?></td>
                <td><?= $persentase; ?>%</td>
            </tr>
            <?php } ?>
            <tr class="total-row">
                <td colspan="4"><strong>TOTAL</strong></td>
                <td><strong><?= $grand_total_hadir; ?></strong></td>
                <td><strong><?= $grand_total_ijin; ?></strong></td>
                <td><strong><?= $grand_total_sakit; ?></strong></td>
                <td><strong><?= $grand_total_alpha; ?></strong></td>
                <td><strong><?= count($student_data) > 0 ? round(($grand_total_hadir / (count($student_data) * $total_hari_kerja)) * 100, 1) : 0; ?>%</strong></td>
            </tr>
        </tbody>
    </table>
    
    <div class="summary">
        <h3>Ringkasan Laporan</h3>
        <table>
            <tr>
                <td><strong>Total Siswa:</strong></td>
                <td><?= count($student_data); ?> orang</td>
            </tr>
            <tr>
                <td><strong>Total Hari Kerja:</strong></td>
                <td><?= $total_hari_kerja; ?> hari</td>
            </tr>
            <tr>
                <td><strong>Total Kehadiran:</strong></td>
                <td><?= $grand_total_hadir; ?> hari</td>
            </tr>
            <tr>
                <td><strong>Total Izin:</strong></td>
                <td><?= $grand_total_ijin; ?> hari</td>
            </tr>
            <tr>
                <td><strong>Total Sakit:</strong></td>
                <td><?= $grand_total_sakit; ?> hari</td>
            </tr>
            <tr>
                <td><strong>Total Alpha:</strong></td>
                <td><?= $grand_total_alpha; ?> hari</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak:</strong></td>
                <td><?= date('d F Y H:i:s'); ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php
$html = ob_get_clean();

// Try to use DOMPdf or similar library if available
// For now, we'll use a simple approach with proper headers

// Set proper headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Laporan_Absensi_' . date('F_Y', strtotime($month . '-01')) . '.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Simple HTML to PDF conversion using wkhtmltopdf-like approach
// For production, consider using libraries like TCPDF, mPDF, or DOMPdf

// For now, we'll create a download-friendly HTML that can be saved as PDF
echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Download PDF - Laporan Absensi ' . date('F Y', strtotime($month . '-01')) . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .download-info { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 8px; 
            margin-bottom: 20px;
            border-left: 4px solid #4640DE;
        }
        .btn-download {
            background: #4640DE;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin: 10px 5px;
        }
        .btn-print {
            background: #28a745;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin: 10px 5px;
        }
    </style>
</head>
<body>
    <div class="download-info">
        <h2>📄 Laporan Absensi Siap</h2>
        <p><strong>Periode:</strong> ' . date('F Y', strtotime($month . '-01')) . '</p>
        <p><strong>Total Data:</strong> ' . count($student_data) . ' siswa</p>
        
        <a href="#" onclick="window.print(); return false;" class="btn-print">
            🖨️ Print/Save as PDF
        </a>
        
        <a href="javascript:history.back()" class="btn-download">
            ← Kembali ke Absensi
        </a>
    </div>
    
    <div style="margin-top: 30px;">
        ' . $html . '
    </div>
    
    <script>
        // Auto trigger print dialog for PDF save
        setTimeout(function() {
            if (confirm("Apakah Anda ingin menyimpan sebagai PDF sekarang?")) {
                window.print();
            }
        }, 500);
    </script>
</body>
</html>';
?>
