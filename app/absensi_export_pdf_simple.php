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

// Calculate totals
$grand_total_hadir = 0;
$grand_total_ijin = 0;
$grand_total_sakit = 0;
$grand_total_alpha = 0;
$total_hari_kerja = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
    "SELECT DISTINCT tanggal FROM absensi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$month'"));

// Start output buffering for clean PDF generation
ob_start();

// Set headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Laporan_Absensi_' . date('F_Y', strtotime($month . '-01')) . '.pdf"');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: 0');

// Simple PDF generation using HTML
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi <?= date('F Y', strtotime($month . '-01')); ?></title>
    <style>
        @media print {
            @page {
                margin: 1cm;
                size: A4 landscape;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            color: #333;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #4640DE;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #4640DE;
            font-size: 20px;
            font-weight: bold;
        }
        
        .header h2 {
            margin: 5px 0;
            color: #666;
            font-weight: normal;
            font-size: 16px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 10px;
        }
        
        th {
            background-color: #4640DE !important;
            color: white !important;
            padding: 10px 6px;
            text-align: center;
            border: 1px solid #333;
            font-weight: bold;
            font-size: 10px;
        }
        
        td {
            padding: 8px 6px;
            border: 1px solid #666;
            text-align: center;
            vertical-align: middle;
        }
        
        .text-left {
            text-align: left !important;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa !important;
        }
        
        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        
        .total-row td {
            font-weight: bold;
        }
        
        .summary {
            margin-top: 25px;
            page-break-inside: avoid;
        }
        
        .summary h3 {
            margin-top: 0;
            color: #4640DE;
            font-size: 16px;
            border-bottom: 2px solid #4640DE;
            padding-bottom: 5px;
        }
        
        .summary-table {
            border: none !important;
            width: 60%;
            font-size: 11px;
        }
        
        .summary-table td {
            border: none !important;
            padding: 4px 15px 4px 0;
            text-align: left;
        }
        
        .no-print {
            display: none;
        }
        
        @media screen {
            .no-print {
                display: block;
                background: #f8f9fa;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 8px;
                border-left: 4px solid #4640DE;
            }
            
            .btn {
                background: #4640DE;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                margin: 5px;
            }
            
            .btn-success {
                background: #28a745;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <p><strong>📄 Laporan Absensi</strong> - Periode: <?= date('F Y', strtotime($month . '-01')); ?></p>
        <a href="javascript:window.print()" class="btn btn-success">🖨️ Print/Save as PDF</a>
        <a href="absensi_modern.php" class="btn">← Kembali</a>
    </div>

    <div class="header">
        <h1><?= $d_aplikasi['nama_aplikasi']; ?></h1>
        <h2>Laporan Absensi Siswa</h2>
        <h2>Periode: <?= date('F Y', strtotime($month . '-01')); ?></h2>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">NIK</th>
                <th style="width: 25%;">Nama Siswa</th>
                <th style="width: 12%;">Kelas</th>
                <th style="width: 11%;">Total Hadir</th>
                <th style="width: 10%;">Total Izin</th>
                <th style="width: 10%;">Total Sakit</th>
                <th style="width: 10%;">Total Alpha</th>
                <th style="width: 5%;">%</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            
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
        <table class="summary-table">
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

    <script>
        // Auto print for PDF save when accessed directly
        window.onload = function() {
            // Check if this is a direct PDF request
            if (window.location.search.includes('auto=1')) {
                setTimeout(function() {
                    window.print();
                }, 1000);
            }
        }
    </script>
</body>
</html>
<?php
ob_end_flush();
?>
