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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - <?= $app['nama_aplikasi'];?></title>
    
    <!-- Modern Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 50px 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-section {
            margin-bottom: 25px;
        }

        .logo-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .login-subtitle {
            color: #7f8c8d;
            font-size: 16px;
            font-weight: 400;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
            font-size: 18px;
            z-index: 2;
        }

        .form-input {
            width: 100%;
            padding: 18px 18px 18px 55px;
            border: 2px solid #e1e8ed;
            border-radius: 15px;
            font-size: 16px;
            background: white;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-input:focus + i {
            color: #667eea;
        }

        .login-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .back-home {
            text-align: center;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background: rgba(102, 126, 234, 0.1);
            text-decoration: none;
            color: #5a67d8;
        }

        /* Clock Widget */
        .clock-widget {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .digital-time {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
            font-family: 'Courier New', monospace;
        }

        .digital-date {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 500;
        }

        /* Loading State */
        .loading {
            display: none;
        }

        .login-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .login-btn.loading .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
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

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 40px 30px;
                margin: 10px;
            }
            
            .login-title {
                font-size: 24px;
            }
            
            .logo-img {
                width: 60px;
                height: 60px;
            }
        }

        /* Error States */
        .error-message {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
        }

        .form-input.error {
            border-color: #e74c3c;
        }

        .form-input.error:focus {
            border-color: #e74c3c;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo-section">
                <img src="images/logo smp.png" alt="Logo Sekolah" class="logo-img">
            </div>
            <h1 class="login-title">
                <i class="fas fa-user-shield"></i>
                Login Admin
            </h1>
            <p class="login-subtitle"><?= $app['nama_perusahaan'];?></p>
        </div>

        <!-- Clock Widget -->
        <div class="clock-widget">
            <div class="digital-time" id="current-time">00:00:00</div>
            <div class="digital-date">
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

        <!-- Error Message -->
        <div class="error-message" id="errorMessage">
            Username atau password salah!
        </div>

        <!-- Login Form -->
        <form method="POST" action="controllers/login_proses.php" class="form-section" id="loginForm">
            <div class="input-group">
                <input type="text" class="form-input" name="username" id="username" placeholder="Masukkan username" required>
                <i class="fas fa-user"></i>
            </div>
            
            <div class="input-group">
                <input type="password" class="form-input" name="password" id="password" placeholder="Masukkan password" required>
                <i class="fas fa-lock"></i>
            </div>
            
            <button type="submit" class="login-btn" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i>
                <span class="btn-text">Login Admin</span>
                <div class="loading"></div>
            </button>
        </form>

        <!-- Back to Home -->
        <div class="back-home">
            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Home
            </a>
        </div>
    </div>

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

        // Form handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.querySelector('.btn-text').textContent = 'Memverifikasi...';
        });

        // Focus management
        function setFocus() {
            document.getElementById('username').focus();
        }

        // Auto-focus when page loads
        window.onload = setFocus;

        // Input validation and animation
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    this.classList.remove('error');
                    document.getElementById('errorMessage').style.display = 'none';
                }
            });
        });

        // Show error message if login failed (you can modify this based on your error handling)
        if (window.location.search.includes('error=1')) {
            document.getElementById('errorMessage').style.display = 'block';
            document.getElementById('username').classList.add('error');
            document.getElementById('password').classList.add('error');
        }

        // Smooth entrance animation
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.login-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.8s ease-out';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
        });
    </script>
</body>
</html>