<?php
// Test mPDF loading
echo "Testing mPDF loading...\n";

try {
    require_once __DIR__ . '/lib/mpdf/mpdf_bootstrap.php';
    echo "Bootstrap loaded successfully\n";
    
    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => __DIR__ . '/lib/mpdf/tmp',
        'format' => 'A4'
    ]);
    echo "mPDF instance created successfully\n";
    
    $mpdf->WriteHTML('<h1>Test PDF</h1><p>This is a test.</p>');
    echo "HTML written successfully\n";
    
    echo "mPDF test completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>
