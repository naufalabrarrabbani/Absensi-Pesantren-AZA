<?php
include 'include/koneksi.php';
include 'include/app.php';

$skr = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $app['nama_aplikasi'];?> - <?= $app['nama_perusahaan'];?></title>
    <meta name="description" content="Sistem Absensi Modern SMP IT INSAN GUNA INDONESIA">
    
    <!-- Modern Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Modern CSS -->
    <link href="css/modern-style.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon/logogl.jpg">
</head>
<body>
    <div class="modern-container">
        <div class="main-card">
            <!-- Logo & Title Section -->
            <div class="logo-section">
                <img src="images/logo smp.png" alt="Logo Sekolah" class="pulse">
                <h1 class="app-title"><?= $app['nama_aplikasi'];?></h1>
                <p class="app-subtitle">Sistem Absensi Digital</p>
            </div>

            <!-- Time & Date Section -->
            <div class="time-section">
                <div class="digital-clock" id="clock">00:00:00</div>
                <div class="date-display">
                    <?php 
                    $tanggal = date('d M Y');
                    $day = date('D', strtotime($tanggal));
                    $dayList = array(
                        'Sun' => 'Minggu',
                        'Mon' => 'Senin', 
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => 'Jumat',
                        'Sat' => 'Sabtu'
                    );
                    echo $dayList[$day] . ", " . $tanggal;
                    ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="masuk.php" class="action-btn masuk">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="btn-text">Absen Masuk</span>
                </a>
                <a href="pulang.php" class="action-btn pulang">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="btn-text">Absen Pulang</span>
                </a>
            </div>

            <!-- School Info -->
            <div class="school-info">
                <p class="school-name"><?= $app['nama_perusahaan'];?></p>
            </div>
        </div>
    </div>

    <!-- Modern Clock Script -->
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update clock immediately and then every second
        updateClock();
        setInterval(updateClock, 1000);

        // Add smooth transitions on load
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.main-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.8s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
