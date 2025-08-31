<?php
require_once '../include/koneksi.php';

// Check connection
if (!$GLOBALS["___mysqli_ston"]) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get parameters
$mode = $_GET['mode'] ?? 'daily';
$date = $_GET['date'] ?? date('Y-m-d');
$subject = $_GET['subject'] ?? '';
$action = $_GET['action'] ?? '';

// Handle get subjects action
if ($action === 'get_subjects') {
    $query = "SELECT DISTINCT mata_pelajaran FROM guru WHERE mata_pelajaran IS NOT NULL AND mata_pelajaran != '' ORDER BY mata_pelajaran";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    
    $subjects = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subjects[] = $row['mata_pelajaran'];
    }
    
    echo json_encode([
        'success' => true,
        'subjects' => $subjects
    ]);
    exit;
}

try {
    if ($mode === 'daily') {
        // Daily mode - show today's attendance
        $data = getDailyAttendance($date, $subject);
        $statistics = getDailyStatistics($date, $subject);
    } else {
        // Monthly mode - show monthly summary
        $month = date('Y-m', strtotime($date));
        $data = getMonthlyAttendance($month, $subject);
        $statistics = getMonthlyStatistics($month, $subject);
    }
    
    echo json_encode([
        'success' => true,
        'data' => $data,
        'statistics' => $statistics,
        'mode' => $mode,
        'date' => $date
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

function getDailyAttendance($date, $subject) {
    $subjectFilter = '';
    if ($subject) {
        $subjectFilter = "AND g.mata_pelajaran = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $subject) . "'";
    }
    
    $query = "
        SELECT 
            g.nip,
            g.nama,
            g.mata_pelajaran,
            g.foto_guru as photo,
            a.jam_masuk,
            a.jam_keluar,
            a.ijin,
            a.status_tidak_masuk,
            a.keterangan,
            a.tanggal
        FROM guru g
        LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$date'
        WHERE 1=1 $subjectFilter
        ORDER BY g.nama
    ";
    
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    if (!$result) {
        throw new Exception("Query error: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'mata_pelajaran' => $row['mata_pelajaran'] ?: '-',
            'photo' => $row['photo'],
            'jam_masuk' => $row['jam_masuk'],
            'jam_keluar' => $row['jam_keluar'],
            'ijin' => $row['ijin'],
            'status_tidak_masuk' => $row['status_tidak_masuk'],
            'keterangan' => $row['keterangan'],
            'status' => determineStatus($row),
            'last_attendance' => formatLastAttendance($row),
            'is_late' => isLate($row['jam_masuk'])
        ];
    }
    
    return $data;
}

function getMonthlyAttendance($month, $subject) {
    $subjectFilter = '';
    if ($subject) {
        $subjectFilter = "AND g.mata_pelajaran = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $subject) . "'";
    }
    
    $query = "
        SELECT 
            g.nip,
            g.nama,
            g.mata_pelajaran,
            g.foto_guru as photo,
            COUNT(CASE WHEN a.jam_masuk IS NOT NULL THEN 1 END) as total_hadir,
            COUNT(CASE WHEN a.ijin = 1 OR a.status_tidak_masuk = 'izin' THEN 1 END) as total_ijin,
            COUNT(CASE WHEN a.status_tidak_masuk = 'alpha' THEN 1 END) as total_alpha,
            COUNT(CASE WHEN a.status_tidak_masuk = 'sakit' THEN 1 END) as total_sakit,
            MAX(a.tanggal) as last_attendance_date,
            MAX(CASE WHEN a.jam_masuk IS NOT NULL THEN a.jam_masuk END) as last_jam_masuk
        FROM guru g
        LEFT JOIN absensi_guru a ON g.nip = a.nip 
            AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$month'
        WHERE 1=1 $subjectFilter
        GROUP BY g.nip, g.nama, g.mata_pelajaran, g.foto_guru
        ORDER BY g.nama
    ";
    
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    if (!$result) {
        throw new Exception("Query error: " . mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'nip' => $row['nip'],
            'nama' => $row['nama'],
            'mata_pelajaran' => $row['mata_pelajaran'] ?: '-',
            'photo' => $row['photo'],
            'total_hadir' => (int)$row['total_hadir'],
            'total_ijin' => (int)$row['total_ijin'],
            'total_alpha' => (int)$row['total_alpha'],
            'total_sakit' => (int)$row['total_sakit'],
            'status' => determineMonthlyStatus($row),
            'status_text' => getMonthlyStatusText($row),
            'last_attendance' => $row['last_attendance_date'] ? 
                date('d/m/Y', strtotime($row['last_attendance_date'])) . 
                ($row['last_jam_masuk'] ? ' (' . $row['last_jam_masuk'] . ')' : '') : '-'
        ];
    }
    
    return $data;
}

function getDailyStatistics($date, $subject) {
    $subjectFilter = '';
    if ($subject) {
        $subjectFilter = "AND g.mata_pelajaran = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $subject) . "'";
    }
    
    $query = "
        SELECT 
            COUNT(g.nip) as total,
            COUNT(CASE WHEN a.jam_masuk IS NOT NULL THEN 1 END) as hadir,
            COUNT(CASE WHEN a.ijin = 1 OR a.status_tidak_masuk IN ('izin', 'sakit') THEN 1 END) as ijin,
            COUNT(CASE WHEN a.status_tidak_masuk = 'alpha' OR (a.jam_masuk IS NULL AND a.ijin IS NULL AND a.status_tidak_masuk IS NULL) THEN 1 END) as alpha
        FROM guru g
        LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$date'
        WHERE 1=1 $subjectFilter
    ";
    
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    return mysqli_fetch_assoc($result);
}

function getMonthlyStatistics($month, $subject) {
    $subjectFilter = '';
    if ($subject) {
        $subjectFilter = "AND g.mata_pelajaran = '" . mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $subject) . "'";
    }
    
    $query = "
        SELECT 
            COUNT(DISTINCT g.nip) as total,
            COUNT(DISTINCT CASE WHEN a.jam_masuk IS NOT NULL THEN g.nip END) as hadir,
            COUNT(DISTINCT CASE WHEN a.ijin = 1 OR a.status_tidak_masuk IN ('izin', 'sakit') THEN g.nip END) as ijin,
            COUNT(DISTINCT CASE WHEN a.status_tidak_masuk = 'alpha' THEN g.nip END) as alpha
        FROM guru g
        LEFT JOIN absensi_guru a ON g.nip = a.nip 
            AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$month'
        WHERE 1=1 $subjectFilter
    ";
    
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    return mysqli_fetch_assoc($result);
}

function determineStatus($row) {
    if ($row['jam_masuk']) {
        return isLate($row['jam_masuk']) ? 'late' : 'present';
    } elseif ($row['ijin'] || in_array($row['status_tidak_masuk'], ['izin', 'sakit'])) {
        return 'permission';
    } else {
        return 'absent';
    }
}

function determineMonthlyStatus($row) {
    $total_hadir = (int)$row['total_hadir'];
    $total_absent = (int)$row['total_ijin'] + (int)$row['total_alpha'] + (int)$row['total_sakit'];
    
    if ($total_hadir > $total_absent) {
        return 'present';
    } elseif ($total_absent > 0) {
        return 'permission';
    } else {
        return 'absent';
    }
}

function getMonthlyStatusText($row) {
    $total_hadir = (int)$row['total_hadir'];
    $total_ijin = (int)$row['total_ijin'];
    $total_alpha = (int)$row['total_alpha'];
    $total_sakit = (int)$row['total_sakit'];
    
    if ($total_hadir > 0) {
        return "Hadir: {$total_hadir} hari";
    } elseif ($total_ijin + $total_alpha + $total_sakit > 0) {
        $details = [];
        if ($total_ijin > 0) $details[] = "Izin: $total_ijin";
        if ($total_sakit > 0) $details[] = "Sakit: $total_sakit";
        if ($total_alpha > 0) $details[] = "Alpha: $total_alpha";
        return implode(", ", $details);
    } else {
        return "Tidak Ada Data";
    }
}

function formatLastAttendance($row) {
    if ($row['jam_masuk']) {
        return $row['jam_masuk'];
    } elseif ($row['ijin'] || $row['status_tidak_masuk']) {
        return $row['keterangan'] ?: 'Tidak hadir';
    } else {
        return '-';
    }
}

function isLate($jam_masuk) {
    if (!$jam_masuk) return false;
    
    $cutoff_time = '08:00:00';
    return $jam_masuk > $cutoff_time;
}
?>

if ($mode === 'daily') {
    // Query untuk data harian
    $mapel_filter = $mapel ? "AND g.mata_pelajaran = '$mapel'" : "";
    
    $query = "SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
              FROM guru g 
              LEFT JOIN absensi_guru a ON g.nip = a.nip AND a.tanggal = '$date'
              WHERE 1=1 $mapel_filter
              ORDER BY g.nama ASC";
    
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    
    $teachers = array();
    $stats = array('total' => 0, 'hadir' => 0, 'tidak_hadir' => 0);
    
    while ($data = mysqli_fetch_array($result)) {
        $stats['total']++;
        
        // Determine status
        $status = 'absent';
        $status_text = 'Belum Absen';
        $status_class = 'status-absent';
        $keterangan = '';
        
        if ($data['ijin']) {
            $status = 'permission';
            $status_text = 'Izin';
            $status_class = 'status-permission';
            $keterangan = $data['ijin'];
            $stats['tidak_hadir']++;
        } elseif ($data['status_tidak_masuk']) {
            $status = 'absent';
            $status_text = ucfirst($data['status_tidak_masuk']);
            $status_class = 'status-absent';
            $keterangan = ucfirst($data['status_tidak_masuk']);
            $stats['tidak_hadir']++;
        } elseif ($data['masuk']) {
            $status = 'present';
            $status_text = 'Hadir';
            $status_class = 'status-present';
            $keterangan = 'Masuk: ' . date('H:i', strtotime($data['masuk']));
            if ($data['pulang'] && $data['pulang'] != '0000-00-00 00:00:00') {
                $keterangan .= ', Pulang: ' . date('H:i', strtotime($data['pulang']));
            }
            $stats['hadir']++;
        } else {
            $stats['tidak_hadir']++;
        }
        
        $teachers[] = array(
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'mata_pelajaran' => $data['mata_pelajaran'] ?: 'Belum ditentukan',
            'foto' => $data['foto'] ?: 'default-avatar.png',
            'masuk' => $data['masuk'] ? date('H:i', strtotime($data['masuk'])) : '-',
            'pulang' => ($data['pulang'] && $data['pulang'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($data['pulang'])) : '-',
            'status' => $status,
            'status_text' => $status_text,
            'status_class' => $status_class,
            'keterangan' => $keterangan,
            'tanggal' => $data['tanggal']
        );
    }
    
    $response = array(
        'mode' => 'daily',
        'date' => $date,
        'teachers' => $teachers,
        'stats' => $stats
    );
    
} else {
    // Query untuk data bulanan
    $mapel_filter = $mapel ? "AND g.mata_pelajaran = '$mapel'" : "";
    
    $query = "SELECT g.*, a.tanggal, a.masuk, a.pulang, a.ijin, a.status_tidak_masuk 
              FROM guru g 
              LEFT JOIN absensi_guru a ON g.nip = a.nip AND DATE_FORMAT(a.tanggal, '%Y-%m') = '$month'
              WHERE 1=1 $mapel_filter
              ORDER BY g.nama ASC, a.tanggal DESC";
    
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    
    $teacher_data = array();
    $stats = array('total_masuk' => 0, 'total_tidak_hadir' => 0);
    
    while ($data = mysqli_fetch_array($result)) {
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
    
    $teachers = array();
    foreach ($teacher_data as $nip => $teacher) {
        $data = $teacher['info'];
        $attendance_records = $teacher['attendance'];
        
        $total_hadir = 0;
        $total_ijin = 0;
        $total_alpha = 0;
        $total_sakit = 0;
        $last_attendance = null;
        
        foreach ($attendance_records as $record) {
            if ($record['ijin']) {
                $total_ijin++;
            } elseif ($record['masuk']) {
                $total_hadir++;
                $stats['total_masuk']++;
            } elseif ($record['status_tidak_masuk']) {
                if ($record['status_tidak_masuk'] == 'alpha') $total_alpha++;
                elseif ($record['status_tidak_masuk'] == 'sakit') $total_sakit++;
                elseif ($record['status_tidak_masuk'] == 'izin') $total_ijin++;
                $stats['total_tidak_hadir']++;
            }
            if (!$last_attendance || $record['tanggal'] > $last_attendance['tanggal']) {
                $last_attendance = $record;
            }
        }
        
        // Determine overall status for the month
        if ($total_hadir > ($total_ijin + $total_alpha + $total_sakit)) {
            $status = 'present';
            $status_text = "Hadir ($total_hadir hari)";
            $status_class = 'status-present';
        } elseif (($total_ijin + $total_sakit + $total_alpha) > 0) {
            $status = 'permission';
            $absence_details = [];
            if ($total_ijin > 0) $absence_details[] = "Izin: $total_ijin";
            if ($total_sakit > 0) $absence_details[] = "Sakit: $total_sakit";
            if ($total_alpha > 0) $absence_details[] = "Alpha: $total_alpha";
            $status_text = implode(", ", $absence_details);
            $status_class = 'status-permission';
        } else {
            $status = 'absent';
            $status_text = "Tidak Ada Data";
            $status_class = 'status-absent';
        }
        
        $teachers[] = array(
            'nip' => $data['nip'],
            'nama' => $data['nama'],
            'mata_pelajaran' => $data['mata_pelajaran'] ?: 'Belum ditentukan',
            'foto' => $data['foto'] ?: 'default-avatar.png',
            'masuk' => ($last_attendance && $last_attendance['masuk']) ? date('H:i', strtotime($last_attendance['masuk'])) : '-',
            'pulang' => ($last_attendance && $last_attendance['pulang'] && $last_attendance['pulang'] != '0000-00-00 00:00:00') ? date('H:i', strtotime($last_attendance['pulang'])) : '-',
            'status' => $status,
            'status_text' => $status_text,
            'status_class' => $status_class,
            'keterangan' => $status_text,
            'last_date' => $last_attendance ? $last_attendance['tanggal'] : null
        );
    }
    
    $response = array(
        'mode' => 'monthly',
        'month' => $month,
        'teachers' => $teachers,
        'stats' => $stats
    );
}

header('Content-Type: application/json');
echo json_encode($response);
?>
