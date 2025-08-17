<?php
//koneksi ke database, username,password  dan namadatabase menyesuaikan 
include "../include/koneksi.php";

//memanggil file excel_reader
require "excel_reader.php";
 
//jika tombol import ditekan
if(isset($_POST['submit'])){
 
    $target = basename($_FILES['fileoff']['name']) ;
    move_uploaded_file($_FILES['fileoff']['tmp_name'], $target);
 
// tambahkan baris berikut untuk mencegah error is not readable
    chmod($_FILES['fileoff']['name'],0777);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['fileoff']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
   
    
//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//       membaca data (kolom ke-1 sd terakhir)
      $nik           	= $data->val($i, 1);
	  $tanggal         	= $data->val($i, 2);
	  $ijin			  	= $data->val($i, 3);
	  
 
//      setelah data dibaca, masukkan ke tabel karyawan sql
      $query = "INSERT into absensi (id, nik, tanggal, ijin) values
	  ('NULL','$nik','$tanggal','$ijin')";
      $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $query);
    }
    
    if(!$hasil){
//          jika import gagal
          die(mysqli_error($GLOBALS["___mysqli_ston"]));
      }else{
//          jika impor berhasil
		header('location:../off?sukses='.base64_encode('Import schedule off Sukses, Terimakasih'));
    }
    
//    hapus file xls yang udah dibaca
    unlink($_FILES['fileoff']['name']);
}
 
?>