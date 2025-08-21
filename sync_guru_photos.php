<?php
// Script untuk sinkronisasi foto guru dari app/images/guru ke images/guru
function syncGuruPhotos() {
    $source_dir = 'app/images/guru/';
    $dest_dir = 'images/guru/';
    
    // Buat direktori tujuan jika belum ada
    if (!file_exists($dest_dir)) {
        mkdir($dest_dir, 0777, true);
    }
    
    $synced = 0;
    if (is_dir($source_dir)) {
        $files = scandir($source_dir);
        foreach($files as $file) {
            if ($file != '.' && $file != '..' && is_file($source_dir . $file)) {
                $source_file = $source_dir . $file;
                $dest_file = $dest_dir . $file;
                
                // Copy jika file tujuan belum ada atau lebih lama
                if (!file_exists($dest_file) || filemtime($source_file) > filemtime($dest_file)) {
                    if (copy($source_file, $dest_file)) {
                        $synced++;
                    }
                }
            }
        }
    }
    
    return $synced;
}

// Jalankan sync jika script dipanggil langsung
if (basename(__FILE__) == basename($_SERVER['SCRIPT_NAME'])) {
    $synced = syncGuruPhotos();
    echo "Sync completed. $synced files synced.\n";
}
?>
