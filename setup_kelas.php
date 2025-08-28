<?php
// Script untuk membuat tabel kelas jika belum ada
include 'include/koneksi.php';

// Check if kelas table exists
$check_table = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'kelas'");

if (mysqli_num_rows($check_table) == 0) {
    // Create kelas table
    $create_table = "
    CREATE TABLE `kelas` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `kode_kelas` varchar(10) NOT NULL,
      `nama_kelas` varchar(50) NOT NULL,
      `tingkat` enum('7','8','9') NOT NULL,
      `jurusan` varchar(30) DEFAULT NULL,
      `wali_kelas` varchar(100) DEFAULT NULL,
      `kapasitas` int(3) DEFAULT 30,
      `status` enum('aktif','nonaktif') DEFAULT 'aktif',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `kode_kelas` (`kode_kelas`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    if (mysqli_query($GLOBALS["___mysqli_ston"], $create_table)) {
        echo "Tabel kelas berhasil dibuat!<br>";
        
        // Insert sample data
        $sample_data = [
            ['7A', 'VII A', '7', 'Umum', 'Ahmad Sari, S.Pd', 32],
            ['7B', 'VII B', '7', 'Umum', 'Siti Nurhaliza, S.Pd', 30],
            ['7C', 'VII C', '7', 'Umum', 'Budi Santoso, S.Pd', 31],
            ['8A', 'VIII A', '8', 'Umum', 'Rina Kartika, S.Pd', 29],
            ['8B', 'VIII B', '8', 'Umum', 'Dedi Mulyadi, S.Pd', 28],
            ['8C', 'VIII C', '8', 'Umum', 'Maya Sari, S.Pd', 30],
            ['9A', 'IX A', '9', 'IPA', 'Dr. Hendra, S.Pd', 27],
            ['9B', 'IX B', '9', 'IPS', 'Lina Marlina, S.Pd', 26],
            ['9C', 'IX C', '9', 'IPA', 'Rudi Hermawan, S.Pd', 28]
        ];
        
        foreach ($sample_data as $data) {
            $insert_query = "INSERT INTO kelas (kode_kelas, nama_kelas, tingkat, jurusan, wali_kelas, kapasitas) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], $insert_query);
            mysqli_stmt_bind_param($stmt, "sssssi", $data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
            mysqli_stmt_execute($stmt);
        }
        
        echo "Data contoh berhasil ditambahkan!<br>";
        echo "<strong>Tabel kelas telah siap digunakan!</strong><br><br>";
        echo "<a href='app/kelas_modern.php'>Akses Halaman Master Data Kelas</a>";
        
    } else {
        echo "Error membuat tabel: " . mysqli_error($GLOBALS["___mysqli_ston"]);
    }
} else {
    echo "Tabel kelas sudah ada!<br>";
    echo "<a href='app/kelas_modern.php'>Akses Halaman Master Data Kelas</a>";
}
?>
