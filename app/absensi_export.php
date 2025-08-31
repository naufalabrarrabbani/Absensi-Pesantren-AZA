<?php
session_start();
error_reporting(0);
include '../include/koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login');
    exit();
}

$format = $_GET['format'] ?? 'pdf';
$month = $_GET['month'] ?? date('Y-m');

if ($format === 'excel') {
    // Redirect to Excel export
    header("Location: absensi_export_excel.php?month=$month");
    exit();
} elseif ($format === 'pdf') {
    // Redirect to PDF simple handler
    header("Location: absensi_export_pdf_simple.php?month=$month&auto=1");
    exit();
}

// PDF Export continues here
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi <?= date('F Y', strtotime($month . '-01')); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            color: #666;
            font-weight: normal;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #4640DE;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary h3 {
            margin-top: 0;
            color: #333;
        }
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
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
                <th>NISN</th>
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
                    } elseif ($record['masuk']) {
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
                $persentase = $total_hari_kerja > 0 ? round(($total_kehadiran / $total_hari_kerja) * 100, 1) : 0;
                
                $grand_total_hadir += $total_hadir;
                $grand_total_ijin += $total_ijin;
                $grand_total_sakit += $total_sakit;
                $grand_total_alpha += $total_alpha;
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nik']; ?></td>
                <td><?= $data['nama']; ?></td>
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
                <td><strong><?= count($student_data) > 0 ? round((($grand_total_hadir + $grand_total_ijin + $grand_total_sakit) / (count($student_data) * $total_hari_kerja)) * 100, 1) : 0; ?>%</strong></td>
            </tr>
        </tbody>
    </table>
    
    <div class="summary">
        <h3>Ringkasan</h3>
        <p><strong>Total Siswa:</strong> <?= count($student_data); ?> orang</p>
        <p><strong>Total Hari Kerja:</strong> <?= $total_hari_kerja; ?> hari</p>
        <p><strong>Total Kehadiran:</strong> <?= $grand_total_hadir; ?> hari</p>
        <p><strong>Total Izin:</strong> <?= $grand_total_ijin; ?> hari</p>
        <p><strong>Total Sakit:</strong> <?= $grand_total_sakit; ?> hari</p>
        <p><strong>Total Alpha:</strong> <?= $grand_total_alpha; ?> hari</p>
        <p><strong>Total Tidak Hadir:</strong> <?= $grand_total_tidak_hadir; ?> hari</p>
        <p><strong>Tanggal Cetak:</strong> <?= date('d F Y H:i:s'); ?></p>
    </div>
    
    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
