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
            <div class="body">
			<?php if($_SESSION['area']=='all') { ?>
                            <div class="icon-and-text-button-demo">
                                <button type="button" class="btn btn-primary waves-effect" data-color="indigo" data-toggle="modal" data-target="#largeModal">
                                    <i class="material-icons">add_box</i>
                                    <span>TAMBAH</span>
                                </button>
								<!-- Large Size -->
								
                            
								
							</div> 
			<?php ;} else {echo'';} ?>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th></th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Nama Sekolah</th>
                                            <!--<th>Start</th>
											<th>End</th>-->
											
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
									<?php
										$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM karyawan");
										while ($d_karyawan=mysqli_fetch_array($s_karyawan)){
									?>
                                        <tr>
											<td>
											<?php 
											$a=$d_karyawan['area'];
												if($_SESSION['area']=='all'){
											?>
											<div class="btn-group">
												<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
													 <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li><a href="karyawan_edit?nik=<?= $d_karyawan['nik'];?>" >Edit</a></li>
													
													<li><a href="controller/karyawan_hapus?id=<?= $d_karyawan['id'];?>" onclick="return confirm('Apakah NISN <?= $d_karyawan['nik'];?> akan dihapus ?')">Hapus</a></li>
												</ul>
											</div>
											<?php 
												;} else if($a==$_SESSION['area']){
											?>
											<div class="btn-group">
												<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
													 <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li><a class="pilihan" href="" data-toggle="modal" data-target="#edit" a1="<?= $d_karyawan['nik'];?>" a2="<?= $d_karyawan['nama'];?>" a3="<?= $d_karyawan['job_title'];?>" a4="<?= $d_karyawan['no_telp'];?>" a5="<?= $d_karyawan['jenis_kelamin'];?>" a6="<?= $d_karyawan['agama'];?>" a7="<?= $d_karyawan['lokasi'];?>" a8="<?= $d_karyawan['area'];?>" a9="<?= $d_karyawan['sub_area'];?>" a10="<?= $d_karyawan['start_date'];?>" a11="<?= $d_karyawan['end_date'];?>" a12="<?= $d_karyawan['foto'];?>">Edit</a></li>
													<li><a href="karyawan_detail?nik=<?= $d_karyawan['nik'];?>">Detail</a></li>
													<li><a href="controller/karyawan_hapus?id=<?= $d_karyawan['id'];?>" onclick="return confirm('NISN <?= $d_karyawan['nik'];?> akan dihapus ?')">Hapus</a></li>
												</ul>
											</div>
											<?php
												;} else{ echo'';}
											?>
											</td>
                                            <td><?= $d_karyawan['nik'];?></td>
                                            <td><?= $d_karyawan['nama'];?></td>
                                            <td><?= $d_karyawan['job_title'];?></td>
                                            <td><?= $d_karyawan['lokasi'];?></td>
									
                                            <!--<td><?= $d_karyawan['start_date'];?></td>
                                            <td><?= $d_karyawan['end_date'];?></td>-->
                                            
                                        </tr>
									<?php ;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
			</div>
</div>

							<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Tambah Siswa</h4>
										</div>
										<div class="modal-body">
										 
											<form action="controller/karyawan_simpan" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">NISN</label>
													</div>
													<div class="col-sm-3">
														<div class="form-group">
															<div class="form-line">
																<input type="text" name="nik" class="form-control" placeholder="Masukan NISN" required>
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
																<input type="text"  name="nama" class="form-control" placeholder="Nama Lengkap" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Kelas</label>
													</div>
													<div class="col-sm-6 ">
														<div class="form-group">
															<select name="job_title" class="form-control show-tick" required>
															<option value="">-- Pilih Kelas --</option>
															<?php
															$sql_jt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jobtitle");
															if(mysqli_num_rows($sql_jt) != 0){
															while($d_jt = mysqli_fetch_assoc($sql_jt)){
															echo '<option value="'.$d_jt['kode_jobtitle'].'">'.$d_jt['jobtitle'].'</option>';
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
																	<select name="jenis_kelamin" class="form-control show-tick" required>
																		<option value="">-- Pilih Jenis Pekerjaan --</option>
																		<option value="Karyawan Swasta">Karyawan Swasta</option>
																		<option value="Wiraswasta">Wiraswasta</option>
																		
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
																<input type="text"  name="nama_ayah" class="form-control" placeholder="Nama Ayah" required>
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
																<input type="text"  name="no_telp" class="form-control" placeholder="Nama Ibu" required>
															</div>
														</div>
													</div>
												</div>-->
												<!--<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Status</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="agama" class="form-control show-tick" required>
																		<option value="">-- Pilih Status --</option>
																		<option value="Islam">Islam</option>
																		<option value="Hindu">Hindu</option>
																		<option value="Budha">Budha</option>
																		<option value="Menikah">Menikah</option>
																		<option value="Lajang">Lajang</option>
															</select>
														</div>
													</div>
												</div>-->
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Jenis Kelamin</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
															<select name="lokasi" class="form-control show-tick" name="lokasi" required>
															<!--<option value="">-- Pilih Lokasi --</option>-->
															<?php
															$sql_l = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM lokasi where id=1");
															if(mysqli_num_rows($sql_l) != 0){
															while($d_l = mysqli_fetch_assoc($sql_l)){
															echo '<option value="'.$d_l['lokasi'].'">'.$d_l['lokasi'].'</option>';
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
															<select name="area" class="form-control show-tick"  name="area" required>
															<!--<option value="">-- Pilih Area --</option>-->
															<?php
															$sql_a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area where id=1");
															if(mysqli_num_rows($sql_a) != 0){
															while($d_a = mysqli_fetch_assoc($sql_a)){
															echo '<option value="'.$d_a['kode_area'].'">'.$d_a['area'].'</option>';
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
															<select name="sub_area" class="form-control show-tick"  name="sub_area" required>
															<option value="">-- Pilih Sub Area --</option>
															<?php
															$sql_s = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM sub_area");
															if(mysqli_num_rows($sql_s) != 0){
															while($d_s = mysqli_fetch_assoc($sql_s)){
															echo '<option value="'.$d_s['subarea'].'">'.$d_s['subarea'].'</option>';
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
																<input type="text" id="date" name="start_date" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="Start Date" required>
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
																<input type="text" id="date2" name="end_date" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="End Date" required>
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
																<input type="file"  name="file" class="form-control" required>
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
							 <!-- Small Size -->
							<div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="smallModalLabel">Import Data</h4>
										</div>
										<div class="modal-body">
										<form name="myForm" id="myForm" onSubmit="return validateForm2()" action="controller/karyawan_import.php" method="post" enctype="multipart/form-data">
											<div class="row clearfix">
												<div class="col-sm12 col-xs-12">
														<div class="form-group">
															<div class="form-line">
																<input type="file" id="filekaryawan" name="filekaryawan"  class="form-control" required>
															</div>
															
														</div>
														<small>*masukkan file .xls (excel 2003)</small><br/>
														<br/>
															<input type="checkbox" name="drop" value="1"  id="basic_checkbox_1" ></input><label for="basic_checkbox_1"><u>Kosongkan tabel Siswa terlebih dahulu.</u> </label>
														
													</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" name="submit"  class="btn btn-success waves-effect" value="Import" />
											<button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
										</div>
										</form>
										<script type="text/javascript">
										//    validasi form (hanya file .xls yang diijinkan)
											function validateForm2()
											{
												function hasExtension(inputID, exts) {
													var fileName = document.getElementById(inputID).value;
													return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
												}
										 
												if(!hasExtension('filekaryawan', ['.xls'])){
													alert("Hanya file XLS (Excel 2003) yang diijinkan.");
													return false;
												}
											}
										</script>
									</div>
								</div>
							</div>
							<!-----------Edit Modal------->
							<div class="modal fade" id="edit" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Edit Siswa</h4>
										</div>
										<div class="modal-body">
										 
											<form action="controller/karyawan_edit" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">NISN</label>
													</div>
													<div class="col-sm-3">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="nik" name="nik" readonly="readonly" class="form-control" placeholder="Masukan NISN" required>
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
																<input type="text"  name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" required>
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
															<div class="form-line">
																<input type="text"  name="job_title" id="job_title" class="form-control" placeholder="Job Title" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Pekerjaan</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="jenis_kelamin" id="jk"  required>
																		<option value="">-- Pilih Jenis Pekerjaan --</option>
																		<option value="Karyawan Swasta" >Karyawan Swasta</option>
																		<option value="Wiraswasta">Wiraswasta</option>
																		
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
																<input type="text"  name="nama_ayah" id="no_telp" class="form-control" placeholder="Nama Ayah" required>
															</div>
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
																<input type="text"  name="nama_ayah" id="nama_ayah" class="form-control" placeholder="Nama Ayah" required>
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
																<input type="text"  name="no_telp" id="no_telp" class="form-control" placeholder="Nama Ibu" required>
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
																		<!--<option value="Islam">Islam</option>-->
																		<!--<option value="Hindu">Hindu</option>-->
																		<!--<option value="Budha">Budha</option>-->
																		<option value="Menikah">Menikah</option>
																		<option value="Lajang">Lajang</option>
																	</select>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Lokasi</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
															<select name="lokasi" id="lokasi" class="form-control show-tick" id="agama" name="agama" required>
															<option value="">-- Pilih Lokasi --</option>
															<?php
															$sql_l = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM lokasi");
															if(mysqli_num_rows($sql_l) != 0){
															while($d_l = mysqli_fetch_assoc($sql_l)){
															echo '<option value="'.$d_l['lokasi'].'">'.$d_l['lokasi'].'</option>';
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
															<select name="area" id="area" class="form-control show-tick" id="agama" name="agama" required>
															<option value="">-- Pilih Area --</option>
															<?php
															$sql_a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area");
															if(mysqli_num_rows($sql_a) != 0){
															while($d_a = mysqli_fetch_assoc($sql_a)){
															echo '<option value="'.$d_a['area'].'">'.$d_a['area'].'</option>';
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
															<select name="sub_area" id="sub_area" class="form-control show-tick" id="agama" name="agama" required>
															<option value="">-- Pilih Sub Area --</option>
															<?php
															$sql_s = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM sub_area");
															if(mysqli_num_rows($sql_s) != 0){
															while($d_s = mysqli_fetch_assoc($sql_s)){
															echo '<option value="'.$d_s['subarea'].'">'.$d_s['subarea'].'</option>';
																	}
																}
															?>
															</select>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Start Date</label>
													</div>
													<div class="col-sm-3 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="date" name="start_date" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="Start Date" required>
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
																<input type="text" id="date2" name="end_date" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="End Date" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Photo</label>
													</div>
													<div class="col-sm5 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="file" id="foto" name="file" class="form-control" required>
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
							 <!-- Small Size -->