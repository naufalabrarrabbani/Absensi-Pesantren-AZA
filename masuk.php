<?php
include 'include/koneksi.php';
include 'include/app.php';
$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan");
$karyawan = mysqli_fetch_array($s_karyawan);
$t_karyawan = mysqli_num_rows($s_karyawan);
$skr = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Masuk - <?= $app['nama_aplikasi'];?></title>
    <meta name="description" content="Halaman Absen Masuk - <?= $app['nama_perusahaan'];?>">
    
    <!-- Modern Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Modern CSS -->
    <link href="css/modern-style.css" rel="stylesheet">
    <link href="css/modern-form.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="images/icon/logogl.jpg">
    
    <style>
        .modern-attendance-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .attendance-grid {
            display: grid;
            grid-template-columns: 1fr 400px 1fr;
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
            align-items: start;
        }

        .side-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .main-attendance-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }

        .attendance-header {
            margin-bottom: 30px;
        }

        .attendance-title {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .qr-section {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 30px;
            border-radius: 16px;
            margin: 20px 0;
            color: white;
        }

        .qr-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .scan-input {
            width: 100%;
            padding: 18px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 18px;
            text-align: center;
            background: white;
            outline: none;
            transition: all 0.3s ease;
            margin: 15px 0;
        }

        .scan-input:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .navigation-buttons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .nav-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-home {
            background: #6c757d;
            color: white;
        }

        .btn-admin {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .nav-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            color: white;
        }

        /* Clock Widget */
        .clock-widget {
            text-align: center;
            margin-bottom: 20px;
        }

        .clock-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .digital-time {
            font-size: 32px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 8px;
        }

        .digital-date {
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            padding: 20px;
            border-radius: 12px;
            color: white;
            text-align: center;
        }

        .stat-card.absent {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            opacity: 0.9;
        }

        .stat-percentage {
            font-size: 10px;
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 6px;
            border-radius: 8px;
            margin-left: 8px;
        }

        /* Recent Attendance */
        .recent-attendance {
            margin-top: 20px;
        }

        .recent-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: center;
        }

        .attendance-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .attendance-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #667eea;
        }

        .attendance-info {
            flex: 1;
        }

        .attendance-name {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .attendance-details {
            font-size: 11px;
            color: #7f8c8d;
        }

        .attendance-time {
            font-size: 10px;
            color: #667eea;
            font-weight: 500;
        }

        /* Progress Bar */
        .progress-container {
            margin: 10px 0;
        }

        .progress-bar-modern {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .attendance-grid {
                grid-template-columns: 1fr;
                max-width: 500px;
            }
            
            .side-card {
                order: 2;
            }
            
            .main-attendance-card {
                order: 1;
            }
        }

        @media (max-width: 768px) {
            .modern-attendance-container {
                padding: 10px;
            }
            
            .main-attendance-card {
                padding: 30px 20px;
            }
            
            .attendance-title {
                font-size: 24px;
            }
            
            .navigation-buttons {
                flex-direction: column;
            }
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        /* Notification Styles */
        .notification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            animation: fadeIn 0.2s ease-out;
        }

        .notification-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 450px;
            width: 90%;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-out;
            text-align: center;
        }

        .notification-card.berhasil {
            border-top: 5px solid #4CAF50;
        }

        .notification-card.gagal {
            border-top: 5px solid #F44336;
        }

        .notification-card.sudah {
            border-top: 5px solid #FF9800;
        }

        .notification-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        .notification-card.berhasil .notification-icon {
            color: #4CAF50;
        }

        .notification-card.gagal .notification-icon {
            color: #F44336;
        }

        .notification-card.sudah .notification-icon {
            color: #FF9800;
        }

        .notification-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .notification-user {
            font-size: 18px;
            color: #667eea;
            margin-bottom: 15px;
        }

        .notification-message {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .notification-time {
            font-size: 14px;
            color: #7f8c8d;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .notification-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #f8f9fa;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .notification-close:hover {
            background: #e9ecef;
            transform: scale(1.1);
        }

        .notification-close i {
            color: #6c757d;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

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
    </style>
</head>
<body>
    <div class="modern-attendance-container">
        <!-- Success/Error Notification -->
        <?php if(isset($_GET['status'])): ?>
        <div class="notification-overlay" id="notificationOverlay">
            <div class="notification-card <?= $_GET['status']; ?>">
                <div class="notification-icon">
                    <?php if($_GET['status'] == 'berhasil'): ?>
                        <i class="fas fa-check-circle"></i>
                    <?php elseif($_GET['status'] == 'gagal'): ?>
                        <i class="fas fa-times-circle"></i>
                    <?php else: ?>
                        <i class="fas fa-info-circle"></i>
                    <?php endif; ?>
                </div>
                <div class="notification-content">
                    <h3 class="notification-title">
                        <?php if($_GET['status'] == 'berhasil'): ?>
                            Absensi Berhasil!
                        <?php elseif($_GET['status'] == 'gagal'): ?>
                            Absensi Gagal!
                        <?php else: ?>
                            Informasi
                        <?php endif; ?>
                    </h3>
                    <?php if(isset($_GET['nama'])): ?>
                        <p class="notification-user">
                            <strong><?= base64_decode($_GET['nama']); ?></strong>
                        </p>
                    <?php endif; ?>
                    <p class="notification-message">
                        <?= base64_decode($_GET['pesan']); ?>
                    </p>
                    <div class="notification-time">
                        <i class="fas fa-clock"></i>
                        <?= date('H:i:s'); ?> - <?= date('d M Y'); ?>
                    </div>
                </div>
                <button class="notification-close" onclick="closeNotification()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?php endif; ?>

        <div class="attendance-grid">
            <!-- Left Side - Clock & Stats -->
            <div class="side-card">
                <div class="clock-widget">
                    <h3 class="clock-title">
                        <i class="fas fa-clock"></i> Waktu Saat Ini
                    </h3>
                    <div class="digital-time" id="current-time">00:00:00</div>
                    <div class="digital-date" id="current-date">
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
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">
                            <?php 
                            $s_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi where tanggal='$skr' and ijin is NULL order by masuk DESC");
                            $t_absen = mysqli_num_rows($s_absen); 
                            echo $t_absen; 
                            ?>
                            <span class="stat-percentage"><?= number_format($t_absen/$t_karyawan*100,0) ?>%</span>
                        </div>
                        <div class="stat-label">Sudah Masuk</div>
                        <div class="progress-container">
                            <div class="progress-bar-modern">
                                <div class="progress-fill" style="width: <?= number_format($t_absen/$t_karyawan*100,0) ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card absent">
                        <div class="stat-number">
                            <?= $t_karyawan-$t_absen; ?>
                            <span class="stat-percentage"><?= number_format(($t_karyawan-$t_absen)/$t_karyawan*100,0) ?>%</span>
                        </div>
                        <div class="stat-label">Belum Masuk</div>
                        <div class="progress-container">
                            <div class="progress-bar-modern">
                                <div class="progress-fill" style="width: <?= number_format(($t_karyawan-$t_absen)/$t_karyawan*100,0) ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main - Attendance Form -->
            <div class="main-attendance-card">
                <div class="attendance-header">
                    <h1 class="attendance-title">
                        <i class="fas fa-qrcode qr-icon"></i>
                        Absen Masuk
                    </h1>
                    <p style="color: #7f8c8d; margin: 0;">Scan QR Code untuk melakukan absensi</p>
                </div>

                <div class="qr-section">
                    <i class="fas fa-qrcode qr-icon"></i>
                    <h3 style="margin: 0 0 15px 0;">Scan QR Code</h3>
                    <form action="controllers/masuk.php" name="attendanceForm" method="POST" id="attendanceForm">
                        <input 
                            type="text" 
                            class="scan-input" 
                            name="nik" 
                            id="nikInput"
                            placeholder="Scan QR code atau ketik NIK..."
                            autocomplete="off"
                            autofocus
                        />
                    </form>
                    <p style="margin: 0; font-size: 14px; opacity: 0.9;">
                        <i class="fas fa-info-circle"></i> 
                        Form akan otomatis submit setelah scan
                    </p>
                </div>

                <div class="navigation-buttons">
                    <a href="index.php" class="nav-btn btn-home">
                        <i class="fas fa-home"></i>
                        Kembali ke Home
                    </a>
                    <a href="login.php" class="nav-btn btn-admin">
                        <i class="fas fa-user-shield"></i>
                        Login Admin
                    </a>
                </div>
            </div>

            <!-- Right Side - Recent Attendance -->
            <div class="side-card">
                <div class="recent-attendance">
                    <h3 class="recent-title">
                        <i class="fas fa-users"></i> Absen Terakhir
                    </h3>
                    <?php 
                    $s_absen1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi where tanggal='$skr' AND masuk!='NULL' order by masuk DESC limit 5");
                    while ($d_absen = mysqli_fetch_array($s_absen1)) { 
                        $peg = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where nik='$d_absen[nik]'"));
                    ?>
                    <div class="attendance-item">
                        <img src="app/images/<?= $peg['foto'] ?: 'default-avatar.png'; ?>" 
                             alt="<?= $peg['nama']; ?>" 
                             class="attendance-avatar"
                             onerror="this.src='images/default-avatar.png'">
                        <div class="attendance-info">
                            <div class="attendance-name"><?= $peg['nama']; ?></div>
                            <div class="attendance-details"><?= $peg['lokasi']; ?> - <?= $peg['area']; ?></div>
                            <div class="attendance-time">
                                <i class="fas fa-clock"></i> 
                                <?= date('H:i', strtotime($d_absen['masuk'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Clock function
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update clock every second
        updateClock();
        setInterval(updateClock, 1000);

        // Auto-submit form when input changes (for QR scanner)
        document.getElementById('nikInput').addEventListener('input', function() {
            const value = this.value.trim();
            if (value.length >= 5) { // Adjust minimum length as needed
                // Add small delay to ensure complete scan
                setTimeout(() => {
                    if (this.value.trim() === value) {
                        document.getElementById('attendanceForm').submit();
                    }
                }, 500);
            }
        });

        // Focus management for QR scanner
        function setFocus() {
            const field = document.getElementById('nikInput');
            field.focus();
            field.select();
        }

        // Auto-focus when page loads and when clicked elsewhere
        window.onload = setFocus;
        document.addEventListener('click', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON') {
                setFocus();
            }
        });

        // Prevent form submission on empty input
        document.getElementById('attendanceForm').addEventListener('submit', function(e) {
            const nikValue = document.getElementById('nikInput').value.trim();
            if (!nikValue) {
                e.preventDefault();
                alert('Silakan scan QR code atau masukkan NIK terlebih dahulu');
                setFocus();
            }
        });

        // Add scanning animation
        document.getElementById('nikInput').addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });

        document.getElementById('nikInput').addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });

        // Smooth animations on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.side-card, .main-attendance-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Notification handling
        function closeNotification() {
            const notification = document.querySelector('.notification-overlay');
            if (notification) {
                notification.style.animation = 'fadeOut 0.2s ease-out';
                setTimeout(() => {
                    notification.remove();
                    // Clear URL parameters
                    window.history.replaceState({}, document.title, window.location.pathname);
                }, 200);
            }
        }

        // Auto close notification after 0.5 second
        if (document.querySelector('.notification-overlay')) {
            setTimeout(closeNotification, 500);
        }

        // Add fadeOut animation for closing notifications
        const notificationStyle = document.createElement('style');
        notificationStyle.textContent = `
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
        `;
        document.head.appendChild(notificationStyle);
    </script>
</body>
</html>
