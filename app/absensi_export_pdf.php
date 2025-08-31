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

// Set headers for PDF download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Laporan_Absensi_' . date('F_Y', strtotime($month . '-01')) . '.pdf"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

// Simple PDF generation using HTML to PDF conversion
// For better PDF, consider using libraries like TCPDF or mPDF
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi <?= date('F Y', strtotime($month . '-01')); ?></title>
    <style>
        @page {
            margin: 20mm;
            size: A4 landscape;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
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
            font-size: 9px;
        }
        th {
            background-color: #4640DE;
            color: white;
            padding: 8px 5px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 9px;
        }
        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .summary h3 {
            margin-top: 0;
            color: #333;
            font-size: 14px;
        }
        .summary p {
            margin: 3px 0;
            font-size: 10px;
        }
        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
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
                <th width="5%">No</th>
                <th width="12%">NISN</th>
                <th width="25%">Nama Siswa</th>
                <th width="15%">Kelas</th>
                <th width="10%">Total Hadir</th>
                <th width="10%">Total Izin</th>
                <th width="10%">Total Sakit</th>
                <th width="10%">Total Alpha</th>
                <th width="8%">Persentase</th>
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
                
                $total_kehadiran = $total_hadir + $total_ijin + $total_sakit;
                $persentase = $total_hari_kerja > 0 ? round(($total_hadir / $total_hari_kerja) * 100, 1) : 0;
                
                $grand_total_hadir += $total_hadir;
                $grand_total_ijin += $total_ijin;
                $grand_total_sakit += $total_sakit;
                $grand_total_alpha += $total_alpha;
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $data['nik']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['job_title']; ?></td>
                <td class="text-center"><?= $total_hadir; ?></td>
                <td class="text-center"><?= $total_ijin; ?></td>
                <td class="text-center"><?= $total_sakit; ?></td>
                <td class="text-center"><?= $total_alpha; ?></td>
                <td class="text-center"><?= $persentase; ?>%</td>
            </tr>
            <?php } ?>
            <tr class="total-row">
                <td colspan="4" class="text-center"><strong>TOTAL</strong></td>
                <td class="text-center"><strong><?= $grand_total_hadir; ?></strong></td>
                <td class="text-center"><strong><?= $grand_total_ijin; ?></strong></td>
                <td class="text-center"><strong><?= $grand_total_sakit; ?></strong></td>
                <td class="text-center"><strong><?= $grand_total_alpha; ?></strong></td>
                <td class="text-center"><strong><?= count($student_data) > 0 ? round(($grand_total_hadir / (count($student_data) * $total_hari_kerja)) * 100, 1) : 0; ?>%</strong></td>
            </tr>
        </tbody>
    </table>
    
    <div class="summary">
        <h3>Ringkasan Laporan</h3>
        <table style="border: none; width: 50%;">
            <tr style="border: none;">
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Total Siswa:</strong></td>
                <td style="border: none; padding: 2px 0;"><?= count($student_data); ?> orang</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Total Hari Kerja:</strong></td>
                <td style="border: none; padding: 2px 0;"><?= $total_hari_kerja; ?> hari</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Total Kehadiran:</strong></td>
                <td style="border: none; padding: 2px 0;"><?= $grand_total_hadir; ?> hari</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Total Izin:</strong></td>
                <td style="border: none; padding: 2px 0;"><?= $grand_total_ijin; ?> hari</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Total Sakit:</strong></td>
                <td style="border: none; padding: 2px 0;"><?= $grand_total_sakit; ?> hari</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Total Alpha:</strong></td>
                <td style="border: none; padding: 2px 0;"><?= $grand_total_alpha; ?> hari</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 10px 2px 0;"><strong>Tanggal Cetak:</strong></td>
                <td style="border: none; padding: 2px 0;"><?= date('d F Y H:i:s'); ?></td>
            </tr>
        </table>
    </div>

    <script>
        // Trigger download immediately without print dialog
        window.onload = function() {
            // Convert to PDF and download
            setTimeout(function() {
                window.print();
                window.close();
            }, 100);
        }
    </script>
</body>
</html>
