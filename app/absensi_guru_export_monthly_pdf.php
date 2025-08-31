<?php
include '../include/koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login.php');
    exit();
}

// Get parameters
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$selected_mapel = isset($_GET['mapel']) ? urldecode($_GET['mapel']) : '';

// Validate month format
if (!preg_match('/^\d{4}-\d{2}$/', $selected_month)) {
    $selected_month = date('Y-m');
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Build subject filter
$mapel_filter = '';
$mapel_name = 'Semua Mata Pelajaran';
if ($selected_mapel) {
    $selected_mapel_escaped = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $selected_mapel);
    $mapel_filter = " AND g.mata_pelajaran = '$selected_mapel_escaped'";
    $mapel_name = $selected_mapel;
}

// Get attendance data for the month
$attendance_query = "
    SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
    FROM guru g 
    LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
    WHERE 1=1 $mapel_filter
    ORDER BY g.nama ASC, a.tanggal DESC
";

$attendance_result = mysqli_query($GLOBALS["___mysqli_ston"], $attendance_query);
$teacher_data = array();

// Process attendance data
while ($data = mysqli_fetch_array($attendance_result)) {
    if (!isset($teacher_data[$data['nip']])) {
        $teacher_data[$data['nip']] = array(
            'info' => $data,
            'attendance' => array(),
            'total_hadir' => 0,
            'total_sakit' => 0,
            'total_izin' => 0,
            'total_alpha' => 0
        );
    }
    if ($data['tanggal']) {
        $teacher_data[$data['nip']]['attendance'][] = $data;
        
        // Count attendance statistics
        if ($data['masuk'] && !$data['ijin'] && !$data['status_tidak_masuk']) {
            $teacher_data[$data['nip']]['total_hadir']++;
        } elseif ($data['ijin']) {
            $teacher_data[$data['nip']]['total_izin']++;
        } elseif ($data['status_tidak_masuk'] == 'sakit') {
            $teacher_data[$data['nip']]['total_sakit']++;
        } else {
            $teacher_data[$data['nip']]['total_alpha']++;
        }
    }
}

// Get total working days in the month
$total_working_days_query = "SELECT COUNT(DISTINCT tanggal) as total_days 
                            FROM absensi_guru 
                            WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$selected_month'";
$total_working_days_result = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], $total_working_days_query));
$total_working_days = $total_working_days_result['total_days'] ?: 0;

// Calculate overall statistics
$total_teachers = count($teacher_data);
$total_present_all = 0;
$total_sick_all = 0;
$total_permission_all = 0;
$total_alpha_all = 0;

foreach ($teacher_data as $teacher) {
    $total_present_all += $teacher['total_hadir'];
    $total_sick_all += $teacher['total_sakit'];
    $total_permission_all += $teacher['total_izin'];
    $total_alpha_all += $teacher['total_alpha'];
}

