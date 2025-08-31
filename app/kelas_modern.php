<?php
include '../include/koneksi.php';
session_start();
error_reporting(0);

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('location:../login.php');
    exit();
}

// Check if kelas table exists, if not redirect to setup
$check_table = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'kelas'");
if (mysqli_num_rows($check_table) == 0) {
    header('location:../setup_kelas.php');
    exit();
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));

// Handle form submissions
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $kode_kelas = $_POST['kode_kelas'];
                $nama_kelas = $_POST['nama_kelas'];
                $tingkat = $_POST['tingkat'];
                $jurusan = $_POST['jurusan'];
                $wali_kelas = $_POST['wali_kelas'];
                $kapasitas = $_POST['kapasitas'];
                
                $query = "INSERT INTO kelas (kode_kelas, nama_kelas, tingkat, jurusan, wali_kelas, kapasitas) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);
                mysqli_stmt_bind_param($stmt, "sssssi", $kode_kelas, $nama_kelas, $tingkat, $jurusan, $wali_kelas, $kapasitas);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "Kelas berhasil ditambahkan!";
                } else {
                    $error_message = "Gagal menambahkan kelas!";
                }
                break;
                
            case 'edit':
                $id = $_POST['id'];
                $kode_kelas = $_POST['kode_kelas'];
                $nama_kelas = $_POST['nama_kelas'];
                $tingkat = $_POST['tingkat'];
                $jurusan = $_POST['jurusan'];
                $wali_kelas = $_POST['wali_kelas'];
                $kapasitas = $_POST['kapasitas'];
                $status = $_POST['status'];
                
                $query = "UPDATE kelas SET kode_kelas=?, nama_kelas=?, tingkat=?, jurusan=?, wali_kelas=?, kapasitas=?, status=? WHERE id=?";
                $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);
                mysqli_stmt_bind_param($stmt, "sssssisi", $kode_kelas, $nama_kelas, $tingkat, $jurusan, $wali_kelas, $kapasitas, $status, $id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $success_message = "Kelas berhasil diupdate!";
                } else {
                    $error_message = "Gagal mengupdate kelas! Error: " . mysqli_error($GLOBALS["___mysqli_ston"]);
                }
                break;
        }
    }
}

// Handle delete
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM kelas WHERE id = ?";
    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Kelas berhasil dihapus!";
    } else {
        $error_message = "Gagal menghapus kelas!";
    }
}

