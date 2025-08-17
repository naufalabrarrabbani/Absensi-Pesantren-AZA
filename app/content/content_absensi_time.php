<div class="container-fluid">
	<div class="row">
	    <div class="card col-md-8">
            <div class="body">
			<form method="get">				
				<div class="col-sm-3 ">
					<div class="form-group">
						<div class="form-line">
							<input type="text" id="date" name="start_date" value="<?= $_GET['start_date']?>" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="Start Date" required>
						</div>
					</div>
				</div>
										
				<div class="col-sm-3">
					<div class="form-group">
						<div class="form-line">
							<input type="text" id="date2" name="end_date" value="<?= $_GET['end_date']?>" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="End Date" required>
						</div>
					</div>
				</div>
				<div class="col-sm-4 ">
					<div class="form-group">
					<?php if($_SESSION['area']=='all') { ?>
						<select name="area" class="form-control show-tick">
							<option value="">-- Pilih Area --</option>
								<?php
									$a=$_GET['area'];
									$sql_a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area");
									while($d_a = mysqli_fetch_assoc($sql_a)){
									if($a == $d_a['kode_area']){
									echo '<option value="'.$d_a['kode_area'].'" selected>'.$d_a['area'].'</option>';
										} else {
									echo '<option value="'.$d_a['kode_area'].'">'.$d_a['area'].'</option>';		
										}
									}
								?>
								
						</select>
						<?php ;} else {?>
						<select name="area" class="form-control show-tick">
							
								<?php
									$a=$_GET['area'];
									$sql_a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area where kode_area='$_SESSION[area]'");
									while($d_a = mysqli_fetch_assoc($sql_a)){
									
									echo '<option value="'.$d_a['kode_area'].'" selected>'.$d_a['area'].'</option>';
										
									}
								?>
								
						</select>
						<?php ;} ?>
					</div>
				</div>
				<button type="submit" class="btn btn-primary waves-effect">
                <i class="material-icons">search</i>
                <span>FILTER</span>
                </button>
				                       
           </div>    
        </div>
	</div>
            <div class="row clearfix">
			 <div class="card">
                        <div class="header">
                            <h2>
                                LAPORAN TIMESHEET
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th>NISN</th>
                                            <th>Nama</th>
                                            <th>Status Keanggotaan</th>
                                            <th>Lokasi</th>
											<th>Area</th>
                                            <th>SubArea</th>
                                            <th>Absen</th>
											<?php
											$date = $_GET['start_date'];
											while ($date <= $_GET['end_date'])
											{ ?>
											<th><?= $date;?> </th>	
											<?php $date = date('Y-m-d', strtotime($date . ' +1 day')); }
											 ?>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
									<?php
										$s_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM absensi,karyawan where absensi.nik=karyawan.nik AND tanggal between '$_GET[start_date]' AND '$_GET[end_date]' AND karyawan.area LIKE '%$_GET[area]' GROUP BY karyawan.nik");
										while ($d_absen=mysqli_fetch_array($s_absen)){
									?>
									<tr>
                                            <td><?= $d_absen['nik'];?></td>
                                            <td><?= $d_absen['nama'];?></td>
                                            <td><?= $d_absen['job_title'];?></td>
                                            <td><?= $d_absen['lokasi'];?></td>
											<td><?= $d_absen['area'];?></td>
                                            <td><?= $d_absen['sub_area'];?></td>
                                            <td>Masuk</td>
										<?php
											$date = $_GET['start_date'];
											while ($date <= $_GET['end_date'])
											{ ?>
											<td><?php 
											$s_masuk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM absensi where nik='$d_absen[nik]' AND tanggal='$date' GROUP by nik");
											$d_masuk=mysqli_fetch_array($s_masuk);
											?>
											<?php $hourdiff  = round((strtotime($d_masuk['pulang']) - strtotime($d_masuk['masuk']))/3600, 1);
													if ($hourdiff > 8) { echo '1';} else if ($hourdiff < 8){?>
													<a style="color:red"><?= $d_masuk['ijin']?></a>
													<?php ;} ?>
											 </td>	
											<?php $date = date('Y-m-d', strtotime($date . ' +1 day')); }
											 ?>
                                        </tr>
										
										<?php ;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
			</div>
</div>
