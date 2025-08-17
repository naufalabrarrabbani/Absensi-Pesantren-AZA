<?php
include '../include/koneksi.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login');
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_aplikasi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama_aplikasi']);
    $alamat = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['alamat'] ?? '');
    $jam_masuk = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jam_masuk'] ?? '07:00');
    $jam_pulang = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jam_pulang'] ?? '15:00');
    $toleransi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['toleransi'] ?? '15');
    $radius = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['radius'] ?? '100');

    // Handle logo upload
    $logo_uploaded = false;
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (in_array($_FILES['logo']['type'], $allowed_types) && $_FILES['logo']['size'] <= $max_size) {
            $upload_dir = '../images/';
            $file_extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $new_filename = 'logo_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['logo']['tmp_name'], $upload_path)) {
                $logo_uploaded = true;
                // You might want to update the logo path in database here
            }
        }
    }

    // Update aplikasi table
    $query = "UPDATE aplikasi SET 
                nama_aplikasi = '$nama_aplikasi',
                alamat = '$alamat',
                jam_masuk = '$jam_masuk',
                jam_pulang = '$jam_pulang',
                toleransi = '$toleransi',
                radius = '$radius'
              WHERE id = 1";

    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);

    if ($result) {
        $message = "Pengaturan berhasil disimpan!";
        if ($logo_uploaded) {
            $message .= " Logo juga berhasil diupload.";
        }
        header('location:setting_modern.php?success=' . base64_encode($message));
    } else {
        header('location:setting_modern.php?error=' . base64_encode('Gagal menyimpan pengaturan. Silakan coba lagi.'));
    }
} else {
    header('location:setting_modern.php');
}
exit();
?>