// Get all classes
$classes_query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas ORDER BY tingkat ASC, kode_kelas ASC");
if (!$classes_query) {
    $error_message = "Error mengambil data kelas: " . mysqli_error($GLOBALS["___mysqli_ston"]);
    $total_classes = 0;
    $active_classes = 0;
    $inactive_classes = 0;
} else {
    $total_classes = mysqli_num_rows($classes_query);
    
    // Count by status
    $active_result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) as count FROM kelas WHERE status='aktif'");
    $active_classes = $active_result ? mysqli_fetch_array($active_result)['count'] : 0;
    
    $inactive_result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(*) as count FROM kelas WHERE status='nonaktif'");
    $inactive_classes = $inactive_result ? mysqli_fetch_array($inactive_result)['count'] : 0;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $d_aplikasi['nama_aplikasi']; ?> - Master Data Kelas</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8F8FA;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #fff;
            padding: 50px 20px;
            height: 100vh;
            overflow-y: scroll;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
            width: 260px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            margin-bottom: 30px;
            flex-direction: column;
        }

        .sidebar-logo img {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .sidebar-logo span {
            font-weight: 700;
            font-size: 16px;
            color: #121F3E;
            text-align: center;
        }

        .sidebar-title {
            font-weight: 400;
            font-size: 14px;
            color: #ABB3C4;
            margin: 40px 0 12px 0;
        }

        .sidebar-item {
            text-decoration: none;
            display: flex;
            align-items: center;
            height: 46px;
            border-radius: 16px;
            padding: 0 16px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            color: #121F3E;
        }

        .sidebar-item:hover {
            background: #f8f9fa;
            color: #121F3E;
            text-decoration: none;
        }

        .sidebar-item.active {
            background: #4640DE;
            color: #fff;
        }

        .sidebar-item i {
            width: 18px;
            margin-right: 20px;
            font-size: 18px;
        }

        .main-content {
            margin-left: 260px;
            padding: 50px 40px;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
        }

        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: #121F3E;
        }

        .stats-label {
            color: #ABB3C4;
            font-size: 14px;
            margin-top: 5px;
        }

        .data-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .btn-modern {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-modern.primary {
            background: #4640DE;
            color: white;
        }

        .btn-modern.success {
            background: #4CAF50;
            color: white;
        }

        .btn-modern.warning {
            background: #FF9800;
            color: white;
        }

        .btn-modern.danger {
            background: #F44336;
            color: white;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }

        .form-control:focus {
            border-color: #4640DE;
            box-shadow: 0 0 0 0.2rem rgba(70, 64, 222, 0.25);
        }

        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
        }

        .table-modern {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .table-modern thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table-modern th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table-modern td {
            border: none;
            padding: 15px;
            vertical-align: middle;
        }

        .table-modern tbody tr {
            border-bottom: 1px solid #f8f9fa;
        }

        .table-modern tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-aktif {
            background-color: #e8f5e8;
            color: #4CAF50;
        }

        .badge-nonaktif {
            background-color: #ffebee;
            color: #F44336;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons .btn {
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="sidebar-logo">
            <img src="../images/logo smp.png" alt="Logo">
            <span><?= $d_aplikasi['nama_aplikasi']; ?></span>
        </a>

        <h5 class="sidebar-title">Daily Use</h5>
        <a href="home_modern.php" class="sidebar-item">
            <i class="fas fa-th"></i>
            <span>Overview</span>
        </a>
        <a href="karyawan_modern.php" class="sidebar-item">
            <i class="fas fa-users"></i>
            <span>Siswa</span>
        </a>
        <a href="guru_modern.php" class="sidebar-item">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Guru</span>
        </a>
        <a href="absensi_modern.php" class="sidebar-item">
            <i class="fas fa-clipboard-list"></i>
            <span>Absensi Siswa</span>
        </a>
        <a href="absensi_guru_modern.php" class="sidebar-item">
            <i class="fas fa-calendar-check"></i>
            <span>Absensi Guru</span>
        </a>

        <h5 class="sidebar-title">Master Data</h5>
        <a href="kelas_modern.php" class="sidebar-item active">
            <i class="fas fa-school"></i>
            <span>Kelas</span>
        </a>
        <a href="area_modern.php" class="sidebar-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>Area</span>
        </a>
        <a href="generate_qr.php" class="sidebar-item">
            <i class="fas fa-qrcode"></i>
            <span>Generate QR</span>
        </a>

        <h5 class="sidebar-title">Others</h5>
        <a href="setting_modern.php" class="sidebar-item">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <a href="../controllers/logout.php" class="sidebar-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="mb-0">
                <i class="fas fa-school me-3"></i>Master Data Kelas
            </h1>
            <p class="mb-0 mt-2">Kelola data kelas dan pengaturan kelas di sekolah</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number"><?= $total_classes; ?></div>
                            <div class="stats-label">Total Kelas</div>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number"><?= $active_classes; ?></div>
                            <div class="stats-label">Kelas Aktif</div>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stats-number"><?= $inactive_classes; ?></div>
                            <div class="stats-label">Kelas Nonaktif</div>
                        </div>
                        <div class="text-danger">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Card -->
        <div class="data-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-list me-2"></i>Daftar Kelas
                </h3>
                <button class="btn btn-modern primary" data-bs-toggle="modal" data-bs-target="#addClassModal">
                    <i class="fas fa-plus me-2"></i>Tambah Kelas
                </button>
            </div>

            <!-- Search -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari kelas...">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Kelas</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($classes_query && mysqli_num_rows($classes_query) > 0) {
                            $no = 1;
                            mysqli_data_seek($classes_query, 0);
                            while ($class = mysqli_fetch_assoc($classes_query)): 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($class['kode_kelas']); ?></strong></td>
                            <td><?= htmlspecialchars($class['nama_kelas']); ?></td>
                            <td>
                                <span class="badge bg-primary">Kelas <?= htmlspecialchars($class['tingkat']); ?></span>
                            </td>
                            <td><?= htmlspecialchars($class['jurusan']) ?: '-'; ?></td>
                            <td><?= htmlspecialchars($class['wali_kelas']) ?: '-'; ?></td>
                            <td>
                                <i class="fas fa-users me-1"></i><?= htmlspecialchars($class['kapasitas']); ?> siswa
                            </td>
                            <td>
                                <span class="badge-status badge-<?= $class['status']; ?>">
                                    <?= ucfirst(htmlspecialchars($class['status'])); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-warning btn-sm" 
                                            onclick="editClass(<?= htmlspecialchars(json_encode($class)); ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="?delete=<?= $class['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus kelas <?= htmlspecialchars($class['nama_kelas']); ?>?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        } else {
                        ?>
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-school fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data kelas</h5>
                                    <p class="text-muted">Silakan tambahkan kelas baru menggunakan tombol di atas</p>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Class Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus me-2"></i>Tambah Kelas Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Kelas</label>
                                <input type="text" class="form-control" name="kode_kelas" required 
                                       placeholder="Contoh: 7A, 8B, 9C">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" name="nama_kelas" required 
                                       placeholder="Contoh: VII A, VIII B, IX C">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tingkat</label>
                                <select class="form-control" name="tingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="7">Kelas 7</option>
                                    <option value="8">Kelas 8</option>
                                    <option value="9">Kelas 9</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control" name="jurusan" 
                                       placeholder="Contoh: IPA, IPS, Umum">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <input type="text" class="form-control" name="wali_kelas" 
                                       placeholder="Nama lengkap wali kelas">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" name="kapasitas" 
                                       value="30" min="1" max="50">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-modern primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Class Modal -->
    <div class="modal fade" id="editClassModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Kelas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="editForm">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kode Kelas</label>
                                <input type="text" class="form-control" name="kode_kelas" id="edit_kode_kelas" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" name="nama_kelas" id="edit_nama_kelas" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tingkat</label>
                                <select class="form-control" name="tingkat" id="edit_tingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="7">Kelas 7</option>
                                    <option value="8">Kelas 8</option>
                                    <option value="9">Kelas 9</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control" name="jurusan" id="edit_jurusan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Wali Kelas</label>
                                <input type="text" class="form-control" name="wali_kelas" id="edit_wali_kelas">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" name="kapasitas" id="edit_kapasitas" min="1" max="50">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="edit_status" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-modern warning">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Search functionality
        function searchClasses() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.table-modern tbody');
            const rows = table.querySelectorAll('tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let found = false;
                
                // Search in kode_kelas, nama_kelas, tingkat, jurusan, wali_kelas
                for (let i = 1; i <= 5; i++) {
                    if (cells[i] && cells[i].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                
                if (found || filter === '') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Edit class function
        function editClass(classData) {
            document.getElementById('edit_id').value = classData.id;
            document.getElementById('edit_kode_kelas').value = classData.kode_kelas;
            document.getElementById('edit_nama_kelas').value = classData.nama_kelas;
            document.getElementById('edit_tingkat').value = classData.tingkat;
            document.getElementById('edit_jurusan').value = classData.jurusan || '';
            document.getElementById('edit_wali_kelas').value = classData.wali_kelas || '';
            document.getElementById('edit_kapasitas').value = classData.kapasitas;
            document.getElementById('edit_status').value = classData.status;
            
            const editModal = new bootstrap.Modal(document.getElementById('editClassModal'));
            editModal.show();
        }

        // Add event listener for search
        document.getElementById('searchInput').addEventListener('input', searchClasses);

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    </script>
</body>
</html>
