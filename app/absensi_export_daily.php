<?php
include '../include/koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login.php');
    exit();
}

// Get parameters
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$selected_class = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$format = isset($_GET['format']) ? $_GET['format'] : 'excel';

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selected_date)) {
    $selected_date = date('Y-m-d');
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Build class filter
$class_filter = '';
$class_name = 'Semua Kelas';
if ($selected_class) {
    $class_filter = " AND k.job_title = '$selected_class'";
    $kelas_info = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama_kelas FROM kelas WHERE kode_kelas = '$selected_class'"));
    $class_name = $kelas_info ? $kelas_info['nama_kelas'] : $selected_class;
}

// Query for daily attendance data
$query = "SELECT k.nik, k.nama, k.job_title, k.foto, 
                 a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk,
                 kls.nama_kelas
          FROM karyawan k 
          LEFT JOIN absensi a ON k.nik = a.nik AND a.tanggal = '$selected_date'
          LEFT JOIN kelas kls ON k.job_title = kls.kode_kelas
          WHERE 1=1 $class_filter
          ORDER BY kls.tingkat ASC, k.nama ASC";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

if (!$result) {
    die("Error in query: " . mysqli_error($GLOBALS["___mysqli_ston"]));
}

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan_Absensi_Harian_' . date('d-m-Y', strtotime($selected_date)) . '_' . ($selected_class ? $selected_class : 'Semua_Kelas') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Calculate statistics
$total_students = 0;
$total_present = 0;
$total_absent = 0;
$total_permission = 0;
$total_sick = 0;
$total_alpha = 0;

// Process data for statistics
mysqli_data_seek($result, 0);
while ($data = mysqli_fetch_array($result)) {
    $total_students++;
    
    if ($data['masuk'] && !$data['ijin'] && !$data['status_tidak_masuk']) {
        $total_present++;
    } elseif ($data['ijin']) {
        $total_permission++;
    } elseif ($data['status_tidak_masuk']) {
        $total_absent++;
        if ($data['status_tidak_masuk'] == 'sakit') $total_sick++;
        elseif ($data['status_tidak_masuk'] == 'izin') $total_permission++;
        elseif ($data['status_tidak_masuk'] == 'alpha') $total_alpha++;
    } else {
        $total_absent++;
        $total_alpha++;
    }
}

// Reset result pointer
mysqli_data_seek($result, 0);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Harian</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .data-table th { background-color: #f2f2f2; font-weight: bold; }
        .stats-table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .stats-table th, .stats-table td { border: 1px solid #000; padding: 8px; }
        .stats-table th { background-color: #e6f3ff; }
    </style>
</head>
<body>
    <div class="header">
        <h2><?= $d_aplikasi['nama_aplikasi']; ?></h2>
        <h3>LAPORAN ABSENSI HARIAN</h3>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 150px;"><strong>Tanggal</strong></td>
            <td>: <?= date('d F Y', strtotime($selected_date)); ?></td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>: <?= $class_name; ?></td>
        </tr>
        <tr>
            <td><strong>Waktu Cetak</strong></td>
            <td>: <?= date('d F Y H:i:s'); ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">NISN</th>
                <th style="width: 25%;">Nama Siswa</th>
                <th style="width: 15%;">Kelas</th>
                <th style="width: 10%;">Jam Masuk</th>
                <th style="width: 10%;">Jam Pulang</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
                // Determine status
                $status = '';
                $keterangan = '';
                
                if ($data['masuk'] && !$data['ijin'] && !$data['status_tidak_masuk']) {
                    $status = 'Hadir';
                    $keterangan = 'Masuk: ' . date('H:i', strtotime($data['masuk']));
                    if ($data['pulang'] && $data['pulang'] != '0') {
                        $keterangan .= ', Pulang: ' . date('H:i', strtotime($data['pulang']));
                    }
                } elseif ($data['ijin']) {
                    $status = 'Izin';
                    $keterangan = 'Izin: ' . $data['ijin'];
                } elseif ($data['status_tidak_masuk']) {
                    $status = ucfirst($data['status_tidak_masuk']);
                    $keterangan = 'Tidak masuk: ' . ucfirst($data['status_tidak_masuk']);
                } else {
                    $status = 'Alpha';
                    $keterangan = 'Tidak ada data kehadiran';
                }
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nik']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['nama_kelas'] ?: $data['job_title']; ?></td>
                <td><?= ($data['masuk'] && $status == 'Hadir') ? date('H:i', strtotime($data['masuk'])) : '-'; ?></td>
                <td><?= ($data['pulang'] && $data['pulang'] != '0' && $status == 'Hadir') ? date('H:i', strtotime($data['pulang'])) : '-'; ?></td>
                <td><?= $status; ?></td>
                <td><?= $keterangan; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <table class="stats-table">
        <thead>
            <tr>
                <th colspan="2">STATISTIK KEHADIRAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Total Siswa</strong></td>
                <td><?= $total_students; ?> siswa</td>
            </tr>
            <tr>
                <td><strong>Hadir</strong></td>
                <td><?= $total_present; ?> siswa (<?= $total_students > 0 ? round(($total_present / $total_students) * 100, 1) : 0; ?>%)</td>
            </tr>
            <tr>
                <td><strong>Sakit</strong></td>
                <td><?= $total_sick; ?> siswa</td>
            </tr>
            <tr>
                <td><strong>Izin</strong></td>
                <td><?= $total_permission; ?> siswa</td>
            </tr>
            <tr>
                <td><strong>Alpha</strong></td>
                <td><?= $total_alpha; ?> siswa</td>
            </tr>
            <tr>
                <td><strong>Total Tidak Hadir</strong></td>
                <td><?= ($total_sick + $total_permission + $total_alpha); ?> siswa (<?= $total_students > 0 ? round((($total_sick + $total_permission + $total_alpha) / $total_students) * 100, 1) : 0; ?>%)</td>
            </tr>
            <tr>
                <td><strong>Persentase Kehadiran</strong></td>
                <td><?= $total_students > 0 ? round(($total_present / $total_students) * 100, 1) : 0; ?>%</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: <?= date('d F Y H:i:s'); ?></p>
        <p>Sistem Absensi <?= $d_aplikasi['nama_aplikasi']; ?></p>
    </div>
</body>
</html>
