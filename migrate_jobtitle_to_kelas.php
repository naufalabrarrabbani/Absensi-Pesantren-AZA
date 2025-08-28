<?php
require_once 'include/koneksi.php';

echo "<h2>Migrasi Data dari JobTitle ke Kelas</h2>";

// 1. Cek apakah tabel kelas ada
$cek_tabel = mysqli_query($GLOBALS["___mysqli_ston"], "SHOW TABLES LIKE 'kelas'");
if (mysqli_num_rows($cek_tabel) == 0) {
    echo "<p style='color: red;'>Tabel 'kelas' belum ada! Jalankan setup_kelas.php terlebih dahulu.</p>";
    exit;
}

echo "<h3>1. Memigrasikan data dari tabel jobtitle ke tabel kelas...</h3>";

// 2. Ambil data dari tabel jobtitle
$sql_jobtitle = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jobtitle");

if (mysqli_num_rows($sql_jobtitle) > 0) {
    $migrated = 0;
    $skipped = 0;
    
    while ($jobtitle = mysqli_fetch_assoc($sql_jobtitle)) {
        $kode_jobtitle = $jobtitle['kode_jobtitle'];
        $nama_jobtitle = $jobtitle['jobtitle'];
        
        // Cek apakah sudah ada di tabel kelas
        $cek_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE kode_kelas = '$kode_jobtitle'");
        
        if (mysqli_num_rows($cek_kelas) == 0) {
            // Extract tingkat dari nama kelas (misal: "7A" -> tingkat = 7)
            $tingkat = 7; // default
            if (preg_match('/^(\d+)/', $nama_jobtitle, $matches)) {
                $tingkat = intval($matches[1]);
            }
            
            // Insert ke tabel kelas
            $insert_kelas = "INSERT INTO kelas (kode_kelas, nama_kelas, tingkat, wali_kelas, ruang_kelas, jumlah_siswa, status, created_at) 
                           VALUES ('$kode_jobtitle', '$nama_jobtitle', $tingkat, '', '', 0, 'aktif', NOW())";
            
            if (mysqli_query($GLOBALS["___mysqli_ston"], $insert_kelas)) {
                echo "<p style='color: green;'>✓ Berhasil migrate: $nama_jobtitle ($kode_jobtitle)</p>";
                $migrated++;
            } else {
                echo "<p style='color: red;'>✗ Gagal migrate: $nama_jobtitle ($kode_jobtitle) - " . mysqli_error($GLOBALS["___mysqli_ston"]) . "</p>";
            }
        } else {
            echo "<p style='color: orange;'>- Sudah ada: $nama_jobtitle ($kode_jobtitle)</p>";
            $skipped++;
        }
    }
    
    echo "<h3>Hasil Migrasi:</h3>";
    echo "<p>✓ Berhasil migrate: <strong>$migrated</strong> kelas</p>";
    echo "<p>- Sudah ada: <strong>$skipped</strong> kelas</p>";
} else {
    echo "<p style='color: orange;'>Tidak ada data di tabel jobtitle untuk dimigrasikan.</p>";
}

echo "<h3>2. Memperbarui data siswa untuk menggunakan kode kelas baru...</h3>";

// 3. Update data siswa yang masih menggunakan kode_jobtitle
$sql_siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nik, job_title FROM karyawan WHERE job_title IS NOT NULL AND job_title != ''");

if (mysqli_num_rows($sql_siswa) > 0) {
    $updated = 0;
    $not_found = 0;
    
    while ($siswa = mysqli_fetch_assoc($sql_siswa)) {
        $nik = $siswa['nik'];
        $old_job_title = $siswa['job_title'];
        
        // Cek apakah job_title tersebut ada di tabel kelas
        $cek_kelas_siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT kode_kelas FROM kelas WHERE kode_kelas = '$old_job_title'");
        
        if (mysqli_num_rows($cek_kelas_siswa) > 0) {
            echo "<p style='color: green;'>✓ Siswa NIK $nik sudah menggunakan kode kelas yang valid: $old_job_title</p>";
            $updated++;
        } else {
            echo "<p style='color: red;'>✗ Siswa NIK $nik menggunakan kode kelas yang tidak ditemukan: $old_job_title</p>";
            $not_found++;
        }
    }
    
    echo "<h3>Hasil Update Siswa:</h3>";
    echo "<p>✓ Siswa dengan kelas valid: <strong>$updated</strong></p>";
    echo "<p>✗ Siswa dengan kelas tidak valid: <strong>$not_found</strong></p>";
} else {
    echo "<p style='color: orange;'>Tidak ada data siswa yang perlu diupdate.</p>";
}

echo "<h3>3. Menampilkan data kelas yang tersedia:</h3>";

// 4. Tampilkan semua kelas yang tersedia
$sql_all_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas ORDER BY tingkat ASC, kode_kelas ASC");

if (mysqli_num_rows($sql_all_kelas) > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>Kode Kelas</th><th>Nama Kelas</th><th>Tingkat</th><th>Status</th>";
    echo "</tr>";
    
    while ($kelas = mysqli_fetch_assoc($sql_all_kelas)) {
        $bg_color = ($kelas['status'] == 'aktif') ? '#e8f5e8' : '#ffe8e8';
        echo "<tr style='background-color: $bg_color;'>";
        echo "<td>{$kelas['kode_kelas']}</td>";
        echo "<td>{$kelas['nama_kelas']}</td>";
        echo "<td>{$kelas['tingkat']}</td>";
        echo "<td>{$kelas['status']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: red;'>Tidak ada data kelas yang ditemukan.</p>";
}

echo "<h3>✅ Migrasi Selesai!</h3>";
echo "<p>Sekarang field kelas di form siswa akan menggunakan data dari master data kelas.</p>";
echo "<p><a href='app/kelas_modern.php'>👉 Kelola Master Data Kelas</a></p>";
echo "<p><a href='app/karyawan_modern.php'>👉 Kelola Data Siswa</a></p>";
?>
