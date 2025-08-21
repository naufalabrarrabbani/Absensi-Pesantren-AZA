<?php
include '../include/koneksi.php';

if ($_POST) {
    $nama = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama']);
    $nip = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nip']);
    $mata_pelajaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['mata_pelajaran']);
    $no_telp = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['no_telp']);
    $jenis_kelamin = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jenis_kelamin']);
    $agama = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['agama'] ?? '');
    $lokasi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lokasi'] ?? '');
    $area = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['area'] ?? '');
    $sub_area = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['sub_area'] ?? '');
    
    // Handle file upload for photo
    $foto_name = '';
    $debug_message = '';
    
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $debug_message = 'Processing file upload from field: file';
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) { // 2MB limit
            $foto_name = $nip . '_' . time() . '.' . $file_ext;
            $upload_path = '../app/images/guru/' . $foto_name;
            
            // Create directory if it doesn't exist
            if (!file_exists('../app/images/guru/')) {
                mkdir('../app/images/guru/', 0777, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Copy juga ke images/guru untuk konsistensi akses
                $public_path = '../images/guru/' . $foto_name;
                if (!file_exists('../images/guru/')) {
                    mkdir('../images/guru/', 0777, true);
                }
                copy($upload_path, $public_path);
                $debug_message .= ' - Upload successful and copied to public folder';
            } else {
                $foto_name = '';
                $debug_message .= ' - Upload failed';
            }
        } else {
            $debug_message .= ' - File type/size invalid';
        }
    } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $debug_message = 'Processing file upload from field: foto';
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_size = $_FILES['foto']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) { // 2MB limit
            $foto_name = $nip . '_' . time() . '.' . $file_ext;
            $upload_path = '../app/images/guru/' . $foto_name;
            
            // Create directory if it doesn't exist
            if (!file_exists('../app/images/guru/')) {
                mkdir('../app/images/guru/', 0777, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Copy juga ke images/guru untuk konsistensi akses
                $public_path = '../images/guru/' . $foto_name;
                if (!file_exists('../images/guru/')) {
                    mkdir('../images/guru/', 0777, true);
                }
                copy($upload_path, $public_path);
                $debug_message .= ' - Upload successful and copied to public folder';
            } else {
                $foto_name = '';
                $debug_message .= ' - Upload failed';
            }
        } else {
            $debug_message .= ' - File type/size invalid';
        }
    } else {
        $debug_message = 'No file uploaded or file has error';
    }
    
    // Check if NIP already exists
    $check_nip = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE nip = '$nip'");
    if (mysqli_num_rows($check_nip) > 0) {
        header('Location: ../app/guru_modern.php?pesan=nip_exists');
        exit();
    }
    
    // Insert into database
    $query = "INSERT INTO guru (nama, nip, mata_pelajaran, no_telp, jenis_kelamin, agama, lokasi, area, sub_area, foto, start_date) 
              VALUES ('$nama', '$nip', '$mata_pelajaran', '$no_telp', '$jenis_kelamin', '$agama', '$lokasi', '$area', '$sub_area', '$foto_name', CURDATE())";
    
    if (mysqli_query($GLOBALS["___mysqli_ston"], $query)) {
        $success_msg = urlencode($debug_message . ' | Foto: ' . ($foto_name ?: 'Using default avatar'));
        header('Location: ../app/guru_modern.php?pesan=berhasil&debug=' . $success_msg);
    } else {
        header('Location: ../app/guru_modern.php?pesan=gagal&debug=' . urlencode($debug_message));
    }
} else {
    header('Location: ../app/guru_modern.php');
}
?>
