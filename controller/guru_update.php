<?php
include '../include/koneksi.php';

if ($_POST && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
    $nama = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama']);
    $nip = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nip']);
    $mata_pelajaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['mata_pelajaran']);
    $no_telp = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['no_telp']);
    $jenis_kelamin = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jenis_kelamin']);
    $lokasi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['lokasi']);
    
    // Get current data
    $current_data = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE id = '$id'");
    $guru = mysqli_fetch_assoc($current_data);
    $foto_name = $guru['foto'];
    
    // Handle file upload for photo
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_size = $_FILES['foto']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) { // 2MB limit
            $new_foto_name = $nip . '_' . time() . '.' . $file_ext;
            $upload_path = '../app/images/guru/' . $new_foto_name;
            
            // Create directory if it doesn't exist
            if (!file_exists('../app/images/guru/')) {
                mkdir('../app/images/guru/', 0777, true);
            }
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                // Delete old photo if exists
                if ($foto_name && file_exists('../app/images/guru/' . $foto_name)) {
                    unlink('../app/images/guru/' . $foto_name);
                }
                $foto_name = $new_foto_name;
            }
        }
    }
    
    // Check if NIP already exists for other records
    $check_nip = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru WHERE nip = '$nip' AND id != '$id'");
    if (mysqli_num_rows($check_nip) > 0) {
        header('Location: ../app/guru_modern.php?pesan=nip_exists');
        exit();
    }
    
    // Update database
    $query = "UPDATE guru SET 
              nama = '$nama', 
              nip = '$nip', 
              mata_pelajaran = '$mata_pelajaran', 
              no_telp = '$no_telp', 
              jenis_kelamin = '$jenis_kelamin', 
              lokasi = '$lokasi', 
              foto = '$foto_name' 
              WHERE id = '$id'";
    
    if (mysqli_query($GLOBALS["___mysqli_ston"], $query)) {
        header('Location: ../app/guru_modern.php?pesan=update_berhasil');
    } else {
        header('Location: ../app/guru_modern.php?pesan=update_gagal');
    }
} else {
    header('Location: ../app/guru_modern.php');
}
?>
