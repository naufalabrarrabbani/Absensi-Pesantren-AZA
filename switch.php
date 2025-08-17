<?php
// File untuk switch antara tampilan modern dan lama
// Akses: http://localhost/absen/switch.php?theme=modern atau ?theme=classic

$theme = isset($_GET['theme']) ? $_GET['theme'] : 'modern';

if ($theme === 'classic') {
    // Copy file lama ke index.php
    copy('index_old.php', 'index.php');
    $message = "Berhasil mengganti ke tampilan klasik";
    $current = "classic";
} else {
    // Copy file modern ke index.php  
    copy('index_modern.php', 'index.php');
    $message = "Berhasil mengganti ke tampilan modern";
    $current = "modern";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Switcher - Sistem Absensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .switcher-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-classic {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .current-theme {
            font-size: 18px;
            color: #2c3e50;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="switcher-card">
        <h2>🎨 Theme Switcher</h2>
        <div class="alert"><?= $message ?></div>
        
        <div class="current-theme">
            <strong>Theme Aktif:</strong> 
            <?= $current === 'modern' ? '🚀 Modern' : '📱 Classic' ?>
        </div>
        
        <div>
            <a href="?theme=modern" class="btn btn-modern">
                🚀 Tampilan Modern
            </a>
            <a href="?theme=classic" class="btn btn-classic">
                📱 Tampilan Classic
            </a>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="index.php" class="btn" style="background: #28a745; color: white;">
                🏠 Lihat Hasil
            </a>
        </div>
        
        <p style="margin-top: 20px; color: #6c757d; font-size: 14px;">
            File yang digunakan: <br>
            Modern: <code>index_modern.php</code><br>
            Classic: <code>index_old.php</code>
        </p>
    </div>
</body>
</html>
