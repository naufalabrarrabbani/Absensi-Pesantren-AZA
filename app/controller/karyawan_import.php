<?php
//koneksi ke database, username,password  dan namadatabase menyesuaikan 
include "../include/koneksi.php";

//memanggil file excel_reader
require "excel_reader.php";
 
//jika tombol import ditekan
if(isset($_POST['submit'])){
 
    $target = basename($_FILES['filekaryawan']['name']) ;
    move_uploaded_file($_FILES['filekaryawan']['tmp_name'], $target);
 
// tambahkan baris berikut untuk mencegah error is not readable
    chmod($_FILES['filekaryawan']['name'],0777);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['filekaryawan']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
    if($drop == 1){
//             kosongkan tabel karyawan
             $truncate ="TRUNCATE TABLE karyawan";
             mysqli_query($GLOBALS["___mysqli_ston"], $truncate);
    };
    
//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//       membaca data (kolom ke-1 sd terakhir)
      $nik           	= $data->val($i, 2);
	  $nama           	= $data->val($i, 3);
      $job_title   		= $data->val($i, 4);
      $no_telp		  	= $data->val($i, 5);
      $nama_ayah	  	= $data->val($i, 6);
	  $jenis_kelamin  	= $data->val($i, 7);
	  $agama	  		= $data->val($i, 8);
	  $lokasi		  	= $data->val($i, 9);
	  $area			  	= $data->val($i, 10);
	  $sub_area		  	= $data->val($i, 11);
	  $start_date  		= $data->val($i, 12);
	  $end_date  		= $data->val($i, 13);

 
//      setelah data dibaca, masukkan ke tabel karyawan sql
      $query = "INSERT into karyawan (id, nik, nama, job_title, no_telp, nama_ayah, jenis_kelamin, agama, lokasi, area, sub_area, start_date, end_date) values
	  ('NULL','$nik','$nama','$job_title','$no_telp', '$nama_ayah', '$jenis_kelamin','$agama','$lokasi','$area','$sub_area','$start_date','$end_date')";
      $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    }
    
    if(!$hasil){
//          jika import gagal
          die(mysqli_error($GLOBALS["___mysqli_ston"]));
      }else{
//          jika impor berhasil
		header('location:../karyawan?sukses='.base64_encode('Import karyawan Sukses, Terimakasih'));
    }
    
//    hapus file xls yang udah dibaca
    unlink($_FILES['filekaryawan']['name']);
}
 
?>