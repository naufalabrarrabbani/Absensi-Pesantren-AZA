<?php
include 'include/koneksi.php';
include 'include/app.php';

$status = base64_decode($_GET['status']);
$pesan = base64_decode($_GET['pesan']);
$nama = isset($_GET['nama']) ? base64_decode($_GET['nama']) : '';
$untuk = isset($_GET['untuk']) ? $_GET['untuk'] : 'siswa'; // default siswa

// Set data berdasarkan jenis user
if($untuk == 'guru') {
    $home_link = 'index_guru_siswa.php';
    $masuk_link = 'masuk_guru.php';
    $pulang_link = 'pulang_guru.php';
    $user_type = 'Guru';
    $icon_class = 'fas fa-chalkboard-teacher';
    $color_primary = '#e74c3c';
    $color_gradient = 'linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)';
} else {
    $home_link = 'index.php';
    $masuk_link = 'masuk.php';
    $pulang_link = 'pulang.php';
    $user_type = 'Siswa';
    $icon_class = 'fas fa-user-graduate';
    $color_primary = '#667eea';
    $color_gradient = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Absensi - <?= $app['nama_aplikasi'];?></title>
    <meta name="description" content="Status Absensi - <?= $app['nama_perusahaan'];?>">
    
    <!-- Modern Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon/logogl.jpg">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: <?= $color_gradient ?>;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .status-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 500px;
            width: 100%;
            animation: slideUp 0.8s ease-out;
        }

        .status-icon {
            font-size: 80px;
            margin-bottom: 25px;
            animation: bounce 2s infinite;
        }

        .status-berhasil {
            color: #27ae60;
        }

        .status-gagal {
            color: #e74c3c;
        }

        .status-sudah {
            color: #f39c12;
        }

        .status-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .status-subtitle {
            font-size: 16px;
            color: <?= $color_primary ?>;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .user-info {
            background: <?= $color_gradient ?>;
            color: white;
            padding: 20px;
            border-radius: 16px;
            margin: 25px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .user-icon {
            font-size: 32px;
        }

        .user-details h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-details p {
            font-size: 14px;
            opacity: 0.9;
        }

        .status-message {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 4px solid <?= $color_primary ?>;
        }

        .status-message p {
            font-size: 16px;
            color: #2c3e50;
            line-height: 1.6;
        }

        .time-info {
            display: flex;
            justify-content: space-between;
            background: #ecf0f1;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 14px;
            color: #7f8c8d;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
        }

        .btn-primary {
            background: <?= $color_gradient ?>;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: white;
        }

        .countdown {
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }

        .countdown span {
            font-weight: 600;
            color: <?= $color_primary ?>;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .status-container {
                padding: 40px 30px;
                margin: 10px;
            }
            
            .status-icon {
                font-size: 60px;
            }
            
            .status-title {
                font-size: 24px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .user-info {
                flex-direction: column;
                text-align: center;
            }
            
            .time-info {
                flex-direction: column;
                gap: 10px;
            }
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="status-container">
        <!-- Status Icon -->
        <div class="status-icon 
            <?php 
            if($status == 'berhasil') echo 'status-berhasil';
            elseif($status == 'gagal') echo 'status-gagal';
            else echo 'status-sudah';
            ?>">
            <?php 
            if($status == 'berhasil') echo '<i class="fas fa-check-circle"></i>';
            elseif($status == 'gagal') echo '<i class="fas fa-times-circle"></i>';
            else echo '<i class="fas fa-info-circle"></i>';
            ?>
        </div>

        <!-- Status Title -->
        <h1 class="status-title">
            <?php 
            if($status == 'berhasil') echo 'Absensi Berhasil!';
            elseif($status == 'gagal') echo 'Absensi Gagal!';
            else echo 'Informasi Absensi';
            ?>
        </h1>

        <p class="status-subtitle">Absensi <?= $user_type ?></p>

        <!-- User Info -->
        <?php if($nama): ?>
        <div class="user-info">
            <div class="user-icon">
                <i class="<?= $icon_class ?>"></i>
            </div>
            <div class="user-details">
                <h3><?= $nama ?></h3>
                <p><?= $user_type ?> - <?= $app['nama_perusahaan'] ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Status Message -->
        <div class="status-message">
            <p><?= $pesan ?></p>
        </div>

        <!-- Time Info -->
        <div class="time-info">
            <div>
                <i class="fas fa-calendar"></i>
                <?php 
                $tanggal = date('d M Y');
                $day = date('D', strtotime($tanggal));
                $dayList = array(
                    'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa',
                    'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu'
                );
                echo $dayList[$day] . ", " . $tanggal;
                ?>
            </div>
            <div>
                <i class="fas fa-clock"></i>
                <span id="current-time"><?= date('H:i:s') ?></span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= $home_link ?>" class="btn btn-secondary">
                <i class="fas fa-home"></i>
                Kembali ke Home
            </a>
            
            <?php if($status == 'berhasil'): ?>
                <?php if(strpos($pesan, 'masuk') !== false): ?>
                <a href="<?= $pulang_link ?>" class="btn btn-primary">
                    <i class="fas fa-sign-out-alt"></i>
                    Absen Pulang
                </a>
                <?php else: ?>
                <a href="<?= $masuk_link ?>" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    Absen Masuk
                </a>
                <?php endif; ?>
            <?php else: ?>
            <a href="<?= $masuk_link ?>" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Coba Lagi
            </a>
            <?php endif; ?>
        </div>

        <!-- Auto Redirect Countdown -->
        <div class="countdown">
            <p>Otomatis kembali ke halaman utama dalam <span id="countdown">10</span> detik</p>
        </div>
    </div>

    <script>
        // Update clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Countdown timer
        let countdown = 10;
        function updateCountdown() {
            document.getElementById('countdown').textContent = countdown;
            countdown--;
            
            if (countdown < 0) {
                window.location.href = '<?= $home_link ?>';
            }
        }

        // Start timers
        setInterval(updateClock, 1000);
        setInterval(updateCountdown, 1000);
        updateClock();

        // Add entrance animation delay for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.status-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(50px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.8s ease-out';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