$filename = 'Laporan_Absensi_Guru_Bulanan_' . date('m-Y', strtotime($selected_month . '-01')) . '.html';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Guru Bulanan - <?= date('F Y', strtotime($selected_month . '-01')) ?></title>
    <style>
        @media print {
            @page { 
                size: A4; 
                margin: 15mm;
            }
            body { 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
        }
        
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10px;
            color: #333;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
        }
        
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #2c3e50;
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        .header h2 {
            color: #34495e;
            margin: 0;
            font-size: 12px;
            font-weight: normal;
        }
        
        .info-table { 
            width: 100%; 
            margin-bottom: 15px; 
            border-collapse: collapse;
        }
        
        .info-table td { 
            padding: 5px 8px; 
            border: 1px solid #ddd;
            font-size: 9px;
        }
        
        .info-table td:first-child {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 120px;
        }
        
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 15px;
            font-size: 7px;
        }
        
        .data-table th, .data-table td { 
            border: 1px solid #333; 
            padding: 2px 1px; 
            text-align: center; 
        }
        
        .data-table th { 
            background-color: #2c3e50; 
            color: white;
            font-weight: bold; 
            text-align: center;
            font-size: 7px;
        }
        
        .data-table td {
            background-color: white;
        }
        
        .data-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
        
        .data-table .nama-column {
            text-align: left;
            width: 15%;
        }
        
        .stats-table { 
            width: 70%; 
            margin: 10px 0; 
            border-collapse: collapse; 
        }
        
        .stats-table th, .stats-table td { 
            border: 1px solid #333; 
            padding: 5px; 
            font-size: 8px;
        }
        
        .stats-table th { 
            background-color: #3498db; 
            color: white;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
        }
        
        .stats-table td:first-child {
            background-color: #ecf0f1;
            font-weight: bold;
        }
        
        .stats-table td:last-child {
            text-align: right;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        
        .status-hadir { color: #27ae60; font-weight: bold; }
        .status-sakit { color: #f39c12; font-weight: bold; }
        .status-izin { color: #3498db; font-weight: bold; }
        .status-alpha { color: #e74c3c; font-weight: bold; }
        .text-center { text-align: center; }
        
        @media screen {
            .print-controls {
                position: fixed;
                top: 10px;
                right: 10px;
                background: #fff;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                z-index: 1000;
            }
            .print-controls button {
                background: #007bff;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 3px;
                cursor: pointer;
                margin: 0 5px;
            }
            .print-controls button:hover {
                background: #0056b3;
            }
        }
        
        @media print {
            .print-controls { display: none; }
        }
    </style>
</head>
<body>
    <div class="print-controls">
        <button onclick="window.print()">🖨️ Print/Save as PDF</button>
        <button onclick="window.close()">❌ Close</button>
    </div>

    <div class="header">
        <h1><?= htmlspecialchars($d_aplikasi['nama_aplikasi']) ?></h1>
        <h2>LAPORAN ABSENSI GURU BULANAN</h2>
    </div>

    <table class="info-table">
        <tr>
            <td>Bulan</td>
            <td><?= date('F Y', strtotime($selected_month . '-01')) ?></td>
        </tr>
        <tr>
            <td>Mata Pelajaran</td>
            <td><?= htmlspecialchars($mapel_name) ?></td>
        </tr>
        <tr>
            <td>Total Hari Kerja</td>
            <td><?= $total_working_days ?> hari</td>
        </tr>
        <tr>
            <td>Waktu Cetak</td>
            <td><?= date('d F Y H:i:s') ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">NIP</th>
                <th class="nama-column">Nama Guru</th>
                <th style="width: 15%;">Mata Pelajaran</th>
                <th style="width: 8%;">Jabatan</th>
                <th style="width: 6%;">Hadir</th>
                <th style="width: 6%;">Sakit</th>
                <th style="width: 6%;">Izin</th>
                <th style="width: 6%;">Alpha</th>
                <th style="width: 8%;">% Kehadiran</th>
                <th style="width: 17%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            foreach ($teacher_data as $nip => $teacher): 
                $total_attendance = $teacher['total_hadir'] + $teacher['total_sakit'] + $teacher['total_izin'] + $teacher['total_alpha'];
                $attendance_percentage = $total_attendance > 0 ? round(($teacher['total_hadir'] / $total_attendance) * 100, 1) : 0;
                
                // Generate keterangan
                $keterangan_parts = [];
                if ($teacher['total_hadir'] > 0) $keterangan_parts[] = "H: {$teacher['total_hadir']}";
                if ($teacher['total_sakit'] > 0) $keterangan_parts[] = "S: {$teacher['total_sakit']}";
                if ($teacher['total_izin'] > 0) $keterangan_parts[] = "I: {$teacher['total_izin']}";
                if ($teacher['total_alpha'] > 0) $keterangan_parts[] = "A: {$teacher['total_alpha']}";
                $keterangan = implode(', ', $keterangan_parts);
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= htmlspecialchars($teacher['info']['nip']) ?></td>
                <td style="text-align: left; font-size: 6px;"><?= htmlspecialchars($teacher['info']['nama']) ?></td>
                <td style="font-size: 6px;"><?= htmlspecialchars($teacher['info']['mata_pelajaran'] ?: 'Tidak ada') ?></td>
                <td style="font-size: 6px;"><?= htmlspecialchars($teacher['info']['jabatan'] ?: '-') ?></td>
                <td class="text-center status-hadir"><?= $teacher['total_hadir'] ?></td>
                <td class="text-center status-sakit"><?= $teacher['total_sakit'] ?></td>
                <td class="text-center status-izin"><?= $teacher['total_izin'] ?></td>
                <td class="text-center status-alpha"><?= $teacher['total_alpha'] ?></td>
                <td class="text-center">
                    <span class="<?= $attendance_percentage >= 80 ? 'status-hadir' : 'status-alpha' ?>">
                        <?= $attendance_percentage ?>%
                    </span>
                </td>
                <td style="font-size: 6px;"><?= $keterangan ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="stats-table">
        <thead>
            <tr>
                <th colspan="2">STATISTIK KEHADIRAN GURU BULANAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Guru</td>
                <td><?= $total_teachers ?> guru</td>
            </tr>
            <tr>
                <td>Total Hari Kerja</td>
                <td><?= $total_working_days ?> hari</td>
            </tr>
            <tr>
                <td>Total Kehadiran</td>
                <td class="status-hadir"><?= $total_present_all ?> hari guru</td>
            </tr>
            <tr>
                <td>Total Sakit</td>
                <td class="status-sakit"><?= $total_sick_all ?> hari guru</td>
            </tr>
            <tr>
                <td>Total Izin</td>
                <td class="status-izin"><?= $total_permission_all ?> hari guru</td>
            </tr>
            <tr>
                <td>Total Alpha</td>
                <td class="status-alpha"><?= $total_alpha_all ?> hari guru</td>
            </tr>
            <tr style="background-color: #e8f5e8;">
                <td>Rata-rata Kehadiran</td>
                <td class="status-hadir">
                    <?php 
                    $total_possible = $total_teachers * $total_working_days;
                    $overall_percentage = $total_possible > 0 ? round(($total_present_all / $total_possible) * 100, 1) : 0;
                    echo $overall_percentage . '%';
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: <?= date('d F Y H:i:s') ?></p>
        <p>Sistem Absensi <?= htmlspecialchars($d_aplikasi['nama_aplikasi']) ?></p>
    </div>
</body>
</html>
