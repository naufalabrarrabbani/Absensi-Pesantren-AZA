<?php
include '../include/koneksi.php';

// Start session
session_start();

if (!isset($_SESSION['level'])) {
    header('location:../login.php');
    exit();
}

$format = isset($_GET['format']) ? $_GET['format'] : 'excel';
$is_daily = isset($_GET['date']);
$mapel_filter = isset($_GET['mata_pelajaran']) ? $_GET['mata_pelajaran'] : '';

// Build mata pelajaran condition with proper escaping
$mapel_condition = "";
if ($mapel_filter && $mapel_filter != '') {
    $mapel_filter_escaped = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $mapel_filter);
    $mapel_condition = " AND g.mata_pelajaran = '$mapel_filter_escaped'";
}

if ($is_daily) {
    $selected_date = $_GET['date'];
    $filename = "absensi_guru_" . $selected_date;
} else {
    $selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
    $filename = "absensi_guru_" . $selected_month;
}

if ($mapel_filter) {
    $filename .= "_" . str_replace(' ', '_', $mapel_filter);
}

if ($format === 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
    header('Cache-Control: max-age=0');
    
    echo '<html>';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<style>';
    echo 'table { border-collapse: collapse; width: 100%; }';
    echo 'th, td { border: 1px solid #000; padding: 8px; text-align: left; }';
    echo 'th { background-color: #f2f2f2; font-weight: bold; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    
    echo '<h2>Data Absensi Guru</h2>';
    echo '<p>Periode: ' . ($is_daily ? date('d F Y', strtotime($selected_date)) : date('F Y', strtotime($selected_month . '-01'))) . '</p>';
    if ($mapel_filter) {
        echo '<p>Mata Pelajaran: ' . $mapel_filter . '</p>';
    }
    
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>No</th>';
    echo '<th>Nama Guru</th>';
    echo '<th>NIP</th>';
    echo '<th>Mata Pelajaran</th>';
    if ($is_daily) {
        echo '<th>Tanggal</th>';
        echo '<th>Jam Masuk</th>';
        echo '<th>Jam Pulang</th>';
        echo '<th>Status</th>';
        echo '<th>Keterangan</th>';
    } else {
        echo '<th>Total Hadir</th>';
        echo '<th>Total Izin</th>';
        echo '<th>Total Sakit</th>';
        echo '<th>Total Alpha</th>';
        echo '<th>Persentase Kehadiran</th>';
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    $no = 1;
    
    if ($is_daily) {
        // Daily export
        $attendance = mysqli_query($GLOBALS["___mysqli_ston"], "
            SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
            FROM guru g 
            LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$selected_date'
            WHERE 1=1 $mapel_condition
            ORDER BY g.nama ASC
        ");
        
        while ($data = mysqli_fetch_array($attendance)) {
            if ($data['ijin']) {
                $status = "Izin";
                $keterangan = $data['ijin'];
            } elseif ($data['status_tidak_masuk']) {
                $status = ucfirst($data['status_tidak_masuk']);
                $keterangan = "Status: " . ucfirst($data['status_tidak_masuk']);
            } elseif ($data['masuk']) {
                $status = "Hadir";
                $keterangan = "-";
            } else {
                $status = "Tidak Ada Data";
                $keterangan = "-";
            }
            
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $data['nama'] . '</td>';
            echo '<td>' . $data['nip'] . '</td>';
            echo '<td>' . ($data['mata_pelajaran'] ?: 'Belum ditentukan') . '</td>';
            echo '<td>' . date('d/m/Y', strtotime($selected_date)) . '</td>';
            echo '<td>' . ($data['masuk'] ? date('H:i', strtotime($data['masuk'])) : '-') . '</td>';
            echo '<td>' . ($data['pulang'] && $data['pulang'] != '0' ? date('H:i', strtotime($data['pulang'])) : '-') . '</td>';
            echo '<td>' . $status . '</td>';
            echo '<td>' . $keterangan . '</td>';
            echo '</tr>';
        }
    } else {
        // Monthly export
        $attendance = mysqli_query($GLOBALS["___mysqli_ston"], "
            SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
            FROM guru g 
            LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$selected_month'
            WHERE 1=1 $mapel_condition
            ORDER BY g.nama ASC, a.tanggal DESC
        ");
        
        $teacher_data = array();
        while ($data = mysqli_fetch_array($attendance)) {
            if (!isset($teacher_data[$data['nip']])) {
                $teacher_data[$data['nip']] = array(
                    'info' => $data,
                    'attendance' => array()
                );
            }
            if ($data['tanggal']) {
                $teacher_data[$data['nip']]['attendance'][] = $data;
            }
        }
        
        foreach ($teacher_data as $nip => $teacher) {
            $data = $teacher['info'];
            $attendance_records = $teacher['attendance'];
            
            $total_hadir = 0;
            $total_ijin = 0;
            $total_alpha = 0;
            $total_sakit = 0;
            
            foreach ($attendance_records as $record) {
                if ($record['ijin']) {
                    $total_ijin++;
                } elseif ($record['masuk']) {
                    $total_hadir++;
                } elseif ($record['status_tidak_masuk']) {
                    if ($record['status_tidak_masuk'] == 'alpha') $total_alpha++;
                    elseif ($record['status_tidak_masuk'] == 'sakit') $total_sakit++;
                    elseif ($record['status_tidak_masuk'] == 'izin') $total_ijin++;
                }
            }
            
            $total_days = count($attendance_records);
            $percentage = $total_days > 0 ? round(($total_hadir / $total_days) * 100, 1) : 0;
            
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $data['nama'] . '</td>';
            echo '<td>' . $data['nip'] . '</td>';
            echo '<td>' . ($data['mata_pelajaran'] ?: 'Belum ditentukan') . '</td>';
            echo '<td>' . $total_hadir . '</td>';
            echo '<td>' . $total_ijin . '</td>';
            echo '<td>' . $total_sakit . '</td>';
            echo '<td>' . $total_alpha . '</td>';
            echo '<td>' . $percentage . '%</td>';
            echo '</tr>';
        }
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</body>';
    echo '</html>';
    
} else {
    // PDF format would require additional libraries like TCPDF or mPDF
    echo "PDF format not implemented yet";
}
?>
