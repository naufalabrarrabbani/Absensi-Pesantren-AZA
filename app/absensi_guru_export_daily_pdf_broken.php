<?php
// Include mPDF library
require_once __DIR__ . '/lib/mpdf/mpdf_bootstrap.php';

include '../include/koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login.php');
    exit();
}

// Get parameters
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

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

// Calculate statistics
$total_guru = 0;
$total_present = 0;
$total_absent = 0;
$total_permission = 0;
$total_sick = 0;
$total_alpha = 0;
$attendance_data = [];

// Process data for statistics and storage
while ($data = mysqli_fetch_array($result)) {
    $total_guru++;
    
    // Determine status
    $status = '';
    $keterangan = '';
    
    if ($data['masuk'] && !$data['ijin'] && !$data['status_tidak_masuk']) {
        $status = 'Hadir';
        $keterangan = 'Masuk: ' . date('H:i', strtotime($data['masuk']));
        if ($data['pulang'] && $data['pulang'] != '0') {
            $keterangan .= ', Pulang: ' . date('H:i', strtotime($data['pulang']));
        }
        $total_present++;
    } elseif ($data['ijin']) {
        $status = 'Izin';
        $keterangan = 'Izin: ' . $data['ijin'];
        $total_permission++;
    } elseif ($data['status_tidak_masuk']) {
        $status = ucfirst($data['status_tidak_masuk']);
        $keterangan = 'Tidak masuk: ' . ucfirst($data['status_tidak_masuk']);
        $total_absent++;
        if ($data['status_tidak_masuk'] == 'sakit') $total_sick++;
        elseif ($data['status_tidak_masuk'] == 'izin') $total_permission++;
        elseif ($data['status_tidak_masuk'] == 'alpha') $total_alpha++;
    } else {
        $status = 'Alpha';
        $keterangan = 'Tidak ada data kehadiran';
        $total_absent++;
        $total_alpha++;
    }
    
    $attendance_data[] = [
        'nip' => $data['nip'],
        'nama' => $data['nama'],
        'jabatan' => $data['jabatan'],
        'masuk' => ($data['masuk'] && $status == 'Hadir') ? date('H:i', strtotime($data['masuk'])) : '-',
        'pulang' => ($data['pulang'] && $data['pulang'] != '0' && $status == 'Hadir') ? date('H:i', strtotime($data['pulang'])) : '-',
        'status' => $status,
        'keterangan' => $keterangan
    ];
}

// Create mPDF instance
try {
    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => __DIR__ . '/lib/mpdf/tmp',
        'format' => 'A4',
        'orientation' => 'P',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 20,
        'margin_bottom' => 20,
        'default_font_size' => 9,
        'default_font' => 'dejavusans'
    ]);

    // Build HTML content
    $html = '
    <style>
        body { 
            font-family: "DejaVu Sans", sans-serif; 
            font-size: 9px;
            color: #333;
            line-height: 1.3;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c3e50;
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header h2 {
            color: #34495e;
            margin: 0;
            font-size: 14px;
            font-weight: normal;
        }
        .info-table { 
            width: 100%; 
            margin-bottom: 20px; 
            border-collapse: collapse;
        }
        .info-table td { 
            padding: 6px 10px; 
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
            margin-bottom: 20px;
            font-size: 8px;
        }
        .data-table th, .data-table td { 
            border: 1px solid #333; 
            padding: 4px 3px; 
            text-align: left; 
        }
        .data-table th { 
            background-color: #2c3e50; 
            color: white;
            font-weight: bold; 
            text-align: center;
            font-size: 8px;
        }
        .data-table td {
            background-color: white;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
        .stats-table { 
            width: 65%; 
            margin: 15px 0; 
            border-collapse: collapse; 
        }
        .stats-table th, .stats-table td { 
            border: 1px solid #333; 
            padding: 6px 8px; 
            font-size: 9px;
        }
        .stats-table th { 
            background-color: #3498db; 
            color: white;
            text-align: center;
            font-size: 11px;
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
            margin-top: 20px;
            text-align: right;
            font-size: 7px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .status-hadir { color: #27ae60; font-weight: bold; }
        .status-sakit { color: #f39c12; font-weight: bold; }
        .status-izin { color: #3498db; font-weight: bold; }
        .status-alpha { color: #e74c3c; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
    
    <div class="header">
        <h1>' . htmlspecialchars($d_aplikasi['nama_aplikasi']) . '</h1>
        <h2>LAPORAN ABSENSI GURU HARIAN</h2>
    </div>

    <table class="info-table">
        <tr>
            <td>Tanggal</td>
            <td>' . date('d F Y', strtotime($selected_date)) . '</td>
        </tr>
        <tr>
            <td>Waktu Cetak</td>
            <td>' . date('d F Y H:i:s') . '</td>
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
        <tbody>';

    $no = 1;
    foreach ($attendance_data as $data) {
        $status_class = '';
        switch(strtolower($data['status'])) {
            case 'hadir': $status_class = 'status-hadir'; break;
            case 'sakit': $status_class = 'status-sakit'; break;
            case 'izin': $status_class = 'status-izin'; break;
            case 'alpha': $status_class = 'status-alpha'; break;
        }
        
        $html .= '
            <tr>
                <td class="text-center">' . $no++ . '</td>
                <td class="text-center">' . htmlspecialchars($data['nip']) . '</td>
                <td>' . htmlspecialchars($data['nama']) . '</td>
                <td>' . htmlspecialchars($data['jabatan']) . '</td>
                <td class="text-center">' . $data['masuk'] . '</td>
                <td class="text-center">' . $data['pulang'] . '</td>
                <td class="text-center ' . $status_class . '">' . $data['status'] . '</td>
                <td style="font-size: 7px;">' . htmlspecialchars($data['keterangan']) . '</td>
            </tr>';
    }

    $html .= '
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
                <td>Total Guru</td>
                <td>' . $total_guru . ' guru</td>
            </tr>
            <tr>
                <td>Hadir</td>
                <td class="status-hadir">' . $total_present . ' guru (' . ($total_guru > 0 ? round(($total_present / $total_guru) * 100, 1) : 0) . '%)</td>
            </tr>
            <tr>
                <td>Sakit</td>
                <td class="status-sakit">' . $total_sick . ' guru</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td class="status-izin">' . $total_permission . ' guru</td>
            </tr>
            <tr>
                <td>Alpha</td>
                <td class="status-alpha">' . $total_alpha . ' guru</td>
            </tr>
            <tr style="background-color: #ffebee;">
                <td>Total Tidak Hadir</td>
                <td>' . ($total_sick + $total_permission + $total_alpha) . ' guru (' . ($total_guru > 0 ? round((($total_sick + $total_permission + $total_alpha) / $total_guru) * 100, 1) : 0) . '%)</td>
            </tr>
            <tr style="background-color: #e8f5e8;">
                <td>Persentase Kehadiran</td>
                <td class="status-hadir">' . ($total_guru > 0 ? round(($total_present / $total_guru) * 100, 1) : 0) . '%</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: ' . date('d F Y H:i:s') . '</p>
        <p>Sistem Absensi ' . htmlspecialchars($d_aplikasi['nama_aplikasi']) . '</p>
    </div>';

    // Write HTML to PDF
    $mpdf->WriteHTML($html);

    // Set filename
    $filename = 'Laporan_Absensi_Guru_Harian_' . date('d-m-Y', strtotime($selected_date)) . '.pdf';

    // Output PDF
    $mpdf->Output($filename, 'D'); // D = Download

} catch (\Mpdf\MpdfException $e) {
    echo "Error creating PDF: " . $e->getMessage();
}
?>
