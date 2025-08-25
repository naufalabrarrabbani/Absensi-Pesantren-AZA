<?php
include '../include/koneksi.php';
// memulai session

session_start();
error_reporting(0);
/**
 * Jika Tidak login atau sudah login tapi bukan sebagai admin
 * maka akan dibawa kembali kehalaman login atau menuju halaman yang seharusnya.
 */
if ( !isset($_SESSION['username'])) {
	header('location:../login.php');
	exit();
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Query untuk data siswa
$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan ORDER BY nama ASC");
$t_karyawan = mysqli_num_rows($s_karyawan);

// Query untuk data guru
$s_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from guru ORDER BY nama ASC");
$t_guru = mysqli_num_rows($s_guru);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- QR Code Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    <!-- JSZip for bulk download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- FileSaver for download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");
        
        html, body {
            font-family: "Poppins";
            font-style: normal;
            background-color: #F8F8FA;
            overflow-x: hidden;
            position: relative;
        }

        .btn-statistics, .nav-input, .nav-input-group .btn-nav-input, .nav .btn-notif, #toggle-navbar {
            background-color: transparent;
            border: none;
            outline: none;
        }

        .screen-cover {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.4);
            display: block;
        }

        #toggle-navbar {
            margin-right: 15px;
            display: block;
        }
        @media (min-width: 1200px) {
            #toggle-navbar {
                display: none;
            }
        }

        aside {
            background-color: #fff;
            padding: 50px 20px;
            padding-bottom: 250px;
            height: 100vh;
            overflow-y: scroll;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
            width: 260px;
        }

        .sidebar-logo {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            text-decoration: none;
            margin-bottom: 30px;
            padding: 0 8px;
        }
        @media (min-width: 1200px) {
            .sidebar-logo {
                padding: 0 16px;
                justify-content: center;
            }
        }
        .sidebar-logo span {
            font-weight: 700;
            font-size: 16px;
            line-height: 22px;
            color: #121F3E;
            margin-top: 8px;
            white-space: nowrap;
            text-align: center;
        }
        
        .sidebar-logo img {
            flex-shrink: 0;
        }
        
        .sidebar-logo .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            min-width: 0;
        }
        
        .sidebar-title {
            font-weight: 400;
            font-size: 14px;
            line-height: 21px;
            color: #ABB3C4;
            margin-top: 40px;
            margin-bottom: 12px;
        }
        
        .sidebar-item {
            text-decoration: none;
            display: block;
            background: transparent;
            height: 46px;
            border-radius: 16px;
            padding: 0 11px;
            margin-bottom: 8px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-item.active {
            background: #4640DE;
        }
        .sidebar-item.active span {
            color: #fff;
        }
        .sidebar-item.active svg path,
        .sidebar-item.active i {
            color: #fff;
        }
        .sidebar-item i {
            width: 18px;
            height: 18px;
            margin-right: 20px;
            color: #ABB3C4;
            font-size: 18px;
        }
        .sidebar-item span {
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #121F3E;
        }

        .sidebar-item:hover {
            background: #f8f9fa;
            text-decoration: none;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 50px 14px 24px 14px;
        }
        @media (min-width: 1200px) {
            .nav {
                padding: 50px 64px 24px 0px;
            }
        }

        .nav-title {
            font-weight: 600;
            font-size: 32px;
            line-height: 48px;
            color: #121F3E;
        }

        .content {
            padding: 10px 14px 24px 14px;
        }
        @media (min-width: 1200px) {
            .content {
                padding: 0px 64px 0px 0px;
            }
        }

        .content-title {
            font-weight: 500;
            font-size: 20px;
            line-height: 30px;
            color: #121F3E;
        }

        .content-desc {
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #ABB3C4;
        }

        .qr-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .qr-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .qr-item {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .qr-item:hover {
            transform: translateY(-5px);
        }

        .qr-canvas {
            margin: 15px 0;
        }

        .qr-name {
            font-weight: 600;
            font-size: 16px;
            color: #121F3E;
            margin-bottom: 5px;
        }

        .qr-id {
            font-size: 14px;
            color: #ABB3C4;
            margin-bottom: 15px;
        }

        .btn-generate {
            background: linear-gradient(135deg, #4640DE 0%, #6366F1 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(70, 64, 222, 0.3);
            color: white;
        }

        .btn-download {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-download:hover {
            transform: translateY(-1px);
            color: white;
        }

        .btn-download-all {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .btn-download-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
            color: white;
        }

        .toggle-section {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .section-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab-btn {
            background: #f8f9fa;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            color: #6c757d;
        }

        .tab-btn.active {
            background: #4640DE;
            color: white;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading.show {
            display: block;
        }

        .spinner-border {
            color: #4640DE;
        }

        .progress-container {
            margin: 20px 0;
            display: none;
        }

        .progress-container.show {
            display: block;
        }
    </style>

    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Generate QR Code</title>
</head>

<body>

    <div class="screen-cover d-none d-xl-none"></div>

    <div class="row">
        <div class="col-12 col-lg-3 col-navbar d-none d-xl-block">

            <aside class="sidebar">
                <a href="#" class="sidebar-logo">
                    <div class="logo-container">
                        <img src="../images/logo smp.png" alt="Logo" style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover;">
                        <span><?= $d_aplikasi['nama_aplikasi']; ?></span>
                    </div>

                    <button id="toggle-navbar" onclick="toggleNavbar()">
                        <i class="fas fa-times"></i>
                    </button>
                </a>

                <h5 class="sidebar-title">Daily Use</h5>

                <a href="./home_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-th"></i>
                    <span>Overview</span>
                </a>

                <a href="karyawan_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-users"></i>
                    <span>Siswa</span>
                </a>

                <a href="guru_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Guru</span>
                </a>

                <a href="absensi_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Absensi Siswa</span>
                </a>

                <a href="absensi_guru_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-calendar-check"></i>
                    <span>Absensi Guru</span>
                </a>

                <a href="area_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Area</span>
                </a>

                <a href="generate_qr.php" class="sidebar-item active" onclick="toggleActive(this)">
                    <i class="fas fa-qrcode"></i>
                    <span>Generate QR</span>
                </a>

                <h5 class="sidebar-title">Others</h5>

                <a href="setting_modern.php" class="sidebar-item" onclick="toggleActive(this)">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <a href="../controllers/logout.php" class="sidebar-item">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>

            </aside>

        </div>

        <div class="col-12 col-xl-9">
            <div class="nav">
                <div class="d-flex justify-content-between align-items-center w-100 mb-3 mb-md-0">
                    <div class="d-flex justify-content-start align-items-center">
                        <button id="toggle-navbar" onclick="toggleNavbar()">
                            <i class="fas fa-bars" style="font-size: 20px; color: #121F3E;"></i>
                        </button>
                        <h2 class="nav-title">Generate QR Code</h2>
                    </div>
                </div>
            </div>

            <div class="content">
                <!-- Toggle Section -->
                <div class="toggle-section">
                    <div class="section-tabs">
                        <button class="tab-btn active" onclick="switchTab('siswa', this)">
                            <i class="fas fa-users"></i> Siswa (<?= $t_karyawan; ?>)
                        </button>
                        <button class="tab-btn" onclick="switchTab('guru', this)">
                            <i class="fas fa-chalkboard-teacher"></i> Guru (<?= $t_guru; ?>)
                        </button>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="content-title mb-2">QR Code Generator</h4>
                            <p class="content-desc">Generate QR codes for attendance system</p>
                        </div>
                        <div>
                            <button class="btn-generate" onclick="generateAllQR()">
                                <i class="fas fa-qrcode"></i> Generate All QR
                            </button>
                            <button class="btn-download-all" onclick="downloadAllQR()" id="downloadAllBtn" disabled>
                                <i class="fas fa-download"></i> Download All
                            </button>
                            <button class="btn" style="background: #dc3545; color: white; border: none; border-radius: 8px; padding: 8px 15px; margin: 5px;" onclick="testQR()">
                                <i class="fas fa-test"></i> Test QR
                            </button>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="progress-container" id="progressContainer">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Generating QR Codes...</span>
                            <span id="progressText">0%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Loading -->
                    <div class="loading" id="loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Generating QR Codes...</p>
                    </div>
                </div>

                <!-- Siswa Section -->
                <div id="siswa-section" class="qr-section">
                    <div class="qr-grid" id="siswa-grid">
                        <!-- QR codes for students will be generated here -->
                    </div>
                </div>

                <!-- Guru Section -->
                <div id="guru-section" class="qr-section" style="display: none;">
                    <div class="qr-grid" id="guru-grid">
                        <!-- QR codes for teachers will be generated here -->
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const navbar = document.querySelector('.col-navbar')
        const cover = document.querySelector('.screen-cover')
        const sidebar_items = document.querySelectorAll('.sidebar-item')

        // Data from PHP
        const siswaData = [
            <?php 
            mysqli_data_seek($s_karyawan, 0);
            $first = true;
            while ($siswa = mysqli_fetch_array($s_karyawan)) { 
                if (!$first) echo ",";
                $first = false;
                echo "{";
                echo "id: '" . addslashes($siswa['nik']) . "',";
                echo "nama: '" . addslashes($siswa['nama']) . "',";
                echo "area: '" . addslashes($siswa['area']) . "',";
                echo "lokasi: '" . addslashes($siswa['lokasi']) . "'";
                echo "}";
            } 
            ?>
        ];

        const guruData = [
            <?php 
            mysqli_data_seek($s_guru, 0);
            $first = true;
            while ($guru = mysqli_fetch_array($s_guru)) { 
                if (!$first) echo ",";
                $first = false;
                echo "{";
                echo "id: '" . addslashes($guru['nip']) . "',";
                echo "nama: '" . addslashes($guru['nama']) . "',";
                echo "mata_pelajaran: '" . addslashes($guru['mata_pelajaran']) . "',";
                echo "alamat: '" . addslashes($guru['alamat']) . "'";
                echo "}";
            } 
            ?>
        ];

        let currentSection = 'siswa';
        let generatedQRs = [];
        let allQRsGenerated = false;

        // Debug data
        console.log('Siswa Data:', siswaData);
        console.log('Guru Data:', guruData);
        console.log('Total Siswa:', siswaData.length);
        console.log('Total Guru:', guruData.length);
        
        // Check QR libraries
        console.log('QRious available:', typeof QRious !== 'undefined');
        console.log('qrcode-generator available:', typeof qrcode !== 'undefined');

        function toggleNavbar() {
            navbar.classList.toggle('d-none')
            cover.classList.toggle('d-none')
        }

        function toggleActive(e) {
            sidebar_items.forEach(function(v, k) {
                v.classList.remove('active')
            })
            e.closest('.sidebar-item').classList.add('active')
        }

        function switchTab(section, btn) {
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Hide all sections
            document.querySelectorAll('.qr-section').forEach(s => s.style.display = 'none');
            
            // Show selected section
            document.getElementById(section + '-section').style.display = 'block';
            
            currentSection = section;
            allQRsGenerated = false;
            document.getElementById('downloadAllBtn').disabled = true;
        }

        async function generateQR(data, canvasId) {
            try {
                const canvas = document.getElementById(canvasId);
                if (!canvas) {
                    console.error('Canvas not found:', canvasId);
                    return null;
                }
                
                console.log('Generating QR for:', data, 'on canvas:', canvasId);
                
                // Method 1: Try QRious library
                if (typeof QRious !== 'undefined') {
                    const qr = new QRious({
                        element: canvas,
                        value: data,
                        size: 150,
                        background: 'white',
                        foreground: 'black'
                    });
                    console.log('QR generated successfully with QRious for:', data);
                    return canvas;
                }
                
                // Method 2: Try qrcode-generator library
                if (typeof qrcode !== 'undefined') {
                    const ctx = canvas.getContext('2d');
                    canvas.width = 150;
                    canvas.height = 150;
                    
                    const qr = qrcode(0, 'M');
                    qr.addData(data);
                    qr.make();
                    
                    const cellSize = 150 / qr.getModuleCount();
                    for (let row = 0; row < qr.getModuleCount(); row++) {
                        for (let col = 0; col < qr.getModuleCount(); col++) {
                            ctx.fillStyle = qr.isDark(row, col) ? 'black' : 'white';
                            ctx.fillRect(col * cellSize, row * cellSize, cellSize, cellSize);
                        }
                    }
                    console.log('QR generated successfully with qrcode-generator for:', data);
                    return canvas;
                }
                
                // Method 3: Fallback to API-based QR generation
                console.log('Using API fallback for QR generation');
                const img = new Image();
                img.crossOrigin = 'anonymous';
                
                return new Promise((resolve) => {
                    img.onload = function() {
                        const ctx = canvas.getContext('2d');
                        canvas.width = 150;
                        canvas.height = 150;
                        ctx.drawImage(img, 0, 0, 150, 150);
                        console.log('QR generated successfully with API for:', data);
                        resolve(canvas);
                    };
                    img.onerror = function() {
                        console.error('API QR generation failed for:', data);
                        resolve(null);
                    };
                    img.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(data)}`;
                });
                
            } catch (err) {
                console.error('Error generating QR code:', err);
                return null;
            }
        }

        async function generateAllQR() {
            const data = currentSection === 'siswa' ? siswaData : guruData;
            const gridId = currentSection + '-grid';
            const grid = document.getElementById(gridId);

            console.log('Starting QR generation for:', currentSection, 'Data count:', data.length);

            if (data.length === 0) {
                alert('No data found for ' + currentSection);
                return;
            }

            // Show loading and progress
            document.getElementById('loading').classList.add('show');
            document.getElementById('progressContainer').classList.add('show');
            
            // Clear previous QRs
            grid.innerHTML = '';
            generatedQRs = [];

            const totalItems = data.length;
            let processedItems = 0;

            for (const item of data) {
                console.log('Processing item:', item);
                
                // Create QR item container
                const qrItem = document.createElement('div');
                qrItem.className = 'qr-item';
                
                const canvasId = currentSection + '-qr-' + item.id.replace(/[^a-zA-Z0-9]/g, '');
                console.log('Canvas ID:', canvasId);
                
                qrItem.innerHTML = `
                    <div class="qr-name">${item.nama}</div>
                    <div class="qr-id">${currentSection === 'siswa' ? 'NIK' : 'NIP'}: ${item.id}</div>
                    <canvas id="${canvasId}" class="qr-canvas"></canvas>
                    <button class="btn-download" onclick="downloadSingleQR('${canvasId}', '${item.nama.replace(/'/g, "\\'")}', '${item.id}')">
                        <i class="fas fa-download"></i> Download
                    </button>
                `;
                
                grid.appendChild(qrItem);

                // Wait for DOM to be ready
                await new Promise(resolve => setTimeout(resolve, 10));

                // Generate QR code
                const canvas = await generateQR(item.id, canvasId);
                if (canvas) {
                    generatedQRs.push({
                        canvas: canvas,
                        name: item.nama,
                        id: item.id
                    });
                    console.log('QR added to collection for:', item.nama);
                }

                // Update progress
                processedItems++;
                const progress = Math.round((processedItems / totalItems) * 100);
                document.getElementById('progressBar').style.width = progress + '%';
                document.getElementById('progressText').textContent = progress + '%';
                
                // Small delay to prevent UI blocking
                await new Promise(resolve => setTimeout(resolve, 50));
            }

            // Hide loading
            document.getElementById('loading').classList.remove('show');
            document.getElementById('progressContainer').classList.remove('show');
            
            allQRsGenerated = true;
            document.getElementById('downloadAllBtn').disabled = false;
            
            console.log('QR generation completed. Total QRs:', generatedQRs.length);
        }

        // Test function untuk debugging
        async function testQR() {
            const testGrid = document.getElementById(currentSection + '-grid');
            testGrid.innerHTML = `
                <div class="qr-item">
                    <div class="qr-name">Test QR</div>
                    <div class="qr-id">ID: 123456</div>
                    <canvas id="test-canvas" class="qr-canvas"></canvas>
                    <button class="btn-download">Test Download</button>
                </div>
            `;
            
            try {
                console.log('Testing QR generation...');
                
                // Check if QRious is available
                if (typeof QRious !== 'undefined') {
                    console.log('Using QRious library');
                    const qr = new QRious({
                        element: document.getElementById('test-canvas'),
                        value: '123456',
                        size: 150,
                        background: 'white',
                        foreground: 'black'
                    });
                    console.log('Test QR generated successfully with QRious!');
                } else if (typeof qrcode !== 'undefined') {
                    console.log('Using qrcode-generator library');
                    const canvas = document.getElementById('test-canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = 150;
                    canvas.height = 150;
                    
                    const qr = qrcode(0, 'M');
                    qr.addData('123456');
                    qr.make();
                    
                    const cellSize = 150 / qr.getModuleCount();
                    for (let row = 0; row < qr.getModuleCount(); row++) {
                        for (let col = 0; col < qr.getModuleCount(); col++) {
                            ctx.fillStyle = qr.isDark(row, col) ? 'black' : 'white';
                            ctx.fillRect(col * cellSize, row * cellSize, cellSize, cellSize);
                        }
                    }
                    console.log('Test QR generated successfully with qrcode-generator!');
                } else {
                    console.error('No QR library available');
                    alert('QR Code libraries not loaded properly');
                }
            } catch (err) {
                console.error('Test QR failed:', err);
                alert('Test QR generation failed: ' + err.message);
            }
        }

        function downloadSingleQR(canvasId, name, id) {
            const canvas = document.getElementById(canvasId);
            canvas.toBlob(function(blob) {
                const fileName = `QR_${currentSection}_${name.replace(/[^a-zA-Z0-9]/g, '_')}_${id.replace(/[^a-zA-Z0-9]/g, '_')}.png`;
                saveAs(blob, fileName);
            });
        }

        async function downloadAllQR() {
            if (!allQRsGenerated || generatedQRs.length === 0) {
                alert('Please generate QR codes first!');
                return;
            }

            const zip = new JSZip();
            const folder = zip.folder(`QR_Codes_${currentSection.charAt(0).toUpperCase() + currentSection.slice(1)}`);

            // Show loading
            document.getElementById('loading').classList.add('show');

            for (const qr of generatedQRs) {
                try {
                    const blob = await new Promise(resolve => {
                        qr.canvas.toBlob(resolve);
                    });
                    
                    const fileName = `QR_${currentSection}_${qr.name.replace(/[^a-zA-Z0-9]/g, '_')}_${qr.id.replace(/[^a-zA-Z0-9]/g, '_')}.png`;
                    folder.file(fileName, blob);
                } catch (err) {
                    console.error('Error processing QR:', err);
                }
            }

            try {
                const content = await zip.generateAsync({type: 'blob'});
                const fileName = `QR_Codes_${currentSection.charAt(0).toUpperCase() + currentSection.slice(1)}_${new Date().toISOString().split('T')[0]}.zip`;
                saveAs(content, fileName);
            } catch (err) {
                console.error('Error creating zip:', err);
                alert('Error creating download file. Please try again.');
            }

            // Hide loading
            document.getElementById('loading').classList.remove('show');
        }
    </script>
</body>

</html>
