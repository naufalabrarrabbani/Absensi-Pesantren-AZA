<?php
// mPDF bootstrap file - Simple autoloader for mPDF library

// Function to automatically include mPDF files
function mpdf_autoload($className) {
    $prefix = 'Mpdf\\';
    $base_dir = __DIR__ . '/src/';
    
    // Check if the class uses the namespace prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        return;
    }
    
    // Get the relative class name
    $relative_class = substr($className, $len);
    
    // Replace namespace separators with directory separators
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
}

// Register the autoloader
spl_autoload_register('mpdf_autoload');

// Include core files that don't follow namespace convention
require_once __DIR__ . '/src/functions.php';
require_once __DIR__ . '/src/Strict.php';
require_once __DIR__ . '/src/Config/ConfigVariables.php';
require_once __DIR__ . '/src/Config/FontVariables.php';

// Main Mpdf class
require_once __DIR__ . '/src/Mpdf.php';
?>
