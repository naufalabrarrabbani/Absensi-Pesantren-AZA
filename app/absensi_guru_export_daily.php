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
$format = isset($_GET['format']) ? $_GET['format'] : 'excel';

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selected_date)) {
    $selected_date = date('Y-m-d');
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Query for daily attendance data
$query = "SELECT g.nip, g.nama, g.jabatan, g.foto, 
                 a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk
          FROM guru g 
          LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$selected_date'
          ORDER BY g.nama ASC";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

if (!$result) {
    die("Error in query: " . mysqli_error($GLOBALS["___mysqli_ston"]));
}

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan_Absensi_Guru_Harian_' . date('d-m-Y', strtotime($selected_date)) . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Calculate statistics
$total_guru = 0;
$total_present = 0;
$total_absent = 0;
$total_permission = 0;
$total_sick = 0;
$total_alpha = 0;

// Process data for statistics
mysqli_data_seek($result, 0);
while ($data = mysqli_fetch_array($result)) {
    $total_guru++;
    
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
    <title>Laporan Absensi Guru Harian</title>
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
        <h3>LAPORAN ABSENSI GURU HARIAN</h3>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 150px;"><strong>Tanggal</strong></td>
            <td>: <?= date('d F Y', strtotime($selected_date)); ?></td>
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
                <th style="width: 15%;">NIP</th>
                <th style="width: 25%;">Nama Guru</th>
                <th style="width: 15%;">Jabatan</th>
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
                <td><?= $data['nip']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['jabatan']; ?></td>
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
                <td><strong>Total Guru</strong></td>
                <td><?= $total_guru; ?> guru</td>
            </tr>
            <tr>
                <td><strong>Hadir</strong></td>
                <td><?= $total_present; ?> guru (<?= $total_guru > 0 ? round(($total_present / $total_guru) * 100, 1) : 0; ?>%)</td>
            </tr>
            <tr>
                <td><strong>Sakit</strong></td>
                <td><?= $total_sick; ?> guru</td>
            </tr>
            <tr>
                <td><strong>Izin</strong></td>
                <td><?= $total_permission; ?> guru</td>
            </tr>
            <tr>
                <td><strong>Alpha</strong></td>
                <td><?= $total_alpha; ?> guru</td>
            </tr>
            <tr>
                <td><strong>Total Tidak Hadir</strong></td>
                <td><?= ($total_sick + $total_permission + $total_alpha); ?> guru (<?= $total_guru > 0 ? round((($total_sick + $total_permission + $total_alpha) / $total_guru) * 100, 1) : 0; ?>%)</td>
            </tr>
            <tr>
                <td><strong>Persentase Kehadiran</strong></td>
                <td><?= $total_guru > 0 ? round(($total_present / $total_guru) * 100, 1) : 0; ?>%</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: <?= date('d F Y H:i:s'); ?></p>
        <p>Sistem Absensi <?= $d_aplikasi['nama_aplikasi']; ?></p>
    </div>
</body>
</html>
