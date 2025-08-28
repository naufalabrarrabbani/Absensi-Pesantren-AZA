<?php
// Simple QR Code generator using Google Charts API
if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $qr_url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($nik);
    
    // Get the image from Google Charts
    $image_data = file_get_contents($qr_url);
    
    if ($image_data !== false) {
        header('Content-Type: image/png');
        echo $image_data;
    } else {
        // If Google Charts fails, create a simple placeholder
        header('Content-Type: image/png');
        
        // Create a simple placeholder image
        $img = imagecreate(300, 300);
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);
        
        imagefill($img, 0, 0, $white);
        imagestring($img, 5, 50, 140, "QR: " . $nik, $black);
        
        imagepng($img);
        imagedestroy($img);
    }
} else {
    // Return empty 1x1 pixel if no NIK provided
    header('Content-Type: image/png');
    $img = imagecreate(1, 1);
    $white = imagecolorallocate($img, 255, 255, 255);
    imagepng($img);
    imagedestroy($img);
}
?>
