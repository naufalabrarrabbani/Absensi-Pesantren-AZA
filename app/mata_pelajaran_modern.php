<?php
include '../include/koneksi.php';
session_start();
error_reporting(0);

// Check if user is logged in
if (!isset($_SESSION['level'])) {
    header('location:../login.php');
    exit();
}

$d_aplikasi = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from aplikasi"));
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Master Data Mata Pelajaran - <?= $d_aplikasi['nama_aplikasi']; ?></title>
    <meta name="description" content="Master Data Mata Pelajaran">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .main-wrapper {
            background: rgba(255, 255, 255, 0.95);
            min-height: 100vh;
            backdrop-filter: blur(10px);
        }

        .header-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: white;
            margin-bottom: 30px;
        }

        .card-header-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            border: none;
        }

        .btn-modern {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-success-modern {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-danger-modern {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
        }

        .form-modern {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .form-label-modern {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .table-modern {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .table-modern thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modal-modern .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .alert-modern {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .badge-modern {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- Header -->
        <div class="header-modern">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="mb-0">
                            <i class="fas fa-book-open me-2"></i>
                            Master Data Mata Pelajaran
                        </h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="karyawan_modern.php" class="btn btn-light btn-modern">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Alert Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= base64_decode($_GET['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= base64_decode($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add Form Card -->
            <div class="card card-modern">
                <div class="card-header card-header-modern">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tambah Mata Pelajaran Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="controller/mata_pelajaran_simpan.php" method="POST" id="addMapelForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kode_mapel" class="form-label form-label-modern">
                                        <i class="fas fa-code me-1"></i>
                                        Kode Mata Pelajaran
                                    </label>
                                    <input type="text" class="form-control form-modern" id="kode_mapel" name="kode_mapel" 
                                           placeholder="Contoh: MTK, IPA, IPS" maxlength="10" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_mapel" class="form-label form-label-modern">
                                        <i class="fas fa-book me-1"></i>
                                        Nama Mata Pelajaran
                                    </label>
                                    <input type="text" class="form-control form-modern" id="nama_mapel" name="nama_mapel" 
                                           placeholder="Contoh: Matematika, Ilmu Pengetahuan Alam" maxlength="100" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="reset" class="btn btn-secondary btn-modern me-2">
                                <i class="fas fa-undo me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary-modern btn-modern">
                                <i class="fas fa-save me-1"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table Card -->
            <div class="card card-modern">
                <div class="card-header card-header-modern">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Mata Pelajaran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-modern" id="mapelTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="20%">Kode</th>
                                    <th width="55%">Nama Mata Pelajaran</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = "SELECT * FROM mata_pelajaran ORDER BY kode_mapel ASC";
                                $result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
                                
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td><span class='badge bg-primary badge-modern'>" . htmlspecialchars($row['kode_mapel']) . "</span></td>";
                                        echo "<td>" . htmlspecialchars($row['nama_mapel']) . "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-success-modern btn-modern btn-sm me-1' onclick='editMapel(" . $row['id'] . ", \"" . htmlspecialchars($row['kode_mapel']) . "\", \"" . htmlspecialchars($row['nama_mapel']) . "\")'>";
                                        echo "<i class='fas fa-edit'></i>";
                                        echo "</button>";
                                        echo "<button class='btn btn-danger-modern btn-modern btn-sm' onclick='deleteMapel(" . $row['id'] . ", \"" . htmlspecialchars($row['nama_mapel']) . "\")'>";
                                        echo "<i class='fas fa-trash'></i>";
                                        echo "</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>Belum ada data mata pelajaran</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-modern">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Mata Pelajaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="controller/mata_pelajaran_update.php" method="POST" id="editMapelForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_kode_mapel" class="form-label form-label-modern">
                                <i class="fas fa-code me-1"></i>Kode Mata Pelajaran
                            </label>
                            <input type="text" class="form-control form-modern" id="edit_kode_mapel" name="kode_mapel" maxlength="10" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nama_mapel" class="form-label form-label-modern">
                                <i class="fas fa-book me-1"></i>Nama Mata Pelajaran
                            </label>
                            <input type="text" class="form-control form-modern" id="edit_nama_mapel" name="nama_mapel" maxlength="100" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary-modern btn-modern">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%); color: white;">
                    <h5 class="modal-title">
                        <i class="fas fa-trash me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus mata pelajaran <strong id="delete_nama"></strong>?</p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <a href="#" id="delete_link" class="btn btn-danger-modern btn-modern">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#mapelTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                },
                "pageLength": 10,
                "ordering": true,
                "searching": true
            });
        });

        function editMapel(id, kode, nama) {
            $('#edit_id').val(id);
            $('#edit_kode_mapel').val(kode);
            $('#edit_nama_mapel').val(nama);
            $('#editModal').modal('show');
        }

        function deleteMapel(id, nama) {
            $('#delete_nama').text(nama);
            $('#delete_link').attr('href', 'controller/mata_pelajaran_delete.php?id=' + id);
            $('#deleteModal').modal('show');
        }

        // Form validation
        $('#addMapelForm').on('submit', function(e) {
            const kode = $('#kode_mapel').val().trim();
            const nama = $('#nama_mapel').val().trim();
            
            if (kode === '' || nama === '') {
                e.preventDefault();
                alert('Semua field wajib diisi!');
                return false;
            }
        });

        $('#editMapelForm').on('submit', function(e) {
            const kode = $('#edit_kode_mapel').val().trim();
            const nama = $('#edit_nama_mapel').val().trim();
            
            if (kode === '' || nama === '') {
                e.preventDefault();
                alert('Semua field wajib diisi!');
                return false;
            }
        });
    </script>
</body>
</html>
