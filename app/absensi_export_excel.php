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

// Get application data
$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Create Excel file using simple HTML table
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan_Absensi_' . date('F_Y', strtotime($month . '-01')) . '.xls"');

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

// Get statistics
$total_siswa = count($student_data);
$total_hari_kerja = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], 
    "SELECT DISTINCT tanggal FROM absensi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$month'"));

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #4640DE; color: white; font-weight: bold; }
        .header { text-align: center; font-weight: bold; font-size: 14px; }
        .summary { background-color: #f0f0f0; font-weight: bold; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="9" class="header">
                <?= $d_aplikasi['nama_aplikasi']; ?><br>
                LAPORAN ABSENSI SISWA<br>
                Periode: <?= date('F Y', strtotime($month . '-01')); ?>
            </td>
        </tr>
        <tr><td colspan="9"></td></tr>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Total Hadir</th>
            <th>Total Izin</th>
            <th>Total Sakit</th>
            <th>Total Alpha</th>
            <th>Persentase Kehadiran</th>
        </tr>
        
        <?php
        $no = 1;
        $grand_total_hadir = 0;
        $grand_total_ijin = 0;
        $grand_total_sakit = 0;
        $grand_total_alpha = 0;
        
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
        
        <tr><td colspan="9"></td></tr>
        <tr class="summary">
            <td colspan="4">TOTAL</td>
            <td><?= $grand_total_hadir; ?></td>
            <td><?= $grand_total_ijin; ?></td>
            <td><?= $grand_total_sakit; ?></td>
            <td><?= $grand_total_alpha; ?></td>
            <td><?= $total_siswa > 0 ? round((($grand_total_hadir + $grand_total_ijin + $grand_total_sakit) / ($total_siswa * $total_hari_kerja)) * 100, 1) : 0; ?>%</td>
        </tr>
        
        <tr><td colspan="9"></td></tr>
        <tr>
            <td colspan="2"><strong>Total Siswa:</strong></td>
            <td><?= $total_siswa; ?> orang</td>
            <td colspan="2"><strong>Total Hari Kerja:</strong></td>
            <td><?= $total_hari_kerja; ?> hari</td>
            <td colspan="3"><strong>Tanggal Cetak:</strong> <?= date('d/m/Y H:i'); ?></td>
        </tr>
    </table>
</body>
</html>
