<?php
session_start();
error_reporting(0);
include '../../include/koneksi.php';

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

// Set content type to JSON
header('Content-Type: application/json');

try {
    if ($_POST['action'] === 'cancel') {
        $nik = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nik']);
        $tanggal = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tanggal']);
        
        // Validate inputs
        if (empty($nik) || empty($tanggal)) {
            echo json_encode(['success' => false, 'message' => 'NIK dan tanggal harus diisi']);
            exit();
        }
        
        // Check if attendance record exists for this date
        $check_query = "SELECT * FROM absensi WHERE nik = '$nik' AND tanggal = '$tanggal'";
        $check_result = mysqli_query($GLOBALS["___mysqli_ston"], $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $attendance = mysqli_fetch_array($check_result);
            
            // Only allow canceling if student has absent status (ijin or status_tidak_masuk)
            if ($attendance['ijin'] || $attendance['status_tidak_masuk']) {
                // Delete the attendance record to allow new marking
                $delete_query = "DELETE FROM absensi WHERE nik = '$nik' AND tanggal = '$tanggal' AND (ijin IS NOT NULL OR status_tidak_masuk IS NOT NULL)";
                $delete_result = mysqli_query($GLOBALS["___mysqli_ston"], $delete_query);
                
                if ($delete_result) {
                    echo json_encode(['success' => true, 'message' => 'Status tidak masuk berhasil dibatalkan']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Gagal membatalkan status: ' . mysqli_error($GLOBALS["___mysqli_ston"])]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Siswa tidak memiliki status tidak masuk yang dapat dibatalkan']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Data absensi tidak ditemukan']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
}
?>
