<?php
// Debug file untuk cek file controllers
echo "<h2>Debug Controllers Directory</h2>";

$controllers_dir = __DIR__ . '/controllers/';
echo "Controllers directory: " . $controllers_dir . "<br><br>";

if (is_dir($controllers_dir)) {
    echo "<h3>Files in controllers directory:</h3>";
    $files = scandir($controllers_dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filepath = $controllers_dir . $file;
            echo "- " . $file;
            if (is_file($filepath)) {
                echo " (file exists, size: " . filesize($filepath) . " bytes)";
            }
            echo "<br>";
        }
    }
} else {
    echo "Controllers directory does not exist!<br>";
}

echo "<br><h3>Test file_exists for specific controllers:</h3>";
$test_files = ['masuk.php', 'masuk_guru.php', 'pulang.php', 'pulang_guru.php'];
foreach ($test_files as $file) {
    $filepath = $controllers_dir . $file;
    echo "controllers/" . $file . ": " . (file_exists($filepath) ? "EXISTS" : "NOT FOUND") . "<br>";
}

echo "<br><h3>Current working directory:</h3>";
echo getcwd() . "<br>";

echo "<br><h3>Document Root:</h3>";
echo $_SERVER['DOCUMENT_ROOT'] . "<br>";

echo "<br><h3>Script Path:</h3>";
echo $_SERVER['SCRIPT_FILENAME'] . "<br>";
?>
