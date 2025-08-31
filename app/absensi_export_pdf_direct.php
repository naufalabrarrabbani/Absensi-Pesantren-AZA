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
$kelas = $_GET['kelas'] ?? '';
$download = $_GET['download'] ?? '0';

// If download is requested, set proper headers
if ($download == '1') {
    $filename = 'Laporan_Absensi_' . date('F_Y', strtotime($month . '-01'));
    if ($kelas) {
        $kelas_name = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama_kelas FROM kelas WHERE kode_kelas = '$kelas'"));
        $filename .= '_' . ($kelas_name ? $kelas_name['nama_kelas'] : $kelas);
    }
    $filename .= '.html';
    
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Get attendance data for the month with class filter
$class_filter = $kelas ? " AND k.job_title = '$kelas'" : "";
$attendance_query = "
    SELECT k.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
    FROM karyawan k 
    LEFT JOIN absensi a ON k.nik = a.nik AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$month'
    WHERE 1=1 $class_filter
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

// Generate HTML content
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            color: #333;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
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
            background-color: #4640DE;
            color: white;
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
            text-align: left;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        
        .summary {
            margin-top: 25px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .summary h3 {
            margin-top: 0;
            color: #4640DE;
            font-size: 16px;
            border-bottom: 2px solid #4640DE;
            padding-bottom: 5px;
        }
        
        .summary-table {
            border: none;
            width: 100%;
            font-size: 11px;
        }
        
        .summary-table td {
            border: none;
            padding: 4px 15px 4px 0;
            text-align: left;
        }
        
        .buttons {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .btn {
            background: #4640DE;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-success {
            background: #28a745;
        }
        
        .btn-secondary {
            background: #6c757d;
        }
        
        @media print {
            .buttons { display: none; }
            body { margin: 0; }
            .container { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="buttons">
            <strong>📄 Laporan Absensi</strong> - Periode: <?= date('F Y', strtotime($month . '-01')); ?>
            <br><br>
            <p style="background: #e3f2fd; padding: 10px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #2196f3;">
                <strong>💡 Cara Download PDF:</strong><br>
                1. Klik tombol "Print/Save as PDF" di bawah<br>
                2. Pilih "Save as PDF" sebagai printer destination<br>
                3. Klik "Save" untuk download file PDF
            </p>
            <button onclick="window.print()" class="btn btn-success">🖨️ Print/Save as PDF</button>
            <a href="absensi_modern.php" class="btn btn-secondary">← Kembali</a>
        </div>

        <div class="header">
            <h1><?= $d_aplikasi['nama_aplikasi']; ?></h1>
            <h2>Laporan Absensi Siswa</h2>
            <h2>Periode: <?= date('F Y', strtotime($month . '-01')); ?></h2>
            <?php if ($kelas): ?>
                <?php
                $kelas_name = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama_kelas FROM kelas WHERE kode_kelas = '$kelas'"));
                ?>
                <h3>Kelas: <?= $kelas_name ? $kelas_name['nama_kelas'] : $kelas; ?></h3>
            <?php endif; ?>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 12%;">NISN</th>
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
                    
                    // Calculate percentage based on total attendance records, not working days
                    $total_all_records = $total_hadir + $total_ijin + $total_sakit + $total_alpha;
                    $persentase = $total_all_records > 0 ? round(($total_hadir / $total_all_records) * 100, 1) : 0;
                    
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
                    <td><strong>
                        <?php 
                        $grand_total_all = $grand_total_hadir + $grand_total_ijin + $grand_total_sakit + $grand_total_alpha;
                        echo $grand_total_all > 0 ? round(($grand_total_hadir / $grand_total_all) * 100, 1) : 0; 
                        ?>%
                    </strong></td>
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
    </div>

    <script>
        function downloadAsPDF() {
            // For direct download, redirect to self with download parameter
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('download', '1');
            window.location.href = currentUrl.toString();
        }
        
        // Only show print option if not downloading
        <?php if ($download != '1'): ?>
        // Add download button functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Create download button if it doesn't exist
            const toolsDiv = document.querySelector('.tools');
            if (toolsDiv) {
                const downloadBtn = document.createElement('button');
                downloadBtn.innerHTML = '📥 Download HTML';
                downloadBtn.className = 'btn btn-primary';
                downloadBtn.onclick = downloadAsPDF;
                toolsDiv.insertBefore(downloadBtn, toolsDiv.firstChild);
            }
        });
        <?php endif; ?>
        
        // Auto download if parameter is set
        <?php if ($download == '1'): ?>
        // File will be downloaded automatically due to headers
        <?php endif; ?>
    </script>
</body>
</html>
<?php
$html_content = ob_get_clean();
echo $html_content;
?>
