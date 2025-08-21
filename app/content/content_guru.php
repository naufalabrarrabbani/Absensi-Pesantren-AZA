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
                                    <span>TAMBAH GURU</span>
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
                                DATA GURU
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
											<th></th>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Jenis Kelamin</th>
                                            <th>No. Telp</th>
											
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
									<?php
										$s_guru = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM guru");
										while ($d_guru=mysqli_fetch_array($s_guru)){
									?>
                                        <tr>
											<td>
											<?php 
											$a=$d_guru['area'];
												if($_SESSION['area']=='all'){
											?>
											<div class="btn-group">
												<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
													 <span class="caret"></span>
												</button>
												<ul class="dropdown-menu">
													<li><a href="guru_edit?nip=<?= $d_guru['nip'];?>" >Edit</a></li>
													
													<li><a href="controller/guru_hapus?id=<?= $d_guru['id'];?>" onclick="return confirm('Apakah NIP <?= $d_guru['nip'];?> akan dihapus ?')">Hapus</a></li>
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
													<li><a class="pilihan" href="" data-toggle="modal" data-target="#edit" a1="<?= $d_guru['nip'];?>" a2="<?= $d_guru['nama'];?>" a3="<?= $d_guru['mata_pelajaran'];?>" a4="<?= $d_guru['no_telp'];?>" a5="<?= $d_guru['jenis_kelamin'];?>" a6="<?= $d_guru['agama'];?>" a7="<?= $d_guru['lokasi'];?>" a8="<?= $d_guru['area'];?>" a9="<?= $d_guru['sub_area'];?>" a10="<?= $d_guru['start_date'];?>" a11="<?= $d_guru['end_date'];?>" a12="<?= $d_guru['foto'];?>">Edit</a></li>
													<li><a href="guru_detail?nip=<?= $d_guru['nip'];?>">Detail</a></li>
													<li><a href="controller/guru_hapus?id=<?= $d_guru['id'];?>" onclick="return confirm('NIP <?= $d_guru['nip'];?> akan dihapus ?')">Hapus</a></li>
												</ul>
											</div>
											<?php
												;} else{ echo'';}
											?>
											</td>
                                            <td><?= $d_guru['nip'];?></td>
                                            <td><?= $d_guru['nama'];?></td>
                                            <td><?= $d_guru['mata_pelajaran'];?></td>
                                            <td><?= $d_guru['jenis_kelamin'];?></td>
                                            <td><?= $d_guru['no_telp'];?></td>
									
                                            
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
											<h4 class="modal-title" id="largeModalLabel">Tambah Guru</h4>
										</div>
										<div class="modal-body">
										 
											<form action="controller/guru_simpan" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">NIP</label>
													</div>
													<div class="col-sm-3">
														<div class="form-group">
															<div class="form-line">
																<input type="text" name="nip" class="form-control" placeholder="Masukan NIP" required>
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
														<label for="password_2">Mata Pelajaran</label>
													</div>
													<div class="col-sm-6 ">
														<div class="form-group">
															<select name="mata_pelajaran" class="form-control show-tick" required>
															<option value="">-- Pilih Mata Pelajaran --</option>
															<?php
															$sql_mp = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran");
															if(mysqli_num_rows($sql_mp) != 0){
															while($d_mp = mysqli_fetch_assoc($sql_mp)){
															echo '<option value="'.$d_mp['nama_mapel'].'">'.$d_mp['nama_mapel'].'</option>';
																	}
																}
															?>
															</select>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Jenis Kelamin</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="jenis_kelamin" class="form-control show-tick" required>
																		<option value="">-- Pilih Jenis Kelamin --</option>
																		<option value="Laki-laki">Laki-laki</option>
																		<option value="Perempuan">Perempuan</option>
																		
																	</select>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">No. Telp</label>
													</div>
													<div class="col-sm-5">
														<div class="form-group">
															<div class="form-line">
																<input type="text"  name="no_telp" class="form-control" placeholder="Nomor Telepon" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Agama</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="agama" class="form-control show-tick" required>
																		<option value="">-- Pilih Agama --</option>
																		<option value="Islam">Islam</option>
																		<option value="Kristen">Kristen</option>
																		<option value="Katolik">Katolik</option>
																		<option value="Hindu">Hindu</option>
																		<option value="Budha">Budha</option>
																		<option value="Konghucu">Konghucu</option>
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
							
							<!-----------Edit Modal------->
							<div class="modal fade" id="edit" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="largeModalLabel">Edit Guru</h4>
										</div>
										<div class="modal-body">
										 
											<form action="controller/guru_edit" class="form-horizontal" method="POST" enctype="multipart/form-data">
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="email_address_2">NIP</label>
													</div>
													<div class="col-sm-3">
														<div class="form-group">
															<div class="form-line">
																<input type="text" id="nip" name="nip" readonly="readonly" class="form-control" placeholder="Masukan NIP" required>
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
														<label for="password_2">Mata Pelajaran</label>
													</div>
													<div class="col-sm-8">
														<div class="form-group">
															<div class="form-line">
																<input type="text"  name="mata_pelajaran" id="mata_pelajaran" class="form-control" placeholder="Mata Pelajaran" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Jenis Kelamin</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="jenis_kelamin" id="jk"  required>
																		<option value="">-- Pilih Jenis Kelamin --</option>
																		<option value="Laki-laki" >Laki-laki</option>
																		<option value="Perempuan">Perempuan</option>
																		
																	</select>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">No. Telp</label>
													</div>
													<div class="col-sm-5">
														<div class="form-group">
															<div class="form-line">
																<input type="text"  name="no_telp" id="no_telp" class="form-control" placeholder="Nomor Telepon" required>
															</div>
														</div>
													</div>
												</div>
												<div class="row clearfix">
													<div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
														<label for="password_2">Agama</label>
													</div>
													<div class="col-sm-4 ">
														<div class="form-group">
																	<select name="agama" id="agama" class="form-control show-tick" required>
																		<option value="">-- Pilih Agama --</option>
																		<option value="Islam">Islam</option>
																		<option value="Kristen">Kristen</option>
																		<option value="Katolik">Katolik</option>
																		<option value="Hindu">Hindu</option>
																		<option value="Budha">Budha</option>
																		<option value="Konghucu">Konghucu</option>
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
														<label for="password_2">Photo</label>
													</div>
													<div class="col-sm5 col-xs-7">
														<div class="form-group">
															<div class="form-line">
																<input type="file" id="foto" name="file" class="form-control">
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
							 
<script type="text/javascript">
$(document).ready(function(){
	$('body').on('click', '.pilihan', function(){
		var nip= $(this).attr('a1');
		var nama= $(this).attr('a2');
		var mata_pelajaran= $(this).attr('a3');
		var no_telp= $(this).attr('a4');
		var jenis_kelamin= $(this).attr('a5');
		var agama= $(this).attr('a6');
		var lokasi= $(this).attr('a7');
		var area= $(this).attr('a8');
		var sub_area= $(this).attr('a9');
		var start_date= $(this).attr('a10');
		var end_date= $(this).attr('a11');
		var foto= $(this).attr('a12');
		
		$('#nip').val(nip);
		$('#nama').val(nama);
		$('#mata_pelajaran').val(mata_pelajaran);
		$('#no_telp').val(no_telp);
		$('#jk').val(jenis_kelamin);
		$('#agama').val(agama);
		$('#lokasi').val(lokasi);
		$('#area').val(area);
		$('#sub_area').val(sub_area);
		$('#start_date').val(start_date);
		$('#end_date').val(end_date);
		$('#foto').val(foto);
		
	});
});
</script>
