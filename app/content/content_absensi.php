<div class="container-fluid">
	<div class="row">
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
				</form>                       
           </div>    
        </div>
		<a href="ijin"> <div class="col-md-3">
                   <div class="info-box-3 bg-red hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">highlight_off</i>
                        </div>
                        <div class="content">
                            <div class="text">SISWA TIDAK MASUK</div>
							<?php $s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan");
							$karyawan = mysqli_fetch_array($s_karyawan);
							$t_karyawan = mysqli_num_rows($s_karyawan);
							$skr = date('Y-m-d');
							$s_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi where tanggal='$skr' and ijin is NULL order by masuk DESC");
							$t_absen = mysqli_num_rows($s_absen); 
							?>
                            <div class="number"><?= $t_karyawan-$t_absen;?></div>
                        </div>
                    </div>
                </div></a>
		
	</div>
            <div class="row clearfix">
			 <div class="card">
                        <div class="header">
                            <h2>
                                DATA ABSENSI
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th>NISN</th>
                                            <th>Nama</th>
                                            <th>Status Siswa</th>
                                            <th>Lokasi</th>
											<th>Area</th>
                                            <th>SubArea</th>
											<th>Tanggal</th>
                                            <th>Jam Masuk</th>
											<th>Jam Pulang</th>
											<th>Jam Sekolah</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
									<?php
										$s_absen = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM absensi,karyawan where absensi.nik=karyawan.nik AND tanggal between '$_GET[start_date]' AND '$_GET[end_date]' AND karyawan.area LIKE '%$_GET[area]'");
										while ($d_absen=mysqli_fetch_array($s_absen)){
									?>
                                        <tr>
											
                                            <td><?= $d_absen['nik'];?></td>
                                            <td><?= $d_absen['nama'];?></td>
                                            <td><?= $d_absen['job_title'];?></td>
                                            <td><?= $d_absen['lokasi'];?></td>
											<td><?php $a=$d_absen['area']; $d_a = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from area where kode_area ='$a'")); echo $d_a['area'];?></td>
                                            <td><?= $d_absen['sub_area'];?></td>
											<td><?= $d_absen['tanggal'];?></td>
                                            <td><?= $d_absen['masuk'];?></td>
                                            <td><?= $d_absen['pulang'];?></td>
                                            <td><?php $hourdiff  = round((strtotime($d_absen['pulang']) - strtotime($d_absen['masuk']))/3600, 1);
													if ($hourdiff > 8) { echo $hourdiff;} else if ($hourdiff < 8){?>
													<a style="color:red"><?= $hourdiff; ?></a>
													<?php ;} ?>
													</td>	
											<td>
											<?php 
												if($_SESSION['area']=='all'){
											?>
											<div class="btn-group">
												<a class="pilih_absen" data-toggle="modal" data-target="#edit_absen" p1="<?= $d_absen['nik'];?>" p2="<?= $d_absen['masuk'];?>" p3="<?= $d_absen['pulang'];?>" p4="<?= $d_absen['tanggal'];?>"><button  type="button" class="btn bg-blue btn-block btn-xs" >
													  <i class="material-icons">edit</i>
												</button></a>
												
											</div>
											<?php 
												;} else if($a==$_SESSION['area']){
											?>
											<div class="btn-group">
												<a class="pilih_absen" data-toggle="modal" data-target="#edit_absen" p1="<?= $d_absen['nik'];?>" p2="<?= $d_absen['masuk'];?>" p3="<?= $d_absen['pulang'];?>" p4="<?= $d_absen['tanggal'];?>"><button  type="button" class="btn bg-blue btn-block btn-xs" >
													  <i class="material-icons">edit</i>
												</button></a>
												
											</div>
											<?php
												;} else{ echo'';}
											?></td>
                                        </tr>
									<?php ;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
			</div>
</div>
							<div class="modal fade" id="edit_absen" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-sm" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="smallModalLabel">Edit Absensi<h4>
										</div>
										<div class="modal-body">
										<form name="myForm" id="myForm" action="controller/absensi_edit.php?start_date=<?= $_GET['start_date'];?>&end_date=<?= $_GET['end_date'];?>&area=<?= $_GET['area'];?>" method="post" enctype="multipart/form-data">
											<div class="row clearfix">
													<div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">NISN</label>
													</div>
													<div class="col-sm-8">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="nik_pegawai" name="nik" class="form-control" readonly="readonly" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">Tanggal</label>
													</div>
													<div class="col-sm-8">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="tanggal" name="tanggal" class="form-control" readonly="readonly" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-3 col-md-3col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">Masuk</label>
													</div>
													<div class="col-sm-8">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="masuk" name="masuk" class="timepicker form-control" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-3 col-md-3 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">Pulang</label>
													</div>
													<div class="col-sm-8">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="pulang" name="pulang" class="timepicker form-control" required>
															</div>
														</div>
													</div>
												</div>
										</div>
										<div class="modal-footer">
											<input type="submit" name="submit"  class="btn btn-success waves-effect" value="Edit" />
											<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
										</div>
										</form>
										
									</div>
								</div>
							</div>