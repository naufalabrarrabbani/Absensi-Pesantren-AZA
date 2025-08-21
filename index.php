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
    
    <!-- Bootstrap & Modern CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <!-- Clean Modern Switch Buttons -->
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .modern-container {
            max-width: 500px;
            margin: 0 auto;
            padding-top: 20px;
        }

        .main-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-section img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .app-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .app-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        .time-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .digital-clock {
            font-size: 28px;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        .date-display {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .user-selection {
            margin: 30px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .selection-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            color: white;
            font-size: 18px;
            font-weight: 500;
        }

        .user-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .user-btn {
            padding: 20px 25px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            min-width: 120px;
            text-decoration: none;
        }

        .user-btn i {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .user-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .user-btn.active {
            background: rgba(255, 255, 255, 0.9);
            color: #2c3e50;
            border-color: rgba(255, 255, 255, 0.8);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin: 30px 0;
            justify-content: center;
        }

        .action-btn {
            flex: 1;
            padding: 20px;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .action-btn.masuk {
            background: rgba(46, 204, 113, 0.8);
        }

        .action-btn.pulang {
            background: rgba(231, 76, 60, 0.8);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .action-btn i {
            font-size: 24px;
        }

        .school-info {
            text-align: center;
            margin-top: 30px;
        }

        .school-name {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin: 0;
        }

        @media (max-width: 576px) {
            .user-buttons {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
    
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

            <!-- User Type Selection -->
            <div class="user-selection">
                <div class="selection-title">
                    <i class="fas fa-user-friends"></i>
                    <span>Pilih Tipe Pengguna</span>
                </div>
                <div class="user-buttons">
                    <button class="user-btn active" data-type="siswa">
                        <i class="fas fa-user-graduate"></i>
                        <span>Siswa</span>
                    </button>
                    <button class="user-btn" data-type="guru">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Guru</span>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons" id="action-buttons">
                <a href="masuk.php" class="action-btn masuk" id="btn-masuk">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="btn-text">Absen Masuk</span>
                </a>
                <a href="pulang.php" class="action-btn pulang" id="btn-pulang">
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

        // User type switching - Simplified
        document.addEventListener('DOMContentLoaded', function() {
            const userBtns = document.querySelectorAll('.user-btn');
            const btnMasuk = document.getElementById('btn-masuk');
            const btnPulang = document.getElementById('btn-pulang');
            const body = document.body;

            userBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    userBtns.forEach(b => b.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const userType = this.dataset.type;
                    
                    if (userType === 'guru') {
                        // Update links for guru
                        btnMasuk.href = 'masuk_guru.php';
                        btnPulang.href = 'pulang_guru.php';
                        
                        // Update button text
                        btnMasuk.querySelector('.btn-text').textContent = 'Absen Masuk Guru';
                        btnPulang.querySelector('.btn-text').textContent = 'Absen Pulang Guru';
                    } else {
                        // Update links for siswa
                        btnMasuk.href = 'masuk.php';
                        btnPulang.href = 'pulang.php';
                        
                        // Update button text
                        btnMasuk.querySelector('.btn-text').textContent = 'Absen Masuk';
                        btnPulang.querySelector('.btn-text').textContent = 'Absen Pulang';
                    }
                });
            });
        });
    </script>
</body>
</html>
