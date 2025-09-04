<?php
include '../../include/koneksi.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan']);
    exit;
}

$student_id = $_GET['id'];

// Query to get student details with class information
$query = "SELECT k.*, kl.nama_kelas, kl.tingkat 
          FROM karyawan k 
          LEFT JOIN kelas kl ON k.job_title = kl.kode_kelas 
          WHERE k.id = ?";
$stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($student = mysqli_fetch_assoc($result)) {
        // Add formatted class name
        if ($student['nama_kelas']) {
            $student['formatted_class'] = $student['nama_kelas'] . ' (' . $student['job_title'] . ')';
        } else {
            $student['formatted_class'] = $student['job_title'];
        }
        
        // Add formatted status
        $today = date('Y-m-d');
        $student['is_active'] = ($student['end_date'] && $student['end_date'] > $today);
        $student['status_text'] = $student['is_active'] ? 'Aktif' : 'Tidak Aktif';
        
        // Format dates for display
        if ($student['start_date']) {
            $student['start_date_formatted'] = date('d/m/Y', strtotime($student['start_date']));
        }
        if ($student['end_date']) {
            $student['end_date_formatted'] = date('d/m/Y', strtotime($student['end_date']));
        }
        
        echo json_encode([
            'success' => true,
            'student' => $student
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Data siswa tidak ditemukan'
        ]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error dalam query database: ' . mysqli_error($GLOBALS["___mysqli_ston"])
    ]);
}
?>
