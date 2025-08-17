<div class="container-fluid">
	<?php $detail=mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where nik='$_GET[nik]'")); ?>
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
            <div class="body">
			
            </div>    
            </div>
			
            <div class="row clearfix">
			 <div class="card">
                        <div class="header">
                            <h2>
                                DATA SISWA
                            </h2>
                        </div>
                        <div class="body">
										 
											<form action="controller/karyawan_edit" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">NISN</label>
													</div>
													<div class="col-sm-3">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="nik" name="nik" readonly="readonly" class="form-control" value="<?= $detail['nik'];?>" placeholder="Masukkan NISN" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Nama</label>
													</div>
													<div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="text"  name="nama" id="nama" class="form-control" value="<?= $detail['nama'];?>" placeholder="Nama Lengkap" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Kelas</label>
													</div>
													<div class="col-sm-8">
														<div class="form-group">
															<select name="job_title" class="form-control show-tick" required>
															<option value="">-- Pilih Kelas --</option>
															<?php
															$jt = $detail['job_title'];
															$sql_jt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jobtitle");
															while($d_jt = mysqli_fetch_assoc($sql_jt)){
															if($jt == $d_jt['kode_jobtitle']){
															echo '<option value="'.$d_jt['kode_jobtitle'].'" selected>'.$d_jt['jobtitle'].'</option>';
																	} else{
															echo '<option value="'.$d_jt['kode_jobtitle'].'" >'.$d_jt['jobtitle'].'</option>';			
																	}
																}
															?>
															</select>
														</div>
													</div>
												</div>
												<!--<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Pekerjaan</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="jenis_kelamin" id="jk"  required>
																		<option value="">-- Pilih Jenis Pekerjaan --</option>
																		<option value="Karyawan Swasta" <?php if (!(strcmp("Karyawan Swasta", htmlentities($detail['jenis_kelamin'])))) {echo "selected=\"selected\"";} ?>>Karyawan Swasta</option>
																		<option value="Wiraswasta" <?php if (!(strcmp("Wiraswasta", htmlentities($detail['jenis_kelamin'])))) {echo "selected=\"selected\"";} ?>>Wiraswasta</option>
																		
																	</select>
														</div>
													</div>
												</div>
												
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Nama Ayah</label>
													</div>
													<div class="col-sm-5">
														<div class="form-group">
															<div class="form-line">
																<input type="text"  name="nama_ayah" id="nama_ayah" value="<?= $detail['nama_ayah'];?>" class="form-control" placeholder="Nama Ayah" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Nama Ibu</label>
													</div>
													<div class="col-sm-5">
														<div class="form-group">
															<div class="form-line">
																<input type="text"  name="no_telp" id="no_telp" value="<?= $detail['no_telp'];?>" class="form-control" placeholder="Nama Ibu" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Status</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="agama" id="agama" class="form-control show-tick" required>
																		<option value="">-- Pilih Status --</option>
																		<option value="Islam" <?php if (!(strcmp("Islam", htmlentities($detail['agama'])))) {echo "selected=\"selected\"";} ?>>Islam</option>
																		<option value="Hindu" <?php if (!(strcmp("Hindu", htmlentities($detail['agama'])))) {echo "selected=\"selected\"";} ?>>Hindu</option>
																		<option value="Budha" <?php if (!(strcmp("Budha", htmlentities($detail['agama'])))) {echo "selected=\"selected\"";} ?>>Budha</option>
																		<option value="Menikah" <?php if (!(strcmp("Menikah", htmlentities($detail['agama'])))) {echo "selected=\"selected\"";} ?>>Menikah</option>
																		<option value="Lajang" <?php if (!(strcmp("Lajang", htmlentities($detail['agama'])))) {echo "selected=\"selected\"";} ?>>Lajang</option>
																	</select>
														</div>
													</div>
												</div>-->
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Jenis kelamin</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
															<select name="Jenis Kelamin" id="lokasi" class="form-control show-tick" id="agama" name="agama" required>
															<option value="">-- Jenis Kelamin --</option>
															<?php
															$lok = $detail['lokasi'];
															$sql_l = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM lokasi");
															while($d_l = mysqli_fetch_assoc($sql_l)){
																if($lok == $d_l['lokasi']){
															echo '<option value="'.$d_l['lokasi'].'" selected>'.$d_l['lokasi'].'</option>';
																	} else {
															echo '<option value="'.$d_l['lokasi'].'" >'.$d_l['lokasi'].'</option>';			
																	}
																}
															?>
															</select>
															
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Area</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
															<select name="area" id="area" class="form-control show-tick" required>
															<option value="">-- Pilih Area --</option>
															<?php
															$ar = $detail['area'];
															$sql_a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area");
															while($d_a = mysqli_fetch_assoc($sql_a)){
																if($ar == $d_a['kode_area']){
															echo '<option value="'.$d_a['kode_area'].'" selected>'.$d_a['area'].'</option>';
																	} else {
															echo '<option value="'.$d_a['kode_area'].'" >'.$d_a['area'].'</option>';			
																	}
																}
															?>
															</select>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Sub Area</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
															<select name="sub_area" id="sub_area" class="form-control show-tick" required>
															<option value="">-- Pilih Sub Area --</option>
															<?php
															$sub = $detail['sub_area'];
															$sql_sa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM sub_area");
															while($d_sa = mysqli_fetch_assoc($sql_sa)){
																if($sub == $d_sa['subarea']){
															echo '<option value="'.$d_sa['subarea'].'" selected>'.$d_sa['subarea'].'</option>';
																	} else {
															echo '<option value="'.$d_sa['subarea'].'" >'.$d_sa['subarea'].'</option>';			
																	}
																}
															?>
															</select>
														</div>
													</div>
												</div>
												<!--<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Start Date</label>
													</div>
													<div class="col-sm-3 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="date" name="start_date" class="datepicker form-control" value="<?= $detail['start_date'];?>" data-date-format="yyyy/mm/dd" placeholder="Start Date" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">End Date</label>
													</div>
													<div class="col-sm-3 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="date2" name="end_date" class="datepicker form-control" value="<?= $detail['end_date'];?>" data-date-format="yyyy/mm/dd" placeholder="End Date" required>
															</div>
														</div>
													</div>
												</div>-->
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Photo</label>
													</div>
													<div class="col-sm5 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="file" id="foto" name="file"  class="form-control" >
															</div>
														</div>
													</div>
												</div>
											
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-success waves-effect">SAVE CHANGES</button>
											<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
										</div>
										</form>
                    </div>
			</div>
</div>

							