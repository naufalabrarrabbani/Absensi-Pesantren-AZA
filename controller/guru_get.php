<?php
include '../include/koneksi.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);
    
    $query = "SELECT * FROM guru WHERE id = '$id'";
    $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $teacher = mysqli_fetch_assoc($result);
        
        echo json_encode([
            'success' => true,
            'data' => $teacher
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Data guru tidak ditemukan'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'ID guru tidak diberikan'
    ]);
}
?>
