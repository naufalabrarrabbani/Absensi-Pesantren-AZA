<div class="container-fluid">
			<div class="row clearfix">
			<div class="block-header">
                <h2><?php $tanggal = date('d M Y');
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
								echo $dayList[$day].", ".$tanggal;?></h2>
            </div>
                <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">SISWA AKTIF</div>
                            <div class="number"><?php $s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan");
							$karyawan = mysqli_fetch_array($s_karyawan);
							$t_karyawan = mysqli_num_rows($s_karyawan);
							echo $t_karyawan;?></div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-green hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">check_box</i>
                        </div>
                        <div class="content">
                            <div class="text">SISWA MASUK</div>
                            <div class="number"><?php 
						$skr = date('Y-m-d');
						$s_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi where tanggal='$skr' and ijin is NULL order by masuk DESC");
						$t_absen = mysqli_num_rows($s_absen); echo $t_absen; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-red hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">highlight_off</i>
                        </div>
                        <div class="content">
                            <div class="text">SISWA TIDAK MASUK</div>
                            <div class="number"><?= $t_karyawan-$t_absen;?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-cyan hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">home</i>
                        </div>
                        <div class="content">
                            <div class="text">SISWA PULANG</div>
                            <div class="number"><?php 
						$s_pulang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi where tanggal='$skr' AND pulang !='0' order by pulang DESC");
						$t_pulang = mysqli_num_rows($s_pulang); echo $t_pulang; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
			
            <div class="row clearfix">
			 <div class="block-header">
                <h2><?= $d_aplikasi['nama_perusahaan'];?></h2>
            </div>
			 <div class="row">
                <!-- Basic Examples -->
                
                <!-- #END# Basic Examples -->
                <!-- Badges -->
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SISWA MASUK
                            </h2>
                            
                        </div>
                        <div class="body">
                            <ul class="list-group">
								<?php
								$s_area = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from area ");
									while ($d_area=mysqli_fetch_array($s_area)){
								?>
                                <li class="list-group-item"><?php echo $d_area['area'];?><span class="badge bg-green">
								<?php
								$d_masuk = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi,karyawan where absensi.nik= karyawan.nik AND karyawan.area='$d_area[kode_area]' AND absensi.tanggal='$skr' AND absensi.ijin is NULL"));
								echo $d_masuk;?> orang</span></li>
								<?php ;}
								?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Badges -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SISWA TIDAK MASUK 
                            </h2>
                            
                        </div>
                        <div class="body">
                            <ul class="list-group">
								<?php
								$s_area1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from area ");
									while ($d_area1=mysqli_fetch_array($s_area1)){
								?>
                                <li class="list-group-item"><?php echo $d_area1['area'];?><span class="badge bg-red">
								<?php
								$d_masuk1 = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi,karyawan where absensi.nik= karyawan.nik AND karyawan.area='$d_area1[kode_area]' AND absensi.tanggal='$skr' AND absensi.ijin is NULL"));
								$d_total = mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where area='$d_area1[kode_area]'"));
								echo $d_total-$d_masuk1;?> orang</span></li>
								<?php ;}
								?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- #END# Badges -->
            </div>
			</div>
</div>